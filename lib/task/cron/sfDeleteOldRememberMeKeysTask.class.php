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
class sfDeleteOldRememberMeKeysTask extends sfBaseCronTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    parent::configure();

    $this->aliases = array('delete-old-remember-me-keys');
    $this->name = 'delete-old-remember-me-keys';
    $this->briefDescription = 'Deletes old rememberme keys';

    $this->detailedDescription = <<<EOF
Deletes old rememberme keys.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function executeTask($env, $arguments = array(), $options = array())
  {
    $connection = Propel::getConnection();

    $queryFieldList = " t.id, t.list_id, t.description, t.sort_order, t.due_date, t.due_time, t.repetition_id, t.repetition_param, t.is_starred, t.is_completed, t.is_header, t.is_from_system, t.special_flag, t.note, t.contexts, t.completed_at, t.updated_at, t.created_at ";

    $queryTableJoins = " INNER JOIN pc_list AS l ON (t.list_id=l.id)
INNER JOIN pc_user AS u ON (l.creator_id=u.id)
LEFT JOIN pc_supporter s ON (u.id=s.user_id) ";

    $query = sprintf("DELETE FROM `pc_rememberme_key` WHERE `created_at` < '%s'", 
            date('Y-m-d h:i:s', strtotime('1 month ago')));
    
    
    $statement = $connection->prepare($query);
    $statement->execute();


    echo "Deleted old rememberme keys";
  } 
}
