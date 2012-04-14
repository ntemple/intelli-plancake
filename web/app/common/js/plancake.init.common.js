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

var PLANCAKE = PLANCAKE || {};

PLANCAKE.isMobile = null;
PLANCAKE.isOfflineEnabled = false;

PLANCAKE.repetitionOptions = null;
PLANCAKE.userSettings = null;
PLANCAKE.data = null;
PLANCAKE.config = null;

PLANCAKE.lists = null; // this is going to be deleted after use
PLANCAKE.tags = null; // this is going to be deleted after use

PLANCAKE.hideableHintsSetting = null; // this is going to be deleted after use

PLANCAKE.ignoreLocalStorage = false;

PLANCAKE.lang = {};

PLANCAKE.initPopulateStartupVariables = function (startupData) {
        PLANCAKE.lists = startupData['lists']['lists'];
        PLANCAKE.tags = startupData['tags']['tags'];
        PLANCAKE.repetitionOptions = startupData['repetitionOptions']['repetitions'];
        PLANCAKE.userSettings = startupData['userSettings'];
        PLANCAKE.data = startupData['data'];   
        PLANCAKE.config = startupData['config']; 
        PLANCAKE.lang = startupData['lang'];
        
        PLANCAKE.hideableHintsSetting = startupData['hideableHintsSetting'];
};

PLANCAKE.initPopulateLayout = function () {
    PLANCAKE.initLists(PLANCAKE.lists);
    PLANCAKE.initTags(PLANCAKE.tags);

    delete PLANCAKE.lists;
    delete PLANCAKE.tags;
}
