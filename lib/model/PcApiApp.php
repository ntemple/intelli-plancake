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

class PcApiApp extends BasePcApiApp
{
    /**
     *
     * @var PcApiAppStats 
     */
    private static $stats = null;

    /**
     * Alias for getIsLimited
     * 
     * @return bool 
     */
    public function isLimited()
    {
        return $this->getIsLimited();
    }

    /**
     * @return PcApiAppStats
     */
    public function getStats()
    {
        $stats = self::$stats;

        if ($stats === null)
        {
            self::$stats = PcApiAppStatsPeer::retrieveByApiAppId($this->getId());
        }

        return self::$stats;
    }

    /**
     * @return bool
     */
    public function hasReachedLimits()
    {
        if (! $this->isLimited())
        {
            return false;
        }

        $this->adjustValues();

        $stats = $this->getStats();

        $maxRequestsPerHour = sfConfig::get('app_api_maxRequestsPerHour');
        $maxDownloadBandwidthKbytePerHour = sfConfig::get('app_api_maxDownloadBandwidthPerHour') * 1024;

        if ( ($stats->getNumberOfRequestsLastHour() > $maxRequestsPerHour) ||
             ($stats->getBandwidthLastHour() > $maxDownloadBandwidthKbytePerHour) )
        {
            return true;
        }

        return false;
    }

    /**
     * @param int $responseSizeBytes
     * @return void
     */
    public function recordStats($responseSizeBytes)
    {
        $this->adjustValues();

        $stats = $this->getStats();

        $stats->setNumberOfRequestsToday($stats->getNumberOfRequestsToday()+1)
              ->setNumberOfRequestsLastHour($stats->getNumberOfRequestsLastHour()+1)
              ->setNumberOfRequests($stats->getNumberOfRequests()+1)
              ->setBandwidthToday($stats->getBandwidthToday()+$responseSizeBytes)
              ->setBandwidthLastHour($stats->getBandwidthLastHour()+$responseSizeBytes)
              ->setBandwidth($stats->getBandwidth()+$responseSizeBytes)
              ->save();
    }

    /**
     * Adjusts values if a new day/hour has started
     *
     * @return void
     */
    private function adjustValues()
    {
        $todayString = date('Y-m-d');
        $lastHourString = date('H');

        $stats = $this->getStats();

        if ($stats->getToday() != $todayString)
        {
            $stats->setToday($todayString)
                  ->setNumberOfRequestsToday(0)
                  ->setBandwidthToday(0);
        }

        if ($stats->getLastHour() != $lastHourString)
        {
            $stats->setLastHour($lastHourString)
                  ->setNumberOfRequestsLastHour(0)
                  ->setBandwidthLastHour(0);
        }

        $stats->save();
    }
}
