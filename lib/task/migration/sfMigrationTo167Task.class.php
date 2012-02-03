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
class sfMigrationTo167Task extends sfBaseMigrationTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    parent::configure();

    $this->aliases = array('migration-to-167');
    $this->name = 'migration-to-167';
    $this->briefDescription = 'Migration to 1.6.7';

    $this->detailedDescription = <<<EOF
Migration to 1.6.7.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function executeTask($env, $arguments = array(), $options = array())
  {
    $tasks = PcTaskPeer::doSelect(new Criteria());

    foreach ($tasks as $task)
    {
        $contextsBlob = $task->getContexts();

        if (strlen($contextsBlob) > 0)
        {
            $contextIds = explode(',', $contextsBlob);

            foreach ($contextIds as $contextId)
            {
                // checking the context exists
                $context = PcUsersContextsPeer::retrieveByPK($contextId);

                if (is_object($context))
                {
                    $tasksContextsEntry = new PcTasksContexts();
                    $tasksContextsEntry->setTaskId($task->getId())
                                       ->setUsersContextsId($contextId)
                                       ->save();
                }
            }
        }
    }

    echo "\nDone migration to 1.6.7 \n\n";
  }
}
