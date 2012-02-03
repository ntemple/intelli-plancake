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

class PcDirtyTaskPeer extends BasePcDirtyTaskPeer
{
    public static function cleanDirtyTasks(PcUser $user)
    {
        if ($user == null)
        {
            return;
        }

        $c = new Criteria();
        $c->add(self::USER_ID, $user->getId());
        $taskEntriesToClean = self::doSelect($c);

        foreach ($taskEntriesToClean as $taskEntryToClean)
        {
            $task = PcTaskPeer::retrieveByPK( $taskEntryToClean->getTaskId() );

            if ($task != null)
            {
                $cacheManager = sfContext::getInstance()->getViewCacheManager();
                if (is_object($cacheManager))
                {
                    $cacheManager->remove('@sf_cache_partial?module=task&action=_incompletedTask&sf_cache_key=' . $task->getCacheKey(true));
                    $cacheManager->remove('@sf_cache_partial?module=task&action=_completedTask&sf_cache_key=' . $task->getCacheKey(false));
                }
            }
            
            $taskEntryToClean->delete();
        }
    }

    /**
     *
     * @param PcUser $user
     * @param PcTask $task
     * @return boolean - return true if the entry has been actually added
     */
    public static function addEntry($user, $task)
    {
        if ($user == null)
        {
            return false;
        }

        if ($task == null)
        {
            return false;
        }

        $entry = self::retrieveByPK($user->getId(), $task->getId());

        if (is_object($entry))
        {
            // the entry already exists
            return false;
        }


        $dirtyTask = new PcDirtyTask();
        $dirtyTask->setUserId($user->getId())
                ->setTaskId($task->getId())
                ->save();

        return true;
    }
}
