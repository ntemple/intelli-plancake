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

require 'lib/model/om/BasePcLanguagePeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'pc_language' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcLanguagePeer extends BasePcLanguagePeer {

    public static function getAvailableLanguageAbbreviations()
    {
        $langAbbrs = array();
        if ( (PcUserPeer::getLoggedInUser()) &&
                (PcUserPeer::getLoggedInUser()->isStaffMember() || PcUserPeer::getLoggedInUser()->isTranslator()) )
        {
            $langsUnderDev = is_array(SfConfig::get('app_site_langsUnderDev')) ? SfConfig::get('app_site_langsUnderDev') : array();
            $langAbbrs = array_merge($langAbbrs, $langsUnderDev);
        }

        return array_merge($langAbbrs, SfConfig::get('app_site_langs'));
    }

    /**
     * @param string $languageAbbrToExclude
     * @return array of PcLanguage
     */
    public static function getAvailableLanguages($languageAbbrToExclude = null)
    {
        $c = new Criteria();

        $c->add(self::ID, self::getAvailableLanguageAbbreviations(), Criteria::IN);
        if ($languageAbbrToExclude)
        {
            $c->addAnd(self::ID, $languageAbbrToExclude, Criteria::NOT_EQUAL);
        }
        $c->addAscendingOrderByColumn(self::SORT_ORDER);

        return self::doSelect($c);
    }

    /**
     * @return array of PcLanguage
     */
    public static function getAvailableLanguagesPreferredFirst()
    {
        $preferredLanguage = self::getUserPreferredLanguage();

        if ($preferredLanguage)
        {
            $preferredLanguageAbbr = $preferredLanguage->getId();
        }
        else
        {
            $preferredLanguageAbbr = SfConfig::get('app_site_defaultLang');
        }

        $availableLangs = self::getAvailableLanguages($preferredLanguageAbbr);

        return array_merge(array($preferredLanguage), $availableLangs);
    }


    /**
     * @return PcLanguage
     */
    public static function getUserPreferredLanguage()
    {
        $c = new Criteria();
        $c->add(self::ID, strtolower(sfContext::getInstance()->getUser()->getCulture()));
        $lang = self::doSelectOne($c);
        if (! is_object($lang))
        {
            $lang = PcLanguagePeer::retrieveByPk(SfConfig::get('app_site_defaultLang'));
        }
        return $lang;
    }
    
    public static function isUserPreferredLanguageRTL()
    {
        return (self::getUserPreferredLanguage() === 'he');
    }
} // PcLanguagePeer
