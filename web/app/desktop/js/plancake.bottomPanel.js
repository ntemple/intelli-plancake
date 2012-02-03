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

    $('#bottomFilters').buttonset();
    $('#filterToday').click(function () {
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_TODAY      
        })
    });
    $('#filterCalendar').click(function () {
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_CALENDAR,
            extraParam: date('Y-m-d', strtotime("today"))
        })
    });
    $('#filterStarred').click(function () {
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_STARRED      
        })
    });
    $('#filterCompleted').click(function () {
        var contentConfig = PLANCAKE.getActivePanelContentConfig();
        contentConfig.done = true;
        PLANCAKE.loadContent(contentConfig);
    });
    
    $('#accountButton')
    .button({
            icons: {
                secondary: "ui-icon-triangle-1-n"
            }
    })
    .click(function () {
        $('#secondaryNav').toggle();
    })
    .attr('title', PLANCAKE.lang.ACCOUNT_MISC_CLICK_TO_DO_MORE);
    
    $('#blogLink').button({
            icons: {
                primary: ""
            }
    });

    $('#settingsButton').button();
    
    $('#upgradeButton').button();
    
    $('#helpButton').button({
            icons: {
                primary: "helpButtonIcon"
            },
            text: false
    })
    .click(function() {
        var cookiesContent = $.cookie(PLANCAKE.COOKIE_NAME_FOR_FEEDBACK_BOX);
        
        if (cookiesContent && (cookiesContent === '1')) {
            $.cookie(PLANCAKE.COOKIE_NAME_FOR_FEEDBACK_BOX, '0', {expires: 70});
        } else {
            $.cookie(PLANCAKE.COOKIE_NAME_FOR_FEEDBACK_BOX, '1', {expires: 70});            
        }
        
        $('#feedbackBox').toggle();
    });
    
    $('#videoTutorialButton').button({
            icons: {
                primary: "videoIcon"
            },
            text: false
    })
    .click(function() {
        PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_videoTutorial(), function() {
            $('#tutorialVideo').remove();
        });
    });    
    
    $('#teamBanner').css('opacity',0.4)
    .hover(
        function(){
            $(this).stop().animate({opacity: 1}, 200);
        },
        function(){
            $(this).stop().animate({opacity: 0.4}, 200);
    });
    
    $('#helpButton').attr('title', PLANCAKE.lang.ACCOUNT_MISC_HELP_LINK);
    $('#teamBanner').attr('title', PLANCAKE.lang.ACCOUNT_MISC_PLANCAKE_TEAM_AD);
    
    $('ul#secondaryNav li').not('.secondaryNavDivider').hover(function () {
        $(this).toggleClass('secondaryNavHighlight');
    });
});