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

PLANCAKE.activePanel = $('#panel1'); // for compatibility with the desktop app

$(document).ready(function() {
    
    $('.homeButton').attr("href", PLANCAKE.BASE_URL_MOBILE);
    
    $('#calendarJumpDate').css('placeholder', PLANCAKE.lang.GENERAL_MISC_SET_DATE);

    // I use unbind to make sure the event is not triggered twice
    $('a.syncButton').unbind('tap').bind('tap', function (event) {
        if (!PLANCAKE.isFiringMultipleTimes($(this), event)) {
            PLANCAKE.sync();    
        }
    });

    // I use unbind to make sure the event is not triggered twice
    $('a.helpButton').unbind('tap').bind('tap', function (event) {
        if (!PLANCAKE.isFiringMultipleTimes($(this), event)) {
            PLANCAKE.showToastNotice(PLANCAKE.getOverlayContent_info());    
        }        
    });    

    $('a.helpButton .ui-btn-text').text(PLANCAKE.lang['ACCOUNT_MOBILE_APP_HELP_BUTTON']);
    $('a#homepageListsLink .ui-btn-text').text(PLANCAKE.lang['ACCOUNT_LISTS_HEADER']);
    $('a#homepageTagsLink .ui-btn-text').text(PLANCAKE.lang['ACCOUNT_TAGS_FILTER_HEADER']);    
    $('a#homepageStarredLink .ui-btn-text').text(PLANCAKE.lang['ACCOUNT_LISTS_STARRED']);
    $('a#homepageCalendarLink .ui-btn-text').text(PLANCAKE.lang['ACCOUNT_LISTS_ALL_SCHEDULED']);
    $('a#homepageTodayLink .ui-btn-text').text(PLANCAKE.lang['ACCOUNT_LISTS_OVERDUE_DUE_TODAY']);    

    // I use unbind to make sure the event is not triggered twice
    $('h1').unbind('tap').bind('tap', function() {
        // $.mobile.changePage($('#homepage'), {dataUrl: '#'});  this line didn't work as it should have
        // window.location.href = PLANCAKE.BASE_URL_MOBILE;
    });
    
    $('div#settingsActions a').bind("tap taphold", function(e) {
        var buttonId = $(this).attr('id');
        
        switch (buttonId) {
            case 'resetDataAction':
                if (confirm(PLANCAKE.lang['ACCOUNT_MISC_CONFIRM_MSG'])) {
                    PLANCAKE.resetData(); 
                    window.location.href = PLANCAKE.BASE_URL_MOBILE;
                }
                break;
            case 'logoutAction':
                if (confirm(PLANCAKE.lang['ACCOUNT_MISC_CONFIRM_MSG'])) {
                    PLANCAKE.resetData(); 
                    window.location.href = 'http://www.plancake.com/logout';
                }
                break;
            case 'goBackSettingsAction':
                break;
        }
    });

    $('.settingsButton').unbind('tap').bind('tap', function(e){
        $.mobile.changePage($('#settings-menu-screen'), {transition: "pop", role: "dialog", reverse: false});
        e.preventDefault();
    });
    
    $('.addTaskButton').unbind('tap taphold').bind('tap taphold', function(e){
        var activeListId = 0;
        if ($('.ui-page-active').data('url') == "tasks-screen") {
            activeListId = window.location.href.match(/&id=([0-9]+)/i)[1];
        }
        PLANCAKE.activeListId = activeListId;
        $.mobile.changePage($('#add-task-screen'), {transition: "pop", role: "dialog", reverse: false});
        e.preventDefault();
    });
    
    if (PLANCAKE.ignoreLocalStorage) {
        $('a.syncButton').hide();
    }
});

/**
 * This is just for compatibility with the desktop app - we have just one panel in the mobile app
 */
PLANCAKE.setActivePanel = function (panel) {
    PLANCAKE.activePanel = $('#panel1');
}