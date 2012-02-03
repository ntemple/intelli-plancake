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
class sfBaseCronTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->namespace = 'cron';

    $this->addOption('env', null,
                     sfCommandOption::PARAMETER_REQUIRED,
                     'The environment');

  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $env = $options['env'];

    $availableEnvironments = array('dev', 'staging', 'prod');

    if (! in_array($env, $availableEnvironments))
    {
        throw new InvalidArgumentException("$env is not an environment.");
    }

    require_once(dirname(__FILE__).'/../../../config/ProjectConfiguration.class.php');
    $configuration = ProjectConfiguration::getApplicationConfiguration('auto' , $env, true);
    sfContext::createInstance($configuration);

    try
    {
        $this->executeTask($env, $arguments, $options);
    }
    catch (Exception $e)
    {
        sfErrorNotifier::alert($e->getMessage() . ' - ' . print_r($e->getTrace(), true));
    }
  }
}
