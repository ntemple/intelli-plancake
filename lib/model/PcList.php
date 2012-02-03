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

class PcList extends BasePcList
{
	/**
	 * Clears the cache relevant for lists
	 */
	private function clearRelevantCache()
	{
    if ($this->getId())
    {
      if (sfContext::getInstance()->getUser()->isAuthenticated())
      {
        $userId = PcUserPeer::getLoggedInUser()->getId();
        $cacheManager = sfContext::getInstance()->getViewCacheManager();
        if (is_object($cacheManager))
        {
          $cacheManager->remove('@sf_cache_partial?module=lists&action=_mainNavigation&sf_cache_key=' . PcCache::getMainNavigationKey());
        }
        $cache = PcCache::getInstance();
        if (is_object($cache))
        {
          $cache->remove('PcUser::getLists' . $userId);
          $cache->remove('PcUser::getSystemLists' . $userId);
          $cache->remove('PcUser::getAllLists' . $userId);
        }
      }
    }

    // we need to clear the cache of each task as its partial will probably
    // contain the list name
    $tasks = $this->getIncompletedTasks();
    foreach ($tasks as $task)
    {
        $task->save();
    }
  }

	/**
	 * Overrides the save method
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
   * Alias for PcList::setPcUser()
   * 
   * @see        self:setPcUser()
   * @param      PcUser $v (=null)
   * @return     PcList
   */
  public function setCreator(PcUser $v = null)
  {
    return parent::setPcUser($v);
  }

  /**
   * Alias for PcList::getIsHeader()
   * 
   * @return     boolean
   */
  public function isHeader()
  {
    return parent::getIsHeader();
  }

  /**
   * Alias for PcList::getIsSystem()
   * 
   * @return     boolean
   */
  public function isSystem()
  {
    return ($this->isInbox() || $this->isTodo());
  }

  /**
   * Alias for PcList::getIsInbox()
   * 
   * @return     boolean
   */
  public function isInbox()
  {
    return parent::getIsInbox();
  }

  /**
   * Alias for PcList::getIsTodo()
   * 
   * @return     boolean
   */
  public function isTodo()
  {
    return parent::getIsTodo();
  }

  /**
   * Returns a label for the type ('user', 'inbox', 'todo')
   * 
   * @return string
   */
  public function getTypeLabel()
  {
    if ($this->isInbox()) return 'inbox';
    else if ($this->isTodo()) return 'todo';
    else return 'user';
  }

  /**
   * Alias for PcList::getPcUser()
   * 
   * @see        self:getPcUser()
   * @param      PropelPDO Optional Connection object.
   * @return     PcUser
   */
  public function getCreator(PropelPDO $con = null)
  {
    return parent::getPcUser($con);
  }

