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

class PcUser extends BasePcUser
{
  /**
   * @param string $plainPassword - the plain password to set
   */
  public function setPassword($plainPassword)
  {
    $salt = PcUtils::generateRandomString(12);
    $this->setSalt($salt);
    parent::setEncryptedPassword(PcUtils::createEncryptedPassword($plainPassword, $salt));
    return $this;
  }

  /**
   * Sets language truncating it to 8 characters.
   * 
   * @see        parent::setLanguage()
   * @param      string $v the value to set as language
   * @return     PcTask The current object (for fluent API support)
   */
  public function setLanguage($v)
  {
    $v = substr($v, 0, 8);
    return parent::setLanguage($v);
  }

  /**
   * Returns all the lists owned by the user
   * On top there are the items with the greater sortOrder
   * 
   * @return     array of PcList
   */
  public function getLists()
  {
    if ($cache = PcCache::getInstance())
    {
      $key = __METHOD__ . $this->getId();
      if ($cache->has($key))
      {
        return $cache->get($key); 
      }
    }

    $ret = null;
    foreach($this->getAllLists() as $list)
    {
      if (!$list->isSystem()) $ret[] = $list;
    }  

    if( $cache ) $cache->set($key, $ret);
    return $ret;
  }

  /**
   * Returns the system lists owned by the user: Inbox and Todo
   * 
   * @return     array of PcList
   */
  public function getSystemLists()
  {
    if ($cache = PcCache::getInstance())
    {
      $key = __METHOD__ . $this->getId();
      if ($cache->has($key))
      {
        return $cache->get($key); 
      }
    }

    $ret = null;
    $c = new Criteria();
    $c->add(PcListPeer::CREATOR_ID, $this->getId(), Criteria::EQUAL);
    $c->add(PcListPeer::IS_INBOX, 1, Criteria::EQUAL);
    $ret[] = PcListPeer::doSelectOne($c);
    $c = new Criteria();
    $c->add(PcListPeer::CREATOR_ID, $this->getId(), Criteria::EQUAL);
    $c->add(PcListPeer::IS_TODO, 1, Criteria::EQUAL);
    $ret[] = PcListPeer::doSelectOne($c);

    if( $cache ) $cache->set($key, $ret);
    return $ret;
  }

  /**
   * Returns all lists owned by the user (Inbox+Todo+any other list)
   * 
   * @return     array of PcList
   */
  public function getAllLists()
  {
    if ($cache = PcCache::getInstance())
    {
      $key = __METHOD__ . $this->getId();
      if ($cache->has($key))
      {
        return $cache->get($key); 
      }
    }

    $criteria = new Criteria();
    $criteria->add(PcListPeer::CREATOR_ID, $this->getId(), Criteria::EQUAL);
    $criteria->addDescendingOrderByColumn(PcListPeer::IS_INBOX);
    $criteria->addDescendingOrderByColumn(PcListPeer::IS_TODO);
    $criteria->addAscendingOrderByColumn(PcListPeer::SORT_ORDER);
    $ret = PcListPeer::doSelect($criteria);

    if( $cache ) $cache->set($key, $ret);
    return $ret;
  }

  /**
   * Returns all the lists owned by the user
   * On top there are the items with the greater sortOrder
   * 
   * @return     array of PcList
   */
  public function getTimezoneLabel()
  {
    return PcTimezonePeer::retrieveByPk($this->getTimezoneId())->getLabel();
  }

  /**
   * Returns the number of lists owned by the user
   * 
   * @return     integer
   */
  public function getListsCounter()
  {
    return count($this->getLists());
  }

