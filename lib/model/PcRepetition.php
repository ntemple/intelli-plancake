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

class PcRepetition extends BasePcRepetition
{
  /**
   * Alias for PcRepetition::getNeedsParam()
   * 
   * @return     boolean
   */
  public function needsParam()
  {
    return parent::getNeedsParam();
  }

  /**
   * Alias for PcRepetition::getIsParamCardinal()
   * 
   * @return     boolean
   */
  public function isParamCardinal()
  {
    return parent::getIsParamCardinal();
  }

  /**
   * Alias for PcRepetition::getHasDividerBelow()
   * 
   * @return     boolean
   */
  public function hasDividerBelow()
  {
    return parent::getHasDividerBelow();
  }

  public function getLocalizedHumanExpression()
  {
      return __('ACCOUNT_TASK_REPETITION_' . $this->getId());
  }
}
