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

require 'lib/model/om/BasePcStringCategory.php';


/**
 * Skeleton subclass for representing a row from the 'pc_string_category' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcStringCategory extends BasePcStringCategory {

    public function getStrings()
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(PcStringPeer::SORT_ORDER_IN_CATEGORY);
        $c->add(PcStringPeer::CATEGORY_ID, $this->getId());
        $c->add(PcStringPeer::IS_ARCHIVED, 0);
        return PcStringPeer::doSelect($c);
    }

} // PcStringCategory
