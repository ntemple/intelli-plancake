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

class PcTrashbinListPeer extends BasePcTrashbinListPeer
{
    /**
     *
     * @param int $fromTimestamp (GMT)
     * @param int $toTimestamp (GMT)
     * @param Criteria $c (=null)
     * @return array (of PcTrashbinList)
     */
    public static function getDeletedListsSince($fromTimestamp, $toTimestamp, Criteria $c=null)
    {
        $c = ($c === null) ? new Criteria() : $c;
        $c->add(self::DELETED_AT, $fromTimestamp, Criteria::GREATER_EQUAL);
        $c->addAnd(self::DELETED_AT, $toTimestamp, Criteria::LESS_THAN);
        return self::doSelect($c);
    }
}
