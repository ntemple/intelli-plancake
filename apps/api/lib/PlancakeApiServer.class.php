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
 * Description of PlancakeApiServer
 *
 * @author dan
 */
class PlancakeApiServer
{

    const INVALID_METHOD_ERROR = 10;
    const MISSING_TOKEN_ERROR = 20;
    const MISSING_SIGNATURE_ERROR = 21;
    const MISSING_PARAMETER_ERROR = 22;
    const MISSING_API_VERSION = 24;
    const MISSING_USER_KEY_ERROR = 25;
    const INVALID_USER_KEY_ERROR =26;
    const INVALID_TOKEN_ERROR = 30;
    const INVALID_SIGNATURE_ERROR = 31;
    const INVALID_API_KEY_ERROR = 32;
    const INVALID_API_KEY_OR_TOKEN_ERROR = 33;
    const MISSING_FROMTS_OR_TOTS_PARAMETER_ERROR = 40;
    const RATE_LIMIT_REACHED = 50;
    const RESOURCE_DOESNT_EXIST_ERROR = 100;
    const PERMISSION_MISMATCH_ERROR = 101;
    const OPERATION_NOT_PERMITTED_ERROR = 110;
    const SERVICE_UNAVAILABLE_ERROR = 500;
    const UNKNOWN_ERROR = 999;

    const API_VERSION_ERROR = 210;
    const WRONG_AUTHENTICATION_ERROR = 220;
    const TASK_DUE_TIME_NOT_APPLICABLE_ERROR = 230;

    const TASK_DUE_DATE_WRONG_FORMAT_ERROR = 240;
    const TASK_DUE_TIME_WRONG_FORMAT_ERROR = 250;
    const TASK_REPETITION_ID_DOESNT_EXIST_ERROR = 260;
    const TASK_REPETITION_PARAM_OUT_OF_LIMIT_ERROR = 270;

    const ICAL_RRULE_NOT_RECOGNIZED_ERROR = 290;

    public static function getToken($params)
    {
        $extraInfo = isset($params['extra_info']) ? $params['extra_info'] : '';

        $minVersion = sfConfig::get('app_api_minVersion');

        if ($params['api_ver'] < $minVersion)
        {
            return array('error' => self::API_VERSION_ERROR);
        }

        $apiKey = $params['api_key'];

        $apiAppEntry = PcApiAppPeer::retrieveByApiKey($apiKey);

        $userId = $apiAppEntry->getUserId();

        $userKey = isset($params['user_key']) ? $params['user_key'] : '';        
        
        if ($params['api_ver'] >= 3)
        {
            if ($userId) // the app is for personal use
            {
                // they need to pass the param 'user_key' to getToken
                // that we are not going to use right now - it will be helpful in the future
                if (!isset($userKey))
                {
                    return array('error' => self::MISSING_USER_KEY_ERROR);
                }
                else
                {
                    $userKeyEntry = PcUserKeyPeer::retrieveByKey($userKey);
                    if (! $userKeyEntry)
                    {
                       return array('error' => self::INVALID_USER_KEY_ERROR);
                    }
                    $userId = $userKeyEntry->getUserId();
                }
            }
        }

        if (! $userId)
        {
            // The API key is not associated with a user_id.
            // We need to get it from the user email and password
            $userEmail = isset($params['user_email']) ? $params['user_email'] : '';
            $userPassword = isset($params['user_pwd']) ? $params['user_pwd'] : '';

            $user = PcUserPeer::isCorrectAuthentication($userEmail, $userPassword);

            if (is_object($user))
            {
                $userId = $user->getId();
            }
            else
            {
                if ($userKey)
                {
                   if ($userKeyRecord = PcUserKeyPeer::retrieveByKey($userKey))
                   {
                        $userId = $userKeyRecord->getUserId();    
                   }
                   else
                   {
                        return array('error' => self::WRONG_AUTHENTICATION_ERROR);    
                   }
                }
                else
                {
                    return array('error' => self::WRONG_AUTHENTICATION_ERROR);
                }    
            }
        }


        $token = PcApiTokenPeer::createToken($apiAppEntry, $userId);

        return array('token' => $token,
                     'api_ver' => sfConfig::get('app_api_version'));
    }