  /**
   * Returns the incompleted tasks that have got a due date
   * 
   * @param      PropelPDO Optional Connection object.
   * @return     array of PcTask
   */
  public function getIncompletedTasksWithDate(PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(PcTaskPeer::LIST_ID, $this->getId(), Criteria::EQUAL);
    $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNOTNULL);
    $criteria->addAscendingOrderByColumn(PcTaskPeer::DUE_DATE);
    $criteria->addAscendingOrderByColumn(PcTaskPeer::DUE_TIME);
    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * Returns the incompleted tasks that have not got a due date
   * 
   * @param      PropelPDO Optional Connection object.
   * @return     array of PcTask
   */
  public function getIncompletedTasksWithoutDate(PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(PcTaskPeer::LIST_ID, $this->getId(), Criteria::EQUAL);
    $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNULL);
    $criteria->addDescendingOrderByColumn(PcTaskPeer::SORT_ORDER);
    //$criteria->addAscendingOrderByColumn(PcTaskPeer::CREATED_AT);
    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * Returns the incompleted tasks
   *
   * @param      PropelPDO Optional Connection object.
   * @return     array of PcTask
   */
  public function getIncompletedTasks(PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(PcTaskPeer::LIST_ID, $this->getId(), Criteria::EQUAL);
    $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $criteria->addDescendingOrderByColumn(PcTaskPeer::SORT_ORDER);
    $criteria->addAscendingOrderByColumn(PcTaskPeer::CREATED_AT);
    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * Returns the completed tasks
   * 
   * @param      PropelPDO Optional Connection object.
   * @param      integer $limit (=0) - if >0, a limit is set for the query
   * @return     array of PcTask
   */
  public function getCompletedTasks(PropelPDO $con = null, $limit = 0)
  {
    $criteria = new Criteria();
    $criteria->add(PcTaskPeer::LIST_ID, $this->getId(), Criteria::EQUAL);
    $criteria->add(PcTaskPeer::IS_COMPLETED, 1, Criteria::EQUAL);
    $criteria->addDescendingOrderByColumn(PcTaskPeer::COMPLETED_AT);
    if ($limit > 0)
    {
      $criteria->setLimit($limit);
    }
    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * Overrides the delete method to delete the associated tasks and the sharings
   * 
   * @see        parent::delete()
   * @param      PropelPDO Optional Connection object.
   * @return     PcList
   */
  public function delete(PropelPDO $con = null)
  {
    // deleting all the tasks related to the list
    $tasksCriteria = new Criteria();
    $tasksCriteria->add(PcTaskPeer::LIST_ID, $this->getId(), Criteria::EQUAL);
    $tasks = PcTaskPeer::doSelect($tasksCriteria);
    foreach($tasks as $task)
    {
      $task->delete();
    }

    // deleting all the sharing related to the list
    $sharingsCriteria = new Criteria();
    $sharingsCriteria->add(PcTaskPeer::LIST_ID, $this->getId(), Criteria::EQUAL);
    $sharings = PcTaskPeer::doSelect($sharingsCriteria);
    foreach($sharings as $sharing)
    {
      $sharing->delete();
    }

    $this->clearRelevantCache();

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

  /**
   * Sets the title after basic sanitizing
   * 
   * @see        parent::setTitle()
   * @param      string $v
   * @return     PcList
   */
  public function setTitle($v)
  {
    $v = strip_tags(trim($v));
    return parent::setTitle($v);
  }

  /**
   * Returns the header of the list (if any)
   * 
   * @return     string
   */
  public function getHeaderTitle()
  {
    if ($this->isSystem()) return '';
    if ($this->isHeader()) return '';

    $sortOrder = $this->getSortOrder();

    $c = new Criteria();
    $c->add(PcListPeer::SORT_ORDER, $sortOrder, Criteria::GREATER_THAN);
    $c->add(PcListPeer::IS_HEADER, 1, Criteria::EQUAL);
    $c->add(PcListPeer::CREATOR_ID, $this->getCreatorId(), Criteria::EQUAL);
    $header = PcListPeer::doSelectOne($c);

    return is_object($header) ? $header->getTitle() : '';
  }

  /**
   * Returns the header of the list (if any)
   *
   * @return     string
   */
  public function getFullTitle()
  {
      $headerTitle = $this->getHeaderTitle();

      return ($headerTitle == '') ? $this->getTitle() : $headerTitle . ' ' . $this->getTitle();
  }

    private function copyObjectToTrashBin()
    {
        $id = $this->getId();

        if(! ($trashBin = PcTrashbinListPeer::retrieveByPK($id)) )
        {
            $trashBin = new PcTrashbinList();
        }
        
        $trashBin->setId($this->getId())
                 ->setCreatorId($this->getCreatorId())
                 ->setTitle($this->getTitle())
                 ->setSortOrder($this->getSortOrder())
                 ->setIsHeader($this->isHeader())
                 ->setIsInbox($this->isInbox())
                 ->setIsTodo($this->isTodo())
                 ->setUpdatedAt($this->getUpdatedAt())
                 ->setCreatedAt($this->getCreatedAt())
                 ->setDeletedAt(time('U'))
                 ->save();
    }
    
    public function __toString()
    {
        return $this->getTitle();
    }    
}
