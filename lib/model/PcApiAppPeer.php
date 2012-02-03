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

class PcApiAppPeer extends BasePcApiAppPeer
{
    /**
     * Retrieves the personal key for a user
     *
     * @param int $userId 
     * @return PcApiApp
     */
    public static function retrieveByUserId($userId)
    {
        $c = new Criteria();
        $c->add(self::USER_ID, $userId);
        return self::doSelectOne($c);
    }

    /**
     * Retrieves the personal key for a user
     *
     * @param string $apiKey
     * @return PcApiApp
     */
    public static function retrieveByApiKey($apiKey)
    {
        $c = new Criteria();
        $c->add(self::API_KEY, $apiKey);
        return self::doSelectOne($c);
    }

    /**
     *
     * @param int $userId
     * @param string $description (='') - the description of the use
     * @return boolean - false is the user has got a personal api key already, true otherwise
     */
    public static function createPersonalApiApp($userId, $description = '')
    {
        $alreadyExisting = is_object(self::retrieveByUserId($userId));

        if ($alreadyExisting)
        {
            return false;
        }

        $apiKey = '';
        $safetyCounter = 0; // to avoid infinite loop under any circumstances
        do
        {
            $apiKey = PcUtils::generate40CharacterRandomHash();
            $c = new Criteria();
            $c->add(PcApiAppPeer::API_KEY, $apiKey);
            $alreadyExisting = PcApiAppPeer::doSelectOne($c);
            $safetyCounter++;
            if ($safetyCounter == 100)
            {
                throw new Exception("Detected possible infinite loop while creating API key");
            }
        } while(is_object($alreadyExisting));

        $personalApiApp = new PcApiApp();
        $personalApiApp->setUserId($userId)
                       ->setName('personal')
                       ->setApiKey($apiKey)
                       ->setApiSecret(PcUtils::generateRandomString(16))
                       ->setIsLimited(true)
                       ->setDescription($description)
                       ->save();

        $apiKeyStats = new PcApiAppStats();
        $apiKeyStats->setApiAppId($personalApiApp->getId())
                    ->setToday(date('Y-m-d'))
                    ->setLastHour(date('H'))
                    ->save();

        $userKey = PcUserKeyPeer::retrieveByPK($userId);
        
        if (!is_object($userKey))
        {
            $userKey = new PcUserKey();
            $userKey->setUserId($userId)
                    ->setKey(PcUtils::generate32CharacterRandomHash())
                    ->save();
        }
        
        return true;
    }

}
