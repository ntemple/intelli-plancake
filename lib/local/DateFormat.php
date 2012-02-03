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
 * Aggregates everything that depends on the date format.
 * It is a Singleton.
 * It works with the logged in user and with their preferences
 *
 */
class DateFormat
{
  /**
   * @var        object DateFormat the actual instance
   */
  static $instance;
  /**
   * @var        string the date format of the user (using the PHP date() format)
   */
  private $dateFormat;

  /**
   * The constuctor is private to implement the Singleton pattern.
   */
  private function __construct()
  {
    $sfContext = sfContext::getInstance();
    $loggedUser = PcUserPeer::getLoggedInUser();
    if (is_object($loggedUser))
    {
      $this->dateFormat = $loggedUser->getDateFormat();
    }
  }

  /**
   * Used to implement the Singleton pattern.
   *
   * @return DateFormat
   */
  public static function getInstance()
  {
    if (is_object(self::$instance))
    {
      return self::$instance;
    }
    else
    {
      return new DateFormat();
    }
  }

  /**
   * The date format suitable to be used with the PHP date() function
   *
   * @return string
   */
  public function getPHPDateFormat()
  {
    return $this->dateFormat;
  }

  /**
   * N.B.: The result depends on the timezone of the user who is logged in
   *
   * Returns an array containing respectively day, month and year (as integers)
   * from the due date that the user writes for their action (i.e.: 26-06-2009)
   *
   * @param  string $dateExpression
   * @param  string $dateFormat (='') the date format to use, rather than the user's one
   * @return array of integer
   */
  public function getDateBits($dateExpression, $dateFormat='')
  {
    $dateFormat = ($dateFormat != '') ? $dateFormat : $this->dateFormat;

    $dateOrder = explode('-', $dateFormat);
    $regExp = str_replace('d', '(\d\d)', $dateFormat);
    $regExp = str_replace('m', '(\d\d)', $regExp);
    $regExp = str_replace('Y', '(\d\d\d\d)', $regExp);
    if (preg_match("/$regExp/", $dateExpression, $matches))
    {
      $dateOrder = array_flip($dateOrder);
      $dayIndex = $dateOrder['d']+1;
      $monthIndex = $dateOrder['m']+1;
      $yearIndex = $dateOrder['Y']+1;

      $dateDay = $matches[$dayIndex];
      $dateMonth = $matches[$monthIndex];
      $dateYear = $matches[$yearIndex];
      return array($dateDay, $dateMonth, $dateYear);
    }
    else
    {
      return array();
    }
  }

  /**
   * N.B.: The result depends on the timezone of the user who is logged in
   *
   * Returns a timestamp
   * from the due date that the user writes for their action (i.e.: 26-06-2009)
   *
   * @param  string $dueDateExpression  
   * @return array of integer
   */
  public function getTimestamp($dateExpression)
  {
    list($dateDay, $dateMonth, $dateYear) = $this->getDateBits($dateExpression);
    return mktime(12, 0, 0, $dateMonth, $dateDay, $dateYear);	
  }

  /**
   * Useful for task repetitions in the case of some weekdays
   *
   * @param bool $sun
   * @param bool $mon
   * @param bool $tue
   * @param bool $wed
   * @param bool $thu
   * @param bool $fri
   * @param bool $sat
   */
  public static function fromWeekdaysSetToIntegerForRepetition($sun = false,
                                                               $mon = false,
                                                               $tue = false,
                                                               $wed = false,
                                                               $thu = false,
                                                               $fri = false,
                                                               $sat = false)
  {
    $binaryMask = $sun ? '1' : '0';
    $binaryMask .= $mon ? '1' : '0';
    $binaryMask .= $tue ? '1' : '0';
    $binaryMask .= $wed ? '1' : '0';
    $binaryMask .= $thu ? '1' : '0';
    $binaryMask .= $fri ? '1' : '0';
    $binaryMask .= $sat ? '1' : '0';

    return bindec((string)$binaryMask);
  }

