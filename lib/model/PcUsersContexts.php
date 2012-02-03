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

class PcUsersContexts extends BasePcUsersContexts
{
	/**
	 * Clears the cache relevant for contexts
	 */
	private function clearRelevantCache()
	{
    if (sfContext::getInstance()->getUser()->isAuthenticated())
    {
      $userId = PcUserPeer::getLoggedInUser()->getId();
      $cache = PcCache::getInstance();
      if (is_object($cache))
      {
        $cache->remove('PcUser::getContexts' . $userId);
        $cache->remove('PcUser::getContextsArray' . $userId);
      }
    }
  }

	/**
	 * Overriding on the save method
   *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @see        parent::save()
	 */
	public function save(PropelPDO $con = null)
	{
    $this->clearRelevantCache();
    return parent::save($con);
  }

	/**
	 * Overriding on the delete method
   *
	 * @param      PropelPDO $con
	 * @return     void
	 * @see        parent::delete()
	 */
	public function delete(PropelPDO $con = null)
	{
            $this->clearRelevantCache();
            $this->deleteReferenceInTasks();

            $con = Propel::getConnection();
            $ret = null;
            try
            {
                $con->beginTransaction();
                $this->copyObjectToTrashBin();
                $ret = parent::delete($con);
                $con->commit();
            }
            catch(Exception $e)
            {
                $con->rollback();
                throw $e;
            }

            return $ret;
        }

        private function deleteReferenceInTasks()
        {
            $contextId = $this->getId();
            $tasks = PcTaskPeer::getTasksByContextId($contextId);

            foreach($tasks as $task)
            {
                $contextIdsString = $task->getContexts();
                $contextIds = PcUtils::explodeWithEmptyInputDetection(',', $contextIdsString);
                $contextIds = array_diff($contextIds, array($contextId));
                $task->setContexts(implode(',', $contextIds))
                     ->save();
            }
        }

        private function copyObjectToTrashBin()
        {
            $id = $this->getId();

            if(! ($trashBin = PcTrashbinUsersContextsPeer::retrieveByPK($id)) )
            {
                $trashBin = new PcTrashbinUsersContexts();
            }

            $trashBin->setId($id)
                     ->setUserId($this->getUserId())
                     ->setContext($this->getContext())
                     ->setUpdatedAt($this->getUpdatedAt())
                     ->setCreatedAt($this->getCreatedAt())
                     ->setDeletedAt(time('U'))
                     ->save();
        }
}
