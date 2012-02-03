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
 * Provides an instance of sfMemcacheCache if the view cache is active and
 * if the sfMemcacheCache is the cache class used for the view.
 * Provides null otherwise
 *
 * The SfMemcacheCache object returned has got the string
 * generic_
 * as prefix for the keys and it is a Singleton for the whole project
 *
 */
class PcCache
{
  private static $cache;

  public static function getInstance()
  {
    if (is_object(self::$cache)) return self::$cache;

    $viewCacheManager = sfContext::getInstance()->getViewCacheManager();

    if (is_object($viewCacheManager))
    {
      $cacheClass = get_class($viewCacheManager->getCache());
      if ($cacheClass == 'sfMemcacheCache')
      {
        $newObject = new $cacheClass(array('prefix' => 'generic_'));
        self::$cache = $newObject;
        return $newObject;
      }
    }
    return null;
  }

  /**
   * @param string $lang - 2-char string (i.e.: it, en)
   * @param <type> $stringId
   */
  public static function generateKeyForTranslation($lang, $stringId)
  {
    return trim('LANGS_' . trim($lang) . '_' . trim($stringId) );
  }

  public static function getMainNavigationKey()
  {
      return PcLanguagePeer::getUserPreferredLanguage()->getId() . '-' . PcUserPeer::getLoggedInUser()->getId();
  }
}
