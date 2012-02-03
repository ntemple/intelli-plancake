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
 * Aggregates common data for the application
 * It is a Singleton.
 * It avoids replication of data
 *
 */
class PcCommonData
{
  /**
   * Returns an array with all the date formats
   *
   * @return array
   */
  public static function getDateFormats()
  {
    return array(0 => 'Y-m-d', 3 => 'd-m-Y', 4 => 'm-d-Y');
  }

  /**
   * Returns an array with all the time formats
   *
   * @return array
   */
  public static function getTimeFormats()
  {
    return array(0 => '5:00 pm', 1 => '17:00');
  }


  /**
   * Returns an array with all the time formats
   *
   * @return array
   */
  public static function getWeekStarts()
  {
    return array(0 => 'Sunday', 1 => 'Monday');
  }
}
