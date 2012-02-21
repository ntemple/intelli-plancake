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

$consumer = new PlancakeOpenIdConsumer(PlancakeOpenIdConsumer::PROVIDER_GOOGLE,
                                       'http://www.plancake.com/openIdEndpoints/googleReceiveLogin.php',
                                       PlancakeOpenIdConsumer::MODE_LOGIN);

$consumer->receive($data);

$email = $data['http://axschema.org/contact/email'][0];

if (PcUserPeer::emailExist($email))
{
    $userToLogin = PcUserPeer::retrieveByEmailAddress($email);
    CustomAuth::login($context->getUser(), $userToLogin, false, false);
    
    if (PcUtils::isMobileBrowser()) {
        $redirectUrl = 'https://' . sfConfig::get('app_site_url') . "/account.php/mobile";    
    } else {
        $redirectUrl = 'http://' . sfConfig::get('app_site_url') . "/account.php";            
    }
}
else // email doesn't exist
{
    $encodedEmail = urlencode($email);

    $redirectUrl = 'http://' . sfConfig::get('app_site_url') .
    "/openIdWrongLogin?input_email=$encodedEmail";
}

header( "Location: $redirectUrl" ) ;
