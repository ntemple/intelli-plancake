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

require_once 'lib/model/om/BasePcQuoteOfTheDayPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'pc_quote_of_the_day' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcQuoteOfTheDayPeer extends BasePcQuoteOfTheDayPeer {

    /**
     * @return PcQuoteOfTheDay|null|false
     */
    public static function getUserTodayQuote()
    {
        $loggedInUser = PcUserPeer::getLoggedInUser();
        
        $hideableHintsSetting = $loggedInUser->getHideableHintsSetting();
        
        if ($hideableHintsSetting[PcHideableHintsSettingPeer::QUOTE_HINT] === 1)
        {
            return false;
        }

        $localTimestamp = $loggedInUser->getTime();
        $today = date('Ymd', $localTimestamp);

        $c = new Criteria();
        $c->add(self::SHOWN_ON, $today);
        $todayQuote = self::doSelectOne($c);
        
        if (! $todayQuote) // this is the first time of the day we need to serve a new quote
        {
            $c = new Criteria();
            $c->add(self::SHOWN_ON, null, Criteria::ISNULL);
            $c->addAscendingOrderByColumn('rand()');
            $c->setLimit(1);
            $todayQuote = self::doSelectOne($c);

            if ($todayQuote)
            {
                $todayQuote->setShownOn($today)
                           ->save();
            }
            else
            {
                sfErrorNotifier::alert("There are no quotes available anymore.");
            }
        }
        return $todayQuote;
    }


} // PcQuoteOfTheDayPeer
