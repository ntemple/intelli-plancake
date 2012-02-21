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

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Calendar');

class GoogleCalendarInterface
{
    const PLANCAKE_SPECIFIC_CALENDAR_NAME = 'Plancake';

    //const GCAL_INTEGRATION_SCOPE = "http://www.google.com/calendar/feeds/";
    const GCAL_INTEGRATION_SCOPE = "https://www.google.com/calendar/feeds";

    const EVENT_CREATE_MODE = 1;
    const EVENT_UPDATE_MODE = 2;
    
    const EVENT_EXTENDED_PROPERTY_TASK_ID = 'PlancakeTaskId';

    /**
     *
     * @var Zend_Gdata_Calendar(
     */
    private $service = null;

    /**
     *
     * @var PcUser $user
     */
    private $user = null;

    /**
     * @param PcUser $user
     */
    public function __construct(PcUser $user)
    {
        $this->user = $user;
    }

    /**
    *
    */
    public function resetDbEntry()
    {
        $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);

        if (is_object($dbEntry))
        {
            $dbEntry->setSessionToken('')
                    ->setCalendarUrl('')
                    ->setEmailAddress('')
                    ->setIsActive(false)
                    ->setIsSyncing(false)
                    ->setLatestSyncStartTimestamp(null)
                    ->setLatestSyncEndTimestamp(null)
                    ->save();
        }
    }

    /**
    *
    * @param string $sessionToken
    */
    public function setSessionToken($sessionToken)
    {
        $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);

        if (! is_object($dbEntry))
        {
            $dbEntry = new PcGoogleCalendar();
        }

        $dbEntry->setPcUser($this->user)
                ->setSessionToken($sessionToken)
                ->save();
    }


    /**
    *
    * @param string $calendarUrl
    */
    public function setCalendarUrl($calendarUrl)
    {
        $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);

        if (! is_object($dbEntry))
        {
            throw new Exception("GoogleCalendarInterface: missing db entry");
        }

        $dbEntry->setCalendarUrl($calendarUrl)
                ->save();
    }

    /**
    *
    * @return string $calendarUrl
    */
    public function getCalendarUrl()
    {
        $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);

        return $dbEntry->getCalendarUrl();
    }

    /**
    *
    * @return string $calendarUrl
    */
    public function getCalendarId()
    {
        $calendarUrl = $this->getCalendarUrl();

        if (!strlen($calendarUrl))
        {
            throw new Exception("You need to set the calendarUrl before requesting the calendarId");
        }

        preg_match('![^/@]+@group\.calendar\.google\.com!', $calendarUrl, $matches);
        return $matches[0];
    }

    /**
     * N.B.: A session token must be available before calling this method
     *
     * @return void
     */
    public function init()
    {
        if (! is_object($this->service))
        {
            $pathToKey = sfConfig::get('sf_root_dir') . '/' .
                         sfConfig::get('app_googleCalendarIntegration_privateKeyPath');

            $client = new Zend_Gdata_HttpClient();
            $client->setAuthSubPrivateKeyFile($pathToKey, null, true);

            $sessionToken = $this->getSessionToken();
            if (! $sessionToken)
            {
                throw new Exception("GoogleCalendarInterface: missing session token");
            }

            $client->setAuthSubToken($sessionToken);

            $this->service = new Zend_Gdata_Calendar($client, 'google-calendar-plancake-integration');
            $this->service->setMajorProtocolVersion(2);
            $this->service->setMinorProtocolVersion(null);
        }
    }

    /**
    *
    * @return string|null - null if the user hasn't got a session token
    */
    public function getSessionToken()
    {
        $tokenEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);
        return (is_object($tokenEntry) ? $tokenEntry->getSessionToken() : null );
    }


    /**
     * With the returned value, you can do something like this:
     *
     *  echo "<h1>Calendar List Feed</h1>";
     *  echo "<ul>";
     *  foreach ($listFeed as $calendar) {
     *      echo "<li>";
     *      echo $calendar->title; echo " XXX ";
     *      echo $calendar->content->src; echo " XXX ";
     *      echo $calendar->id;
     *      echo "</li>";
     *   }
     *   echo "</ul>";
     *
     *
     * @return array of Zend_Gdata_Calendar_ListFeed
     */
    public function getAllCalendars()
    {
        try {
            $listFeed= $this->service->getCalendarListFeed();
        } catch (Zend_Gdata_App_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $listFeed;
    }

    /**
     * @return bool
     */
    public function calendarAlreadyExistsByUrl($calendarUrl)
    {
        $calendars = $this->getAllCalendars();
        foreach ($calendars as $calendar)
        {
            if ($calendar->content->src == $calendarUrl)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function calendarAlreadyExistsByName($calendarName)
    {
        $calendars = $this->getAllCalendars();
        foreach ($calendars as $calendar)
        {
            if ($calendar->title == $calendarName)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $calendarName
     * @return string $calendarUrl
     */
    public function createCalendar($calendarName)
    {
// This commented code seems to work too
/*
      $appCal = $this->service->newListEntry();

      // I only set the title, other options like color are available.
      $appCal->title = $this->service->newTitle($calendarName);

      //This is the right URL to post to for new calendars...
      //Notice that the user's info is nowhere in there
      $ownCal = self::GCAL_INTEGRATION_SCOPE . "/default/owncalendars/full";

      //And here's the payoff.
      //Use the insertEvent method, set the second optional var to the right URL
      $newCalendar = $this->service->insertEvent($appCal, $ownCal);
*/
        
        
    $uri = self::GCAL_INTEGRATION_SCOPE . "/default/owncalendars/full";
    $xml = "<entry xmlns='http://www.w3.org/2005/Atom' xmlns:gd='http://schemas.google.com/g/2005' xmlns:gCal='http://schemas.google.com/gCal/2005'><title type='text'>{$calendarName}</title><summary type='text'></summary><gCal:hidden value='false'></gCal:hidden><gCal:color value='#B1440E'></gCal:color><gd:where rel='' label='' valueString='Oakland'></gd:where></entry>";
    $responseAfterCalendarCreation = $this->service->post($xml, $uri);

    $responseBodyAfterCalendarCreation = $responseAfterCalendarCreation->getBody();

    $xml = simplexml_load_string($responseBodyAfterCalendarCreation);

    $calendarUrl = str_replace("%40", '@', $xml->content['src']);

      $this->setCalendarUrl($calendarUrl);

      return $calendarUrl;
    }

    /**
     *
     * @param int $start - timestamp (UTC)
     * @param int $end - timestamp (UTC)
     * @return array of Events
     */
    private function getUpdatedEvents($start, $end)
    {
        $query = $this->service->newEventQuery();
        $query->setUser($this->getCalendarId());
        // Set to $query->setVisibility('private-magicCookieValue') if using
        // MagicCookie auth
        $query->setVisibility('private');
        $query->setProjection('full');
        $query->setOrderby('starttime');
        $query->setSingleevents('false');
        $query->setParam('ctz', 'UTC');
        $query->setMaxResults(5000);

        $dateFormat = 'Y-m-d\TH:i:s\Z';

        $query->setUpdatedMin(date($dateFormat, $start));
        $query->setUpdatedMax(date($dateFormat, $end));

        // Retrieve the event list from the calendar server
        try {
            $eventFeed = $this->service->getCalendarEventFeed($query);
        } catch (Zend_Gdata_App_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $eventFeed;
    }

    /**
     * @return int - the number of tasks that has been changed
     */
    public function syncPlancake()
    {
        $count = 0;

        $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);
        if (is_object($dbEntry))
        {
            if (! $dbEntry->getSessionToken())
            {
                throw new Exception("You need a session token in order to sync.");
            }
        }
        else
        {
            throw new Exception("You need to have a Google Calendar entry in order to sync.");
        }


        // I want to avoid 2 concurrent syncs
        if ( (!$dbEntry->getIsSyncing()) ||
             ($dbEntry->getIsSyncing() && 
                ( (time()-$dbEntry->getLatestSyncStartTimestamp()) > 600  ) ) )   // 600 secs = 10 mins!
                   // this second case means the sycning flag is stuck because of an error that occurred
        {
            $dbEntry->setIsSyncing(true)
                    ->setLatestSyncStartTimestamp(time())
                    ->save();

            try
            {
                $updatedEvents = $this->getUpdatedEvents($dbEntry->getLatestSyncEndTimestamp(), time());

                if (count($updatedEvents))
                {
                    // We want to give Google Calendar the time to settle down.
                    // We noticed when we edit something on Google Calendar, for the first
                    // few moments Plancake detects a deletion rather than an update.
                    // Maybe we should also improve the code to detect whether the task has
                    // been deleted.
                    sleep(1);

                    foreach($updatedEvents as $updatedEvent)
                    {
                        if (SfConfig::get('app_gcal_debug'))
                        {
                            error_log('Syncing eventId ' . $this->getEventId($updatedEvent));
                        }

                        $this->updatePlancakeTask($updatedEvent);
                    }
                }

                
                $dbEntry->setPcUser($this->user)
                        ->setLatestSyncEndTimestamp(time())
                        ->setIsSyncing(false)
                        ->save();
            }
            catch (Exception $e)
            {
                $dbEntry->setPcUser($this->user)
                        ->setIsSyncing(false)
                        ->save();
            }

            $count = count($updatedEvents);
        }
        return $count;
    }

    /**
     * Updates the corresponding Plancake task.
     * If there is not a corresponding Plancake task,
     * we create a new one.
     *
     * @param -Google Calendar Event- $event
     */
    private function updatePlancakeTask($event)
    {
        $eventId = $this->getEventId($event);
        
        // retrieving the Plancake task: we use this method, rather than the EVENT_EXTENDED_PROPERTY_TASK_ID 
        // extended property, because it should be more reliable
        $task = PcTaskPeer::getTaskByGoogleCalendarEventId($eventId);

        
        // {{{ PATCH: we have this problem something Google was trying to send us back some events that
        // had been either completed or deleted on the Plancake side.
        // This is the reason why we have decided to use an extended property to keep a record of the link
        // CalendarEvent<-->PlancakeTask
        $taskIdFromExtendedProperty = $this->getExtendedProperty($event, self::EVENT_EXTENDED_PROPERTY_TASK_ID);
        if ($taskIdFromExtendedProperty)
        {
            $taskFromExtendedProperty = PcTaskPeer::retrieveByPK($taskIdFromExtendedProperty);
            if ($taskFromExtendedProperty && $taskFromExtendedProperty->isCompleted())
            {
                    $taskFromExtendedProperty->removeGoogleCalendarEventId();
                    return;
            }
            if (PcTrashbinTaskPeer::retrieveByPK($taskIdFromExtendedProperty)) // tasks was deleted
            // this is not actually totally accurate because we don't keep deleted tasks forever but
            // just for some months (check configuration)
            {
                return;
            }
        }
        // }}} // end PATCH

        
        // {{{ checking whether the event has been deleted
            if ($this->hasEventBeenDeleted($event))
            {
                // event has been deleted
                if (is_object($task))
                {
                    if (SfConfig::get('app_gcal_debug'))
                    {
                        error_log('Deleting Plancake task ' . $task->getId() . ' ' . $task->getDescription());
                    }

                    $task->removeGoogleCalendarEventId();

                    // In order to avoid potential disasters, we disable the possibility
                    // for GCal to delete tasks
                    // $task->delete();
                    return;
                }
            }
        // }}}


        $eventDescription = $event->title->text;
        $eventNote = $event->content->text;
        $eventDueDate = '';
        $eventDueTime = '';
        $eventRepetitionId = 0;
        $eventRepetitionParam = 0;

        $eventIsRecurrent = true;
        foreach ($event->when as $when) {
          $startTime = $when->startTime;
          $eventIsRecurrent = false;

          if (strlen($startTime) == 10) // i.e.: 2011-03-09
          {
              $eventDueDate = $startTime;
              $eventDueTime = '';
          }
          else // i.e.: 2011-03-09T14:00:00.000Z
          {
              preg_match('!([^T]+)T([0-9]{2}):([0-9]{2}):.*!', $startTime, $matches);
              $eventDueDate = $matches[1];
              $eventDueTime = $matches[2] . $matches[3];
              $eventDueTime = (int)$eventDueTime;
          }

          break; // getting just the first due date
        }

        if ($eventIsRecurrent)
        {
            $recurrentData = $event->recurrence->text;
            // $recurrentData is something like:
            // DTSTART;VALUE=DATE:20110215 DTEND;VALUE=DATE:20110216 RRULE:FREQ=WEEKLY;INTERVAL=2;BYDAY=TU
            // DTSTART:20110228T110000Z DTEND:20110228T120000Z RRULE:FREQ=WEEKLY;BYDAY=MO
            list($eventDueDate, $eventDueTime, $eventRepetitionId, $eventRepetitionParam) = 
                DateFormat::fromICalRecurrentStringToInternalParams($recurrentData);
        }

        foreach ($event->when as $when) {
          break; // we only consider the first 'when' parameter
        }

        list($eventLocalDueDate, $eventLocalDueTime) = DateFormat::fromGmtDateAndTime2LocalDateAndTime($eventDueDate, $eventDueTime);

        if (is_object($task))
        {
            $task->edit($eventDescription,
                        null,
                        null,
                        null,
                        $eventNote,
                        $eventLocalDueDate,
                        $eventLocalDueTime,
                        null,
                        $eventRepetitionId,
                        $eventRepetitionParam,
                        'gcal');

            if (SfConfig::get('app_gcal_debug'))
            {
                error_log('Updated Plancake task ' . $task->getId() . ' ' . $task->getDescription());
            }
        }
        else
        {
            $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);
            if (!is_object($dbEntry))
            {
                throw new Exception("You need a session token in order to create a new task.");
            }

            // we have to create a new Plancake task
            $task = PcTaskPeer::createOrEdit($eventDescription,
                                     null,
                                     0,
                                     '',
                                     false,
                                     $eventNote,
                                     $eventLocalDueDate,
                                     $eventLocalDueTime,
                                     0,
                                     $eventRepetitionId,
                                     $eventRepetitionParam,
                                     0,
                                     'gcal',
                                     'Y-m-d');

            if (SfConfig::get('app_gcal_debug'))
            {
                error_log('Created Plancake task ' . $task->getId() . ' ' . $task->getDescription());
            }
        }

        $task->setGoogleCalendarEventId($eventId);
    }

    /**
     * Retrieves only event that haven't been deleted
     *
     * @param  string           $eventId The event ID string
     * @return Zend_Gdata_Calendar_EventEntry|null if the event is found, null if it's not
     */
    function getEvent($eventId)
    {
      $query = $this->service->newEventQuery();
      $query->setUser($this->getCalendarId());
      $query->setVisibility('private');
      $query->setProjection('full');
      $query->setEvent($eventId);

      try {
        $eventEntry = $this->service->getCalendarEventEntry($query);
        return $eventEntry;
      } catch (Zend_Gdata_App_Exception $e) {
        return null;
      }
    }

    /**
     * @param string $eventId
     */
    public function deleteEventById($eventId)
    {
        if ($event = $this->getEvent($eventId))
        {
            if ($this->hasEventBeenDeleted($event)) // we are trying to delete an event that was already deleted
            {
                return;
            }

            // $eventEditUrl = $event->getLink('edit')->href;
            if (SfConfig::get('app_gcal_debug'))
            {
                error_log('Right before deleting the Plancake task ' . $event->title->text);
            }            
            
            // {{{ rather then running just $event->delete() ,
            // we try many times, as sometimes the updating is a bit
            //quirky on Google Calendar end
            try
            {
                $event->delete();
            }
            catch(Exception $e)
            {
                try
                {
                    $event->delete();
                }
                catch(Exception $e)
                {
                    $event->delete();
                }
            }
            // }}}


            if (SfConfig::get('app_gcal_debug'))
            {
                error_log('Deleted task on GCal for the Plancake task ' . $event->title->text);
            }
        }
    }

    /**
     * @param PcTask $task
     */
    public function deleteEvent(PcTask $task)
    {
        $eventId = $task->getGoogleCalendarEventId();

        if ($eventId)
        {
            if (SfConfig::get('app_gcal_debug'))
            {
                error_log('Deleting task on GCal for the Plancake task ' . $task->getId() . ' ' . $task->getDescription() . ' and eventID: ' . $eventId);
            }
            $this->deleteEventById($eventId);
        }
    }

    /**
     * Inserts or updates an event to the specific calendar.
     * If we try to edit a task without due date, it deletes it
     *
     * @param PcTask $task
     * @param string $calendarUrl
     * @param bool $updateEmailAddress (=false)
     * @return int|bool the id of the event - false if the event we try to add/edit hasn't got due date
     */
    public function createOrUpdateEvent(PcTask $task, $updateEmailAddress = false)
    {
        $event = null;
        $googleCalendarEventId = $task->getGoogleCalendarEventId();

        $mode = self::EVENT_CREATE_MODE;
        if (strlen($googleCalendarEventId))
        {
            $event = $this->getEvent($googleCalendarEventId);
            if (is_object($event))
            {
                $mode = self::EVENT_UPDATE_MODE;
            }

            if ($this->hasEventBeenDeleted($event)) // we are trying to edit an event that was deleted
            {
                return;
            }
        }

        if (SfConfig::get('app_gcal_debug'))
        {
            if ($mode == self::EVENT_CREATE_MODE)
            {
                error_log('Creating task on GCal for the Plancake task ' . $task->getId() . ' ' . $task->getDescription());
            }
            else
            {
                error_log('Editing task on GCal for the Plancake task ' . $task->getId() . ' ' . $task->getDescription());
            }
        }

        if ($mode == self::EVENT_CREATE_MODE)
        {
            $event= $this->service->newEventEntry();
        }

        if ( (!$task->getDueDate()) || $task->isCompleted() )
        {
            // A task without due date or completed shouldn't be on Google Calendar
            $this->deleteEventById($googleCalendarEventId);
            $task->removeGoogleCalendarEventId();
            return false;
        }
        
        // {{{ Adding extended property to patch a problem we have this the integration:
        // search 'EVENT_EXTENDED_PROPERTY_TASK_ID' in this file
        $this->setExtendedProperty($event, self::EVENT_EXTENDED_PROPERTY_TASK_ID, $task->getId());
        // }}}

        $event->title = $this->service->newTitle($task->getDescription());
        $event->where = array($this->service->newWhere(""));
        $event->content =
            $this->service->newContent($task->getNote());

        // Setting the date using RFC 3339 format
        list($startDate, $startTime) = DateFormat::fromLocalDateAndTime2GMTDateAndTime($task->getDueDate("Y-m-d"), $task->getDueTime());

        $timeObject= new PcTime();

        if ($startTime > 0)
        {
            $startTime = $timeObject->createFromIntegerValue($startTime)
                            ->get5CharsRepresentation();
        }
        else
        {
            $startTime = null;
        }
        //$endDate = "2011-01-20";
        //$endTime = "16:00";

        //$userTimezone = $this->user->getPcTimezone();
        //$tzOffset = ($userTimezone->getOffset()/60);
        // right now, $tzOffset can be -8, but we need -08
        //$tzOffset = "-08";

        if ($task->getRepetitionId() > 0)
        {
//            $recurrence = "DTSTART;VALUE=DATE:20110501\r\n" .
//                    "DTEND;VALUE=DATE:20110502\r\n" .
//                    "RRULE:FREQ=WEEKLY;BYDAY=Tu;UNTIL=20110904\r\n";

              $dtStart = $task->getDueDate("Ymd");
              if ($startTime !== null)
              {
                $dtStart = $dtStart . 'T' . str_replace(':', '', $startTime) . '00Z';
              }

              $recurrence = "DTSTART:{$dtStart}\r\n" .
                      "RRULE:{$task->getRepetitionICalRrule()}\r\n";

            $event->recurrence = $this->service->newRecurrence($recurrence);

        }
	else
	{
	        $when = $this->service->newWhen();

                if ($startTime !== null)
                {
                    $when->startTime = "{$startDate}T{$startTime}:00.000Z";
                }
                else
                {
                    $when->startTime = $startDate;
                }

        	// $when->endTime = "{$endDate}T{$endTime}:00.000{$tzOffset}:00";

		$event->when = array($when);
	}

        if ($mode == self::EVENT_CREATE_MODE)
        {
            $newEvent = null;
            try
            {
                $newEvent = $this->service->insertEvent($event, $this->getCalendarUrl());
            }
            catch (Exception $e)
            {
                $newEvent = $this->service->insertEvent($event, $this->getCalendarUrl());
            }
        }
        else
        {
            // {{{ rather then running just $event->save() ,
            // we try many times, as sometimes the updating is a bit
            //quirky on Google Calendar end
            try
            {
                $event->save();
            }
            catch(Exception $e)
            {
                try
                {
                    $event->save();
                }
                catch(Exception $e)
                {
                    $event->save();
                }
            }
            // }}}

            $newEvent = $event;
        }

        if($updateEmailAddress)
        {
            $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);
            $dbEntry->setEmailAddress($newEvent->author[0]->email->text)
                    ->save();
        }

        $eventId = $this->getEventId($newEvent);

        if ($mode == self::EVENT_CREATE_MODE)
        {
            $task->setGoogleCalendarEventId($eventId);
        }

        return $eventId;
    }

    /**
     *
     * @param -Google Calendar event- $event
     * @return string
     */
    private function getEventId($event)
    {
        $longEventId = str_replace('%40', '@', $event->id->text);

        preg_match("!/([^/]+)$!", $longEventId, $matches);

        return $matches[1];
    }

    /**
     *
     * @param array $tasks (PcTask)
     */
    public function import($tasks)
    {
        $this->createCalendar(self::PLANCAKE_SPECIFIC_CALENDAR_NAME);

        $updateEmailAddress = true;

        $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);

        $dbEntry->setLatestSyncStartTimestamp(time())
                ->save();

        foreach ($tasks as $task)
        {
            $eventId = $this->createOrUpdateEvent($task, $updateEmailAddress);
            $updateEmailAddress = false;
        }

        // Just to make sure everything is settled down on GCal side
        sleep(5);


        $dbEntry->setLatestSyncEndTimestamp(time())
                ->setIsActive(true)
                ->setIsSyncing(false)
                ->save();
    }

    public function deActivate()
    {
        $dbEntry = PcGoogleCalendarPeer::retrieveByUser($this->user);
        $dbEntry->setIsActive(false)
                ->save();
    }

    /**
     *
     * @param <type> $event
     * @return bool
     */
    private function hasEventBeenDeleted($event)
    {
        $eventStatus = $event->eventStatus;
        return ($eventStatus == 'http://schemas.google.com/g/2005#event.canceled');
    }
    
    private function getExtendedProperty(Zend_Gdata_Calendar_EventEntry $event, $name)  
    {  
        $extProps = $event->extendedProperty;  
        foreach($extProps as $extProp){  
            if ($name == $extProp->name){  
                return $extProp->value;  
            }  
        }  
    }  

    /**
     * This doesn't save the object
     * 
     * @param Zend_Gdata_Calendar_EventEntry $event
     * @param Zend_Gdata_Calendar_EventEntry $name
     * @param type $value 
     */
    private function setExtendedProperty(Zend_Gdata_Calendar_EventEntry $event, $name, $value)  
    {  
        $extProp = $this->service->newExtendedProperty($name, $value);  
        $extProps = array_merge($event->extendedProperty, array($extProp));  
        $event->extendedProperty = $extProps;   
    }    
}
