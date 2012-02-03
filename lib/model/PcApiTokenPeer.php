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

class PcApiTokenPeer extends BasePcApiTokenPeer
{
    /**
     * N.B.: if the user passed as input is a supporter, the method prefix '1'
     * to the token, making it 41-character long, rather than 40
     *
     * @param PcApiApp $apiApp
     * @param int $userId
     * @return string
     */
    public static function createToken(PcApiApp $apiApp, $userId)
    {
        $apiAppId = $apiApp->getId();

        // if there is already a token entry for the application and the user, we delete it
        $c = new Criteria();
        $c->add(PcApiTokenPeer::API_APP_ID, $apiAppId);
        $c->add(PcApiTokenPeer::USER_ID, $userId);
        PcApiTokenPeer::doDelete($c);

        $apiTokenEntry = new PcApiToken();

        $tokenPrefix = PcUserPeer::retrieveByPK($userId)->isSupporter() ? '1' : '';

        // we want to be extra-sure the token is unique
        $token = '';
        $safetyCounter = 0; // to avoid infinite loop under any circumstances
        do
        {
            $token = $tokenPrefix . PcUtils::generate40CharacterRandomHash();
            $c = new Criteria();
            $c->add(PcApiTokenPeer::TOKEN, $token);
            $alreadyExisting = PcApiTokenPeer::doSelectOne($c);
            $safetyCounter++;
            if ($safetyCounter == 100)
            {
                throw new Exception("Detected possible infinite loop while creating API token");
            }
        } while(is_object($alreadyExisting));

        $apiTokenEntry->setToken($token)
                      ->setApiAppId($apiAppId)
                      ->setUserId($userId)
                      ->setExpiryTimestamp( time() + (sfConfig::get('app_api_tokenValidity')*3600) )
                      ->save();

        return $token;
    }
}
