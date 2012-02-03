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
 * Description of sfSecureFilter
 *
 * @author dan
 */
class sfSecureFilter extends sfFilter
{
  public function execute($filterChain)
  {
    if (! defined('PLANCAKE_PUBLIC_RELEASE'))
    {
        $context = $this->getContext();
        $request = $context->getRequest();

        $moduleName = $request->getParameter('module');
        $actionName = $request->getParameter('action');

        $loggedInUser = PcUserPeer::getLoggedInUser();
        
        $inMobileApp = ($moduleName == "mobile");
        
        if ( ($loggedInUser) && 
             (($loggedInUser->isSupporter()) || ($inMobileApp) ) )  // we force https with mobile app so that
                                                                    // the cache manifest can have this entry:
                                                                    // https://www.plancake.com/account.php/mobile
                                                                    // and it is going to work for any user, not just Premium ones
        {
            if (!$request->isSecure())
            {
              $secureUrl = str_replace('http', 'https', $request->getUri());

              if (stripos($secureUrl, 'http') !== 0) {
                  $secureUrl = 'https://' . $secureUrl;
              }
              
              return $context->getController()->redirect($secureUrl);
              // We don't continue the filter chain
            }
        }
        else
        {
            if ($request->isSecure())
            {
              $secureUrl = str_replace('https', 'http', $request->getUri());

              return $context->getController()->redirect($secureUrl);
              // We don't continue the filter chain
            }
        }
    }
    $filterChain->execute();
  }
}
?>
