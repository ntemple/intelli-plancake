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

/**
 * These stats are recording into the db upon registration
 *
 * @author dan
 */
class PcCaptureReferralAndEntryPoint extends sfFilter
{
  const ENTRY_POINT_SESSION_KEY =  'session_entry_point';
  const REFERRAL_SESSION_KEY = 'session_referral';
    
  public function execute($filterChain)
  {
    $context = $this->getContext();
    $user = $context->getUser();
    
    if (!$user->getAttribute(self::ENTRY_POINT_SESSION_KEY)) {
        $user->setAttribute(self::ENTRY_POINT_SESSION_KEY, PcUtils::getCurrentURL());
    }
    
    if (!$user->getAttribute(self::REFERRAL_SESSION_KEY) && 
            isset($_SERVER['HTTP_REFERER']) &&
            (strpos($_SERVER['HTTP_REFERER'], 'www.plancake.com/openIdWrongLogin') === FALSE) ) { // added to prevent a lot of meaningless entries
        $user->setAttribute(self::REFERRAL_SESSION_KEY, $_SERVER['HTTP_REFERER']);
    }    
    
    $filterChain->execute();
  }
}
?>
