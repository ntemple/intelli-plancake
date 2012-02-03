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
abstract class PlancakeActions extends sfActions
{
    protected function renderJson($data) 
    {
      $this->getResponse()->setHttpHeader('Content-type', 'application/json');        
      return $this->renderText(json_encode($data));
    }
    
    /*
     * In order to detect a user has been logged out via AJAX, we check
     * whether the call has generated any content as a reply.
     * Which is why we always send something back.
     */
    protected function renderDefault() 
    {       
      return $this->renderText('ok');
    }    
}
?>