    public static function getServerTime($params)
    {
        return array('time' => time());
    }

    public static function getUserSettings($params)
    {
        $user = PcUserPeer::getLoggedInUser();
        $timezone = $user->getPcTimezone();
        $dateFormats = PcCommonData::getDateFormats();
        
        $camelCaseKeys = $params['camel_case_keys'];
        
        $dateFormatKey = $camelCaseKeys ? 'dateFormat' : 'date_format';
        $timeFormatKey = $camelCaseKeys ? 'timeFormat' : 'time_format';        
        $dstActiveKey = $camelCaseKeys ? 'dstActive' : 'dst_active'; 
        $weekStartKey = $camelCaseKeys ? 'weekStart' : 'week_start';
        $clientLangStringKey = $camelCaseKeys ? 'clientLangString' : 'client_lang_string';
        $isSupporterKey = $camelCaseKeys ? 'isPremium' : 'is_premium';        
        
        $labelParts = explode(',', $timezone->getLabel());
        
        return array('timezone' => array('description' => $timezone->getDescription(),
                                         'offset' => $timezone->getOffset(),
                                         'dst' => $labelParts[1]),
                     $dateFormatKey => $user->getDateFormat(),
                     $timeFormatKey => (int)$user->getTimeFormat(),
                     $dstActiveKey => (int)$user->getDstActive(),
                     $weekStartKey => (int)$user->getWeekStart(),
                     'lang' => $user->getPreferredLanguage(),
                     $clientLangStringKey => $user->getLanguage(),
                     $isSupporterKey => (int)$user->isSupporter(),
                     'email' => $user->getEmail());
    }

    public static function getLists($params)
    {
        $user = PcUserPeer::getLoggedInUser();
        $apiVersion = $params['api_ver'];

        $fromTs = isset($params['from_ts']) ? $params['from_ts'] : 0;
        $toTs = 0;
        if ($fromTs > 0)
        {
            $toTs = $params['to_ts'];
        }

        $lists = $user->getAllLists();

        $listsArray = array();
        foreach($lists as $list)
        {
            $updatedTimespamp = $list->getUpdatedAt('U');
            if ( ($fromTs == 0) ||
                 (($updatedTimespamp >= $fromTs) && ($updatedTimespamp < $toTs)) )
            {
                if ($apiVersion == 1) // backwards compatibility
                {
                    $maxListSortOrder = 100; // this is an absolute hack
        
                    // {{{ sortOrder fix
                    // this is because the sort order stored in the db is a bit misleading
                    $sortOrder = 0; // already good if it is Inbox
                    if ($list->isTodo())
                    {
                        $sortOrder = 1;
                    }
                    else if ( !$list->isSystem() )
                    {
                        $sortOrder = $maxListSortOrder - $list->getSortOrder() +2;
                    }
                    // sortOrder fix }}}
                }
                else if ($apiVersion >= 2)
                {
                    $sortOrder = $list->getSortOrder();
                }
                
                $camelCaseKeys = $params['camel_case_keys'];
                
                $sortOrderKey = null;
                $isHeaderKey = null;
                $isInboxKey = null;        
                $updatedAtKey = null;
                $createdAtKey = null;         
                if ($camelCaseKeys)
                {
                    $sortOrderKey = 'sortOrder';
                    $isHeaderKey = 'isHeader';
                    $isInboxKey = 'isInbox';
                    $updatedAtKey = 'updatedAt';
                    $createdAtKey = 'createdAt';             
                }
                else
                {
                    $sortOrderKey = 'sort_order';
                    $isHeaderKey = 'is_header';
                    $isInboxKey = 'is_inbox';            
                    $updatedAtKey = 'updated_at';
                    $createdAtKey = 'created_at';            
                }                

                $listArray = array('id' => (int)$list->getId(),
                                   'name' => $list->getTitle(),
                                   $sortOrderKey => $sortOrder,
                                   $isHeaderKey => (int)$list->isHeader(),
                                   $isInboxKey => (int)$list->isInbox(),
                                   $updatedAtKey => $updatedTimespamp,
                                   $createdAtKey => $list->getCreatedAt('U') );
                $listsArray[] = $listArray;
            }
        }

        return array('lists' => $listsArray);
    }

