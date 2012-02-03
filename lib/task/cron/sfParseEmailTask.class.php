<?php

/*************************************************************************************
* ===================================================================================*
* Software by: Danyuki Software Limited                                              *
* This file is part of Plancake.                                                     *
*                                                                                    *
* Copyright 2009-2010-2011-2012 by:     Danyuki Software Limited                          *
* Support, News, Updates at:  http://www.plancake.com                                *
* Licensed under the AGPL version 3 license.                                         *                                                       *
* Danyuki Software Limited is registered in England and Wales (Company No. 07554549) *
**************************************************************************************
* Plancake is distributed in the hope that it will be useful,                        *
* but WITHOUT ANY WARRANTY; without even the implied warranty of                     *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                      *
* GNU Affero General Public License for more details.                                *
*                                                                                    *
* You should have received a copy of the GNU Affero General Public License           *
* along with this program.  If not, see <http://www.gnu.org/licenses/>.              *
*                                                                                    *
**************************************************************************************/

/**
 * Packs a new release to make it ready to be downloaded by users
 *
 * @package    symfony
 * @subpackage task
 * @version    SVN: $Id: sfProjectDeployTask.class.php 10956 2008-08-19 15:20:48Z fabien $
 */
class sfParseEmailTask extends sfBaseCronTask {
    /**
     * @see sfTask
     */
    protected function configure() {
        parent::configure();

        $this->aliases = array('parse-email');
        $this->name = 'parse-email';
        $this->briefDescription = 'Parses an email';

        $this->addArguments(
                array(
                new sfCommandArgument('emailFileAbsolutePath', sfCommandArgument::REQUIRED,
                'The absolute path of the file when the email is.'),
                )
        );

        $this->detailedDescription = <<<EOF
Parses an email.
EOF;
    }

    /**
     * @see sfTask
     */
    protected function executeTask($env, $arguments = array(), $options = array()) {
        /**
         * Getting the directory where the emails are stored
         */
        $inboxUser = sfConfig::get('app_emailToInbox_inboxUser');
        $emailDomain = sfConfig::get('app_emailToInbox_mailServerDomain');

        $newEmailPath = $arguments['emailFileAbsolutePath'];

        // there are some regular Plancake inbox email address that are
        // use just for spam
        $spamAccounts = array();
        $spamAccounts[] = 'niki_5436'; // this will be interpreted as inbox_niki_5436@plancakebox.com
        $spamAccounts[] = 'niki.jones_15c522';


        $this->log('');
        $this->log('');
        $this->log("parsing the email at " . $newEmailPath);

        $mailParser = new PlancakeEmailParser(file_get_contents($newEmailPath));

        $plancakeSubjectOK = false;
        $plancakeRecipientOK = false;

        $emailTo = array();
        $emailSubject = '';
        $emailCc = $mailParser->getCc();
        try {
            $emailTo = $mailParser->getTo();
        }
        catch (Exception $e) {
            $this->handleFault("couldn't retrieve the 'to' header of the email", $newEmailPath);
            return;
        }
        try {
            $emailSubject = $mailParser->getSubject();
            $plancakeSubjectOK = true;
            $this->log("got the subject of the email: " . $emailSubject);
        }
        catch (Exception $e) {
            $this->handleFault("couldn't retrieve the subject of the email", $newEmailPath);
            return;
        }

        $emailRecipients = array_merge($emailTo, $emailCc);
        $emailRecipients = implode(', ', $emailRecipients);

        $deliveredToHeader = $mailParser->getHeader('Delivered-To');
        $emailRecipients = $deliveredToHeader . ', ' . $emailRecipients;

        $this->log("all recipients of the email: " . $emailRecipients);

        $internalEmail = false; // to flag an email sent to the catchall address
        $spamEmail = false;

        if( preg_match('/' . $inboxUser . "@$emailDomain/", $emailRecipients, $matches) ) {
            $internalEmail = true;
            $this->log("discarding the email as it is an internal one");
            if (is_file($newEmailPath))
            {
                unlink($newEmailPath);
            }

            return;
        }

        if( preg_match("/inbox_([^@]+)@$emailDomain/i", $emailRecipients, $matches) ) { // found Plancake Inbox address!
            $plancakeInbox = $matches[1];
            if (in_array($plancakeInbox, $spamAccounts)) {
                $spamEmail = true;
                $this->handleFault("discarding the email because it is from a spammer", $newEmailPath);
                return;
            } else {
                $emailRecipient = 'inbox_' . $plancakeInbox . "@$emailDomain";
                $plancakeRecipientOK = true;
                $this->log("got the Plancake recipient of the email: " . $emailRecipient);
            }
        } else {
            $this->handleFault("couldn't find a Plancake recipient for the email", $newEmailPath);
            return;
        }

        /**
         * Sorting the email into the database
         */
        if ($plancakeRecipientOK && $plancakeSubjectOK) {
            $this->log('well done. For this email we got both the recipient and the subject. I can now create the task for the user.');
            $emailRecipientWithoutDomain = str_replace("@$emailDomain", '', $emailRecipient);
            $c = new Criteria();
            $c->add(PcPlancakeEmailAddressPeer::EMAIL, $emailRecipientWithoutDomain, Criteria::EQUAL);
            $plancakeEmail = PcPlancakeEmailAddressPeer::doSelectOne($c);

            if (is_object($plancakeEmail)) {
                // everything's OK
                $userId = $plancakeEmail->getUserId();
                $user = PcUserPeer::retrieveByPk($userId);
                PcUserPeer::setLoggedInUser($user);

                // check whether there is a note for the task
                $note = $this->extractNote($mailParser->getPlainBody());
                
                if (strlen($note)) {
                    $this->log("note: $note");
                }

                if (!strlen($emailSubject)) {
                    $emailSubject = 'Something went wrong with a task you sent via email. Please contact us.';
                }
                
                PcTaskPeer::createOrEdit($emailSubject, $user->getInbox()->getId(), 0, '', false, $note);
                $this->log('the email has successfully become a task for the user.');
            } else {
                // something wrong
                $this->handleFault('no email user', $newEmailPath);
                $this->log('couldn\'t create a task from the email - the Plancake address is not in the system :-(.');
            }
        } else if ((!$plancakeRecipientOK || !$plancakeSubjectOK) && !$internalEmail && !$spamEmail) {
            // something wrong
            $this->handleFault('email parsing', $newEmailPath);
            $this->log("counldn't find both the recipient and the subject of the email. Nothing to do.");
        }

        $this->log("deleting the email from the hard disk.");

        if (is_file($newEmailPath))
        {
            unlink($newEmailPath);
        }

        $this->log('');
        $this->log('');
    }

