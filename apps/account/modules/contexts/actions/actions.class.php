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
 * contexts actions.
 *
 * @package    plancake
 * @subpackage contexts
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class contextsActions extends PlancakeActions
{
  public function executeReorder(sfWebRequest $request)
  {
    $tagIds = $request->getParameter('tag');
      
    $i = 1;
    
    foreach($tagIds as $tagId) {
        $tag = PcUsersContextsPeer::retrieveByPk($tagId);
        
	PcUtils::checkLoggedInUserPermission(PcUserPeer::retrieveByPK($tag->getUserId()));
        $tag->setSortOrder($i)
            ->save();
        $i++;       
    }

    return $this->renderDefault();
  }
  
  public function executeGet(sfWebRequest $request)
  {
    include_once(sfConfig::get('sf_root_dir') . '/apps/api/lib/PlancakeApiServer.class.php');
    
    $tags = PlancakeApiServer::getTags(array('api_ver' => sfConfig::get('app_api_version'), 'camel_case_keys' => 1));
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderJson($tags);
    }      
  }   
}
