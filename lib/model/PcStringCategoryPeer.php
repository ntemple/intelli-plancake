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

require 'lib/model/om/BasePcStringCategoryPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'pc_string_category' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcStringCategoryPeer extends BasePcStringCategoryPeer {

    /**
     * @param boolean $inAccount(=false)
     * @return array of PcStringCategory
     */
    public static function getSortedCategories($inAccount = false, $inMisc = false)
    {
        $c = new Criteria();

        $c->add(self::IN_ACCOUNT, $inAccount ? 1 : 0);
        $c->add(self::IN_MISC, $inMisc ? 1 : 0);

        $c->addAscendingOrderByColumn(self::SORT_ORDER);
        return self::doSelect($c);
    }

} // PcStringCategoryPeer
