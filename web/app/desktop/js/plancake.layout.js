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

PLANCAKE.COOKIE_NAME_FOR_PANELS_WIDTH_RATIO = 'plancakePanelsWidthRatio';
PLANCAKE.COOKIE_NAME_FOR_PANEL1_CONTENT_CONFIG = 'plancakePanel1ContentConfig';
PLANCAKE.COOKIE_NAME_FOR_PANEL2_CONTENT_CONFIG = 'plancakePanel2ContentConfig';

PLANCAKE.activePanel = null; // JQuery object

$(document).ready(function () {    
    
    $("#panelSeparator").mouseover(function () {
       $(this).addClass('hover'); 
    });
    
    PLANCAKE.resizePanels();
       
    $('.panel').click(function () {
        PLANCAKE.setActivePanel($(this));
    });
    
    $('h1').click(function() {
        window.location.href = window.location.href.split('#')[0];
    });
    
    $(document).pngFix();
    
    var panel2CookiesContent = $.cookie(PLANCAKE.COOKIE_NAME_FOR_PANEL2_VISIBLE);
    if (panel2CookiesContent && (panel2CookiesContent === '1')) {
        // nothing to do
    } else {
        PLANCAKE.hidePanel2(); 
    }    
    
    $('.reloadContentPanel').click(function() {
        var panel = $(this).parents('.panel');
        PLANCAKE.loadContent(PLANCAKE.getActivePanelContentConfig(panel), panel, false);
    })
    .attr('title', PLANCAKE.lang.ACCOUNT_HINT_RELOAD_BTN);
    
    $('.hidePanel2').click(function (e) {
        PLANCAKE.hidePanel2();
        e.stopPropagation();
    })
    .attr('title', PLANCAKE.lang.ACCOUNT_HINT_COLLAPSE_PANEL2_BTN);

    $('#panelSeparator').click(function(e) {
        PLANCAKE.hidePanel2();
        e.stopPropagation();        
    });
    
    $('.showPanel2').click(function () {
        PLANCAKE.showPanel2();
    })
    .attr('title', PLANCAKE.lang.ACCOUNT_HINT_EXPAND_PANEL2_BTN);
    
    $('#breakingNewsClose').click(function () {
        $('#breakingNews').slideUp('medium');
        
        var ajaxParams = "newsId=" + $('#breakingNewsId').text();

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_HIDE_BREAKING_NEWS, 
                                 ajaxParams, '', function() {                     
        });
        
        return false;
    });   

    $('.hideableHintClose').click(function () {
        var hideableHint = $(this).parents('.hideableHint');
        var hideableHintClass = hideableHint.attr('class');        
        var hintIdRegEx = /([^_]*)_hideableHint/;
        
        hideableHint.slideUp('slow', function() {
            $(this).remove();
        });
        
        var ajaxParams = "hintId=" + (hideableHintClass.match(hintIdRegEx)[1]); // i.e.: todo

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_HIDE_HINT, 
                                 ajaxParams, '', function() {                     
        });

        return false;
    });    
    
    $('.extendSubscription').button();
    
/*    
    if ($('#breakingNews').is(':visible')) {
        $('#breakingNews').pulse({
            opacity: [0.25, 1],
            backgroundColor: ['#fff', '#fef7ff']
        }, 1000, 5, 'linear', function(){
            // alert("I'm done pulsing!");    
        });
    }
*/
    
    $('.editPanel').click(function () {
        var panelConfig = PLANCAKE.getActivePanelContentConfig($(this).parents('.panel'));
        
        if (panelConfig.type === PLANCAKE.CONTENT_TYPE_LIST) {
            PLANCAKE.openListDialog(PLANCAKE.EDIT_LISTS_MODE_EDIT, $('#list_' + panelConfig.extraParam));
        } else if (panelConfig.type === PLANCAKE.CONTENT_TYPE_TAG) {
            PLANCAKE.openTagDialog(PLANCAKE.EDIT_TAGS_MODE_EDIT, $('#tag_' + panelConfig.extraParam));            
        }
    })
    .attr('title', PLANCAKE.lang.ACCOUNT_HINT_EDIT_LIST_BTN);
});



PLANCAKE.removeContentSelection = function () {
    $('ul#lists li').removeClass('selected');
    $('ul#tags li').removeClass('selected'); 
    $('#bottomFilters label').removeClass('ui-state-active');
}

/**
 * @param Object contentConfig, it has got these keys:
 * _ boolean done - whether to display the tasks that has been done
 * _ string type - the type of content - see PLANCAKE.CONTENT_TYPE_* constants
 * _ int extraParam - i.e. listId or tagId
 */
