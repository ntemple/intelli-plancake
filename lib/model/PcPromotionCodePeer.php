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

class PcPromotionCodePeer extends BasePcPromotionCodePeer
{
    const PROMOTION_CODE_ERROR_INVALID_CODE = 1;
    const PROMOTION_CODE_ERROR_EXPIRED_CODE = 2;
    const PROMOTION_CODE_ERROR_MAX_USES_REACHED = 3;    
    const PROMOTION_CODE_ERROR_ONLY_FOR_NEW_CUSTOMERS = 4; 
    
    /**
     *
     * @param string $promoCode
     * @return pcPromotionCode|null
     */
    public static function getValidPromoCodeEntry($promoCode)
    {
        $c = new Criteria();
        $c->add(self::EXPIRY_DATE, PcUtils::getMysqlTimestamp(time()), Criteria::GREATER_EQUAL);
        $c->add(self::ID, $promoCode);
        return self::doSelectOne($c);
    }
    
    /**
     *
     * @param string $discountCode
     * @param int &$errorCode > 0 if error occurred (see top of the file)
     * @return int - discount (e.g.: 20) - 0 if error occurred
     */
    public static function getDiscountByCode($discountCode, &$errorCode)
    {
        $errorCode = 0;
        $discount = 0;
        
        if (strlen($discountCode) === 0) {
            return 0;
        }
        
        $c = new Criteria();
        $c->add(self::CODE, trim($discountCode));
        $promotionObj = self::doSelectOne($c);
        $loggedInUser = PcUserPeer::getLoggedInUser();
        
        if (! $promotionObj)
        {
            $errorCode = self::PROMOTION_CODE_ERROR_INVALID_CODE;
        } else {        
            if ( date('Ymd') > str_replace('-', '', $promotionObj->getExpiryDate()) )
            {
                $errorCode = self::PROMOTION_CODE_ERROR_EXPIRED_CODE;            
            }

            if ( $promotionObj->getMaxUses() && 
                    ($promotionObj->getUsesCount() >= $promotionObj->getMaxUses()) )
            {
                $errorCode = self::PROMOTION_CODE_ERROR_MAX_USES_REACHED;            
            }

            if ( $promotionObj->getOnlyForNewCustomers() && $loggedInUser && $loggedInUser->isSupporter() )
            {
                $errorCode = self::PROMOTION_CODE_ERROR_ONLY_FOR_NEW_CUSTOMERS;            
            }
        }
        
        if ($errorCode == 0)
        {
            $discount = $promotionObj->getDiscountPercentage();
        }
        
        return $discount;
    }
    
    public static function getByCode($code)
    {
        $c = new Criteria();
        $c->add(self::CODE, trim($code));
        return self::doSelectOne($c);        
    }
}
