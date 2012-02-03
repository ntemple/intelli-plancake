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

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('account', 'prod', false);
$context = sfContext::createInstance($configuration);

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Calendar');

$redirectUrl = '';

try
{
    $googleCalender = new GoogleCalendarInterface(PcUserPeer::getLoggedInUser());
    $googleCalender->init();
    $googleCalender->import(PcTaskPeer::getIncompletedTasksWithDate());

    $configuration->loadHelpers('Url');
    $redirectUrl = 'http://' . sfConfig::get('app_site_url') . '/' . sfConfig::get('app_accountApp_frontController') .
        '/googleCalendarIntegration/step4';
}
catch(Exception $e)
{
    sfErrorNotifier::alert("Google Calendar Import: " . $e->getMessage());

    error_log("Google Calendar Import: " . $e->getMessage());

    $configuration->loadHelpers('Url');
    $redirectUrl = 'http://' . sfConfig::get('app_site_url') . '/' . sfConfig::get('app_accountApp_frontController') .
        '/googleCalendarIntegration/step4Error';

}

header( "Location: $redirectUrl" ) ;