  /**
   * Useful for task repetitions in the case of some weekdays
   *
   * @param int $repetitionParam
   * @return array associative array with keys 'sun', 'mon', 'tue', ... and boolean values
   */
  public static function fromIntegerToWeekdaysSetForRepetition($repetitionParam)
  {
    $binaryMask = decbin($repetitionParam);

    $binaryMask = str_pad($binaryMask, 7, '0', STR_PAD_LEFT);  // i.e.: from 1001 to 0001001

    $ret = array();
    $ret['sun'] = ($binaryMask{0} == 1);  // rightmost digit
    $ret['mon'] = ($binaryMask{1} == 1);
    $ret['tue'] = ($binaryMask{2} == 1);
    $ret['wed'] = ($binaryMask{3} == 1);
    $ret['thu'] = ($binaryMask{4} == 1);
    $ret['fri'] = ($binaryMask{5} == 1);
    $ret['sat'] = ($binaryMask{6} == 1);  // leftmost digit

    return $ret;
  }

  /**
   *
   * @param string $recurrentData, i.e.:
   *        DTSTART;VALUE=DATE:20110215 DTEND;VALUE=DATE:20110216 RRULE:FREQ=WEEKLY;INTERVAL=2;BYDAY=TU
   *        DTSTART:20110228T110000Z DTEND:20110228T120000Z RRULE:FREQ=WEEKLY;BYDAY=MO
   * @return array ($eventDueDate, $eventDueTime, $eventRepetitionId, $eventRepetitionParam)
   *         $eventDueDate in the format Y-m-d, $eventDueTime in the format (H)H:ss
   */
  public static function fromICalRecurrentStringToInternalParams($recurrentData)
  {
            $recurrentData = str_replace("\r\n", ' ', $recurrentData);
            $recurrentData = str_replace("\n", ' ', $recurrentData);

            $regexp = "!DTSTART[^:]*:([^ ]+) .* RRULE:([^ ]+)!";
            preg_match($regexp, $recurrentData, $matches);

            $dtStart = $matches[1]; // i.e.:  20110222T130000   or  20110222
            $repetitionRule = $matches[2]; // i.e.: FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU

            if (strpos($dtStart, 'T') === FALSE)
            {
                // there is no due time
                $eventDueTime = '';
                $eventDueDate = substr($dtStart, 0, 4) . '-' .
                                substr($dtStart, 4, 2) . '-' .
                                substr($dtStart, 6, 2); // changing from 20110222 to 2011-02-22
            }
            else
            {
                // we have both dueDate and dueTime
                preg_match('!([0-9]+)T([0-9]+)!', $dtStart, $matches);
                $dtStartDate = $matches[1];
                $dtStartTime = $matches[2]; // i.e.:  130000
                $eventDueTime = substr($dtStartTime, 0, 4); // i.e.:  1300

                $eventDueDate = substr($dtStartDate, 0, 4) . '-' .
                                substr($dtStartDate, 4, 2) . '-' .
                                substr($dtStartDate, 6, 2); // changing from 20110222 to 2011-02-22

                $eventDueTime = (int)$eventDueTime;
            }

            list($eventRepetitionId, $eventRepetitionParam) = self::fromICalRruleStringToInternalParams($repetitionRule);
            return array($eventDueDate, $eventDueTime, $eventRepetitionId, $eventRepetitionParam);
  }


