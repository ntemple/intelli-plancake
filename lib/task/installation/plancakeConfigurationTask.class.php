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
class plancakeConfigurationTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->aliases = array('configure');
    $this->namespace = 'installation';
    $this->name = 'configure';
    $this->briefDescription = 'Configuration wizard for Plancake.';

    $this->detailedDescription = <<<EOF
Configuration wizard for Plancake. Can be run as many times as necessarily.
EOF;

  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $configFiles = array('config/databases.yml', 'config/app.yml', 'plugins/sfErrorNotifierPlugin/config/app.yml');

    shell_exec("./symfony project:permissions");

    $this->log("");
    $this->log("");

    $this->log("I am the wizard that will help you get Plancake configured on your server.");
    $this->log("Before starting you have to make sure there is a database available for Plancake.");
    $this->log("You can run me whenever you need to change the configuration.");
    
    $this->log("");

    $this->log("I am checking you have all the configuration files needed...");
    foreach ($configFiles as $configFile)
    {
        if (!is_file($this->getFullPath($configFile)))
        {
            // the configuration file doesn't exist
            // looking for the example configuration file
            if (!is_file($this->getExampleFullPath($configFile)))
            {
                // neither the example configuration file exists...oh oh
                throw new Exception("The configuration file $configFile is missing");
            }
            else
            {
                // move the example config file to the actual config file
                $cmd = "mv {$this->getExampleFullPath($configFile)} {$this->getFullPath($configFile)}";
                exec($cmd);
            }
        }
    }
    $this->log("You have all the configuration files you need. Good.");

    $this->log("");

    $this->log("Now I am going to ask you some questions.");

    $siteUrl = $this->ask("What's the domain of the Plancake installation? Please do not include 'http://' (i.e.:  plancake.mywebsite.com)");

    $siteEmail = $this->ask("Please give me an email address I can send important emails to");

    $dbHost = $this->ask("What's the host for the database? (most probably it is localhost)");

    $dbName = $this->ask("What's the name of the database you want to install Plancake to?");

    $dbUsername = $this->ask("What's the username for the database?");

    $dbPassword = $this->ask("What's the password for the database?");

    $this->log("");

    $this->log("I am storing the configuration values.");
    $settingFilesWithContent = array(array('site_url' => $siteUrl),
                                     array('site_email' => $siteEmail),
                                     array('db_dns' => "mysql:host=$dbHost;dbname=$dbName"),
                                     array('db_username' => $dbUsername),
                                     array('db_password' => $dbPassword));

    foreach($settingFilesWithContent as $s)
    {
        file_put_contents(sfConfig::get('sf_root_dir') . '/settings/' . key($s), $s);
    }
    
    $this->log("");

    $this->log("All done here.");
    $this->log("If you made any mistake, just run this task again.");
  }

  private function getFullPath($configFile)
  {
      return sfConfig::get('sf_root_dir') . '/' . $configFile;
  }

  private function getExampleFullPath($configFile)
  {
    $exampleSuffix = '.example';
    return $this->getFullPath($configFile) . $exampleSuffix;
  }
}
