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

class PcTime
{
    /*
     * @var integer
     * i.e.: 915 for 9:15am
     * i.e.: 1800 for 9pm
     */
    private $integerValue = 0;

    const TIME_FORMAT_0 = 0;
    const TIME_FORMAT_1 = 1;

    public function __construct()
    {

    }

    /**
     *
     * @param int|null $integerValue i.e.: 915 for 9:15am, i.e.: 1800 for 9pm
     */
    public function createFromIntegerValue($integerValue)
    {
        $this->integerValue = $integerValue;
        return $this;
    }

    /**
     *
     * @param int $hours
     * @param int $minutes
     * @param string $amOrPmString (='') case-insensitive
     */
    public function createFromParts($hours, $minutes = 0, $amOrPmString = '')
    {
        $amOrPmString = strtolower($amOrPmString);
        if ( ($amOrPmString != 'am') && ($amOrPmString != 'pm'))
        {
            // illegal value: reset it
            $amOrPmString = '';
        }
        $isPm = ($amOrPmString == 'pm');
        $isAm = ($amOrPmString == 'am');

        // see http://en.wikipedia.org/wiki/24-hour_clock
        if ( $isPm )
        {
            if ($hours < 12)
            {
                $hours = $hours + 12;
            }
        }

        if ($isAm && ($hours == 12))
        {
            $hours = 0;
        }

        $this->integerValue = ($hours * 100) + $minutes;
        return $this;
    }

    /**
     * @return int - in the 24-H form (H)HMM (i.e.: 915 or 1800)
     */
    public function getIntegerValue()
    {
        return $this->integerValue;
    }

    /**
     * @return array of int, with hour and minute
     */
    public function getDueTimeHourAndMinute()
    {
        $ret = array();
        $dueTime = str_pad($this->integerValue, 4, '0', STR_PAD_LEFT);

        $ret[0] = (int)substr($dueTime, 0, strlen($dueTime)-2);
        $ret[1] = (int)substr($dueTime, -2);

        return $ret;
    }

    /**
     * @return string - 09:15, 18:30
     */
    public function get5CharsRepresentation()
    {
        list($hours, $mins) = $this->getDueTimeHourAndMinute();

        return str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @param PcUser $loggedInUser
     * @param int $forcedTimeFormatId
     * @return string
     */
    public function getHumanFriendlyTime(PcUser $loggedInUser, $forcedTimeFormatId = null)
    {
        if ($this->integerValue === NULL)
        {
            return '';
        }

        list($hour, $minute) = $this->getDueTimeHourAndMinute();

        $timeFormat = ($forcedTimeFormatId !== null) ? $forcedTimeFormatId : $loggedInUser->getTimeFormat();

        if($timeFormat == 1)
        {
            if ( strlen($minute) == 1 )
            {
                $minute = '0' . $minute;
            }
            return $hour . ':' . $minute;
        }
        else
        {
            // see http://en.wikipedia.org/wiki/24-hour_clock
            $pm = null;
            if ($hour > 12)
            {
                $hour -= 12;
                $pm = true;
            }
            else if ($hour == 12)
            {
                $pm = true;
            }
            else
            {
                if ($hour == 0)
                {
                    $hour = 12;
                }
                $pm = false;
            }

            if ( strlen($minute) == 1 )
            {
                $minute = '0' . $minute;
            }

            return $hour . ':' . $minute . ($pm ? 'pm' : 'am');
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->integerValue < 2360;
    }
}
