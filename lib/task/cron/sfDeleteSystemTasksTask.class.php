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
class sfDeleteSystemTasksTask extends sfBaseCronTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    parent::configure();

    $this->aliases = array('delete-system-tasks');
    $this->name = 'delete-system-tasks';
    $this->briefDescription = 'Deletes system tasks';

    $this->detailedDescription = <<<EOF
Deletes system tasks.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function executeTask($env, $arguments = array(), $options = array())
  {
    $connection = Propel::getConnection();

    // N.B.: the conditiion pc_task.created_at = pc_task.updated_at   is to make sure    
    // they didn't just edit a system task to use it as a normal task - we DO NOT
    // want to delete that.
    $query = "DELETE
FROM pc_task
WHERE pc_task.is_from_system=1 AND (pc_task.created_at = pc_task.updated_at) AND (pc_task.created_at < DATE_SUB(CURRENT_DATE, INTERVAL 2 WEEK))";    
    
    $statement = $connection->prepare($query);

    $statement->execute();

    $this->log("Deleted system tasks");
  }
}
