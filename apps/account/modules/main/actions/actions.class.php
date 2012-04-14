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

class mainActions extends PlancakeActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
    $this->getUser()->setCulture($user->getPreferredLanguage());

    // {{{ START: is this the first login?
    // We need to do this before calling refreshLastLogin()
    if ($user->getLastLogin('U') < mktime(0, 0, 0)) 
    {
        $this->getUser()->setAttribute('user_first_login_of_the_day', 1);    
    }
    else 
    {
        $this->getUser()->setAttribute('user_first_login_of_the_day', 0);   
    }
    // }}} END: is this the first login?
    
    $user->refreshLastLogin()
         ->save();

    if (!$user->getHasDesktopAppBeenLoaded())
    {
        $this->getUser()->setAttribute('user_still_to_load_desktop_app', 1);
    }

    // the action we are in is not called by the mobile app, but must by the desktop app
    $user->setHasDesktopAppBeenLoaded(true)->save();
    
    $this->updateAvailable = false;

    // check whether one day has passed from the last check
    $lastCheckForUpdates = PcUtils::getValue('last_check_for_updates', time());
    if ( (time() - $lastCheckForUpdates) > 86400 ) // one day
    {
        // time to do a new check
        //
        // we access the version file directly (and not the config value) to avoid cache
        $urlFriendlySiteVersion = str_replace('.', '-', file_get_contents(sfConfig::get('sf_root_dir') . '/version'));
        $updatesUrl = sfConfig::get('app_site_urlForUpdates') . '/' . $urlFriendlySiteVersion;
        // $updatesUrl may be something like this: http://updates.plancake.com/updates/1.8.6

        $updates = PcUtils::getFileContentOverInternet($updatesUrl, true);
        // $updates may be something like this:
        // 1--|--ffb524e371203966974750bf5c3a9a77--|--Reminder: Plancake will be down for maintenance in a few hours--|--http://tinyurl.com/34vwsq5

        $updatesParts = explode(sfConfig::get('app_site_updatesStringDivider'), $updates);
        $newReleaseAvailable = isset($updatesParts[0]) ? $updatesParts[0] : '';
        $lastUpdateSignature = isset($updatesParts[1]) ? $updatesParts[1] : '';
        $lastUpdateDescription = isset($updatesParts[2]) ? $updatesParts[2] : '';
        $lastUpdateLink = isset($updatesParts[3]) ? $updatesParts[3] : '';

        // we use this also in the hosted version (even if it is meant for installations)
        // to spot problems easily
        $this->updateAvailable = (boolean)$newReleaseAvailable;

        if (defined('PLANCAKE_PUBLIC_RELEASE'))
        {
           // check whether the update is already in the system
           if (!is_object(PcUpdatePeer::retrieveBySignature($lastUpdateSignature)))
           {
               $update = new PcUpdate();
               $update->setUrl($lastUpdateLink)
                     ->setDescription($lastUpdateDescription)
                     ->setSignature($lastUpdateSignature)
                     ->setCreatedAt(time())
                     ->save();

                PcUtils::broadcastUpdate($lastUpdateDescription, $lastUpdateLink);
           }
        }

        PcUtils::setValue('last_check_for_updates', time());
    }
  }
  
  public function executeStartupData(sfWebRequest $request)
  {
    include_once(sfConfig::get('sf_root_dir') . '/apps/api/lib/PlancakeApiServer.class.php');
    
    $loggedInUser = PcUserPeer::getLoggedInUser();
    $this->getUser()->setCulture($loggedInUser->getPreferredLanguage());

    $userTodayQuote = null;
    if ($this->getUser()->getAttribute('user_first_login_of_the_day') === 1)
    {
        $userTodayQuote = PcQuoteOfTheDayPeer::getUserTodayQuote();
        if ($userTodayQuote === null) {
            sfErrorNotifier::alert("THERE ARE NOT QUOTES LEFT!!!!!!");
        }
    }
    
    $quoteContent = '';
    $quoteAuthor = '';
    if ($userTodayQuote)
    {
        $quoteContent = $userTodayQuote->getQuote();
        $quoteContentInItalian = $userTodayQuote->getQuoteInItalian();

        $quoteAuthor = $userTodayQuote->getQuoteAuthor();
        $quoteAuthorInItalian = $userTodayQuote->getQuoteAuthorInItalian();

        if ($loggedInUser->isItalian() && $quoteContentInItalian)
        {
           $quoteContent = $quoteContentInItalian;
        }

        if ($loggedInUser->isItalian() && $quoteAuthorInItalian)
        {
           $quoteAuthor = $quoteAuthorInItalian;
        }
    }

    $apiVersion = sfConfig::get('app_api_version');
   
    $lists = PlancakeApiServer::getLists(array('api_ver' => $apiVersion, 'camel_case_keys' => 1));   
    $tags = PlancakeApiServer::getTags(array('api_ver' => $apiVersion, 'camel_case_keys' => 1));
    $repetitionOptions = PlancakeApiServer::getRepetitionOptions(array('api_ver' => $apiVersion)); 
    $userSettings = PlancakeApiServer::getUserSettings(array('api_ver' => $apiVersion, 'camel_case_keys' => 1));
    
    $breakingNewsId = '';
    $breakingNewsHeadline = '';
    $breakingNewsLink = '';    
    if ($breakingNews = $loggedInUser->getBreakingNews())
    {
        $breakingNewsId = $breakingNews->getId();
        $breakingNewsHeadline = $breakingNews->getHeadline();        
        $breakingNewsLink = $breakingNews->getLink(); 
    }
    
    $data = array('isPublicRelease' => (int)defined('PLANCAKE_PUBLIC_RELEASE'),
                  'isFirstDesktopLogin' => (int)$this->getUser()->getAttribute('user_still_to_load_desktop_app'),
                  'quoteAuthor' => $quoteAuthor,
                  'quoteContent' =>  $quoteContent,
                  'breakingNewsId' => $breakingNewsId,
                  'breakingNewsHeadline' => $breakingNewsHeadline,
                  'breakingNewsLink' => $breakingNewsLink,        
                  'showExpiringSubscriptionAlert' => (int)$loggedInUser->isExpiringSubscriptionAlertToShow(),
                  'isSubscriptionExpired' => (int)$loggedInUser->isSubscriptionExpired());

    $config = array('maxListsForFreeAccount' => sfConfig::get('app_site_maxListsForNonSupporter'),
                    'maxTagsForFreeAccount' => sfConfig::get('app_site_maxTagsForNonSupporter'),
                    'supportEmailAddress' => sfConfig::get('app_emailAddress_support'),
                    'custom' => (($loggedInUser->getId() == 4) ? 1 : 0) ); // this 'custom' key is a temporal thing
    
    
    if ( stripos($request->getUri(), '/mobile') === FALSE ) { // the request doesn't come from the mobile app
        $this->getUser()->setAttribute('user_still_to_load_desktop_app', 0);
    }
    
    $lang = null;
    $strings = PcStringPeer::getWebAppStrings();
    $i = 0;
    foreach($strings as $string) {
        $lang[$string->getId()] = __($string->getId());
    }
    
    $startupData = array('hideableHintsSetting' => $loggedInUser->getHideableHintsSetting(),
                         'lists' => $lists,
                         'tags' => $tags,
                         'repetitionOptions' => $repetitionOptions,
                         'userSettings' => $userSettings,
                         'data' => $data,
                         'config' => $config,
                         'lang' => $lang);
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderJson($startupData);
    }
  }
  
  public function executeGetTasks(sfWebRequest $request)
  {   
    include_once(sfConfig::get('sf_root_dir') . '/apps/api/lib/PlancakeApiServer.class.php');
    
    $apiVersion = sfConfig::get('app_api_version');
    
    $doneParam = $request->getParameter('done');
    $typeParam = $request->getParameter('type');
    $extraParam = urldecode($request->getParameter('extraParam'));
    
    $filters = array();
    $filters['completed'] = (int)$doneParam;
    if ($typeParam == "list") {
        $filters['list_id'] = (int)$extraParam;
        
        $user = PcUserPeer::getLoggedInUser();
        
        /*
        // This was to hide scheduled tasks from the Todo list
        if ( $user->getTodo()->getId() ==  $filters['list_id']) {
            $filters['only_without_due_date'] = 1;
        }
        */
    }
    else if ($typeParam == "tag") 
    {
        $filters['tag_id'] = (int)$extraParam;
    }    
    else if ($typeParam == "starred") 
    {
        $filters['only_starred'] = 1;
    }
    else if ($typeParam == "today") 
    {
        $filters['only_due_today_or_tomorrow'] = 1;
    }
    else if ($typeParam == "calendar") 
    {
        $filters['by_date'] = $extraParam;
    }
    else if ($typeParam == "search") 
    {
        $filters['search_query'] = $extraParam;
    } 

    $tasks = PlancakeApiServer::getTasks(
            array_merge($filters, array('api_ver' => $apiVersion, 'camel_case_keys' => 1)));
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderJson($tasks);
    }    
    
  }
  
}
