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

class PlancakeOpenIdConsumer
{
    const OID_STORE_DIRECTORY = "/tmp/plancake_oid_store";  // this directory must exist and must be writable

    const PROVIDER_GOOGLE = 0;

    const MODE_LOGIN = 0;
    const MODE_REGISTRATION = 1;

    const GOOGLE_PROVIDER_ENDPOINT = "https://www.google.com/accounts/o8/id";

    /**
     *
     * @var string
     */
    private $providerEndPoint;

    /**
     *
     * @var string
     */
    private $returnToUrl;

    /**
     *
     * @var int - see class constants
     */
    private $mode;

    /**
     *
     * @var string
     */
    private $libraryPath = "";

    /**
     *
     * @param int $provider - see class constants
     * @param string $returnToUrl
     * @param int $mode - see class constants
     */
    public function __construct($provider, $returnToUrl, $mode)
    {
        switch($provider)
        {
            case self::PROVIDER_GOOGLE:
                $this->providerEndPoint = self::GOOGLE_PROVIDER_ENDPOINT;
                break;
        }
        
        $this->returnToUrl = $returnToUrl;
        $this->mode = $mode;
    }

    public function send()
    {
        $oidIdentifier = $this->providerEndPoint;

        // Starts session (needed for YADIS)
        session_start();

        // Create file storage area for OpenID data
        $store = new Auth_OpenID_FileStore(self::OID_STORE_DIRECTORY);

        // Create OpenID consumer
        $consumer = new Auth_OpenID_Consumer($store);

        // Create an authentication request to the OpenID provider
        $auth = $consumer->begin($oidIdentifier);

        $attribute = array();

        if ($this->mode == self::MODE_REGISTRATION)
        {
            // Create attribute request object
            // See http://code.google.com/apis/accounts/docs/OpenID.html#Parameters for parameters
            // Usage: make($type_uri, $count=1, $required=false, $alias=null)
            $attribute[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/email', 2, 1, 'email');
            $attribute[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/pref/language', 1, 1, 'language');
            //$attribute[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/country/home', 1, 1, 'country');
            //$attribute[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/first', 1, 1, 'firstname');
            //$attribute[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/last', 1, 1, 'lastname');
        }
        else
        {
            $attribute[] = Auth_OpenID_AX_AttrInfo::make('http://axschema.org/contact/email', 1, 1, 'email');
        }
        
        // Create AX fetch request
        $ax = new Auth_OpenID_AX_FetchRequest;

        // Add attributes to AX fetch request
        foreach($attribute as $attr){
                $ax->add($attr);
        }

        // Add AX fetch request to authentication request
        $auth->addExtension($ax);

        // Redirect to OpenID provider for authentication
        $url = $auth->redirectURL('http://' . sfConfig::get('app_site_url') . '/', $this->returnToUrl);
        header('Location: ' . $url);
    }

    /**
     * @param array - the user data to get
     * @return boolean - true if success, false otherwise
     */
    public function receive(&$data)
    {
        // Starts session (needed for YADIS)
        session_start();

        // Create file storage area for OpenID data
        $store = new Auth_OpenID_FileStore(self::OID_STORE_DIRECTORY);

        // Create OpenID consumer
        $consumer = new Auth_OpenID_Consumer($store);

        // Create an authentication request to the OpenID provider
        $response = $consumer->complete($this->returnToUrl);

        if ($response->status == Auth_OpenID_SUCCESS) {
                // Get registration informations
                $ax = new Auth_OpenID_AX_FetchResponse();
                $obj = $ax->fromSuccessResponse($response);

                // Print me raw
                $data = $obj->data;
                return true;
        } else {
            return false;
        }
    }
}
