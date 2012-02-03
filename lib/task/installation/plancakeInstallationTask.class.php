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
class plancakeInstallationTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->aliases = array('install');
    $this->namespace = 'installation';
    $this->name = 'install';
    $this->briefDescription = 'Performs the installation for Plancake. Must be run after the configure task. It will reset the database.';

    $this->detailedDescription = <<<EOF
Performs the installation for Plancake. Must be run after the configure task. It will reset the database.
EOF;

  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $this->log("");
    $this->log("");


      $this->log("I am going to install Plancake.");
      $this->log("!!!  BE CAREFUL: all the data in the database will be removed !!!");

    if (!$this->askConfirmation('are you ready for that? (y/n)', 'QUESTION', false))
    {
      exit();
    }

    $this->log("");

    $this->log("I am fixing some permissions.");
    passthru("./symfony project:permissions");
    $this->log("Permissions fixed.");

    $this->log("");

    $this->log("I am installing the tables.");
    passthru("./symfony propel:build-all-load --no-confirmation");
    $this->log("Tables installed.");

    $this->log("Creating the directory /tmp/plancake_oid_store, necessary for login with Google Account.");
    passthru("mkdir /tmp/plancake_oid_store");

    $this->log("All done here.");
  }
}