    public static function getDeletedLists($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $lists = $user->getDeletedListsSince($params['from_ts'], $params['to_ts']);

        $listIds = array();
        foreach($lists as $list)
        {
            $listIds[] = $list->getId();
        }

        return array('list_ids' => $listIds);
    }

    public static function getTags($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $fromTs = isset($params['from_ts']) ? $params['from_ts'] : null;
        $toTs = null;
        if ($fromTs !== null)
        {
            $toTs = $params['to_ts'];
        }

        $tags = $user->getContexts($fromTs, $toTs);

        return array('tags' => $tags);
    }

    public static function getDeletedTags($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $tags = $user->getDeletedContextsSince($params['from_ts'], $params['to_ts']);

        $tagIds = array();
        foreach($tags as $tag)
        {
            $tagIds[] = $tag->getId();
        }

        return array('tag_ids' => $tagIds);
    }

    /**
     * This is a new alias for getRepetitions. We keep the old one for backcompatibility
     */
    public static function getRepetitionOptions($params)
    {
        return self::getRepetitions($params);
    }

    public static function getRepetitions($params)
    {
        $fromTs = isset($params['from_ts']) ? $params['from_ts'] : null;
        $toTs = null;
        if ($fromTs !== null)
        {
            $toTs = $params['to_ts'];
        }

        $reps = PcRepetitionPeer::retrieveUpdatedSince($fromTs, $toTs);

        $repsArray = array();
        foreach($reps as $rep)
        {
            $repArray = array('id' => (int)$rep->getId(),
                              // 'label' => $rep->getHumanExpression(),
                              'label' => __('ACCOUNT_TASK_REPETITION_' . $rep->getId()),
                              'special' => $rep->getSpecial(),
                              'needs_param' => (int)$rep->needsParam(),
                              'is_param_cardinal' => (int)$rep->isParamCardinal(),
                              'min_param' => $rep->getMinParam(),
                              'max_param' => (int)$rep->getMaxParam(),
                              'ical_rrule_template' => $rep->getIcalRrule(),
                              'sort_order' => $rep->getSortOrder(),
                              'has_divider_below' => (int)$rep->hasDividerBelow() );
            $repsArray[] = $repArray;
        }

        return array('repetitions' => $repsArray);
    }