PLANCAKE.setContentSelection = function (contentConfig) {
    
    PLANCAKE.removeContentSelection();
    if (contentConfig.done) {
        $('#filterCompleted').next().addClass('ui-state-active');    
    }
    
    var listId = 0;
    var tagId = 0;
    var list = null;
    var tag = null;    
    
    switch(contentConfig.type) {
        case PLANCAKE.CONTENT_TYPE_LIST:
            listId = contentConfig.extraParam;
            list = $().plancake().getList(listId);            
            list.addClass('selected');
            break;
        case PLANCAKE.CONTENT_TYPE_TAG:
            tagId = contentConfig.extraParam;
            tag = $().plancake().getTag(tagId);            
            tag.addClass('selected');           
            break;
        case PLANCAKE.CONTENT_TYPE_TODAY:
            $('#filterToday').next().addClass('ui-state-active');
            break;
        case PLANCAKE.CONTENT_TYPE_CALENDAR:
            $('#filterCalendar').next().addClass('ui-state-active');            
            break;
        case PLANCAKE.CONTENT_TYPE_STARRED:
            $('#filterStarred').next().addClass('ui-state-active');            
            break;
    }    
}

/**
 * @param JQuery panel
 */
PLANCAKE.setActivePanel = function (panel) {
    var contentConfig;
    
    var panel2 = $('#panel2');
    
    $('#panel1').removeClass('activePanel');
    panel2.removeClass('activePanel');
    
    if (panel2.is(":visible")) { // if just one panel is visible we don't need to highlight it
        panel.addClass('activePanel');
    }
    
    PLANCAKE.activePanel = panel;
    if (contentConfig = PLANCAKE.getActivePanelContentConfig()) {
        PLANCAKE.setContentSelection(contentConfig);
    }
    
    document.title = 'Plancake - ' + panel.find('h3').text();

    $('#secondaryNav').hide();
}

/**
 * @param bool hidePanel2 (=false)
 */
PLANCAKE.resizePanels = function (hidePanel2) {
    
    if ( (hidePanel2 === null) || (hidePanel2 === undefined) ) {
        hidePanel2 = false;
    }

    var panelAdditionalOffset = 55;
    
    // rather than hardcoding 200, we were using
    // $('#sidebar').css('width').replace('px', '')
    // but that was generating some problems in IE, because during the initial
    // loading the sidebar was wider for a split second!
    var panelsWidth = $(window).width() - 200 - panelAdditionalOffset;

    if (!hidePanel2) {
        $('.panel').css('width', panelsWidth/2 + 'px');
    } else {
        var panel2Width = 180;
        $('#panel2').css('width', panel2Width + 'px');
        $('#panel1').css('width', (panelsWidth - panel2Width) + 'px');        
    }

    $('#panelSeparator').addClass('#panelSeparator .active');  
}

PLANCAKE.hidePanel2 = function () {
    $('#panel2').hide();
    $('.hidePanel2').hide();    
    $('.showPanel2').show();
    PLANCAKE.resizePanels(true);
    $('#panelSeparator').hide();
    PLANCAKE.setActivePanel($('#panel1'));
    $.cookie(PLANCAKE.COOKIE_NAME_FOR_PANEL2_VISIBLE, '0', {expires: 70});
    
    $('#panel1 .taskScheduleDetails').addClass('extraPaddingForTaskScheduleDetails');
    
    $('#panel1').addClass('panel1Alone');
}

PLANCAKE.showPanel2 = function () {
    $('#panel2').show();
    $('.hidePanel2').show();     
    $('.showPanel2').hide();
    PLANCAKE.resizePanels();
    $('#panelSeparator').show();
    $.cookie(PLANCAKE.COOKIE_NAME_FOR_PANEL2_VISIBLE, '1', {expires: 70});
    
    $('#panel1 .taskScheduleDetails').removeClass('extraPaddingForTaskScheduleDetails'); 
    
    $('#panel1').removeClass('panel1Alone');  
    
    // show hint
    if (!$.cookie(PLANCAKE.COOKIE_NAME_SPLIT_VIEW_HINT_SHOWN)) {
        $.cookie(PLANCAKE.COOKIE_NAME_SPLIT_VIEW_HINT_SHOWN, '1', {expires: 700});
        jAlert(PLANCAKE.lang.ACCOUNT_HINT_SPLIT_VIEW_HINT);
    }
}