  /**
   * Returns the HTML of a select tag with all the lists and headers owned by the user
   * The value for the option tag is the list ID
   * Gives the class listInSelectTag to all the lists that are not headers,
   * the class headerInSelectTag to all the headers
   * 
   * @param string $id (= 'listsSelect) the id for the select tag
   * @param integer $selectedListId (=null) - the listId to mark as selected or 0 to select no list (otherwise, Inbox as default)
   * @param boolean $includeSystemLists (=true) whether to display the system lists
   * @return string   
   */
  public function getListsSelectTag($id = 'listsSelect', $selectedListId = null, $includeSystemLists = true)
  {
    $tag = '<select id="' . $id .'">';
    if ($includeSystemLists)
    {
      foreach($this->getSystemLists() as $list)
      {
        $listId = $list->getId();
        $selected = '';

        if (($selectedListId===null) && ($list->isInbox())) // if a list isn't specified, let's default to the Inbox
        {
	        $selected = ' selected="selected" ';
        }
        else if ($selectedListId && ($selectedListId == $listId))
        {
	        $selected = ' selected="selected" ';
        }
        $tag .= "<option value=\"$listId\" $selected>{$list->getTitle()}</options>";
      }
    }
    if ($selectedListId == 0)
    {
      $tag .= "<option value='0' selected=\"selected\">--------------</option>";
    }
    else
    {
      $tag .= "<option value='0'>--------------</option>";
    }
    $lists = $this->getLists();
    if (count($lists))
    {
      foreach($lists as $list)
      {
        $listId = $list->getId();
        $selected = '';
        if ($selectedListId && ($selectedListId == $listId))
        {
	        $selected = ' selected="selected" ';
        }
        $optionClass = $list->isHeader() ? 'headerInSelectTag' : 'listInSelectTag';
        $tag .= "<option class=\"$optionClass\" value=\"$listId\" $selected>{$list->getTitle()}</options>";
      }
    }
    $tag .= '</select>';
    return $tag;
  }

  /**
   * Returns an asspciative array with these keys:
   * overdue   - boolean - indicating whether the user has got some overdue task
   * today   - boolean - indicating whether the user has got some task for today
   * tomorrow   - boolean - indicating whether the user has got some task for tomorrow
   * 
   * @return array of booleans
   */
  public function getStatsForTasksWithDueDate()
  {
    $ret = array('overdue' => false, 'today' => false, 'tomorrow' => false);
    
    $c = new Criteria();
    $c->addJoin(PcTaskPeer::LIST_ID, PcListPeer::ID, Criteria::INNER_JOIN);
    $c->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $c->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNOTNULL);
    $c->add(PcListPeer::CREATOR_ID, $this->getId(), Criteria::EQUAL);
    $c->addAscendingOrderByColumn(PcTaskPeer::DUE_DATE);
    $tasks = PcTaskPeer::doSelect($c);