    public static function getTasks($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $fromTs = isset($params['from_ts']) ? $params['from_ts'] : null;
        $toTs = null;
        if ($fromTs !== null)
        {
            $toTs = $params['to_ts'];
        }

        $taskId = (isset($params['task_id'])) ? $params['task_id'] : null;
        $listId = (isset($params['list_id'])) ? $params['list_id'] : null;
        $tagId = (isset($params['tag_id'])) ? $params['tag_id'] : null;
        $completed = (isset($params['completed'])) ? $params['completed'] : null;
        $onlyWithDueDate = (isset($params['only_with_due_date'])) ? $params['only_with_due_date'] : null;
        $onlyWithoutDueDate = (isset($params['only_without_due_date'])) ? $params['only_without_due_date'] : null;
        $onlyDueTodayOrTomorrow = (isset($params['only_due_today_or_tomorrow'])) ? $params['only_due_today_or_tomorrow'] : null;
        $onlyStarred = (isset($params['only_starred'])) ? $params['only_starred'] : null;
        $byDate = (isset($params['by_date'])) ? $params['by_date'] : null;
        $searchQuery = (isset($params['search_query'])) ? $params['search_query'] : null;
        
        if (! $searchQuery)
        {
            $tasks = $user->getTasksByMultipleCriteria($fromTs,
                                                     $toTs,
                                                     $taskId,
                                                     $listId,
                                                     $tagId,
                                                     $completed,
                                                     $onlyWithDueDate,
                                                     $onlyWithoutDueDate,
                                                     $onlyDueTodayOrTomorrow,
                                                     $onlyStarred,
                                                     $byDate);
        }
        else
        {
            $searcher = new Searcher();
            $tasks = $searcher->searchTasks($searchQuery);            
        }

        $camelCaseKeys = $params['camel_case_keys'];
        
        $listIdKey = null;
        $sortOrderKey = null;
        $isHeaderKey = null;
        $dueDateKey = null;
        $dueTimeKey = null;
        $isStarredKey = null;
        $repetitionIdKey = null;
        $repetitionParamKey = null; 
        $repetitionIcalRruleKey = null;
        $isCompletedKey = null;
        $isFromSystemKey = null;
        $updatedAtKey = null;
        $createdAtKey = null;         
        if ($camelCaseKeys)
        {
            $listIdKey = 'listId';
            $sortOrderKey = 'sortOrder';
            $isHeaderKey = 'isHeader';
            $dueDateKey = 'dueDate';
            $dueTimeKey = 'dueTime';
            $isStarredKey = 'isStarred';
            $repetitionIdKey = 'repetitionId';
            $repetitionParamKey = 'repetitionParam'; 
            $repetitionIcalRruleKey = 'repetitionIcalRrule';
            $isCompletedKey = 'isCompleted';
            $isFromSystemKey = 'isFromSystem';
            $updatedAtKey = 'updatedAt';
            $createdAtKey = 'createdAt';             
        }
        else
        {
            $listIdKey = 'list_id';
            $sortOrderKey = 'sort_order';
            $isHeaderKey = 'is_header';
            $dueDateKey = 'due_date';
            $dueTimeKey = 'due_time';
            $isStarredKey = 'is_starred';
            $repetitionIdKey = 'repetition_id';
            $repetitionParamKey = 'repetition_param'; 
            $repetitionIcalRruleKey = 'repetition_ical_rrule';
            $isCompletedKey = 'is_completed';
            $isFromSystemKey = 'is_from_system';
            $updatedAtKey = 'updated_at';
            $createdAtKey = 'created_at';            
        }
        
        
        $ret = array();
        if (count($tasks))
        {
            foreach($tasks as $task)
            {
                $ret[] = array('id' => (int)$task->getId(),
                               $listIdKey => (int)$task->getListId(),
                               'description' => $task->getDescription(),
                               $sortOrderKey => ($task->getSortOrder() !== null) ? (int)$task->getSortOrder() : 0,
                               $isHeaderKey => (int)$task->isHeader(),
                               $dueDateKey => ($task->getDueDate('Y-m-d') !== null) ? $task->getDueDate('Y-m-d') : '',
                               $dueTimeKey => ($task->getDueTime() !== null) ? $task->getDueTime() : '',
                               $isStarredKey => (int)$task->isStarred(),
                               $repetitionIdKey => ($task->getRepetitionId() !== null) ? (int)$task->getRepetitionId() : 0,
                               $repetitionParamKey => (int)$task->getRepetitionParam(),
                               $repetitionIcalRruleKey => ($task->getRepetitionICalRrule() !== null) ? $task->getRepetitionICalRrule() : '',
                               $isCompletedKey => (int)$task->isCompleted(),
                               $isFromSystemKey => (int)$task->isFromSystem(),
                               'note' => ($task->getNote() !== null) ? $task->getNote() : '',
                               'tags' => $task->getContexts(),
                               'extra' => (isset($task->extra) && ($task->extra !== null)) ? $task->extra : '',
                               $updatedAtKey =>  $task->getUpdatedAt('U'),
                               $createdAtKey => $task->getCreatedAt('U'));
            }
        }

        return array('tasks' => $ret);
    }

    public static function getDeletedTasks($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $tasks = $user->getDeletedTasksSince($params['from_ts'], $params['to_ts']);

        $taskIds = array();
        foreach($tasks as $task)
        {
            $taskIds[] = $task->getId();
        }

        return array('task_ids' => $taskIds);
    }

    public static function completeTask($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $task = PcTaskPeer::retrieveByPk($params['task_id']);

        if (! self::validateTask($task, $user))
        {
                return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
        }

        $needsCompleting = true;
        
        $baselineDueDate = isset($params['baseline_due_date']) ? $params['baseline_due_date'] : '';
        if (strlen($baselineDueDate) > 0)
        {
            if ($basicCheckError = self::basicChecksOnTaskParams($baselineDueDate))
            {
                return array('error' => $basicCheckError);
            }

            $baselineDueDateInt = (int)str_replace('-', '', $baselineDueDate);
            $taskDueDateInt = (int)$task->getDueDate('Ymd');
            if ( $taskDueDateInt >  $baselineDueDateInt) // probably the task was already been completed by another app.
                                                         // We don't want to complete a repetitive task twice
            {
                $needsCompleting = false;
            }
        }

        if ($needsCompleting)
        {
            $task->markComplete();
        }

        return array('task_id' => $task->getId());
    }

