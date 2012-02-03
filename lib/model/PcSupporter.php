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

class PcSupporter extends BasePcSupporter
{
    /**
     * This does not extend the subscription period - it only gives a potential new endDate
     *
     * @param PcSubscriptionType $subscriptionType
     * @param string $startDate (in the form YYYY-mm-dd) - the date from when to start the new subscription period
     * @return integer (timestamp)
     */
    public function getNewExpiryDateAfterSubscription(PcSubscriptionType $subscriptionType, $startDate)
    {
        list($startDateYear, $startDateMonth, $startDateDay) = explode('-', $startDate);

        $startDateTimeStamp = mktime(0, 0, 0, $startDateMonth, $startDateDay, $startDateYear);

        return strtotime($subscriptionType->getExpirationTimeExpression(), $startDateTimeStamp);
    }
    
    public function __toString()
    {
        return $this->getUserId();
    }
    
    public function getUserEmail()
    {
        return PcUserPeer::retrieveByPK($this->getUserId())->getEmail();
    }    
}