    foreach ($tasks as $task)
    {
      if (($ret['overdue'] == false) && $task->isOverdue())
      {
        $ret['overdue'] = true;
      }
      else if (($ret['today'] == false) && $task->isToday())
      {
        $ret['today'] = true;
      }
      else if ($task->isTomorrow())
      {
        $ret['tomorrow'] = true;
        break;
      }

      if (!$ret['overdue'] && !$ret['today'] && !$ret['tomorrow'])
      {
        // this means there are not tasks overdue/for today/for tomorrow, that is
        // all of them have got a due date further than tomorrow.
        break;
      }
    }
    return $ret;
  }

  /**
   * Maps the ids on the database to a string:
   * 0 -> Y-m-d
   * 3 -> d-m-Y
   * 4 -> m-d-Y 
   * 
   * @param boolean $returnIndex (=false) - whether to return the actual format or the index
   * @return string
   */
  public function getDateFormat($returnIndex = false)
  {
    if ($returnIndex)
    {
      return parent::getDateFormat();
    }

    $dt = PcCommonData::getDateFormats();
    return $dt[parent::getDateFormat()];
  }

  /**
   * The PHP time() function has got GMT as a refence (because of our Symfony timezone setting)
   * This function returns the UNIX time, considering the timezone and dst of the user
   *
   * @return integer
   */
  public function getTime()
  {
    return time() + $this->getRealOffsetFromGMT();
  }

  /**
   * Returns the real offset in seconds between and GMT and user settings, 
   * considering both the timezone and dst of the user
   *
   * @return integer
   */
  public function getRealOffsetFromGMT()
  {
    $timezone = PcTimezonePeer::retrieveByPk($this->getTimezoneId());
    $ret = 0;
    if ($timezone)
    {
        $timezoneOffsetFromGMT = $timezone->getOffset(); // in minutes
        $dstOffsetFromGMT = $this->getDstActive() * 60; // in minutes // if dst is active, the clock is 1 hour forward
        $ret = ($timezoneOffsetFromGMT * 60) + ($dstOffsetFromGMT * 60);
    }
    return $ret;
  }

  /**
   * @return PcList 
   */
  public function getInbox()
  {
    $criteria = new Criteria();
    $criteria->add(PcListPeer::CREATOR_ID, $this->getId(), Criteria::EQUAL);
    $criteria->add(PcListPeer::IS_INBOX, 1, Criteria::EQUAL);
    return PcListPeer::doSelectOne($criteria);    
  }

  /**
   * @return PcList
   */
  public function getTodo()
  {
    $criteria = new Criteria();
    $criteria->add(PcListPeer::CREATOR_ID, $this->getId(), Criteria::EQUAL);
    $criteria->add(PcListPeer::IS_TODO, 1, Criteria::EQUAL);
    return PcListPeer::doSelectOne($criteria);
  }

  /**
   * Returns the number of items in the Inbox
   *
   * @return integer
   */
  public function getInboxCounter()
  {
    $con = Propel::getConnection();
    $sql = "SELECT count(*) AS counter FROM pc_task WHERE is_completed=0 AND list_id=" . (int)$this->getInbox()->getId();
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $resultset = $stmt->fetch();
    return $resultset['counter'];
  }


  /**
   * Returns the number of items overdue or due today
   *
   * @return integer
   */
  public function getOverdueDueTodayCounter()
  {
    $criteria = new Criteria();
    $lists = $this->getAllLists();
    $listsId = array();
    foreach($lists as $list)
    {
      $listsId[] = $list->getId();
    }

    $criteria->add(PcTaskPeer::LIST_ID, $listsId, Criteria::IN);
    $criteria->add(PcTaskPeer::IS_COMPLETED, 0, Criteria::EQUAL);
    $criteria->add(PcTaskPeer::DUE_DATE, NULL, Criteria::ISNOTNULL);

    $today = date('Y-m-d', strtotime('today'));
    $criteria->add(PcTaskPeer::DUE_DATE, $today, Criteria::LESS_EQUAL);

    return PcTaskPeer::doCount($criteria);
  }

  /**
   * Returns all the contexts.
   * Similar to getContextsArray() BUT:
   * Every element of the array in an associative array with id and name as keys
   *
   * @param int $fromTimestamp (=null) - to return only the contexts that have been edited since
   * @param int $toTimestamp (=null) - to return only the contexts that have been edited till
   * @return array
   */
  public function getContexts($fromTimestamp = null, $toTimestamp = null)
  {
    if ($fromTimestamp === null) // using the cache only when we don't pass $timestamp
    {
        if ($cache = PcCache::getInstance())
        {
          $key = __METHOD__ . $this->getId();
          if ($cache->has($key))
          {
            return $cache->get($key);
          }
        }
    }

    $criteria = new Criteria();
    $criteria->add(PcUsersContextsPeer::USER_ID, $this->getId(), Criteria::EQUAL);

    if ($fromTimestamp !== null)
    {
        $criteria->add(PcUsersContextsPeer::UPDATED_AT, PcUtils::getMysqlTimestamp($fromTimestamp), Criteria::GREATER_EQUAL);
        $criteria->addAnd(PcUsersContextsPeer::UPDATED_AT, PcUtils::getMysqlTimestamp($toTimestamp), Criteria::LESS_THAN);
    }

    $criteria->addAscendingOrderByColumn(PcUsersContextsPeer::SORT_ORDER);
    $criteria->addAscendingOrderByColumn(PcUsersContextsPeer::ID);

    $contexts = PcUsersContextsPeer::doSelect($criteria);

    $ret = array();
    foreach($contexts as $context)
    {
      $ret[] = array('id' => $context->getId(), 'name' => $context->getContext(), 'sort_order' => $context->getSortOrder());
    }

    if ($fromTimestamp === null) // using the cache only when we don't pass $timestamp
    {
        if( $cache ) $cache->set($key, $ret);
    }
    
    return $ret;
  }

  /**
   * Returns all the contexts.
   * Similar to getContexts() BUT:
   * Every element of the array is a contextName, having the contextId as a key
   *
   * @param boolean $returnLowercase (=false)
   * @return array
   */
  public function getContextsArray($returnLowercase = false)
  {
    if ($cache = PcCache::getInstance())
    {
      $key = __METHOD__ . $this->getId();
      if ($cache->has($key))
      {
        return $cache->get($key); 
      }
    }

    $criteria = new Criteria();
    $criteria->add(PcUsersContextsPeer::USER_ID, $this->getId(), Criteria::EQUAL);
    $contexts = PcUsersContextsPeer::doSelect($criteria);
    foreach($contexts as $context)
    {
      $contextName = $returnLowercase ? strtolower($context->getContext()) : $context->getContext();
      $ret[$context->getId()] = $contextName;
    }

    if( $cache ) $cache->set($key, $ret);
    return $ret;
  }

  /**
   * Returns the Plancake email address of the user (including the domain)
   *
   * @return string
   */
  public function getPlancakeEmailAddress()
  {
    $c = new Criteria();
    $c->add(PcPlancakeEmailAddressPeer::USER_ID, $this->getId(), Criteria::EQUAL);
    return PcPlancakeEmailAddressPeer::doSelectOne($c)->getEmail() . '@' . sfConfig::get('app_emailToInbox_mailServerDomain');
  }

  /**
   * Generate and store a Plancake Email address
   *
   */
  public function generateAndStorePlancakeEmailAddress()
  {
    do
    {
      $truncatedUserEmail = preg_replace('/@.*$/', '', $this->getEmail());
      $randomPart = mt_rand(10,99) . chr(mt_rand(97, 122)) . mt_rand(100,999);
      $plancakeEmailAddressWithoutDomain = 'inbox_' . $truncatedUserEmail . '_' . $randomPart;
      // I double check the email address doesn't exist already
      $c = new Criteria();
      $c->add(PcPlancakeEmailAddressPeer::EMAIL, $plancakeEmailAddressWithoutDomain, Criteria::EQUAL);
      $entry = PcPlancakeEmailAddressPeer::doSelectOne($c);
    } while( is_object($entry) );

    $plancakeEmailDbEntry = new PcPlancakeEmailAddress();
    $plancakeEmailDbEntry->setUserId($this->getId())->setEmail($plancakeEmailAddressWithoutDomain)->save();
  }

  /**
   * @return boolean
   */
  public function isAdmin()
  {
    $adminUserEmails = sfConfig::get('app_site_adminUserEmails');
    return in_array($this->getEmail(), $adminUserEmails);
  }

  /**
   * @return boolean
   */
  public function isStaffMember()
  {
    $staffMemberEmails = sfConfig::get('app_site_staffEmails');
    return in_array($this->getEmail(), $staffMemberEmails);
  }

  /**
   * @return boolean
   */
  public function isContractor()
  {
    $contractorEmails = sfConfig::get('app_site_contractorEmails');
    if (! $contractorEmails) {
        return false;
    }
    return in_array($this->getEmail(), $contractorEmails);
  }  

  /**
   * @return boolean
   */
  public function isEditor()
  {
    $editorEmails = sfConfig::get('app_site_editorEmails');
    if (! $editorEmails) {
        return false;
    }
    return in_array($this->getEmail(), $editorEmails);
  }  
  
  /**
   * @return boolean
   */
  public function isTranslator()
  {
      return is_object(PcTranslatorPeer::retrieveByPK($this->getId()));
  }

  /**
   * @return string (empty string if the user hasn't got an avatar)
   */
  public function getAvatarFullPath()
  {
      // see generate_avatar_markup PunBB function

      // the avatar file can have a number of extensions: jpg, gif, png
      $fileFullPathWildcard = sfConfig::get('sf_web_dir') . '/' .
                              sfConfig::get('app_avatar_relativeRoot') . '/' .
                              $this->getForumId() . '_*.*';
      $filenames = glob($fileFullPathWildcard);

      if (empty($filenames))
      {
        return $this->getDefaultAvatarFullPath();
      }

      if ( count($filenames) > 1 )
      {
          throw new Exception("There is more than one avatar for the user " . $this->getId());
      }

      return $filenames[0];
  }

  /**
   * @return string
   */
  public function getAvatarUrl()
  {
      $avatarFullPath = $this->getAvatarFullPath();
      // that is something like: /var/www/plancake/web/forums/img/avatars/2269.jpg
      // and we need /forums/img/avatars/2269.jpg
      return substr($avatarFullPath, strlen(sfConfig::get('sf_web_dir')));
  }

  /**
   * @return string (empty string if the user hasn't got an avatar)
   */
  public function getDefaultAvatarFullPath()
  {
    return sfConfig::get('sf_web_dir') . '/' . sfConfig::get('app_avatar_relativeDefaultPath');
  }

  /**
   * @return boolean
   */
  public function hasAvatar()
  {
    return ($this->getAvatarFullPath() != $this->getDefaultAvatarFullPath());
  }

  /**
   * @return array (of int)
   */
  public function getAllListIds()
  {
      $ids = array();
      $lists = $this->getAllLists();

      foreach ($lists as $list)
      {
          $ids[] = $list->getId();
      }
      return $ids;
  }

    /**
    *
     * @param int $fromTs (=null) - GMT
     * @param int $toTs (=null) - GMT
    * @return array (of PcTrashbinTask)
    */
  public function getDeletedTasksSince($fromTs, $toTs)
  {
    $c = new Criteria();

    // this method returns only the non-deleted lists
    $listIds = $this->getAllListIds();

    // but most of the deleted lists will carry deleted tasks with them
    $deletedLists = $this->getDeletedListsSince($fromTs, $toTs);

    foreach($deletedLists as $deletedList)
    {
        $listIds[] = $deletedList->getId();
    }

    $c->add(PcTrashbinTaskPeer::LIST_ID, $listIds, Criteria::IN);
    return PcTrashbinTaskPeer::getDeletedTasksSince($fromTs, $toTs, $c);
  }


    /**
    *
    * @param int $fromTimestamp (GMT)
    * @param int $toTimestamp (GMT)
    * @return array (of PcTrashbinTask)
    */
  public function getDeletedListsSince($fromTimestamp, $toTimestamp)
  {
    $c = new Criteria();
    $c->add(PcTrashbinListPeer::CREATOR_ID, $this->getId());
    return PcTrashbinListPeer::getDeletedListsSince($fromTimestamp, $toTimestamp, $c);
  }


    /**
    *
    * @param int $fromTimestamp (GMT)
    * @param int $toTimestamp (GMT)
    * @return array (of PcTrashbinTask)
    */
  public function getDeletedContextsSince($fromTimestamp, $toTimestamp)
  {
    $c = new Criteria();
    $c->add(PcTrashbinUsersContextsPeer::USER_ID, $this->getId());
    return PcTrashbinUsersContextsPeer::getDeletedContextsSince($fromTimestamp, $toTimestamp, $c);
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
     * @return array of PcTask
     */
  public function getTasksByMultipleCriteria($fromTs = null,
                                             $toTs = null,
                                             $taskId = null,
                                             $listId = null,
                                             $tagId = null,
                                             $completed = false,
                                             $onlyWithDueDate = false,
                                             $onlyWithoutDueDate = false,
                                             $onlyDueTodayOrTomorrow = false,
                                             $onlyStarred = false,
                                             $byDate = null)
  {
     $c = new Criteria();
     $c->addJoin(PcTaskPeer::LIST_ID, PcListPeer::ID, Criteria::INNER_JOIN);
     $c->add(PcListPeer::CREATOR_ID, $this->getId());

     return PcTaskPeer::getTasksByMultipleCriteria($fromTs,
                                             $toTs,
                                             $taskId,
                                             $listId,
                                             $tagId,
                                             $completed,
                                             $onlyWithDueDate,
                                             $onlyWithoutDueDate,
                                             $onlyDueTodayOrTomorrow,
                                             $onlyStarred,
                                             $byDate,
                                             $c);
  }

  /**
   * It counts also the trial period
   *
   * @return boolean
   */
  public function isSupporter()
  {
    $c = new Criteria();
    $c->add(PcSupporterPeer::USER_ID, $this->getId());
    $c->add(PcSupporterPeer::EXPIRY_DATE, date('Y-m-d'), Criteria::GREATER_EQUAL);
    return is_object(PcSupporterPeer::doSelectOne($c));
  }

  /**
   * We consider a subscription ending soon when there are less than 2 weeks left
   *
   * @return boolean
   */
  public function isSubscriptionGoingToExpireSoon()
  {
    $c = new Criteria();
    $c->add(PcSupporterPeer::USER_ID, $this->getId());
    $c->add(PcSupporterPeer::EXPIRY_DATE, date('Y-m-d'), Criteria::GREATER_EQUAL);
    $c->add(PcSupporterPeer::EXPIRY_DATE, date('Y-m-d', strtotime("2 weeks")), Criteria::LESS_THAN);
    return is_object(PcSupporterPeer::doSelectOne($c));
  }

  /**
   * We want to show an alert during the last week of subscription, any other day
   *
   * @return boolean
   */
  public function isExpiringSubscriptionAlertToShow()
  {
    $c = new Criteria();
    $c->add(PcSupporterPeer::USER_ID, $this->getId());
    $c->add(PcSupporterPeer::IS_RENEWAL_AUTOMATIC, 0);    
    $c->add(PcSupporterPeer::EXPIRY_DATE, date('Y-m-d'), Criteria::GREATER_EQUAL);
    $c->addAnd(PcSupporterPeer::EXPIRY_DATE, date('Y-m-d', strtotime("2 weeks")), Criteria::LESS_THAN);

    $isEndingVerySoon = is_object(PcSupporterPeer::doSelectOne($c));  
    
    // we want to display any other day...
    return ( $isEndingVerySoon && ((date('j')%2) == 0) );
  }
  
  /**
   * We consider a subscription ending soon when there are less than 2 weeks left
   *
   * @return boolean
   */
  public function isSubscriptionExpired()
  {
    $c = new Criteria();
    $c->add(PcSupporterPeer::USER_ID, $this->getId());
    $c->add(PcSupporterPeer::EXPIRY_DATE, date('Y-m-d'), Criteria::LESS_THAN);
    return is_object(PcSupporterPeer::doSelectOne($c));
  } 

  /**
   *
   * @return array of PcNote
   */
  public function getNotes()
  {
    $c = new Criteria();
    $c->add(PcNotePeer::CREATOR_ID, $this->getId());
    $c->addDescendingOrderByColumn(PcNotePeer::UPDATED_AT);
    return PcNotePeer::doSelect($c);
  }

  /**
   *
   * @return int
   */
  public function getNotesCount()
  {
    $c = new Criteria();
    $c->add(PcNotePeer::CREATOR_ID, $this->getId());
    return PcNotePeer::doCount($c);
  }

  public function refreshLastLogin()
  {
      $this->setLastLogin(PcUtils::getMysqlTimestamp(time()));
      return $this;
  }

  /**
   *
   * @param string $taskDescription
   */
  public function addToInbox($taskDescription)
  {
    $task = new PcTask();
    $task->setListId($this->getInbox()->getId())
           ->setIsFromSystem(true)
           ->setDescription($taskDescription)
           ->save();
  }

  /**
   * @return int
   */
  public function getNumberOfDaysSinceRegistration()
  {
      $registrationTimestamp = $this->getCreatedAt('U');
      $todayTimestamp = time();

      return floor(($todayTimestamp - $registrationTimestamp) / 86400);
  }

  public function hasGoogleCalendarIntegrationActive()
  {
      if ($googleCalendar = PcGoogleCalendarPeer::retrieveByUser($this))
      {
          if ($googleCalendar->getIsActive() &&
              $googleCalendar->getCalendarUrl() &&
              $googleCalendar->getSessionToken())
          {
              return true;
          }
          else
          {
              return false;
          }
      }
  }

  /**
   * @return bool
   */
  public function isItalian()
  {
    return (stripos($this->getPreferredLanguage(), 'it') !== FALSE);
  }

  /**
   * @return string|null
   */
  public function getKey()
  {
      $dbEntry = PcUserKeyPeer::retrieveByPK($this->getId());
      if ($dbEntry)
      {
          return $dbEntry->getKey();
      }
      else
      {
          return null;
      }
  }

  public function __toString()
  {
      return $this->getEmail();
  }

  /**
   * @return int
   */
  public function getBlogPostsCounterSinceLatestBlogAccess()
  {
    $c = new Criteria();
    $posts = 0;
    if ($this->getLatestBlogAccess())
    {
        $c->add(PcBlogPostPeer::PUBLISHED_AT, $this->getLatestBlogAccess(), Criteria::GREATER_EQUAL);
        $posts = PcBlogPostPeer::doCount($c);
    }
    return $posts;
  }

  public function refreshLatestBlogAccess()
  {
      $this->setLatestBlogAccess(time())->save();
  }
  
  /**
   * @return Object|null (PcBreakingNews)
   */
  public function getBreakingNews()
  {
      $c = new Criteria();
      $c->addDescendingOrderByColumn(PcBreakingNewsPeer::ID);
      $c->setLimit(1);
      $breakingNews = PcBreakingNewsPeer::doSelectOne($c);
      
      if ($this->getLatestBreakingNewsClosed() && 
              ($this->getLatestBreakingNewsClosed() === $breakingNews->getId()))
      {
          // the user has read and closed the breaking news
          return null;
      }
      
      if (is_object($breakingNews) && is_object($this) && $this->getCreatedAt() &&
         ($breakingNews->getCreatedAt() < $this->getCreatedAt()) )
      {
          // the user signed up after the breaking news was broadcast
          return  null;          
      }
      
      return $breakingNews;
  }
  
  public function getHideableHintsSetting()
  {
      $ret = array();
      
      $setting = PcHideableHintsSettingPeer::retrieveByPK($this->getId());
      if (is_object($setting))
      {
          $ret[PcHideableHintsSettingPeer::INBOX_HINT] = (int)$setting->getInbox();
          $ret[PcHideableHintsSettingPeer::TODO_HINT] = (int)$setting->getTodo();     
          $ret[PcHideableHintsSettingPeer::COMPLETED_HINT] = (int)$setting->getCompleted();         
          $ret[PcHideableHintsSettingPeer::QUOTE_HINT] = (int)$setting->getQuote();
      }
      else
      {
          $ret[PcHideableHintsSettingPeer::INBOX_HINT] = 0;
          $ret[PcHideableHintsSettingPeer::TODO_HINT] = 0;     
          $ret[PcHideableHintsSettingPeer::COMPLETED_HINT] = 0;
          $ret[PcHideableHintsSettingPeer::QUOTE_HINT] = 0;
      }
      
      return $ret;
  }
}