    /**
     * If the email is too big (probably because of attachments), it records
     * only the beginning of it
     *
     * @param string $errorMessage
     * @param string $emailPath
     */
    private function handleFault($errorMessage, $emailPath) {
        $this->log($errorMessage);

        sfErrorNotifier::alert($errorMessage);

        $emailFileSize = filesize($emailPath);

        if ($emailFileSize < 32000) {
            $description = file_get_contents($emailPath);
        } else {
            $description = "The email was too big (probably because of attachment). Here is the beginning of it: \n\n";
            $description .= shell_exec("cat $emailPath | head -100");
        }

        $watchdog = new PcWatchdog();
        $watchdog->setType('email-to-inbox')->setDescription($description)->save();

        if (is_file($emailPath))
        {
            unlink($emailPath);
        }
    }

    /**
     *
     * @param string $emailBody
     * @return string
     */
    private function extractNote($emailBody) {
        $trimmedEmailBody = trim($emailBody);

        if ( (substr($trimmedEmailBody, 0, 2) == '%%') ||
             (strtolower(substr($trimmedEmailBody, 0, 6)) == 'delete')   )
        {
            return '';
        }

        $parts = explode("\n%%", $trimmedEmailBody);
        return $parts[0];

// This is the way it used to be
/**
        $someContentFound = false;
        $magicStringFound = false;
        $content = '';

        // this if statement is to recover in the case the user didn't go
        // newline after the starting magic string %%
        if (preg_match('/^%%/', $emailBody)) {
            $magicStringFound = true;   
            // taking out the magic string
            $emailBody = substr($emailBody, 2);         
        }        
        
        $lines = preg_split("/(\r?\n)/", $emailBody);

        // parsing line by line
        foreach ($lines as $line) {
            if (! PlancakeEmailParser::isNewLine($line)) {
                if (!preg_match('/^%%/', $line)) { // the line does not contain the 'magic' string
                    $someContentFound = true;
                    $content .= $line . "\n";
                } else { // the line contains the 'magic' string
                    $magicStringFound = true;
                    if (!$someContentFound) {
                        // that was the opening one...nothing to do
                    } else {
                        // that was the closing one
                        break;
                    }
                }
            }
        }

        return $magicStringFound ? $content : '';
 */
    }
}