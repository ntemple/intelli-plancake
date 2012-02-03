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
class sfMigrationTo192Task extends sfBaseMigrationTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    parent::configure();

    $this->aliases = array('migration-to-192');
    $this->name = 'migration-to-192';
    $this->briefDescription = 'Migration to 1.9.2';

    $this->detailedDescription = <<<EOF
Migration to 1.9.2.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function executeTask($env, $arguments = array(), $options = array())
  {
    $sql = "UPDATE pc_users_contexts
            SET updated_at='%_UPDATED_AT_%',
                created_at='%_CREATED_AT_%'";

    $sql = str_replace('%_UPDATED_AT_%', date('Y-m-d H:i:s'), $sql);
    $sql = str_replace('%_CREATED_AT_%', date('Y-m-d H:i:s'), $sql);

    $connection = Propel::getConnection();
    $statement = $connection->prepare($sql);
    $statement->execute();



    $sql = "UPDATE pc_repetition
            SET updated_at='%_UPDATED_AT_%',
                created_at='%_CREATED_AT_%'";

    $sql = str_replace('%_UPDATED_AT_%', date('Y-m-d H:i:s'), $sql);
    $sql = str_replace('%_CREATED_AT_%', date('Y-m-d H:i:s'), $sql);

    $connection = Propel::getConnection();
    $statement = $connection->prepare($sql);
    $statement->execute();



    $sql = "UPDATE `pc_task`
            SET `updated_at`=`created_at`";

    $connection = Propel::getConnection();
    $statement = $connection->prepare($sql);
    $statement->execute();

    $sql = "UPDATE `pc_list`
            SET `updated_at`=`created_at`";

    $connection = Propel::getConnection();
    $statement = $connection->prepare($sql);
    $statement->execute();

    echo "\nDone migration to 1.9.2 \n\n";
  }
}