    public static function uncompleteTask($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $task = PcTaskPeer::retrieveByPk($params['task_id']);

        if (! self::validateTask($task, $user))
        {
                return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
        }

        $task->markIncomplete();

        return array('task_id' => $task->getId());
    }

    public static function setTaskNote($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $task = PcTaskPeer::retrieveByPk($params['task_id']);

        if (! self::validateTask($task, $user))
        {
                return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
        }

        $task->setNote($params['note'])->save();

        return array('task_id' => $task->getId());
    }

    public static function addTask($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $listId = isset($params['list_id']) ? $params['list_id'] : 0;
        if ($listId > 0)
        {
            if (! self::validateList(PcListPeer::retrieveByPK($listId), $user))
            {
                    return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
            }
        }

        $contexts = isset($params['tag_ids']) ? $params['tag_ids'] : '';
        if ($contexts != '')
        {
            if (! self::validateContexts($contexts, $user))
            {
                    return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
            }
        }

        $note = isset($params['note']) ? $params['note'] : '';
        $dueDate = isset($params['due_date']) ? $params['due_date'] : '';
        $dueTime = isset($params['due_time']) ? $params['due_time'] : '';
        $isStarred = isset($params['is_starred']) ? $params['is_starred'] : 0;
        $repetitionId = isset($params['repetition_id']) ? $params['repetition_id'] : 0;
        $repetitionParam = isset($params['repetition_param']) ? $params['repetition_param'] : 0;
        $repetitionIcalRrule = isset($params['repetition_ical_rrule']) ? $params['repetition_ical_rrule'] : '';
        $description = $params['descr'];
        $isHeader = isset($params['is_header']) ? $params['is_header'] : 0;

        if ( strlen(trim($repetitionIcalRrule)) > 0 )
        {
            $icalRruleRet = DateFormat::fromICalRruleStringToInternalParams($repetitionIcalRrule);
            if (! $icalRruleRet)
            {
                    return array('error' => self::ICAL_RRULE_NOT_RECOGNIZED_ERROR);
            }
            else
            {
                list($repetitionId, $repetitionParam) = $icalRruleRet;
            }
        }
        
        if ( !strlen(trim($description)) ) // a task with no description doesn't make any sense
        {
            return false;
        }        

        $basicError = self::basicChecksOnTaskParams($dueDate, $dueTime, $repetitionId, $repetitionParam);
        if ($basicError !== false)
        {
            return array('error' => $basicError);
        }

        if($dueTime && (!$dueDate && !$repetitionId))
        {
            // it doesn't make sense to set up a time if a date is not defined
            return array('error' => self::TASK_DUE_TIME_NOT_APPLICABLE_ERROR);
        }

        $task = PcTaskPeer::createOrEdit($description, $listId, 0, $contexts, $isHeader, $note,
                $dueDate, $dueTime, $isStarred, $repetitionId, $repetitionParam, 0, '', 'Y-m-d');

        return array('task_id' => $task->getId());
    }


