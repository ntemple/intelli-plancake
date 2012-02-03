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
class plancakeCreateUserTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->aliases = array('create-user');
    $this->namespace = 'installation';
    $this->name = 'create-user';
    $this->briefDescription = 'Creates a user.';

    $this->addArguments(array(
      new sfCommandArgument('email_address', sfCommandArgument::REQUIRED, "The email address the user will use to log in (must be a real email address)."),
    ));

    $this->addArguments(array(
      new sfCommandArgument('password', sfCommandArgument::REQUIRED, "The password the user will use to log in."),
    ));


    $this->detailedDescription = <<<EOF
Creates a user (their timezone will not be reliably detected).
EOF;

  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    require_once(dirname(__FILE__).'/../../../config/ProjectConfiguration.class.php');
    $configuration = ProjectConfiguration::getApplicationConfiguration('public', 'prod', true);
    sfContext::createInstance($configuration);

    $email = $arguments['email_address'];
    $password = $arguments['password'];

    $newUser = PcUserPeer::registerNewUser($email, $password, 'en', 'en', '+01:00,1', 0, false, false);

    if ($newUser)
    {
        $newUser->setAwaitingActivation(0)->save();
        $supporter = new PcSupporter();
        $supporter->setUserId($newUser->getId())
                  ->setExpiryDate(2100000000)
                  ->save();
        $this->log("The user has been created successfully in the pc_user table. \n You may need to set up the correct timezone in the account settings.");
        $this->log("The new user can reset their password following the link 'forgotten password' on the Login page.");
    }
    else
    {
    	$this->log("An error occurred - probably the user already exists.");
    }

    
  }
}
