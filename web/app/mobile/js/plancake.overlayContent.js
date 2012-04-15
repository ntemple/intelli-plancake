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

$(document).ready(function() {
    $('#simpleDialogClose').live("tap", function() {
        var callbackOnClosing;
        $('a#dummyLinkForSimpleDialog').simpledialog('close');
        
        if ( (PLANCAKE.closeOverlayCallback !== null) && (PLANCAKE.closeOverlayCallback !== undefined) ) {
            callbackOnClosing = PLANCAKE.closeOverlayCallback;
            PLANCAKE.closeOverlayCallback = null;
            callbackOnClosing();
        }
    });
});

PLANCAKE.getOverlayContent_expiredMembership = function() {
        return '<div class="subscriptionAlert">' + 
                    PLANCAKE.lang.ACCOUNT_SUBSCRIPTION_EXPIRED +
                    '<a class="extendSubscription" href="/account.php/upgrade">' + PLANCAKE.lang.ACCOUNT_SUBSCRIPTION_EXTEND_IT_BUTTON + '</a>' +
                    '&nbsp;<br />&nbsp;<br />&nbsp;<br />' + 
               '</div>';
}

PLANCAKE.getOverlayContent_expiringMembership = function() {
        return '<div class="subscriptionAlert">' + 
                    PLANCAKE.lang.ACCOUNT_SUBSCRIPTION_ABOUT_TO_EXPIRE +
                    '<a class="extendSubscription" href="/account.php/upgrade">' + PLANCAKE.lang.ACCOUNT_SUBSCRIPTION_EXTEND_IT_BUTTON + '</a>' +
                    '&nbsp;<br />&nbsp;<br />&nbsp;<br />' + 
               '</div>';
}

PLANCAKE.getOverlayContent_info = function() {
        return PLANCAKE.lang.ACCOUNT_MOBILE_APP_HELP_CONTENT + '<br />' +
               sprintf(PLANCAKE.lang.ACCOUNT_MOBILE_APP_HELP_CONTACT, PLANCAKE.config.supportEmailAddress, PLANCAKE.config.supportEmailAddress);
}

PLANCAKE.getOverlayContent_syncSuccess = function () {
    return PLANCAKE.lang.ACCOUNT_MOBILE_APP_SYNC_OK;
}