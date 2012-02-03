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

class advComponents extends sfComponents
{
  public function executeAdvAccountSettings()
  {
      // preExecute doesn't seem to work with components
      if (! $this->areAdvertsToShow())
      {
          return sfView::NONE;
      }
  }

  public function executeAdvBlog()
  {
      return sfView::NONE;  // never shown

      $user = PcUserPeer::getLoggedInUser();

      // preExecute doesn't seem to work with components
      if ( (!$this->areAdvertsToShow()) ||
           !is_object($user) )
      {
          return sfView::NONE;
      }

      // show the ad only to non-logged in users
      //if (!$this->getUser()->isAuthenticated())
      //{
        //return sfView::NONE;
      //}
  }

  public function executeSubscribe()
  {
      // preExecute doesn't seem to work with components
      if (! $this->areAdvertsToShow())
      {
          return sfView::NONE;
      }
  }

  private function areAdvertsToShow()
  {
      if (defined('PLANCAKE_PUBLIC_RELEASE'))
      {
        return false;
      }

      $user = PcUserPeer::getLoggedInUser();

      if( is_object($user) && ($user->isSupporter()) )
      {
          return false;
      }
      return true;
  }
}
