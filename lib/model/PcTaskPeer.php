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

class PcTaskPeer extends BasePcTaskPeer
{
  /**
   * Returns the incompleted tasks that have got a due date for the logged in user
   * 
   * @param      PropelPDO Optional Connection object.
   * @param      boolean (=false) $sortByListToo
   * @param      boolean (=false) $onlyDueTodayOrTomorrow
   * @return     array of PcTask
   */
  public static function getIncompletedTasksWithDate(PropelPDO $con = null, $sortByListToo = false, $onlyDueTodayOrTomorrow = false)
  {
    $criteria = new Criteria();
    $lists = PcUserPeer::getLoggedInUser()->getAllLists();
    $listsId = array();
    foreach($lists as $list)
    {
      $listsId[] = $list->getId();
    }
    $criteria->add(PcTaskPeer::LIST_ID, $listsId, Criteria::IN);
    $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNOTNULL);
    $criteria->addAscendingOrderByColumn(PcTaskPeer::DUE_DATE);
    $criteria->addAscendingOrderByColumn(PcTaskPeer::DUE_TIME);


    if ($onlyDueTodayOrTomorrow)
    {
        $tomorrow = date('Y-m-d', strtotime('tomorrow'));
        $criteria->add(self::DUE_DATE, $tomorrow, Criteria::LESS_EQUAL);
    }