    public static function editTask($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $task = PcTaskPeer::retrieveByPK($params['task_id']);
        if (! self::validateTask($task, $user))
        {
                return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
        }

        $listId = isset($params['list_id']) ? $params['list_id'] : null;
        if ($listId > 0)
        {
            if (! self::validateList(PcListPeer::retrieveByPK($listId), $user))
            {
                    return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
            }
        }

        $contexts = isset($params['tag_ids']) ? $params['tag_ids'] : null;
        if ($contexts != '')
        {
            if (! self::validateContexts($contexts, $user))
            {
                    return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
            }
        }

        $note = isset($params['note']) ? $params['note'] : null;
        $dueDate = isset($params['due_date']) ? $params['due_date'] : null;
        $dueTime = isset($params['due_time']) ? $params['due_time'] : '';
        $isStarred = isset($params['is_starred']) ? $params['is_starred'] : 0;
        $repetitionId = isset($params['repetition_id']) ? $params['repetition_id'] : null;
        $repetitionParam = isset($params['repetition_param']) ? $params['repetition_param'] : null;
        $repetitionIcalRrule = isset($params['repetition_ical_rrule']) ? $params['repetition_ical_rrule'] : '';
        $description = isset($params['descr']) ? $params['descr'] : null;
        $isHeader = isset($params['is_header']) ? $params['is_header'] : null  ;

        if ( strlen(trim($repetitionIcalRrule)) > 0  )
        {
            $icalRruleRet = DateFormat::fromICalRruleStringToInternalParams($repetitionIcalRrule);
            if (! $icalRruleRet)
            {
                    return array('error' => self::ICAL_RRULE_NOT_RECOGNIZED_ERROR);
            }
            else
            {
                list($repetitionId, $repetitionParam) = $icalRruleRet;
            }
        }

        $basicError = self::basicChecksOnTaskParams($dueDate, $dueTime, $repetitionId, $repetitionParam);
        if ($basicError !== false)
        {
            return array('error' => $basicError);
        }

        if($dueTime && (!$dueDate && !$repetitionId))
        {
            // it doesn't make sense to set up a time if a date is not defined
            return array('error' => self::TASK_DUE_TIME_NOT_APPLICABLE_ERROR);
        }

        $task->edit($description, $listId, $contexts, $isHeader, $note,
                $dueDate, $dueTime, $isStarred, $repetitionId, $repetitionParam, 0, '', 'Y-m-d');

        return array('task_id' => $task->getId());
    }

    public static function deleteTask($params)
    {
        $user = PcUserPeer::getLoggedInUser();

        $task = PcTaskPeer::retrieveByPk($params['task_id']);

        if (! self::validateTask($task, $user))
        {
                return array('error' => self::OPERATION_NOT_PERMITTED_ERROR);
        }

        $task->delete();

        return array('task_id' => $task->getId());
    }

    public static function whatHasChanged($params)
    {
        $toTest = array();

        $toTest['lists'] = 'getLists';
        $toTest['deletedLists'] = 'getDeletedLists';
        $toTest['repetitions'] = 'getRepetitions';
        $toTest['tags'] = 'getTags';
        $toTest['deletedTags'] = 'getDeletedTags';
        $toTest['tasks'] = 'getTasks';
        $toTest['deletedTasks'] = 'getDeletedTasks';

        $whatHasChanged = array();

        foreach($toTest as $key => $methodName)
        {
            $ret = call_user_func(array(__CLASS__, $methodName), $params);
            // the return is always an array with a main key and another value as array
            $retValuesArray = array_values($ret);
            $mainRetValuesArray = $retValuesArray[0];
            if (count($mainRetValuesArray))
            {
                $whatHasChanged[] = $key;
            }
        }

        if (!in_array("tasks", $whatHasChanged))
        {
            // in the previous loop we call getTasks with params['completed']=false (the
            // default parameter. Then, we need to call it also with that param set to
            // true (otherwise we lose the information of tasks marked as done)
            $params['completed'] = 1;
            $ret = self::getTasks($params);
            // the return is always an array with a main key and another value as array
            $retValuesArray = array_values($ret);
            $mainRetValuesArray = $retValuesArray[0];
            if (count($mainRetValuesArray))
            {
                $whatHasChanged[] = "tasks";
            }
        }
        
        return array('changed' => $whatHasChanged);
    }

