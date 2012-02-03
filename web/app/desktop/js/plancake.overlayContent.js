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

$(document).ready(function () {
    $('#hideQuote input').live('click', function () {
        var ajaxParams = "hintId=quote";

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_HIDE_HINT, 
                                 ajaxParams, '', function() {
                                     PLANCAKE.hideOverlay();
        }); 
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

PLANCAKE.getOverlayContent_quoteOfTheDay = function() {   
        return '<div class="quoteOfTheDay">' + 
                    '<span id="quoteContent">' + PLANCAKE.data['quoteContent'] + '</span>' +
                    '<span id="quoteAuthor">' + PLANCAKE.data['quoteAuthor'] + '</span>' +
                    '<div id="hideQuote"><input type="checkbox">' + PLANCAKE.lang.ACCOUNT_MISC_HIDE_QUOTE + '</input></div>' + 
               '</div>';
}

PLANCAKE.getOverlayContent_videoTutorial = function() {   
        return '<h3>' + PLANCAKE.lang.ACCOUNT_TUTORIAL_HEADER + '</h3>' + 
               '<div id="tutorialVideo" style="width: 700px; height: 370px; padding: 10px; margin: auto">' + 
                    '<iframe width="640" height="360" src="http://www.youtube.com/embed/7gzpcWP6bYk?rel=0&autoplay=1&cc_load_policy=1&modestbranding=1&hd=1&theme=light&enablejsapi=1" frameborder="0" allowfullscreen></iframe>' +
               '</div>';
}