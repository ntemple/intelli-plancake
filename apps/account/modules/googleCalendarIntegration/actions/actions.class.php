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
 * googleCalendarIntegration actions.
 *
 * @package    plancake
 * @subpackage googleCalendarIntegration
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class googleCalendarIntegrationActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeStep1(sfWebRequest $request)
  {
      if (PcUserPeer::getLoggedInUser()->hasGoogleCalendarIntegrationActive())
      {
          $this->redirect('default', array('module' => 'main', 'action' => 'index'));
      }
  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeStep2(sfWebRequest $request)
  {
        if (PcUserPeer::getLoggedInUser()->hasGoogleCalendarIntegrationActive())
        {
          $this->redirect('default', array('module' => 'main', 'action' => 'index'));
        }

        $this->redirect('http://' . sfConfig::get('app_site_url') . '/integrations/google_calendar_init.php');
  }

  public function executeStep3(sfWebRequest $request)
  {
      if (PcUserPeer::getLoggedInUser()->hasGoogleCalendarIntegrationActive())
      {
          $this->redirect('default', array('module' => 'main', 'action' => 'index'));
      }

      $googleCalendarInterface = new GoogleCalendarInterface(PcUserPeer::getLoggedInUser());
      $googleCalendarInterface->init();

      $calendars = $googleCalendarInterface->getAllCalendars();

      $oldCalendarUrl = $googleCalendarInterface->getCalendarUrl();
      $plancakeCalendarName = GoogleCalendarInterface::PLANCAKE_SPECIFIC_CALENDAR_NAME;

      $this->calendarAlreadyExist = false;
      foreach ($calendars as $calendar)
      {
        if ( ($calendar->title == $plancakeCalendarName) ||
             ($calendar->content->src == $oldCalendarUrl) )
        {
            $this->calendarAlreadyExist = true;
            break;
        }
      }
  }

  public function executeStep3Error(sfWebRequest $request)
  {
  }

  public function executeStep4(sfWebRequest $request)
  {
  }

  public function executeStep4Error(sfWebRequest $request)
  {
  }
}
