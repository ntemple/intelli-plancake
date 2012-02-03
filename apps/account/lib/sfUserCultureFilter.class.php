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
class sfUserCultureFilter extends sfFilter
{
  public function execute($filterChain)
  {
    $context = $this->getContext();
    $request = $context->getRequest();
    $user = $context->getUser();

    $availableLangs = PcLanguagePeer::getAvailableLanguageAbbreviations();
    if ($preferredLang = $request->getParameter('pc_preferred_lang')) // they use lang dropdown selector
    {
       $loggedInUser = PcUserPeer::getLoggedInUser();

       if ($loggedInUser)
       {
            if (in_array($preferredLang, $availableLangs))
            {
                $user->setCulture($preferredLang);
                $loggedInUser->setPreferredLanguage($preferredLang)->save();
            }
       }
    }

    // fallback to default language
    if (! $user->getCulture())
    {
        $user->setCulture(SfConfig::get('app_site_defaultLang'));
    }

    $filterChain->execute();
  }
}
?>
