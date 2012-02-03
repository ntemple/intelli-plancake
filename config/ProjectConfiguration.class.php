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

// DO NOT edit the following line as that would break the build of the public package
// Next line will be replaced by "define('PLANCAKE_PUBLIC_RELEASE', 1);" during the build of the public package
define('PLANCAKE_PUBLIC_RELEASE', 1);

if (! defined('PLANCAKE_PUBLIC_RELEASE'))
{
    define('PLANCAKE_FORUM_ENABLED', 1);
}
else
{
    define('PLANCAKE_FORUM_ENABLED', 0);
}

require_once dirname(__FILE__).'/../lib/vendor/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

if (! defined('PLANCAKE_PUBLIC_RELEASE'))
{
    // prevent people from running 'propel:build-all-load' on the server by accident
    if (isset($argv) && isset($argv[1]) &&  ($argv[1] == 'propel:build-all-load'))
    {
        $envOption = $argv[2];
        if ($envOption !== "--env=dev")
        {
//            die('You are not allowed to run this task on this environment.');
        }
    }
}

if (defined('PLANCAKE_PUBLIC_RELEASE'))
{
    require_once dirname(__FILE__) . '/../data/public_version_lang_file.php';
}

if (! preg_match('!web/(ctrl|books)([^.]+)?\.php!', $_SERVER["SCRIPT_FILENAME"]))
{
    function __($stringId)
    {
        if (! defined('PLANCAKE_PUBLIC_RELEASE'))
        {
            $lang = PcLanguagePeer::getUserPreferredLanguage()->getId();

            $key = '';
            if ($cache = PcCache::getInstance())
            {
              $key = PcCache::generateKeyForTranslation($lang, $stringId);
              if ($cache->has($key))
              {
                return $cache->get($key);
              }
            }

            $translation =
                PcTranslationPeer::retrieveByPK($lang, $stringId);

            if ( (!is_object($translation)) || (!strlen(trim($translation->getString())) > 0) )
            {
                $translation =
                    PcTranslationPeer::retrieveByPK(SfConfig::get('app_site_defaultLang'), $stringId);
            }

            if (! $translation)
            {
                throw new Exception("Couldn't find the string $stringId for the language $lang");
            }

            $ret = $translation->getString();

            if( $cache ) $cache->set($key, $ret);
        }
        else
        {
            global $pc_lang;
            if (! array_key_exists($stringId, $pc_lang))
            {
                throw new Exception("Couldn't find the string $stringId");
            }
            $ret = $pc_lang[$stringId];
        }
        return $ret;
    }
}


class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    // this is to make the openId library work
    $openIdLibraryPath = sfConfig::get('sf_lib_dir') . '/vendor/openid';
    set_include_path(get_include_path() . PATH_SEPARATOR . $openIdLibraryPath);

    // this is to make the ZendGdata library work
    $zendGdataLibraryPath = sfConfig::get('sf_lib_dir') . '/vendor/ZendGdata/library';
    set_include_path(get_include_path() . PATH_SEPARATOR . $zendGdataLibraryPath);

    // These plugins have been removed from the project PlanCake
    $this->enableAllPluginsExcept(array('sfDoctrinePlugin'));

    if ( defined('PLANCAKE_FORUM_ENABLED') && PLANCAKE_FORUM_ENABLED)
    {
      $this->dispatcher->connect('user.sign_up', array('ForumBridge', 'registrationEventCallback'));
      $this->dispatcher->connect('custom_auth.login', array('ForumBridge', 'loginEventCallback'));
      $this->dispatcher->connect('custom_auth.logout', array('ForumBridge', 'logoutEventCallback'));
      $this->dispatcher->connect('user.set_password', array('ForumBridge', 'setPasswordEventCallback'));
      $this->dispatcher->connect('user.set_username', array('ForumBridge', 'setUsernameEventCallback'));
      $this->dispatcher->connect('user.set_email', array('ForumBridge', 'setEmailEventCallback'));
      $this->dispatcher->connect('user.set_dst', array('ForumBridge', 'setDstEventCallback'));
      $this->dispatcher->connect('user.set_timezone', array('ForumBridge', 'setTimezoneEventCallback'));
      $this->dispatcher->connect('user.set_date_format', array('ForumBridge', 'setDateFormatEventCallback'));
    }
  }
}
