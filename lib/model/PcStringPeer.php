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

require 'lib/model/om/BasePcStringPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'pc_string' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcStringPeer extends BasePcStringPeer {

    public static function getWebAppStrings() {
        $lang = PcLanguagePeer::getUserPreferredLanguage()->getId();

        $c = new Criteria();    
        $c->add(PcStringPeer::CATEGORY_ID, array(115, 119), Criteria::NOT_IN); // Settings && GCal integration
        $c->add(PcStringPeer::IS_ARCHIVED, 0);
        $c->addJoin(PcStringPeer::CATEGORY_ID, PcStringCategoryPeer::ID);
        $c->add(PcStringCategoryPeer::IN_ACCOUNT, 1);
        
        $stringsFromAccount = PcStringPeer::doSelect($c);
        
        $c = new Criteria();
        $c->add(PcStringPeer::CATEGORY_ID, 2); // General
        $c->add(PcStringPeer::IS_ARCHIVED, 0);
        $c->addJoin(PcStringPeer::CATEGORY_ID, PcStringCategoryPeer::ID);
        $c->add(PcStringCategoryPeer::IN_ACCOUNT, 0);
        $c->add(PcStringCategoryPeer::IN_MISC, 0);

        return array_merge($stringsFromAccount, PcStringPeer::doSelect($c));
    }      
    
} // PcStringPeer