  /**
   * This is tested with Google Calendar
   *
   * N.B.: This assumes that we are provided also with a DTSTART parameter
   *
   * It doesn't handle the UNTIL and COUNT parameters
   *
   * @param string $repetitionRule - rrule field - i.e.: FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU
   * @return false|array ($repetitionId, $repetitionParam) - false on unrecognized rrule
   */
  public static function fromICalRruleStringToInternalParams($inputRepetitionRule)
  {
      if (strlen(trim($inputRepetitionRule)) == 0)
      {
          return array();
      }

      // filtering out the UNTIL parameter that we don't use
      $repetitionRule = preg_replace('!UNTIL=[^;$]+(;)?!', '', $inputRepetitionRule);
      // filtering out the COUNT parameter that we don't use
      $repetitionRule = preg_replace('!COUNT=[^;$]+(;)?!', '', $inputRepetitionRule);

      $repetitionId = 0;
      $repetitionParam = 0;

      if (preg_match('!FREQ=WEEKLY;(INTERVAL=([0-9]+))?(BYDAY=([A-Za-z]{2}))?$!', $repetitionRule, $matches)) // i.e.:FREQ=WEEKLY;BYDAY=SU
      {
        $interval = $matches[2];
        if ($interval > 1)
        {
            // the GCal expression comes like this: FREQ=WEEKLY;INTERVAL=3;BYDAY=SA
            // but we can safely ignore the BYDAY=SA bit as that inofrmation comes from
            // the event due date
            $repetitionId = 12;
            $repetitionParam = $interval;
        }
        else
        {
            $weekAbbreviation = strtolower($matches[4]);
            $weekAbbreviations = array(1 => 'su', 2 => 'mo', 3 => 'tu', 4 => 'we', 5 => 'th', 6 => 'fr', 7 => 'sa');

            $repetitionId = array_search($weekAbbreviation, $weekAbbreviations);
        }
        
        if ( ($interval == 1) && !isset($matches[4]) )
        {
            $repetitionId = 11;    
        }
      }
      else if ( ($repetitionRule == 'FREQ=DAILY') || ($repetitionRule == 'FREQ=DAILY;INTERVAL=1') )
      {
        $repetitionId = 8;
      }
      else if (preg_match('!FREQ=WEEKLY;(INTERVAL=([0-9]+);)?BYDAY=MO,TU,WE,TH,FR!', $repetitionRule))
      {
        $repetitionId = 9;
      }
      else if (preg_match('!FREQ=DAILY;INTERVAL=([0-9]+)!', $repetitionRule, $matches)) // i.e.:FREQ=WEEKLY;BYDAY=SU
      {
        $repetitionId = 10;
        $repetitionParam = $matches[1];
      }
      else if ( ($repetitionRule == 'FREQ=WEEKLY') || ($repetitionRule == 'FREQ=WEEKLY;INTERVAL=1') )
      {
        $repetitionId = 11;
      }
      else if (preg_match('!FREQ=MONTHLY;(INTERVAL=([0-9]+);)?BYDAY=([-0-9]+)?(.{2})!', $repetitionRule, $matches))
      {
        // with this case we can handle all
        // 20 <= repetitionId <= 33
        // and
        // repetitionId >= 40

        $repetitionParam = strlen($matches[2]) > 0 ? $matches[2] : 1; // INTERVAL

        $byday = strlen($matches[3]) > 0 ? $matches[3] : 1; // can be one among -1, 1, 2, 3, 4 corresponding to 'last week', 'first week', ...
        $repetitionStartingIds = array('1' => 20, // the first repetitionId corresponding to 'first week' is 20
                                     '-1' => 27,  // the last repetitionId corresponding to 'first week' is 26
                                     '2' => 40,
                                     '3' => 50,
                                     '4' => 60);

        $dow = $matches[4]; // can be either SU or MO or TU.....
        $repetitionIncrementalIds = array('SU' => 0,
                                          'MO' => 1,
                                          'TU' => 2,
                                          'WE' => 3,
                                          'TH' => 4,
                                          'FR' => 5,
                                          'SA' => 6);

        $repetitionId = $repetitionStartingIds[$byday] + $repetitionIncrementalIds[$dow];
      }
      else if (preg_match('!FREQ=MONTHLY;INTERVAL=1$!', $repetitionRule))
      {
        // the GCal expression comes like this: FREQ=MONTHLY;INTERVAL=X;BYMONTHDAY=1
        // but we can safely ignore the BYMONTHDAY=1 bit as that information comes from
        // the event due date
        $repetitionId = 13;
        // this handles also the $repetitionId = 17
      }
      else if (preg_match('!FREQ=MONTHLY;.*BYMONTHDAY=-1!', $repetitionRule))
      {
        $repetitionId = 18;
        $repetitionParam = 1;
      }
      else if (preg_match('!FREQ=MONTHLY;.*BYMONTHDAY=-2!', $repetitionRule))
      {
        $repetitionId = 19;
        $repetitionParam = 1;
      }
      else if (preg_match('!FREQ=MONTHLY;INTERVAL=([0-9]+)!', $repetitionRule, $matches))
      {
        // the GCal expression comes like this: FREQ=MONTHLY;INTERVAL=X;BYMONTHDAY=18
        // but we can safely ignore the BYMONTHDAY=18 bit as that information comes from
        // the event due date
        $repetitionId = 14;
        $repetitionParam = $matches[1];
        // this handles also the $repetitionId = 17
      }
      else if (preg_match('!FREQ=MONTHLY;BYMONTHDAY=[0-9]+!', $repetitionRule))
      {
        // the GCal expression comes like this: FREQ=MONTHLY;INTERVAL=X;BYMONTHDAY=18
        // but we can safely ignore the BYMONTHDAY=18 bit as that information comes from
        // the event due date
        $repetitionId = 14;
        $repetitionParam = 1;
        // this handles also the $repetitionId = 17
      }
      else if ( ($repetitionRule == 'FREQ=YEARLY') || ($repetitionRule == 'FREQ=YEARLY;INTERVAL=1') )
      {
        $repetitionId = 15;
      }
      else if (preg_match('!FREQ=YEARLY;INTERVAL=([0-9]+)!', $repetitionRule, $matches))
      {
        // the GCal expression comes like this: FREQ=MONTHLY;INTERVAL=X;BYMONTHDAY=1
        // but we can safely ignore the BYMONTHDAY=1 bit as that information comes from
        // the event due date
        $repetitionId = 16;
        $repetitionParam = $matches[1];
      }
      else if ( $repetitionRule == 'FREQ=MONTHLY;INTERVAL=([0-9]+);BYMONTHDAY=-1' )
      {
        $repetitionId = 18;
        $repetitionParam = $matches[1];
      }
      else if ( $repetitionRule == 'FREQ=MONTHLY;INTERVAL=([0-9]+);BYMONTHDAY=-2' )
      {
        $repetitionId = 19;
        $repetitionParam = $matches[1];
      }
      else if (preg_match('!FREQ=WEEKLY;.*BYDAY=([A-Za-z]+)!', $repetitionRule, $matches)) // i.e.:FREQ=WEEKLY;BYDAY=MO,TH
      {
        // this will be the case with between 1 and 5 weekdays to repeat because
        // we have handled the other ones in earlier    else if's

        $weekAbbreviations = explode(',', strtolower($matches[1]));
        $onSun = in_array('su', $weekAbbreviations);
        $onMon = in_array('mo', $weekAbbreviations);
        $onTue = in_array('tu', $weekAbbreviations);
        $onWed = in_array('we', $weekAbbreviations);
        $onThu = in_array('th', $weekAbbreviations);
        $onFri = in_array('fr', $weekAbbreviations);
        $onSat = in_array('sa', $weekAbbreviations);

        $repetitionId = 34;
        $repetitionParam = self::fromWeekdaysSetToIntegerForRepetition($onSun, $onMon, $onTue, $onWed, $onThu, $onFri, $onSat);
      }
      else
      {
          sfErrorNotifier::alert("Couldn't map this rule: " . $inputRepetitionRule);
          return false;
      }

      return array($repetitionId, $repetitionParam);
  }