    if ($sortByListToo)
    {
        $criteria->addAscendingOrderByColumn(PcTaskPeer::LIST_ID);
    }

    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * Returns the completed tasks that have got a due date for the logged in user
   *
   * @param      PropelPDO Optional Connection object.
   * @return     array of PcTask
   */
  public static function getCompletedTasksWithDate(PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $lists = PcUserPeer::getLoggedInUser()->getAllLists();
    $listsId = array();
    foreach($lists as $list)
    {
      $listsId[] = $list->getId();
    }
    $criteria->add(PcTaskPeer::LIST_ID, $listsId, Criteria::IN);
    $criteria->add(PcTaskPeer::IS_COMPLETED, 1, Criteria::EQUAL);
    $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNOTNULL);
    $criteria->addDescendingOrderByColumn(PcTaskPeer::COMPLETED_AT);

    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * Returns the completed tasks that have got a due date for the logged in user
   *
   * @param      PropelPDO Optional Connection object.
   * @param      boolean $completed - whether to return completed or incompleted tasks
   * @param      integer $withDueDate -
   *                            0 -> both with and without
   *                            1 -> only with due date
   *                            2 -> only with no due date
   * @return     array of PcTask
   */
  public static function getStarredTasks(PropelPDO $con = null, $completed = false, $withDueDate = 0)
  {
    $criteria = new Criteria();
    $lists = PcUserPeer::getLoggedInUser()->getAllLists();
    $listsId = array();
    foreach($lists as $list)
    {
      $listsId[] = $list->getId();
    }

    $criteria->add(PcTaskPeer::LIST_ID, $listsId, Criteria::IN);
    $criteria->add(PcTaskPeer::IS_STARRED, 1);

    
    
    if ($withDueDate == 1) // only with due date
    {
        $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNOTNULL);
        $criteria->addAscendingOrderByColumn(PcTaskPeer::DUE_DATE);
    }
    else if ($withDueDate == 2) // only with no due date
    {
        $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNULL);
    }

    if ($completed)
    {
        $criteria->add(PcTaskPeer::IS_COMPLETED, 1, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(PcTaskPeer::COMPLETED_AT);
    }
    else
    {
        $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
        $criteria->addDescendingOrderByColumn(PcTaskPeer::LIST_ID);
    }

    return PcTaskPeer::doSelect($criteria);
  }
  
  
  /**
   * Creates (or edits) a task
   * By default, it sets isFromSystem false. That is because a user may
   * edit a task from the system and make it meaningful to them. The problem
   * is the automatic cleaning up of system tasks would delete it. And this
   * method is used also when editing a task.
   * Repetition expression has got priority on dueDate
   * 
   * @param string $description
   * @param integer $listId (if listId not >0, we will use the user's Inbox)
   * @param integer $taskId (if we are editing an existing task)
   * @param string $contexts (comma separated list of ids)
   * @param boolean $isHeader
   * @param string $note
   * @param string $dueDate (no GMT but user's local date)
   * @param string $dueTime - formatted as an integer, ie: 0753 (no GMT but user's local time)
   * @param integer $repetitionId
   * @param integer $repetitionParam
   * @param integer $taskAboveId - if ($taskAboveId = -100000), that means to put at the end of the list
   * @param string $callerContext - can be either 'ajax' or 'email' or 'gcal'
   * @param string $dueDateFormat - to specify a particular format for parsing the dueDate param
   *               (otherwise the user's date format is used).
   *               Uses the PHP date() format
   * @param boolean $setNextOccurrence (=true)
   * @return     PcTask - the object that has been created
   */
  public static function createOrEdit($description, $listId=0, $taskId=0, $contexts='',
          $isHeader=false, $note='', $dueDate='', $dueTime='', $isStarred=0, $repetitionId=0, $repetitionParam=0,
          $taskAboveId=0, $callerContext='', $dueDateFormat='', $setNextOccurrence=true)
  {
    $dueDate = strtolower($dueDate);
    $loggedInUser = PcUserPeer::getLoggedInUser();

    if ($repetitionId < 0)
    {
        $repetitionId = 0;
    }

    if (! ((int)$listId>0))
    {
      // Inserting into the default list: Inbox
      $listId = $loggedInUser->getInbox()->getId();
    }
    $listCreator = PcListPeer::retrieveByPk($listId)->getCreator();
    PcUtils::checkLoggedInUserPermission($listCreator);

    $mode = $taskId ? 'edit' : 'add';

    $task = ($mode == 'add') ? new PcTask() : PcTaskPeer::retrieveByPk($taskId);

    if ( ($mode == 'edit') && (!$task->validateOwner($loggedInUser)) )
    {
      throw new sfException('User '.$loggedInUser->getId().' trying to access the task ' . $task->getId() .  ' illegitimately');
    }

    list( $listIdFromShortcut, $contextIdsFromShortcut, $potentialDueDateExpressionsFromShortcut, $potentialDueTimeExpressionsFromShortcut) =
            $task->extractInfoFromTaskDescription($description);

    $listId = ($listIdFromShortcut > 0) ? $listIdFromShortcut : $listId;

    // NLT Manage tags, taking input both from the user input and the shortcuts
    $userContexts = $loggedInUser->getContextsArray(true);
    $contextIdsFromInput = PcUtils::explodeWithEmptyInputDetection(',', $contexts);
    $validatedContexts = array();
    foreach ($contextIdsFromInput as $cid)
    {
      $userContext = PcUsersContextsPeer::retrieveByPK($cid);
      if ($userContext) {
          $validatedContexts[] = array_search(strtolower($userContext->getContext()), $userContexts);
      }
    }

    if (count($contextIdsFromShortcut))
    {
      $validatedContexts = array_unique(array_merge($validatedContexts, $contextIdsFromShortcut));
    }
    $task->setContexts(implode(',', $validatedContexts));
  


    // {{{ START: looking for a contact
    $contactPrefix = 'cid';
    if (strpos($description, $contactPrefix) !== FALSE) {
        if (preg_match('/' . $contactPrefix . '([0-9]+)/', $description, $contactArray)) {
            $description = str_replace($contactArray[0], '', $description); // removing the contact bit from the description
            if (is_numeric($contactArray[1])) {
                $task->setContactId($contactArray[1]);
            }
        }
    }
    // END: looking for a contact }}}
    
    $task->setDescription($description); // it is the actual content of the task


    if ( ($repetitionId == 34) && !($repetitionParam > 0) )
    {
        // $repetitionParam should have been > 0!
        $repetitionId = 0;
    }


    $oldRepetitionId = $task->getRepetitionId();
    if ($repetitionId > 0)
    {
      $task->setRepetitionId($repetitionId);
      $task->setRepetitionParam($repetitionParam);    
    }
    else
    {
      $task->setRepetitionId(NULL);
      $task->setRepetitionParam(0);    
    }
    $changeInRepetitionId = false;
    if ( ($oldRepetitionId != $task->getRepetitionId()) )
    {
        $changeInRepetitionId = true;
    }

    try {
      $task->setListId($listId);
    }
    catch(sfException $e) {
      if ($callerContext == 'ajax')
      {
        die('ERROR: You can\'t insert a task in a header.');
      }
    }
    $task->setIsHeader($isHeader);

    if (! $isHeader)
    {
      $task->setNote($note);
    }
    else
    {
         $task->setDueDate(null);
    }

    $validDueDateExpression = false;
    $unrecognizedShortcuts = array();
    if ( count($potentialDueDateExpressionsFromShortcut) && (!$isHeader))
    {
      foreach($potentialDueDateExpressionsFromShortcut as $potentialDueDateExpressionFromShortcut)
      {
        $validDueDateExpression = $task->setDueDate($potentialDueDateExpressionFromShortcut);
        if (! $validDueDateExpression)
        {
            $unrecognizedShortcuts[] = $potentialDueDateExpressionFromShortcut;
        }
        else
        {
            $validDueDateExpression = true;
            break;
        }
      }
    }
    
    if (!$validDueDateExpression && $dueDate && (!$isHeader))
    {
      $validDueDateExpression = $task->setDueDate($dueDate, $dueDateFormat);
    }

    if (! $task->getDueDate()) // no due date
    {
      $task->setDueDate(NULL);
    }

    if ( $mode == 'add' )
    {
          $list = $task->getPcList();
          
          if (! $list) { // this should not happen, but just in case...
              $list = $loggedInUser->getInbox();
          }
          
          if( ! $taskAboveId)
          {
            $maxTasksSortOrder = self::getMaxTasksSortOrder($list);              
            $task->setSortOrder($maxTasksSortOrder+1);
          } 
          else if ($taskAboveId == -100000) 
          {
            $minTasksSortOrder = self::getMinTasksSortOrder($list);              
            $task->setSortOrder($minTasksSortOrder-1);              
          }
          else
          {
            $maxTasksSortOrder = self::getMaxTasksSortOrder($list);              
            // they are inserting the new task below an old one
            // I need to insert the new task after the task whose id is beforeListId
            $allTasks = $list->getIncompletedTasks();
            // the tasks are returned with sortOrder descending order
            // and the tasks are displayed with the greatest sortOrder on top
            $newSortOrder = $maxTasksSortOrder;
            foreach($allTasks as $oneOfTheOtherTasks)
            {
              $delta = 1;
              if ($oneOfTheOtherTasks->getId() == $taskAboveId)
              {
                $task->setSortOrder($newSortOrder-1);
                $delta++;
              }
              $oneOfTheOtherTasks->setSortOrder($newSortOrder);
              $oneOfTheOtherTasks->save();
              $newSortOrder -= $delta;
            }
          }
    }    
    
    if (count($unrecognizedShortcuts))
    {
      if ($callerContext == 'ajax')
      {
        die("ERROR: {$unrecognizedShortcuts[0]} is not a tag neither a valid due date/time expression.");
      }
    }

    if ( $potentialDueTimeExpressionsFromShortcut && ($callerContext == 'ajax') )
    {
        if (! $potentialDueTimeExpressionsFromShortcut->isValid())
        {
            die("ERROR: the due time shortcut is not valid.");
        }
    }

    if ($dueTime || $potentialDueTimeExpressionsFromShortcut)
    {
        // it doesn't make sense to set a time if a date is not specified
        if ( $task->getDueDate() || $task->getRepetitionId() )
        {
            if ($dueTime)
            {
                $task->setDueTime($dueTime);
            }
            else
            {
                $task->setDueTime($potentialDueTimeExpressionsFromShortcut->getIntegerValue());
            }
        }
        else
        {
            if ($callerContext == 'ajax')
            {
                die('ERROR: You can\'t set a due time without a due date.');
            }    
            else
            {
                // if the user tried to insert a due time shortcuts but we couldn't take
                // that value because there is no due date, we put the due time back in
                // the description
                if ($potentialDueTimeExpressionsFromShortcut)
                {
                    $descriptionWithDueTimeEmbedded = $task->getDescription() . ' @' .
                           $potentialDueTimeExpressionsFromShortcut->getHumanFriendlyTime($loggedInUser);
                    $task->setDescription($descriptionWithDueTimeEmbedded);
                }
            }
        }
    }
    else
    {
        $task->setDueTime(null);
    }

    if (!$task->isHeader())
    {
        $task->setStarred((bool)$isStarred);
    }

    $task->save();

    if ($task->getRepetitionId() && $setNextOccurrence)
    {
      $task->setNextOccurrence(true); // N.B.: this saves the object!!!!!!!
    } else {
      // Determine if we can save here, remove duplicate save	
    	
    }

    // we need to do this operation here because we need the object
    // saved in the db to be able to refer to it via its ID
    // Added to save method! NLT
    // $task->alignTasksContextsTable();

    // {{{
    // this is to fix a bug:
    // long task descriptions were cut (because of database schema contraint)
    // without a clear feedback on the user interface (Javascript was
    // inserting the whole string sent via AJAX)
    $task = PcTaskPeer::retrieveByPK($task->getId());
    // }}}


    // This is VERY IMPRTANT because a user may
    // edit a task from the system and make it meaningful to them. The problem
    // is the automatic cleaning up of system tasks would delete it. And this
    // method is used also when editing a task.
    $task->setIsFromSystem(false);

    if ($loggedInUser->hasGoogleCalendarIntegrationActive())
    {
        if ($callerContext != 'gcal') // we need this to avoid recursion
        {
            $gcal = new GoogleCalendarInterface($loggedInUser);
            $gcal->init();
            $gcal->createOrUpdateEvent($task);
        }
    }

    return $task;
  }

  /**
   * @param      int $contextId
   * @return     array of PcTask
   */
  public static function getIncompletedTasksWithDateByContextId($contextId)
  {
    $criteria = new Criteria();
    $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNOTNULL);

    $criteria->addJoin(PcTaskPeer::ID, PcTasksContextsPeer::TASK_ID, Criteria::INNER_JOIN);
    $criteria->add(PcTasksContextsPeer::USERS_CONTEXTS_ID, $contextId);
    
    $criteria->addAscendingOrderByColumn(PcTaskPeer::DUE_DATE);
    $criteria->addAscendingOrderByColumn(PcTaskPeer::DUE_TIME);
    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * @param      int $contextId
   * @return     array of PcTask
   */
  public static function getIncompletedTasksWithoutDateByContextId($contextId)
  {
    $criteria = new Criteria();
    $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNULL);

    $criteria->addJoin(PcTaskPeer::ID, PcTasksContextsPeer::TASK_ID, Criteria::INNER_JOIN);
    $criteria->add(PcTasksContextsPeer::USERS_CONTEXTS_ID, $contextId);

    $criteria->addDescendingOrderByColumn(PcTaskPeer::SORT_ORDER);
    $criteria->addAscendingOrderByColumn(PcTaskPeer::CREATED_AT);

    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * @param      int $contextId
   * @param      integer $limit (=0) - if >0, a limit is set for the query
   * @return     array of PcTask
   */
  public static function getCompletedTasksByContextId($contextId, $limit = 0)
  {
    $criteria = new Criteria();
    $criteria->add(PcTaskPeer::IS_COMPLETED, 1, Criteria::EQUAL);

    $criteria->addJoin(PcTaskPeer::ID, PcTasksContextsPeer::TASK_ID, Criteria::INNER_JOIN);
    $criteria->add(PcTasksContextsPeer::USERS_CONTEXTS_ID, $contextId);

    $criteria->addDescendingOrderByColumn(PcTaskPeer::COMPLETED_AT);

    if ($limit > 0)
    {
      $criteria->setLimit($limit);
    }
    return PcTaskPeer::doSelect($criteria);
  }

  /**
   * @param      int $contextId
   * @param      integer $limit (=0) - if >0, a limit is set for the query
   * @return     array of PcTask
   */
  public static function getTasksByContextId($contextId, $limit = 0)
  {
    $criteria = new Criteria();

    $criteria->addJoin(PcTaskPeer::ID, PcTasksContextsPeer::TASK_ID, Criteria::INNER_JOIN);
    $criteria->add(PcTasksContextsPeer::USERS_CONTEXTS_ID, $contextId);

    $criteria->addDescendingOrderByColumn(PcTaskPeer::CREATED_AT);

    if ($limit > 0)
    {
      $criteria->setLimit($limit);
    }
    return PcTaskPeer::doSelect($criteria);
  }

    /**
     *
     * @param int $fromTs (=null) - GMT
     * @param int $toTs (=null) - GMT
     * @param int $taskId (=null)
     * @param int $listId (=null)
     * @param int $tagId (=null)
     * @param bool $completed (=false)
     * @param bool $onlyWithDueDate (=false)
     * @param bool $onlyWithoutDueDate (=false)
     * @param bool $onlyDueTodayOrTomorrow (=false)
     * @param bool $onlyStarred (=false)
     * @param string $byDate (=null)  - in the format yyyy-mm-dd
     * @param Criteria $c (=null)
     * @return array of PcTask
     */
  public static function getTasksByMultipleCriteria($fromTs = null,
                                             $toTs = null,
                                             $taskId = null,
                                             $listId = null,
                                             $tagId = null,
                                             $completed = false,
                                             $onlyWithDueDate = false,
                                             $onlyWithoutDueDate = false,
                                             $onlyDueTodayOrTomorrow = false,
                                             $onlyStarred = false,
                                             $byDate = null,
                                             Criteria $c = null)
  {
    $c = ($c === null) ? new Criteria() : $c;

    if ( ($byDate !== null) && (strlen($byDate) > 0) ) 
    {
        return PcTaskPeer::getTasksByDate($byDate);
    }
    else
    {   
        if ($taskId !== null)
        {
            // the request is for a specific task
            $c->add(self::ID, $taskId);
        }
        else
        {
            if ($fromTs !== null)
            {
                $c->add(self::UPDATED_AT, PcUtils::getMysqlTimestamp($fromTs), Criteria::GREATER_EQUAL);
                $c->addAnd(self::UPDATED_AT, PcUtils::getMysqlTimestamp($toTs), Criteria::LESS_THAN);
            }


            if ($listId !== null)
            {
                $c->add(self::LIST_ID, $listId);
            }

            if ($tagId !== null)
            {
                $c->addJoin(PcTasksContextsPeer::TASK_ID, self::ID);
                $c->add(PcTasksContextsPeer::USERS_CONTEXTS_ID, $tagId);
            }

            $c->add(self::IS_COMPLETED, (int)$completed);

            if ($onlyWithDueDate)
            {
                $c->add(self::DUE_DATE, null, Criteria::ISNOTNULL);
            }

            if ($onlyWithoutDueDate)
            {
                $c->add(self::DUE_DATE, null, Criteria::ISNULL);
            }

            if ($onlyDueTodayOrTomorrow)
            {
                $tomorrow = date('Y-m-d', strtotime('tomorrow'));
                $c->add(self::DUE_DATE, $tomorrow, Criteria::LESS_EQUAL);
                $c->addAscendingOrderByColumn(PcTaskPeer::DUE_DATE);
                $c->addAscendingOrderByColumn(PcTaskPeer::DUE_TIME);            
            }

            if ($onlyStarred)
            {
                $c->add(self::IS_STARRED, 1);
            }

            if ($completed)
            {
                $c->addDescendingOrderByColumn(PcTaskPeer::COMPLETED_AT);            
            }
            else if ($onlyWithDueDate)
            {        
                $c->addAscendingOrderByColumn(PcTaskPeer::DUE_DATE);
                $c->addAscendingOrderByColumn(PcTaskPeer::DUE_TIME);            
            }
            else
            {
                $c->addDescendingOrderByColumn(PcTaskPeer::SORT_ORDER);
            }
        }

        return self::doSelect($c);
    }
  }

  /**
   *
   * @param string $eventId
   * @return PcTask|null - null if there is not a task associated to that $eventId
   */
  public static function getTaskByGoogleCalendarEventId($eventId)
  {
    $c = new Criteria();
    $c->add(PcGoogleCalendarEventPeer::EVENT_ID, $eventId);
    if ($task = PcGoogleCalendarEventPeer::doSelectOne($c))
    {
        return PcTaskPeer::retrieveByPK($task->getTaskId());
    }
    return null;
  }
  
  /**
   *
   * @param PcList $list
   * @return integer 
   */
  public static function getMaxTasksSortOrder($list) 
  {
    $c = new Criteria();
    $c->add(PcTaskPeer::LIST_ID, $list->getId());
    $c->add(PcTaskPeer::IS_COMPLETED, 0);
    $c->addDescendingOrderByColumn(PcTaskPeer::SORT_ORDER);
    $entry = PcTaskPeer::doSelectOne($c);
    $maxTasksSortOrder = $entry ? $entry->getSortOrder() : 1;
    return $maxTasksSortOrder;
  }
    
  /**
   *
   * @param PcList $list
   * @return integer 
   */
  public static function getMinTasksSortOrder($list) 
  {
    $c = new Criteria();
    $c->add(PcTaskPeer::LIST_ID, $list->getId());
    $c->add(PcTaskPeer::IS_COMPLETED, 0);
    $c->addAscendingOrderByColumn(PcTaskPeer::SORT_ORDER);
    $entry = PcTaskPeer::doSelectOne($c);
    $minTasksSortOrder = $entry ? $entry->getSortOrder() : 1;
    return $minTasksSortOrder;
  }
  
  /**
   * Returns tasks scheduled for that day and the next 6 (including multiple occurrences of recurrent tasks)
   *
   * @param string $date - in the format yyyy-mm-dd (e.g.: 2011-12-25)
   * @return array|null - array of PcTask
   */
  public static function getTasksByDate($date)
  {   
    if ( ($date == null) || (strlen($date) <= 0) )  
    {
        return null;
    }
    
    $date = trim($date);
    
    $tasksToReturn = array();
    $c = new Criteria();
    
    $c->add(PcTaskPeer::DUE_DATE, null, Criteria::ISNOTNULL);
    // N.B.: the following criteria would be a mistake because it would take out recurrent tasks
    // $c->addAnd(PcTaskPeer::DUE_DATE, date('Y-m-d', strtotime($date)), Criteria::GREATER_EQUAL);
    $c->add(PcTaskPeer::IS_COMPLETED, 0);
    $c->addJoin(PcTaskPeer::LIST_ID, PcListPeer::ID);
    $c->add(PcListPeer::CREATOR_ID, PcUserPeer::getLoggedInUser()->getId());
    $c->addAscendingOrderByColumn(PcTaskPeer::DUE_TIME);
    
    $tasksWithDueDate = PcTaskPeer::doSelect($c);
    
    $tmpDate = $date;
    for($i = 0; $i < 7; $i++) 
    {
        foreach ($tasksWithDueDate as $taskWithDueDate)
        {          
            if ($taskWithDueDate->isOnThisDay($tmpDate))
            {
                $taskWithDueDate->extra = date('D', strtotime($tmpDate));                
                $tasksToReturn[] = clone $taskWithDueDate;
            }
        }
        $tmpDate = date('Y-m-d', strtotime("+1 day", strtotime($tmpDate)));
    }
    
    return $tasksToReturn;
    
  }   
  
}
