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

PLANCAKE.isMobile = true;
PLANCAKE.isOfflineEnabled = true;

PLANCAKE.BASE_URL = /https?:\/\/*\/[^#]*\.php/i.exec(document.URL)[0]; // i.e.: http://www.plancake.com/account.php
PLANCAKE.BASE_URL_MOBILE = /([^#]*\.php\/mobile)/i.exec(document.URL)[1]; // i.e.: http://www.plancake.com/account.php/mobile

PLANCAKE.FIRST_LOGIN_COOKIE_NAME = "firstLogin";

PLANCAKE.numberOfDaysOnCalendar = 2;

$.holdReady(true);

PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_INIT_DATA, 
                         '', '', function (startupData) {
    PLANCAKE.initPopulateStartupVariables(startupData);
    if (PLANCAKE.isOfflineEnabled || PLANCAKE.supportsHtml5Storage()) {
      var localStartupData = localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA);
      if (! localStartupData) { // startupData can't be found locally, thus we create them
        localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA, JSON.stringify(startupData));          
      } else {
        // startupData already exist locally, thus we want just to refresh the upgradable objects
        // - see localStorage.js file
        localStartupData = JSON.parse(localStartupData); // changed to JSON representation
        localStartupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_LANG] = 
                startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_LANG];
        localStartupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_CONFIG] = 
                startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_CONFIG];
        localStartupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_DATA] = 
                startupData[PLANCAKE.LOCAL_STORAGE_KEY_UPDATABLE_STARTUP_DATA_DATA];
        localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA, JSON.stringify(localStartupData));
      }
    }    
    $.holdReady(false);
});

$(document).ready(function () {
    PLANCAKE.initPopulateLayout();

    /// {{{ START: overlay on startup
    if ($.cookie(PLANCAKE.FIRST_LOGIN_COOKIE_NAME) == null) {
        PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_info());
        $.cookie(PLANCAKE.FIRST_LOGIN_COOKIE_NAME, '1',  { expires: 356 });  // expires in 1 year
    } else {      
        if (PLANCAKE.data.showExpiringSubscriptionAlert) {
            PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_expiringMembership());
        }

        if (PLANCAKE.data.isSubscriptionExpired) {       
            PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_expiredMembership());
        }
    }
    /// }}} END: overlay on startup           
    
    // removing some strings from the calendar controls to suit the narrow space
    $('span.lang_ACCOUNT_MAIN_CONTENT_CAL_PREV_MONTH').hide();
    $('span.lang_ACCOUNT_MAIN_CONTENT_CAL_PREV_7_DAYS').hide();
    $('span.lang_ACCOUNT_MAIN_CONTENT_CAL_NEXT_MONTH').hide();
    $('span.lang_ACCOUNT_MAIN_CONTENT_CAL_NEXT_7_DAYS').hide();
});

//reset type=date inputs to text
$( document ).bind( "mobileinit", function(){
        $.mobile.page.prototype.options.degradeInputs.date = true;
});