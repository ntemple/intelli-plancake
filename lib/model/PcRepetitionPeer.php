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

class PcRepetitionPeer extends BasePcRepetitionPeer
{
  /**
   * Returns the select tag for choosing the repetition type
   *
   * @return     string
   */
  public static function getSelectTag()
  {
    $s = "<select name=\"repetitionTypes\"><option value=\"-1\">" . __('ACCOUNT_TASK_REPETITION_DO_NOT_REPEAT') . "</option>";

    $c = new Criteria();
    $c->addAscendingOrderByColumn(PcRepetitionPeer::SORT_ORDER);
    $repetitions = PcRepetitionPeer::doSelect($c);

    foreach($repetitions as $repetition)
    {
      $s .= "<option value=\"{$repetition->getId()}\">{$repetition->getLocalizedHumanExpression()}</option>";
      if ($repetition->hasDividerBelow())
      {
        $s .= "<option value=\"0\">-------------------</option>";
      } 
    }

    $s .= "</select>";

    return $s;
  }

  /**
   *
   * @param int $fromTimestamp (=null) - GMT
   * @param int $toTimestamp (=null) - GMT
   * @return array of PcRepetition
   */
  public static function retrieveUpdatedSince($fromTimestamp = null, $toTimestamp = null)
  {
    $c = new Criteria();

    if ($fromTimestamp !== null)
    {
        $c->add(self::UPDATED_AT, PcUtils::getMysqlTimestamp($fromTimestamp), Criteria::GREATER_EQUAL);
        $c->addAnd(self::UPDATED_AT, PcUtils::getMysqlTimestamp($toTimestamp), Criteria::LESS_THAN);
    }
    
    $c->addAscendingOrderByColumn(self::SORT_ORDER);    

    return self::doSelect($c);
  }
}
