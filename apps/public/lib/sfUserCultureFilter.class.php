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
    $preferredLang = $request->getParameter('pc_preferred_lang');

    sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));

    $loggedInUser = PcUserPeer::getLoggedInUser();

    if ($loggedInUser && !$preferredLang)
    {
        $user->setCulture($loggedInUser->getPreferredLanguage());
    }
    else if ($preferredLang) // they used lang dropdown selector
    {
        if (in_array($preferredLang, $availableLangs))
        {
            $user->setCulture($preferredLang);
            if ($loggedInUser)
            {
                $loggedInUser->setPreferredLanguage($preferredLang)->save();
            }
        }
    }
    else
    {
        if(! $user->getAttribute('after_user_first_request'))
        {
            $culture = strtolower($request->getPreferredCulture($availableLangs));
            $user->setCulture($culture);

            if( ($context->getModuleName() == 'homepage') &&
                    ($context->getActionName() == 'index') )
            {
                if ($culture != SfConfig::get('app_site_defaultLang'))
                {
                    header('Location: ' . url_for('@localized_homepage', true));
                }
            }

            $user->setAttribute('after_user_first_request', true);
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
