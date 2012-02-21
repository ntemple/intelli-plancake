<?php

/*************************************************************************************
* ===================================================================================*
* Software by: Danyuki Software Limited                                              *
* This file is part of Plancake.                                                     *
*                                                                                    *
* Copyright 2009-2010-2011-2012 by:     Danyuki Software Limited                          *
* Support, News, Updates at:  http://www.plancake.com                                *n d
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

class PcTask extends BasePcTask
{
	/**
	 * Clears the cache relevant for tasks
	 */
	private function clearRelevantCache($beforeDeletion = false)
	{
            if ($this->getId())
            {
              $cacheManager = sfContext::getInstance()->getViewCacheManager();
              if (is_object($cacheManager))
              {
                $cacheManager->remove('@sf_cache_partial?module=task&action=_incompletedTask&sf_cache_key=' . $this->getCacheKey(true));
                $cacheManager->remove('@sf_cache_partial?module=task&action=_completedTask&sf_cache_key=' . $this->getCacheKey(false));
              }
              else
              {
                  if (!$beforeDeletion)
                  {
                      // Something went wrong, thus the cache wasn't cleared even if needed.
                      // This happens when we edit tasks via the API because the API belongs
                      // to a different application than 'account'.
                      // In this way the task cache if scheduled for later clearing
                      PcDirtyTaskPeer::addEntry(PcUserPeer::getLoggedInUser(), $this);
                  }
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
            $savedObject = parent::save($con);
            
            return $savedObject;
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
            $this->clearRelevantCache(true);

            $con = Propel::getConnection();
            $ret = null;
            try
            {
                $loggedInUser = PcUserPeer::getLoggedInUser();
                if($loggedInUser->hasGoogleCalendarIntegrationActive())
                {
                    $gcal = new GoogleCalendarInterface($loggedInUser);
                    $gcal->init();
                    $gcal->deleteEvent($this);
                }

                $con->beginTransaction();
                $this->copyObjectToTrashBin();
                $this->deleteDirtyEntry();
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
   * Sets the description of the task after basic sanitizing.
   * 
   * @see        parent::setDescription()
   * @param      string $v the value to set as description
   * @return     PcTask The current object (for fluent API support)
   */
  public function setDescription($v)
  {
    $v = strip_tags(trim($v));
    return parent::setDescription($v);
  }

  /**
   * @return     PcList
   */
  public function getList()
  {
    return PcListPeer::retrieveByPk($this->getListId());
  }

  /**
   * Given the task typed by a user (i.e.:  pay electricity bill %%27-05-2009 %%money),
   * it returns an array with the information embedded in the task description:
   * _ the first element is null, or the id or the inbox or the todo list of the user
   * _ an array of context Ids
   * _ an array of potential due date expressions (thay could actual be illegal wrong contexts)
   * _ null or a PcTime object as potential due time
   *
   * The task description passed as input is cleared from the shortcuts
   *
   * @param      string $taskDescription (passed by reference) the task text to evaluate and parse
   * @return     array
   */
  public function extractInfoFromTaskDescription(&$taskDescription)
  {
    preg_match('!@([0-9]+)([\.:]([0-9]+))? ?([ap]m\b)?!i', $taskDescription, $matches);
    $potentialDueTime = null;
    if (count($matches))
    {
        $potentialDueTime = new PcTime();
        $potentialDueTime->createFromParts( isset($matches[1]) ? $matches[1] : null,
                                            isset($matches[3]) ? $matches[3] : 0,
                                            isset($matches[4]) ? trim($matches[4]) : '');

        // removing the shortcut from the description
        $taskDescription = str_replace($matches[0], '', $taskDescription);
    }

    $taskDescriptionParts =  explode('%%', $taskDescription);
    $taskDescription = $taskDescriptionParts[0];

    $potentialInfo = array_slice($taskDescriptionParts, 1); // the first part is the actual
                                                       // task description

    $existingContextsLowercase = PcUserPeer::getLoggedInUser()->getContextsArray(true);

    $listId = null;
    $contextIds = array();
    $potentialDueDates = array();

    foreach($potentialInfo as $info)
    {
        $info = trim($info);

        // searching for listId
        if (strtolower($info) == 'inbox')
        {
            $listId = PcUserPeer::getLoggedInUser()->getInbox()->getId();
        }
        else if (strtolower($info) == 'todo')
        {
            $listId = PcUserPeer::getLoggedInUser()->getTodo()->getId();
        }
        // searching for contexts
        else if (in_array(strtolower($info), $existingContextsLowercase))
        {
            $contextIds[] = array_search(strtolower($info), $existingContextsLowercase);
        }
        else // potential due date
        {
            $potentialDueDates[] = strtolower($info);
        }
    }
    
    return array($listId, $contextIds, $potentialDueDates, $potentialDueTime);
  }

  /**
   * Returns false if the dueDateExpression is illegal
   * IMPORTANT: it stores dates using GTM time 
   *
   * The dueDateExpression can have these formats:
   * _ extended (24-09-2009 or different according to date-format setting)
   * _ tomorrow
   * _ tom
   * _ today
   * _ tod
   * _ in 1 day
   * _ in X days  (where X is a number)
   * _ in 1 week
   * _ in X weeks (where X is a number)
   * _ in 1 month
   * _ in X months (where X is a number)
   * _ in 1 year
   * _ in X years (where X is a number)
   * 
   * @param  string $dueDateExpression (see method description)
   * @param  string $incomingDateFormat (='') the date format to use (PHP date() format), rather than the user's one
   * @return PcTask|false
   */
  public function setDueDate($dueDateExpression, $incomingDateFormat = '')
  {
    if (!$dueDateExpression) 
    {
      return parent::setDueDate($dueDateExpression);
    }

    $dueDateExpression = trim($dueDateExpression);
    $dueDateValue = '';
    $timestamp = false;

    // let's look for extended format
    $dateFormat = DateFormat::getInstance();
    $dateBits = $dateFormat->getDateBits($dueDateExpression, $incomingDateFormat);

    $loggedInUser = PcUserPeer::getLoggedInUser();

    if (count($dateBits))
    {
      list($day, $month, $year) = $dateBits; 
      if ($day)
      {
        return parent::setDueDate("$year-$month-$day");
      }
    }

    // let's look for today
    else if (($dueDateExpression == 'today') || ($dueDateExpression == 'tod'))
    {
      $timestamp = $loggedInUser->getTime();
    }

    // let's look for tomorrow
    else if (($dueDateExpression == 'tomorrow') || ($dueDateExpression == 'tom'))
    {
      $timestamp = $loggedInUser->getTime() + 86400;
    }

    else
    {
      // let's look for the other expressions
      $dueDateExpression = str_replace('in ', '+', $dueDateExpression); // we do this so we can use strtotime

      // the strtotime function is a bit lenient: it accepts date shortcuts such as 'in 1 mondddth'
      // returning today's date (???)
      // Thus we need some filtering: the dueDateExpression has to contain at least one of the following words:
      $legalWords = array('next', 'day', 'days', 'week', 'weeks', 'month', 'months', 'year', 'years',
          'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun',
          'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
      
      $dueDateExpressionWords = explode(' ', $dueDateExpression);
      if(!count(array_intersect($legalWords, $dueDateExpressionWords)))
      {
          return false;
      }

      $timestamp = strtotime($dueDateExpression, $loggedInUser->getTime());
    }

    if ($timestamp)
    {
      return parent::setDueDate(date('Y-m-d', $timestamp));
    }

    return false;
  }

  /**
   * Returns the due date (UTC timezone).
   * N.B.: you should NEVER EVER use this method. Use getFormattedLocalDueDate() instead
   *       because the latter takes into consideration the preference of the user on the
   *       format of the date.
   * 
   * @see        parent::getDueDate()
   * @param      string $format (= 'd-m-Y')
   * @return     string
   */
  public function getDueDate($format = 'd-m-Y')
  {
    return parent::getDueDate($format);
  }
  
  public function getDescription()
  {
    $contactExtra = '';  
    if ($this->getContactId() > 0) 
    {
        if ($contact = PcContactPeer::retrieveByPK($this->getContactId())) {
            $contactExtra = '  cid' . $contact->getId();
        }
    }    
    return (parent::getDescription() . $contactExtra);
  }

  /**
   * Returns the due date according to the preference of the user on the format of the date
   * and the timezone
   *
   * @return     string
   */
  public function getFormattedLocalDueDate()
  {

    $dateFormat = DateFormat::getInstance();

    $UTCDueDate = $this->getDueDate($dateFormat->getPHPDateFormat());

    if ($UTCDueDate)
    {
      $UTCDueDateTimestamp = $dateFormat->getTimestamp($UTCDueDate);
      return date($dateFormat->getPHPDateFormat(), $UTCDueDateTimestamp + PcUserPeer::getLoggedInUser()->getRealOffsetFromGMT());
    }
    else
    {
      return '';
    }
  }

  /**
   * Returns the date the task was completed at according to the preference 
   * of the user on the format and timezone
   *
   * @return     string
   */
  public function getFormattedLocalCompletedAt()
  {
    $dateFormat = DateFormat::getInstance();

    $UTCCompletedAt = $this->getCompletedAt($dateFormat->getPHPDateFormat());
    if ($UTCCompletedAt)
    {
      $UTCCompletedAtTimestamp = $dateFormat->getTimestamp($UTCCompletedAt);
      return date($dateFormat->getPHPDateFormat(), $UTCCompletedAtTimestamp + PcUserPeer::getLoggedInUser()->getRealOffsetFromGMT());
    }
    else
    {
      return '';
    }
  }

  /**
   * If possible, returns one of these strings (comparing today's date with the due date):
   * _ yesterday
   * _ today
   * _ tomorrow
   * _ the week-day corresponding to 'in2days, Wed' (i.e.: Wednesday)
   * _ the week-day corresponding to 'in3days, Thu'
   * _ the week-day corresponding to 'in4days, Fri'
   * _ the week-day corresponding to 'in5days, Sat'
   * If any of those is unapplicable, it returns getFormattedLocalDueDate()
   *
   * @return     string
   */
  public function getHumanFriendlyDueDate()
  {
    $dateFormat = DateFormat::getInstance();
    $formattedDueDate = $this->getFormattedLocalDueDate();

    if (!$formattedDueDate)
    {
      return '';
    }

    $dueDateTimestamp = $dateFormat->getTimestamp($formattedDueDate);

    $todayTimestamp = PcUserPeer::getLoggedInUser()->getTime();
    $tomorrowTimestamp = $todayTimestamp + 86400;
    $yesterdayTimestamp = $todayTimestamp - 86400;

    list($tomorrowDay, $tomorrowMonth, $tomorrowYear) = explode('-', date('d-m-Y', $tomorrowTimestamp));
    list($todayDay, $todayMonth, $todayYear) = explode('-', date('d-m-Y', $todayTimestamp));
    list($yesterdayDay, $yesterdayMonth, $yesterdayYear) = explode('-', date('d-m-Y', $yesterdayTimestamp));


    $todayStart = mktime(0, 0, 0, $todayMonth, $todayDay, $todayYear);
    $todayEnd = mktime(23, 59, 59, $todayMonth, $todayDay, $todayYear);
    $tomorrowStart = mktime(0, 0, 0, $tomorrowMonth, $tomorrowDay, $tomorrowYear);
    $tomorrowEnd = mktime(23, 59, 59, $tomorrowMonth, $tomorrowDay, $tomorrowYear);
    $yesterdayStart = mktime(0, 0, 0, $yesterdayMonth, $yesterdayDay, $yesterdayYear);
    $yesterdayEnd = mktime(23, 59, 59, $yesterdayMonth, $yesterdayDay, $yesterdayYear);

    if ( ($todayStart < $dueDateTimestamp) && ($dueDateTimestamp < $todayEnd) )
    {
      return __('ACCOUNT_MISC_TODAY');
    }
    if ( $dueDateTimestamp <  $todayStart ) // overdue task
    {
      if ( ($yesterdayStart < $dueDateTimestamp) && ($dueDateTimestamp < $yesterdayEnd) )
      {
	      return __('ACCOUNT_MISC_YESTERDAY');
      }
    }
    if ( $dueDateTimestamp >  $todayEnd ) // task in the future
    {
      if ( ($tomorrowStart < $dueDateTimestamp) && ($dueDateTimestamp < $tomorrowEnd) )
      {
	      return __('ACCOUNT_MISC_TOMORROW');
      }
      // the task is not in the future but not tomorrow
      // we will check whether it is within the next 5 days
      $deltaSinceTomorrowSec = $dueDateTimestamp - $tomorrowEnd;
      $deltaSinceTomorrowDays = ceil($deltaSinceTomorrowSec / 86400);
      // I'm adding 1 because $deltaDays has got tomorrow as a reference
      $deltaDays = $deltaSinceTomorrowDays + 1;

      if ($deltaDays <= 5)
      {
	      // We need to display something like 'in3days, Thu'

	      // I need to get the day of the week to display
	      $weekDays = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
	      $localizedWeekDays = array(__('ACCOUNT_DOW_SUN'), __('ACCOUNT_DOW_MON'), __('ACCOUNT_DOW_TUE'),
                          __('ACCOUNT_DOW_WED'), __('ACCOUNT_DOW_THU'), __('ACCOUNT_DOW_FRI'), __('ACCOUNT_DOW_SAT'));

	      $todayWeekDay = date('D', PcUserPeer::getLoggedInUser()->getTime());
	      if ( ($todayWeekDayKey = array_search($todayWeekDay, $weekDays)) === FALSE )
	      {
	        throw new Exception('Couldn\'t find the right week day key for today');
	      }
	      $dueDateWeekDayIndex =  ($todayWeekDayKey + $deltaDays) % 7;
	      $dueDateWeekDay = $localizedWeekDays[$dueDateWeekDayIndex];

	      return sprintf(__('ACCOUNT_MISC_IN_X_DAYS'), $deltaDays) . ', ' . ucfirst($dueDateWeekDay);
      }
    }

    // At this point, we realized we can't apply any shortcut
    // we don't specify the year if it is the current one
    if ($this->getDueDate('Y') == date('Y', PcUserPeer::getLoggedInUser()->getTime()))
    {
        return $this->getDueDate("j") . ' ' . PcUtils::fromIndexToMonth($this->getDueDate('n')) . ', ' .
                ucfirst(PcUtils::fromIndexToWeekday($this->getDueDate('N')));
    }
    else
    {
        // return $this->getDueDate('j M Y');
        return $this->getDueDate("j") . ' ' . PcUtils::fromIndexToMonth($this->getDueDate('n')) .
                ' ' . $this->getDueDate('Y');
    }
  }

  /**
   * Returns one of three strings:
   * _ 'overdue'
   * _ 'today'
   * _ 'tomorrow'
   *
   * @return     string
   */
  public function getQuickDateLabel()
  {
    $dateFormat = DateFormat::getInstance();
    $formattedDueDate = $this->getFormattedLocalDueDate();

    if (!$formattedDueDate)
    {
      return '';
    }

    $dueDateTimestamp = 
	$dateFormat->getTimestamp($formattedDueDate);

    $todayTimestamp = PcUserPeer::getLoggedInUser()->getTime();
    $tomorrowTimestamp = $todayTimestamp + 86400;

    list($tomorrowDay, $tomorrowMonth, $tomorrowYear) = explode('-', date('d-m-Y', $tomorrowTimestamp));
    list($todayDay, $todayMonth, $todayYear) = explode('-', date('d-m-Y', $todayTimestamp));

    $todayStart = mktime(0, 0, 0, $todayMonth, $todayDay, $todayYear);
    $todayEnd = mktime(23, 59, 59, $todayMonth, $todayDay, $todayYear);
    $tomorrowStart = mktime(0, 0, 0, $tomorrowMonth, $tomorrowDay, $tomorrowYear);
    $tomorrowEnd = mktime(23, 59, 59, $tomorrowMonth, $tomorrowDay, $tomorrowYear);

    if ( ($todayStart < $dueDateTimestamp) && ($dueDateTimestamp < $todayEnd) )
    {
      return 'today';
    }
    if ( $dueDateTimestamp <  $todayStart )
    {
      return 'overdue';
    }
    if ( ($tomorrowStart < $dueDateTimestamp) && ($dueDateTimestamp < $tomorrowEnd) )
    {
      return 'tomorrow';
    }
    return '';
  }

  /**
   * Returns whether or not the task is overdue
   * N.B.: This doesn't take into account if the task is completed
   *
   * @return boolean
   */
  public function isOverdue()
  {
    return ($this->getQuickDateLabel() == 'overdue');
  }

  /**
   * Marks the tasks as complete (unless the task has got repetitions)
   */
  public function markComplete()
  {
    // Initially we were thinking to delete system tasks straight-away.
    // But the 'welcome task' is a system task. If the newbie completes it
    // and they don't find it in the 'completed tasks' section, they will feel
    // quite puzzled.
    /*
    if ($this->isFromSystem())
    {
       $this->delete();
       return;
    }
    */

    $loggedInUser = PcUserPeer::getLoggedInUser();

    if (! $this->getRepetitionId())
    {
      $this->setIsCompleted(1);
      $this->setCompletedAt(time());
      $this->save();

        if($loggedInUser->hasGoogleCalendarIntegrationActive())
        {
            // google calendar holds only tasks that haven't been completed
            $gcal = new GoogleCalendarInterface($loggedInUser);
            $gcal->init();
            $gcal->deleteEvent($this);
            // even if it sounds reasonable to do this:
            // $this->removeGoogleCalendarEventId();
            // we shouldn't do it, otherwise the GoogleCalendarInterface will re-create this task
        }
    }
    else
    {
      $dateFormat = DateFormat::getInstance();
      // inserting a copy of the task in the history
      $newTask = PcTaskPeer::createOrEdit($this->getDescription(),
                                          $this->getListId(),
                                          0,
                                          $this->getContexts(),
                                          (bool)$this->getIsHeader(),
                                          $this->getNote(),
                                          $this->getDueDate($dateFormat->getPHPDateFormat()),
                                          $this->getDueTime());
      $newTask->markComplete();

      // I need to create the next repetition
      $this->setNextOccurrence();

        if ($loggedInUser->hasGoogleCalendarIntegrationActive())
        {
            $gcal = new GoogleCalendarInterface($loggedInUser);
            $gcal->init();
            $gcal->createOrUpdateEvent($this);
        }
    }
  }

  /**
   * Marks the tasks as incomplete
   */
  public function markIncomplete()
  {
    $this->setIsCompleted(0);
    $this->setCompletedAt(NULL);
    $this->setCreatedAt(time()); // so it will be displayed at the end of the list after reloading
    $this->save();

    $loggedInUser = PcUserPeer::getLoggedInUser();

    if ($loggedInUser->hasGoogleCalendarIntegrationActive())
    {
        $this->removeGoogleCalendarEventId(); // if we don't do this the integration
         // will try to edit a non-existing event on GCal, rather than creating a new one
        $gcal = new GoogleCalendarInterface($loggedInUser);
        $gcal->init();
        $gcal->createOrUpdateEvent($this);
    }
  }

  /**
   * Returns whether or not the task is due today
   * N.B.: This doesn't take into account if the task is completed
   *
   * @return boolean
   */
  public function isToday()
  {
    return ($this->getQuickDateLabel() == 'today');
  }

  /**
   * Returns whether or not the task is due tomorrow
   * N.B.: This doesn't take into account if the task is completed
   *
   * @return boolean
   */
  public function isTomorrow()
  {
    return ($this->getQuickDateLabel() == 'tomorrow');
  }

  /**
   * Returns a simplified timestamp (i.e.: 200906050000) useful to order tasks cronologically.
   * Returns the string '0' if the task hasn't got a due date
   *
   * @return integer
   */
  public function getNumericDueTime()
  {
    if ($this->getDueDate())
    {
      return (int)str_replace('-', '', $this->getDueDate('Y-m-d')) . $this->getDueTime();
    }
    return 0;
  }

  /**
   * Sets the list Id.
   * 
   * @see        parent::setListId()
   * @param      integer $v 
   * @return     PcTask
   */
  public function setListId($v)
  {
    if (PcListPeer::retrieveByPk($v)->isHeader())
    {
      throw new sfException('A task can\'t belong to a header rather than a proper list.');
    }
    return parent::setListId($v);
  }

  /**
   * Alias for PcTask::getIsHeader()
   * 
   * @return     boolean
   */
  public function isHeader()
  {
    return parent::getIsHeader();
  }

  /**
   * Alias for PcTask::getIsCompleted()
   *
   * @return     boolean
   */
  public function isCompleted()
  {
    return parent::getIsCompleted();
  }

  /**
   * Returns an array with all the contexts (the names, not the ids)
   * 
   * @return     array
   */
  public function getContextsArray()
  {
    $contexts = explode(',', $this->getContexts()); // the variable contains ids
    $contexts = PcUsersContextsPeer::retrieveByPks($contexts);
    $ret = array();
    foreach ($contexts as $context)
    {
      $ret[] = $context->getContext();
    }
    return $ret;
  }

	/**
	 * Overrides the parent method
	 * 
	 * @param      boolean $v new value
	 * @return     PcTask The current object (for fluent API support)
	 */
	public function setIsHeader($v)
	{
		$this->setDueDate(null);
    $this->setNote('');

		return parent::setIsHeader($v);
	} // setIsHeader()

  /**
   * Returns the repetition expression for the task (if any), ready to be displayed to the user.
   *
   * @return     string
   */
  public function getRepetitionHumanExpression()
  {
    if (! $repetitionId = $this->getRepetitionId())
    {
      return '';
    }
    else
    {
      $repetition = PcRepetitionPeer::retrieveByPk($repetitionId);

      if (! $repetition->needsParam())
      {
        return $repetition->getLocalizedHumanExpression();
      }
      else
      {
        $repetitionParam = $this->getRepetitionParam();
        if($repetition->getSpecial() != 'selected_wkdays')
        {
            if (! $repetition->isParamCardinal())
            {
              $repetitionParam = PcUtils::getOrdinalFromCardinal($repetitionParam);
            }
            $repetitionString = str_replace(__('ACCOUNT_TASK_REPETITION_SELECT_LATER'),
                    $repetitionParam, $repetition->getLocalizedHumanExpression(), $count);
            if (! $count)
            {
              sfErrorNotifier::alert('The [select later] string has changed');
            }
            else
            {
              return $repetitionString;
            }
        }
        else
        {
            $weekdaysSet = DateFormat::fromIntegerToWeekdaysSetForRepetition($repetitionParam);

            $selectedWeekdays = array();

            foreach ($weekdaysSet as $k => $v)
            {
                if ($v)
                {
                    $selectedWeekdays[] = __('ACCOUNT_DOW_ON_PREPOSITION') . ' ' .
                        PcUtils::fromAbbreviationToWeekday($k);
                }
            }

            return implode(", ", $selectedWeekdays);
        }
      }
    }
  }  

  /**
   * Returns the repetition Ical rule.
   *
   * @return     string|null
   */
  public function getRepetitionICalRrule()
  {
    if (! $repetitionId = $this->getRepetitionId())
    {
      return null;
    }
    else
    {
      $repetition = PcRepetitionPeer::retrieveByPk($repetitionId);

      if (! $repetition->needsParam())
      {
        return $repetition->getIcalRrule();
      }
      else
      {
        $repetitionParam = $this->getRepetitionParam();

        if($repetition->getSpecial() != 'selected_wkdays')
        {
            return str_replace('X', $repetitionParam, $repetition->getIcalRrule());
        }
        else
        {
            $weekdaysSet = DateFormat::fromIntegerToWeekdaysSetForRepetition($repetitionParam);

            $selectedWeekdays = array();

            foreach ($weekdaysSet as $k => $v)
            {
                if ($v)
                {
                    $selectedWeekdays[] = PcUtils::fromAbbreviationToIcalAbbreviation($k);
                }
            }

            $weekdays = implode(",", $selectedWeekdays);

            return str_replace('X', $weekdays, $repetition->getIcalRrule());
        }
      }
    }
  }



  /**
   * Re-arranges due date to the next occurrence on the repetition.
   * IMPORTANT: if the task hasn't got a due date, it uses the today's date
   *
   * @param bool $isInitialAdjustment - whether we want just to compute an initial adjustment
   */
  public function setNextOccurrence($isInitialAdjustment = false)
  {
    $repetition = PcRepetitionPeer::retrieveByPk($this->getRepetitionId());

    if ($repetition->getSpecial() == 'selected_wkdays')
    {
        $startingPointForDueDateTimestamp = (time() > $this->getDueDate('U')) ? time() : $this->getDueDate('U');

        $weekdaysSet = DateFormat::fromIntegerToWeekdaysSetForRepetition($this->getRepetitionParam());
        
        $closestWeekdayInSet = '9999999999'; // this big to make sure the first attempt of the following loop will set a value
        foreach($weekdaysSet as $k => $v)
        {
            if ($v)
            {
                $next = $isInitialAdjustment ? '' : 'next';
                $closestWeekdayInSetTemp = strtotime("$next $k", $startingPointForDueDateTimestamp); // i.e.: next mon
                if ($closestWeekdayInSetTemp < $closestWeekdayInSet)
                {
                    $closestWeekdayInSet = $closestWeekdayInSetTemp;
                }
            }
        }

        $nextTimestamp = $closestWeekdayInSet;
    }
    else  // standard repetition expression
    {
        $rce = $isInitialAdjustment ? $repetition->getInitialComputerExpression() :
                                      $repetition->getComputerExpression();
        $param = $repetition->isParamCardinal() ? $this->getRepetitionParam() : PcUtils::getOrdinalFromCardinal($this->getRepetitionParam());
        $rce = str_replace('_X_', $param, $rce);
        //$rce = str_replace('_Xlong_', PcUtils::getOrdinalFromCardinal($this->getRepetitionParam(), false), $rce);

        $todayTimestamp = strtotime('today');
        $dateFormat = DateFormat::getInstance();
        $oldDueDateTimestamp = 0;
        if ($this->getDueDate())
        {
          $loggedUser = PcUserPeer::getLoggedInUser();
          $oldDueDateTimestamp = $dateFormat->getTimestamp($this->getDueDate($loggedUser->getDateFormat()));
        }
        else
        {
          $oldDueDateTimestamp = $todayTimestamp;
        }

        $nextTimestamp = $oldDueDateTimestamp;

        if ( strpos($rce, '_month') === FALSE )
        {
          if ($isInitialAdjustment)
          {
            $nextTimestamp = strtotime($rce, $nextTimestamp);
          }
          else
          {
              // we are in the case we need to apply the computer expression just once or
              // over and over again
              do
              {
                $nextTimestamp = strtotime($rce, $nextTimestamp);
              } while ( ($nextTimestamp < $todayTimestamp) || ($nextTimestamp <= $oldDueDateTimestamp) );
          }
        }
        else
        {
          $i = 1;
          $repetitionParam = $this->getRepetitionParam();
          // we are in the case where to deal with months. We have to go through the months
          if ($isInitialAdjustment)
          {
                $monthPlus = date('F Y', strtotime('+ 0 months', $oldDueDateTimestamp));
                $rceWithReplacement = str_replace('_month_', $monthPlus, $rce);
                $nextTimestamp = strtotime($rceWithReplacement);

                // comparing just the timestamps was giving some unexpected results
                if ( date('Ymd', $nextTimestamp) < date('Ymd', $oldDueDateTimestamp) )
                {
                    $monthPlus = date('F Y', strtotime('+ 1 months', $oldDueDateTimestamp));
                    $rceWithReplacement = str_replace('_month_', $monthPlus, $rce);
                    $nextTimestamp = strtotime($rceWithReplacement);
                }
          }
          else
          {
              do
              {
                $oldDueDateTimestamp = $nextTimestamp;

                $oldDueDateTimestampFirstDayOfMonth = strtotime('first day of this month', $oldDueDateTimestamp);

                $monthPlus = date('F Y', strtotime('+' . $repetitionParam . 'months', $oldDueDateTimestampFirstDayOfMonth));
                $rceWithReplacement = str_replace('_month_', $monthPlus, $rce);

                $nextTimestamp = strtotime($rceWithReplacement);

                //  {{{ added this code to troubleshoot a PHP max execution error in this loop
                if ($i > 50)
                {
                    $watchdog = new PcWatchdog();
                    $watchdog->setType("NEXT RECURRENCE")->setDescription("taskId: {$this->getId()}")->save();

                    $watchdog3 = new PcWatchdog();
                    $watchdog3->setType("NEXT RECURRENCE")->setDescription("monthPlus: $monthPlus")->save();

                    $watchdog4 = new PcWatchdog();
                    $watchdog4->setType("NEXT RECURRENCE")->setDescription("rceWithReplacement: $rceWithReplacement")->save();

                    $watchdog6 = new PcWatchdog();
                    $watchdog6->setType("NEXT RECURRENCE")->setDescription($nextTimestamp)->save();

                    $watchdog7 = new PcWatchdog();
                    $watchdog7->setType("NEXT RECURRENCE")->setDescription($todayTimestamp)->save();

                    break;
                }
                // }}}
                $i++;
              } while ( ($nextTimestamp < $todayTimestamp) || ($nextTimestamp <= $oldDueDateTimestamp) );
           }
        }
    }

    $this->setDueDate(date('Y-m-d', $nextTimestamp), 'Y-m-d');
    $this->save();
  } 

/**
 * Returns a key that can be used for the view cache manager. It is unique among tasks,
 * not in the whole application.
 * A completed task has got the same HTML across different days ($dependsOnDate will be false)
 * The HTML for an incompleted task will change across days because the due date expression
 * will change (in 2 days, in 3 days,...)
 *
 * @param boolean $dependsOnDate - whether the task is related to a date that can change
 * @return string
 */
  public function getCacheKey($dependsOnDate)
  {
    $user = PcUserPeer::getLoggedInUser();

    if ($dependsOnDate && $user)
    {
      return date('Ymd', $user->getTime()) . $this->getId();
    }
    else
    {
      return $this->getId();
    }
  }

  public function isFromSystem()
  {
      return $this->getIsFromSystem();
  }

  /**
   * It is called by the save() method.
   * It populates the pc_tasks_contexts table.
   *
   * @return void
   */
  public function alignTasksContextsTable()
  {
      $contexts = $this->getContexts();

      // first, let's delete all the pre-existing contexts from this task
      $c = new Criteria();
      $c->add(PcTasksContextsPeer::TASK_ID, $this->getId());
      PcTasksContextsPeer::doDelete($c);

      $contexts = $this->getContexts();
      
      $contextIds = PcUtils::explodeWithEmptyInputDetection(',', $contexts);

      if (count($contextIds))
      {
          foreach($contextIds as $contextId)
          {
              if (is_numeric($contextId))
              {
                  $record = new PcTasksContexts();
                  $record->setTaskId($this->getId())
                         ->setUsersContextsId($contextId)
                         ->save();
              }
          }
      }
  }

    private function copyObjectToTrashBin()
    {
        $taskId = $this->getId();

        if(! ($trashBin = PcTrashbinTaskPeer::retrieveByPK($taskId)) )
        {
            $trashBin = new PcTrashbinTask();
        }

        $trashBin->setId($taskId)
                 ->setListId($this->getListId())
                 ->setDescription($this->getDescription())
                 ->setSortOrder($this->getSortOrder())
                 ->setDueDate($this->getDueDate())
                 ->setRepetitionId($this->getRepetitionId())
                 ->setRepetitionParam($this->getRepetitionParam())
                 ->setIsHeader($this->isHeader())
                 ->setIsCompleted($this->isCompleted())
                 ->setIsFromSystem($this->isFromSystem())
                 ->setNote($this->getNote())
                 ->setContexts($this->getContexts())
                 ->setContactId($this->getContactId())
                 ->setCompletedAt($this->getCompletedAt())
                 ->setUpdatedAt($this->getUpdatedAt())
                 ->setCreatedAt($this->getCreatedAt())
                 ->setDeletedAt(time('U'))
                 ->save();
    }

    /**
     * Returns whether the user is the correct owner of the task
     *
     * @param PcUser $user
     * @return bool
     */
    public function validateOwner(PcUser $user)
    {
        $list = PcListPeer::retrieveByPK($this->getListId());
        return ($list->getCreatorId() == $user->getId());
    }

  /**
   * Edit anything in a task
   * Only the input parameters that are not null will be changed.
   *
   * @param string $description (=null)
   * @param integer $listId (=null)
   * @param string $contexts (=null) (comma separated list)
   * @param boolean $isHeader
   * @param string $note (=null)
   * @param string $dueDate in the PHP date() format 'Y-m-d'
   * @param string $dueTime - formatted as an integer, ie: 0753
   * @param integer $repetitionId
   * @param integer $repetitionParam
   * @param integer $taskAboveId
   * @param string $callerContext - can be either 'ajax' or 'email'
   * @return     PcTask - the object that has been created
   */
    public function edit($description=null, $listId=null, $contexts=null, $isHeader=null, $note=null,
            $dueDate=null, $dueTime=null, $isStarred=null, $repetitionId=null, $repetitionParam=null, $callerContext='')
    {
        $description = ($description === null) ? $this->getDescription() : $description;
        $listId = ($listId === null) ? $this->getListId() : $listId;
        $contexts = ($contexts === null) ? $this->getContexts() : $contexts;
        $note = ($note === null) ? $this->getNote() : $note;
        $isHeader = ($isHeader === null) ? $this->isHeader() : $isHeader;
        $dueDate = ($dueDate === null) ? $this->getDueDate('Y-m-d') : $dueDate;
        $dueTime = ($dueTime === null) ? $this->getDueTime() : $dueTime;
        $isStarred = ($isStarred === null) ? $this->isStarred() : $isStarred;
        $repetitionId = ($repetitionId === null) ? $this->getRepetitionId() : $repetitionId;
        $repetitionParam = ($repetitionParam === null) ? $this->getRepetitionParam() : $repetitionParam;

        $taskId = $this->getId();
        PcTaskPeer::createOrEdit($description, $listId, $taskId, $contexts, $isHeader, $note,
                $dueDate, $dueTime, $isStarred, $repetitionId, $repetitionParam, 0, $callerContext, 'Y-m-d');
    }

    /**
     *
     * @param boolean $v
     * @return PcTask
     */
    public function setStarred($v)
    {
        return $this->setIsStarred($v);
    }

    /**
     *
     * @return bool
     */
    public function isStarred()
    {
        return $this->getIsStarred();
    }

    /**
     * @return string
     */
    public function getHumanFriendlyDueTime()
    {
        $dueTime = new PcTime();
        $dueTime->createFromIntegerValue($this->getDueTime());
        return $dueTime->getHumanFriendlyTime(PcUserPeer::getLoggedInUser());
    }

    /**
     * @param string $eventId
     */
    public function setGoogleCalendarEventId($eventId)
    {
        $googleCalendarEventEntry = PcGoogleCalendarEventPeer::retrieveByPK($this->getId());

        if (! is_object($googleCalendarEventEntry))
        {
            $googleCalendarEventEntry = new PcGoogleCalendarEvent();
        }

        $googleCalendarEventEntry->setTaskId($this->getId())
                                 ->setEventId($eventId)
                                 ->save();
    }

    /**
     * @return string|null
     */
    public function getGoogleCalendarEventId()
    {
        $googleCalendarEventEntry = PcGoogleCalendarEventPeer::retrieveByPK($this->getId());

        return $googleCalendarEventEntry ? $googleCalendarEventEntry->getEventId() : null;
    }

    /**
     * @return string|null
     */
    public function removeGoogleCalendarEventId()
    {
        $googleCalendarEventEntry = PcGoogleCalendarEventPeer::retrieveByPK($this->getId());
        if ($googleCalendarEventEntry)
        {
            $googleCalendarEventEntry->delete();
        }
    }

    public function deleteDirtyEntry()
    {
        $c = new Criteria();
        $c->add(PcDirtyTaskPeer::TASK_ID, $this->getId());
        return PcDirtyTaskPeer::doDelete($c);
    }
    
    public function __toString()
    {
        return $this->getDescription();
    }
    
    // input params are ignored
    // We have them just to avoid "Strict Standards warning"
    public function toArray($keyType = null, $includeLazyLoadColumns = null)
    {
        return array('id' => $this->getId(),
                   'description' => $this->getDescription(),
                   'listId' => $this->getListId(),
                   'isStarred' => (int)$this->isStarred(),
                   'isHeader' => (int)$this->isHeader(),
                   'dueDate' => ($this->getDueDate('Y-m-d') ? $this->getDueDate('Y-m-d') : ''),
                   'dueTime' => ($this->getDueTime() ? $this->getDueTime() : ''),
                   'repetitionId' => ($this->getRepetitionId() > 0) ? $this->getRepetitionId() : '',
                   'repetitionParam' => $this->getRepetitionParam(),
                   'note' => $this->getNote(),
                   'tagIds' => $this->getContexts());
    }
    
    /**
     * The same method is in the JS code: see PLANCAKE.localAPi__isTaskOnThisDay
     * 
     * @param int $day - in the format YYYY-MM-DD (e.g.: 2011-12-25)
     * @return bool
     */
    public function isOnThisDay($day)
    {
        if ( ($day === null) || (!strlen($day)) ) 
        {
            return false;
        }
        
        $dayTimestamp = strtotime($day);
        $dayDowIndex = date('w', $dayTimestamp); // 0 -> Sun ...... 6-> Sat
        
        $taskDueDate = $this->getDueDate('Y-m-d');
        $taskDueDateTimestamp = strtotime($taskDueDate);
        $taskDueDateDowIndex = date('w', $taskDueDateTimestamp); // 0 -> Sun ...... 6-> Sat
        
        $taskRepetitionId = $this->getRepetitionId();
        $taskRepetitionParam = $this->getRepetitionParam();
        
        
        $daysBetweenDayAndDueDate = ($dayTimestamp - $taskDueDateTimestamp) / 86400;
        $weeksBetweenDayAndDueDate = $daysBetweenDayAndDueDate / 7;
        $monthsBetweenDayAndDueDate = (((int)date('Y', $dayTimestamp) - (int)date('Y', $taskDueDateTimestamp)) * 12) + 
                        ((int)date('n', $dayTimestamp) - (int)date('n', $taskDueDateTimestamp));
        
        if (!$taskDueDate) {         
            return false;
        }        
        
        // this is a repetiting task starting in the future, not on the current day
        if ( $taskRepetitionId && ($taskDueDateTimestamp > $dayTimestamp) ) {
           return false;
        }        
        
        if ($taskDueDate == $day) {
            return true;
        }
        
        if ($taskRepetitionId < 7) { // every Sun, every Mon, ... or every Sat            
            if (($taskRepetitionId-1) === $dayDowIndex)
            {
                return true;
            }
        }        
        
        if ($taskRepetitionId == 8) { // every day
            return true;
        }
        
        if ($taskRepetitionId == 9) { // every weekday
            if ( ($dayDowIndex > 0) && ($dayDowIndex < 6) )  
            {
                return true;
            }
        }
        
        if ( ($taskRepetitionId == 10) && $taskRepetitionParam) { // every X days
            if ( !($daysBetweenDayAndDueDate % $taskRepetitionParam) )  
            {
                return true;
            }
        }      
        
        if ( $taskRepetitionId == 11 ) { // every week
            if ( $dayDowIndex === $taskDueDateDowIndex )  
            {
                return true;
            }
        }         

        if ( $taskRepetitionId == 12 ) { // every X weeks
            if ( ($dayDowIndex === $taskDueDateDowIndex) &&
                 !($weeksBetweenDayAndDueDate % $taskRepetitionParam) )  
            {
                return true;
            }
        }        
        
        if ( $taskRepetitionId == 13 ) { // every month on the due date day
            if ( date('d', $taskDueDateTimestamp) === date('d', $dayTimestamp) )  
            {
                return true;
            }
        }
        
        if ( $taskRepetitionId == 14 ) { // every X months on the due date day
            if ( date('d', $taskDueDateTimestamp) === date('d', $dayTimestamp) &&
                 !($monthsBetweenDayAndDueDate % $taskRepetitionParam) )  
            {
                return true;
            }
        }         
        
        if ( $taskRepetitionId == 15 ) { // every year
            if ( (date('d', $taskDueDateTimestamp) === date('d', $dayTimestamp)) &&
                 (date('n', $taskDueDateTimestamp) === date('n', $dayTimestamp)) )  
            {
                return true;
            }
        }
        
        if ( $taskRepetitionId == 16 ) { // every X years
            if ( (date('d', $taskDueDateTimestamp) === date('d', $dayTimestamp)) &&
                 (date('n', $taskDueDateTimestamp) === date('n', $dayTimestamp)) &&
                 !((date('Y', $dayTimestamp) - date('Y', $taskDueDateTimestamp)) % $taskRepetitionParam) )  
            {
                return true;
            }
        }
        
        if ( $taskRepetitionId == 18 ) { // every [select later] month(s) on the last day
            if ( !($monthsBetweenDayAndDueDate % $taskRepetitionParam) &&
                 (date('t', $dayTimestamp) == date('d', $dayTimestamp)) )  
            {
                return true;
            }
        }
             
        if ( $taskRepetitionId == 19 ) { // every [select later] month(s) on the second last day
            if ( !($monthsBetweenDayAndDueDate % $taskRepetitionParam) &&
                 ((date('t', $dayTimestamp)-1) == date('d', $dayTimestamp)) )  
            {
                return true;
            }
        }
        
        if ( ($taskRepetitionId >= 20) && ($taskRepetitionId <= 26) ) { // every X month(s) on the first Sun/Mon..../Sat
            if ( !($monthsBetweenDayAndDueDate % $taskRepetitionParam) &&  // correct "every X months"
                 ($dayDowIndex ==  ($taskRepetitionId - 20)) &&  // correct dow
                 (date('j', $dayTimestamp) <= 7) ) // first week
            {
                return true;
            }            
        }

        if ( ($taskRepetitionId >= 27) && ($taskRepetitionId <= 33) ) { // every X month(s) on the last Sun/Mon..../Sat
            if ( !($monthsBetweenDayAndDueDate % $taskRepetitionParam) &&  // correct "every X months"
                 ($dayDowIndex ==  ($taskRepetitionId - 27)) &&  // correct dow
                 ( (date('j', $dayTimestamp) > (date('t', $dayTimestamp) -7)) ) ) // last week
            {
                return true;
            }             
        }        
        
        if ( $taskRepetitionId == 34 ) { // repeat weekly on some weekdays
            $weekdaysSet = DateFormat::fromIntegerToWeekdaysSetForRepetition($taskRepetitionParam);
            $key = strtolower(date('D', $dayTimestamp));
            if ( $weekdaysSet[$key] )
            {
                return true;
            }
        }
                
        if ( ($taskRepetitionId >= 40) && ($taskRepetitionId <= 46) ) { // every X month(s) on the second Sun/Mon..../Sat
            if ( !($monthsBetweenDayAndDueDate % $taskRepetitionParam) &&  // correct "every X months"
                 ($dayDowIndex ==  ($taskRepetitionId - 40)) &&  // correct dow
                 ( (date('j', $dayTimestamp) > 7) && (date('j', $dayTimestamp) <= 14)  ) ) // second week
            {
                return true;
            }            
        }

        if ( ($taskRepetitionId >= 50) && ($taskRepetitionId <= 56) ) { // every X month(s) on the third Sun/Mon..../Sat
            if ( !($monthsBetweenDayAndDueDate % $taskRepetitionParam) &&  // correct "every X months"
                 ($dayDowIndex ==  ($taskRepetitionId - 50)) &&  // correct dow
                 ( (date('j', $dayTimestamp) > 14) && (date('j', $dayTimestamp) <= 21)  ) ) // third week
            {
                return true;
            }            
        }
        
        if ( ($taskRepetitionId >= 60) && ($taskRepetitionId <= 66) ) { // every X month(s) on the fourth Sun/Mon..../Sat
            if ( !($monthsBetweenDayAndDueDate % $taskRepetitionParam) &&  // correct "every X months"
                 ($dayDowIndex ==  ($taskRepetitionId - 60)) &&  // correct dow
                 ( (date('j', $dayTimestamp) > 21) && (date('j', $dayTimestamp) <= 28)  ) ) // second week
            {
                return true;
            }            
        }         
        
        return false;
    }
    
	/**
	 * @Overriding
         * 
         * We have to trim nicely in the case the list of tagIds is longer than the db
         * allows in order not to have truncated Ids.
         * 
	 * @param      string $v new value - comma separated list of Ids
	 * @return     PcTask The current object (for fluent API support)
	 */
	public function setContexts($v)
	{
                // sorting
                $vArray = explode(',', $v);
                sort($vArray);
                $v = implode(',', $vArray);
                
                // truncating if necessary to fit into the db
		$contextsFieldLength = Propel::getDatabaseMap()->getColumn(PcTaskPeer::CONTEXTS)->getSize();
                
                if ($contextsFieldLength && (strlen($v) > $contextsFieldLength) ) {
                    $v = substr($v, 0, $contextsFieldLength);          
                    if (substr($v, -1) == ',') { // last character is a comma
                        $v = substr($v, 0, $contextsFieldLength-1);
                    } else { // removing all the last digit because they probably are a truncated id
                        $v = explode(',', $v);
                        array_pop($v);
                        $v = implode(',', $v);                        
                    }
                }

                parent::setContexts($v);
		return $this;
	} // setContexts()    
}
