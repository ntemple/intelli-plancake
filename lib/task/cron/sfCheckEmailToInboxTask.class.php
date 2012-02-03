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
class sfCheckEmailToInboxTask extends sfBaseCronTask {
    /**
     * @see sfTask
     */
    protected function configure() {
        parent::configure();

        $this->aliases = array('check-email-to-inbox');
        $this->name = 'check-email-to-inbox';
        $this->briefDescription = 'Checks whether there are new emails to insert into the inbox';

        $this->addArguments(
                array(
                new sfCommandArgument('testNewEmailsDirectory', sfCommandArgument::OPTIONAL,
                'The directory where the emails to test sit.'),
                )
        );

        $this->detailedDescription = <<<EOF
Checks whether there are new emails to insert into the inbox.
EOF;
    }

    /**
     * @see sfTask
     */
    protected function executeTask($env, $arguments = array(), $options = array()) {
        /**
         * Getting the directory where the emails are stored
         */
        $newEmailsDir = sfConfig::get('app_emailToInbox_incomingEmailsDirectory');

        // this is very useful for testing
        if ($arguments['testNewEmailsDirectory']) {
            $newEmailsDir = $arguments['testNewEmailsDirectory'];
        }

        // to make sure staging will not interfere with production
        $newEmailsDir .= ($env == 'prod') ? '' : '-' . $env;

        $newEmailsPath = glob($newEmailsDir . '/*');

        if (! is_dir($newEmailsDir)) {
            $errorMessage = "$newEmailsDir does not exist.";
            sfErrorNotifier::alert($errorMessage);
            throw new Exception($errorMessage);
        }

        $this->log('');
        $this->log(count($newEmailsPath) . " emails to parse in " . $newEmailsDir);
        $this->log('');

        /**
         * Going through all the emails
         */
        foreach($newEmailsPath as $newEmailPath) {
            // we parse the email in a new process so that
            // if a fatal error stops the parsing of an email,
            // the others get parsed anyway
            $cmd = sfConfig::get('sf_root_dir') . "/symfony cron:parse-email $newEmailPath --env=$env";
            passthru($cmd);
        }
    }
}