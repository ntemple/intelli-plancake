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

class PcUpdatePeer extends BasePcUpdatePeer
{
    /**
     * @return string - a 32-character hash
     */
    public static function generateSignature()
    {
        return PcUtils::generate32CharacterRandomHash();
    }

    /*
     * @return PcUpdate
     */
    public static function getLastUpdate()
    {
        $c = new Criteria();
        $c->addDescendingOrderByColumn(self::CREATED_AT);
        $c->setLimit(1);

        return self::doSelectOne($c);
    }

    /**
     *
     * @param string $signature
     * @return PcUpdate|null
     */
    public static function retrieveBySignature($signature)
    {
        $c = new Criteria();
        $c->add(self::SIGNATURE, $signature);
        return self::doSelectOne($c);
    }
}
