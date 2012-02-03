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

// this is the APi client for the 0.9.8.1 server version
require_once(dirname(__FILE__). '/sphinxapi.php');

/**
 * Description of Search
 *
 * @author dan
 */
class Searcher {

    /**
     *
     * @param string $query
     * @return array of integers - taskIds
     */
    public static function searchTasks($query)
    {
        $fieldWeights = array('description' => 10, 'note' => 6);
        $indexName = 'plancake_tasks';

        $client = new SphinxClient();
        // $client->SetServer (sfConfig::get('app_sphinx_host'), sfConfig::get('app_sphinx_port'));
        $client->SetFilter("author_id", array(PcUserPeer::getLoggedInUser()->getId()) );
        $client->SetConnectTimeout (1);
        $client->SetMatchMode (SPH_MATCH_ANY);
        $client->SetSortMode(SPH_SORT_RELEVANCE);
        $client->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
        $client->SetArrayResult(true);
        $client->SetFieldWeights($fieldWeights);
        $client->setLimits(0, 100);
        
        $results = $client->query($client->EscapeString($query), $indexName);
        
        if ($results === false) {
            $error = "Sphinx Error - " . $client->GetLastError();
            sfErrorNotifier::alert($error);
        }
        
        $ids = array();
        if (isset($results['matches']) && count($results['matches']) ) {
            foreach($results['matches'] as $match)
            {
                $ids[] = $match['id'];
            }
        }
        
        return PcTaskPeer::retrieveByPKs($ids);        
    }
    
}

?>
