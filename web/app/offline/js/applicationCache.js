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

// Convenience array of status values
PLANCAKE.cacheStatusValues = [];
PLANCAKE.cacheStatusValues[0] = 'uncached';
PLANCAKE.cacheStatusValues[1] = 'idle';
PLANCAKE.cacheStatusValues[2] = 'checking';
PLANCAKE.cacheStatusValues[3] = 'downloading';
PLANCAKE.cacheStatusValues[4] = 'updateready';
PLANCAKE.cacheStatusValues[5] = 'obsolete';


PLANCAKE.cache = window.applicationCache;

if (PLANCAKE.cache) {
    PLANCAKE.cache.addEventListener("updateready", function () {
         // Don't perform "swap" if this is the first cache
         if (PLANCAKE.cacheStatusValues[PLANCAKE.cache.status] != 'idle') {
            PLANCAKE.cache.swapCache();
            // The updateready trigger tells us an Internet connection is available and
            // and a new version of Plancake has been released - thus we delete the updatable
            // startup data (lang, config, ...) so that they can be updated later on in the startup
            // process (see plancake.init.js file)
            PLANCAKE.deleteUpdatableStartupData();
            
            // console.log("Updated cache is ready");
            // Even after swapping the cache the currently loaded page won't use it
            // until it is reloaded, so force a reload so it is current.
            window.location.reload(true);           
         }
     }, false);
};