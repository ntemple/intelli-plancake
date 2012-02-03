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

class homepageComponents extends sfComponents
{
/*
  public function executeFreshness(sfWebRequest $request)
  {
    $latestDevelopmentActivity = PcActivities::getLatestDevelopmentActivity();
    $latestCommunityActivities = PcActivities::getLatestCommunityActivities(1);

    $this->latestDevelopmentTimeExpression =
            PcUtils::getHumanFriendlyTimeElapsedFromNow($latestDevelopmentActivity['created_at']);
    $this->latestCommunityTimeExpression =
            PcUtils::getHumanFriendlyTimeElapsedFromNow(strtotime($latestCommunityActivities[0]['created_at']));

    $type = '';
    
    switch($latestCommunityActivities[0]['type'])
    {
        case PcActivities::USER_REGISTRATION:
            $type = 'new user';
            break;
        case PcActivities::NEW_LIST:
            $type = 'new list';
            break;
        case PcActivities::NEW_TASK:
            $type = 'new task';
            break;
        case PcActivities::TASK_DONE:
            $type = 'task done';
            break;
        case PcActivities::FORUM_POST:
            $type = 'new post';
            break;
    }
    $this->latestCommunityType = $type;
  }
*/
}
