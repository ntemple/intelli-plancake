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

class PcListPeer extends BasePcListPeer
{
  /**
   * Returns the visitor IP
   * 
   * @return PcList
   */
  public static function getCurrentList()
  {
    $context = sfContext::getInstance();
    return self::retrieveByPk($context->getRequest()->getParameter('id'));
  }

  /**
   * @return array of PcList
   */
  public static function getAllInboxes()
  {
      $c = new Criteria();
      $c->add(self::IS_INBOX, 1);
      return self::doSelect($c);
  }
}