    /**
     * NOTE: this method is very specific to the mobile app.
     * NOTE: it completes all the input tasks that are completed and add all the other ones -
     * but what if a task is simply edited?????  [this method will add it rather than edit it]
     * 
     * 
     * @param array $params
     * @return type 
     */
    public static function sync($params)
    {
        $tasks = $params['tasks'];
        unset($params['tasks']);

        if (is_array($tasks))
        {
            foreach($tasks as $task) {
                if ($task['isCompleted']) {
                    $p['task_id'] = $task['id'];
                    if (strlen($task['dueDate'])) {
                        $p['baseline_due_date'] = $task['dueDate'];
                    }
                    PlancakeApiServer::completeTask($p);
                }
                else
                {
                    if (strlen($task['description'])) {
                        $p['list_id'] = $task['listId'];
                        $p['descr'] = $task['description'];
                        PlancakeApiServer::addTask($p);
                    }
                }
            }
        }
        
        // this is very important to make sure we get the tasks that are
        // affected by the local changes
        sleep(1);
        
        $changes = array();
        
        $serverTime = self::getServerTime($params);
        $changes['serverTime'] = $serverTime['time'];        
        $params['to_ts'] = $changes['serverTime'];
        
        $repetitions = self::getRepetitionOptions($params);
        $changes['repetitions'] = $repetitions['repetitions'];
        
        $lists = self::getLists($params);
        $changes['lists'] = $lists['lists'];
        $deletedLists = self::getDeletedLists($params);
        $changes['deletedLists'] = $deletedLists['list_ids'];

        $tags = self::getTags($params);
        $changes['tags'] = $tags['tags'];        
        $deletedTags = self::getDeletedTags($params);
        $changes['deletedTags'] = $deletedTags['tag_ids']; 
        
        $nonCompletedTasks = self::getTasks($params);
        $completedTasks = self::getTasks(array_merge($params, array('completed' => 1)));
        $changes['tasks'] = array_merge($nonCompletedTasks['tasks'], $completedTasks['tasks']);
        $deletedTasks = self::getDeletedTasks($params);
        $changes['deletedTasks'] = $deletedTasks['task_ids'];
        
        return array('changes' => $changes);
    }
    
    
    /**
     * Returns whether the task exists and it is editable by the user
     *
     * @param PcTask|null $task
     * @param PcUser $user
     * @return bool
     */
    private static function validateTask($task, PcUser $user)
    {
        if (!$task)
        {
            return false;
        }

        return $task->validateOwner($user);
    }

    /**
     * Returns whether the list belongs to the user
     *
     * @param PcList|null $list
     * @param PcUser $user
     * @return bool
     */
    private static function validateList($list, PcUser $user)
    {
        if (!$list)
        {
            return false;
        }

        return ($list->getCreatorId() == $user->getId());
    }

    /**
     * Returns whether the list belongs to the user
     *
     * @param string $contexts - comma-separated string of the context ids
     * @param PcUser $user
     * @return bool
     */
    private static function validateContexts($contexts, PcUser $user)
    {
        $userContexts = $user->getContextsArray();

        $contextIdsFromInput = PcUtils::explodeWithEmptyInputDetection(',', $contexts);

        foreach ($contextIdsFromInput as $cid)
        {
            $context = PcUsersContextsPeer::retrieveByPK($cid);
            if (! $context)
            {
                return false;
            }
            if (array_search($context->getContext(), $userContexts) === false)
            {
                return false;
            }
        }
        return true;
    }

    /**
     *
     * @param string $dueDate
     * @param int $dueTime
     * @param int $repetitionId
     * @param int $repetitionParam
     * @return false|int - false if no errors occurred, the error code otherwise
     */
    private static function basicChecksOnTaskParams($dueDate, $dueTime = null,
            $repetitionId = null, $repetitionParam = null)
    {
        if ( $dueDate && (!preg_match('!\d\d\d\d-\d\d-\d\d!', $dueDate)) )
        {
            return self::TASK_DUE_DATE_WRONG_FORMAT_ERROR;
        }

        if ( $dueTime && (!preg_match('!^\d{1,4}$!', $dueTime)) )
        {
            return self::TASK_DUE_TIME_WRONG_FORMAT_ERROR;
        }

        $repetition = null;
        if ($repetitionId && !($repetition = PcRepetitionPeer::retrieveByPK($repetitionId)) )
        {
            return self::TASK_REPETITION_ID_DOESNT_EXIST_ERROR;
        }

        if ($repetitionParam && ($repetitionParam > $repetition->getMaxParam()) )
        {
            return self::TASK_REPETITION_PARAM_OUT_OF_LIMIT_ERROR;
        }

        return false;
    }
}
?>