  /**
   *
   * @param string $dueDate - in the format Y-m-d (the local one for the user)
   * @param string $dueTime - in the format (H)H:mm (the local one for the user) or empty string
   * @return array ($localDueDate, $localDueTime) - same format as the input
   */
  public static function fromGmtDateAndTime2LocalDateAndTime($dueDate, $dueTime)
  {
      $localDueDate = '';
      $localDueTime = '';

      if (! is_numeric($dueTime))
      {
        $localDueDate = $dueDate;
      }
      else
      {
        list($year, $month, $day) = explode('-', $dueDate);
        $hour = floor($dueTime/100);
        $minute = $dueTime%100;

        $gmtTimestamp = mktime($hour, $minute, 0, $month, $day, $year);

        $localTimestamp = $gmtTimestamp + PcUserPeer::getLoggedInUser()->getRealOffsetFromGMT();

        $localDueDate = date('Y-m-d', $localTimestamp);
        $localDueTime = (int)date('Gi', $localTimestamp);
      }

      return array($localDueDate, $localDueTime);
  }

  /**
   *
   * @param string $localDueDate - in the format Y-m-d (the local one for the user)
   * @param string $localDueTime - in the format (H)H:mm (the local one for the user)
   * @return array ($dueDate, $dueTime) - same format as the input
   */
  public static function fromLocalDateAndTime2GMTDateAndTime($localDueDate, $localDueTime)
  {
      $dueDate = '';
      $dueTime = '';

      if (! is_numeric($localDueTime))
      {
        $dueDate = $localDueDate;
      }
      else
      {
        list($year, $month, $day) = explode('-', $localDueDate);
        $hour = floor($localDueTime/100);
        $minute = $localDueTime%100;

        $localTimestamp = mktime($hour, $minute, 0, $month, $day, $year);

        $gmtTimestamp = $localTimestamp - PcUserPeer::getLoggedInUser()->getRealOffsetFromGMT();

        $dueDate = date('Y-m-d', $gmtTimestamp);
        $dueTime = (int)date('Gi', $gmtTimestamp);
      }

      return array($dueDate, $dueTime);
  }
}
