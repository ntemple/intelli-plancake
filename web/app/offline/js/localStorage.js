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

PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA = "startupData"; // N.B.: this string is hardcoded in /js/&offlin/offline/localDatastore.detection.js !!!
PLANCAKE.LOCAL_STORAGE_KEY_TASKS = "tasks"; // N.B.: this string is hardcoded in /js/&offlin/offline/localDatastore.detection.js !!!
PLANCAKE.LOCAL_STORAGE_KEY_LAST_SYNC_TIMESTAMP = "lastSyncTimestamp";

// Within the startupData object, these are the keys of the "sub-objects" that
// should be updated when a new released is available
// See /app/account/modules/main/actions/actions.class.php
PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_LANG = "lang";
PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_CONFIG = "config";
PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_DATA = "data";

/*
 * When there is a new release, we want to update that data in startupData
 * which is likely to have changes, such as 'lang' because the new release
 * can have new text or changed text.
 * So we want to overwrite these 3 keys for the startupData object:
 * _ PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_LANG
 * _ PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_CONFIG
 * _ PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_DATA
 * 
 * We don't want to do anything with the rest (lists, tasks, tags, ...): those
 * should be updated when the user explicitly press the sync button.
 *
 **/
PLANCAKE.deleteUpdatableStartupData  = function () {
    if (PLANCAKE.supportsHtml5Storage()) {
        var startupData = localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA);
        if (startupData) {
            startupData = JSON.parse(startupData);
            if (startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_LANG]) {
                delete startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_LANG];
            }
            if (startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_CONFIG]) {
                delete startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_CONFIG];
            }
            if (startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_DATA]) {
                delete startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_DATA];
            }
            localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA, JSON.stringify(startupData));
        }
    }    
};

/**
 * @return bool - true if startupData are present but updatable ones are not, false otherwise
 */
PLANCAKE.isUpdatableStartupDataMissing  = function () {
    var isMissing = false;
    if ( PLANCAKE.supportsHtml5Storage()) { 
      var startupData = localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA);
      
      // first of all, we check the startup data are stored locally
      if (startupData) { 
        var startupLangData = JSON.parse(startupData)[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_LANG];
        
        if (!startupLangData) {
            isMissing = true;
        }
      }
    }  
    
    return isMissing;
};

PLANCAKE.resetData = function () {
    if ( PLANCAKE.supportsHtml5Storage()) { 
        if (localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA)) {
            localStorage.removeItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA);
        }
        if (localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS)) {
            localStorage.removeItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS);
        }
        if (localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_LAST_SYNC_TIMESTAMP)) {
            localStorage.removeItem(PLANCAKE.LOCAL_STORAGE_KEY_LAST_SYNC_TIMESTAMP);
        }        
    }    
};  
