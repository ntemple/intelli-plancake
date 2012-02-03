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

//////////////////////
/*
* Retrieve the current URL so that the AuthSub server knows where to
* redirect the user after authentication is complete.
*/
function getCurrentUrl()
{
    global $_SERVER;

    // Filter php_self to avoid a security vulnerability.
    $php_request_uri =
        htmlentities(substr($_SERVER['REQUEST_URI'],
                            0,
                            strcspn($_SERVER['REQUEST_URI'], "\n\r")),
                            ENT_QUOTES);

    if (isset($_SERVER['HTTPS']) &&
        strtolower($_SERVER['HTTPS']) == 'on') {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }
    $host = $_SERVER['HTTP_HOST'];
    if ($_SERVER['HTTP_PORT'] != '' &&
        (($protocol == 'http://' && $_SERVER['HTTP_PORT'] != '80') ||
        ($protocol == 'https://' && $_SERVER['HTTP_PORT'] != '443'))) {
        $port = ':' . $_SERVER['HTTP_PORT'];
    } else {
        $port = '';
    }
    return $protocol . $host . $port . $php_request_uri;
}



// if there is no AuthSub session or one-time token waiting for us,
// redirect the user to the AuthSub server to get one.
if (!isset($_GET['token'])) {
    // Parameters to give to AuthSub server
    $next = getCurrentUrl();
    $scope = GoogleCalendarInterface::GCAL_INTEGRATION_SCOPE;
    $secure = false;
    $session = true;

    // Redirect the user to the AuthSub server to sign in

    $authSubUrl = Zend_Gdata_AuthSub::getAuthSubTokenUri($next,
                                                         $scope,
                                                         $secure,
                                                         $session);
     header("HTTP/1.0 307 Temporary redirect");

     header("Location: " . $authSubUrl);

     exit();
}
else
{
    try
    {
        $client = new Zend_Gdata_HttpClient();

        $pathToKey = sfConfig::get('sf_root_dir') . '/' .
                     sfConfig::get('app_googleCalendarIntegration_privateKeyPath');

        $client->setAuthSubPrivateKeyFile($pathToKey, null, true);
        $sessionToken = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token'], $client);
    }
    catch(Exception $e)
    {
            sfErrorNotifier::alert("Google Calendar Init: " . $e->getMessage());
            $this->redirect('default', array('module' => 'googleCalendarIntegration', 'action' => 'step3Error'));
    }

    $redirectUrl = '';

    if ($sessionToken)
    {
        $loggedInUser = PcUserPeer::getLoggedInUser();
        if ($loggedInUser)
        {
            $googleCalendarInterface = new GoogleCalendarInterface($loggedInUser);
            $googleCalendarInterface->resetDbEntry();
            $googleCalendarInterface->setSessionToken($sessionToken);
        }

        $configuration->loadHelpers('Url');
        $redirectUrl = 'http://' . sfConfig::get('app_site_url') . '/' . sfConfig::get('app_accountApp_frontController') .
            '/googleCalendarIntegration/step3';
    }
    else
    {
        // something wrong
        $configuration->loadHelpers('Url');
        $redirectUrl = 'http://' . sfConfig::get('app_site_url') .
        $redirectUrl = 'http://' . sfConfig::get('app_site_url') . '/' . sfConfig::get('app_accountApp_frontController') .
            '/googleCalendarIntegration/step3Error';
    }

    header( "Location: $redirectUrl" ) ;
}