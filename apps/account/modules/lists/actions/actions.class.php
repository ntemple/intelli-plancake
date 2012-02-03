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

class listsActions extends PlancakeActions
{
  public function executeReorder(sfWebRequest $request)
  {
    $listIds = $request->getParameter('list');
      
    $i = 1;
    
    foreach($listIds as $listId) {
        $list = PcListPeer::retrieveByPK($listId);
        
	PcUtils::checkLoggedInUserPermission($list->getCreator());
        $list->setSortOrder($i)
             ->save();
        $i++;        
    }

    return $this->renderDefault();
  }
  
  
  public function executeGet(sfWebRequest $request)
  {
    include_once(sfConfig::get('sf_root_dir') . '/apps/api/lib/PlancakeApiServer.class.php');
    
    $lists = PlancakeApiServer::getLists(array('api_ver' => sfConfig::get('app_api_version'), 'camel_case_keys' => 1));
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderJson($lists);
    }    
  }  

  
  public function executeGetTaskCounters(sfWebRequest $request)
  {
    $loggedInUser = PcUserPeer::getLoggedInUser();
    if ($loggedInUser->hasGoogleCalendarIntegrationActive())
    {
        $gcal = new GoogleCalendarInterface($loggedInUser);
        $gcal->init();
        $gcal->syncPlancake();
    }
    
    $counters = array();
    $counters['counters']['inboxCounter'] = $loggedInUser->getInboxCounter();
    $counters['counters']['todayCounter'] = $loggedInUser->getOverdueDueTodayCounter();
    $counters['counters']['newsCounter'] = $loggedInUser->getBlogPostsCounterSinceLatestBlogAccess();
    
    return $this->renderJson($counters);
  }

  public function executeScheduledTasksForTodo(sfWebRequest $request)
  {
    $loggedInUser = PcUserPeer::getLoggedInUser();
    if ($loggedInUser->hasGoogleCalendarIntegrationActive())
    {
        $gcal = new GoogleCalendarInterface($loggedInUser);
        $gcal->init();
        $gcal->syncPlancake();
    }

    include_once(sfConfig::get('sf_root_dir') . '/apps/api/lib/PlancakeApiServer.class.php');
    
    $apiVersion = sfConfig::get('app_api_version');
    
    $doneParam = $request->getParameter('done');
    $typeParam = $request->getParameter('type');
    $extraParam = $request->getParameter('extraParam');
    
    $filters = array();
    $filters['list_id'] = $loggedInUser->getTodo()->getId();
    $filters['only_with_due_date'] = 1;
    
    $tasks = PlancakeApiServer::getTasks(
            array_merge($filters, array('api_ver' => $apiVersion, 'camel_case_keys' => 1)));
    
    $tasks['tasks'] = array_reverse($tasks['tasks']); // to make them easier to show on the UI
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderJson($tasks);
    }
  }
}
