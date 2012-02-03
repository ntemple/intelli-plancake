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

/**
 * @param array lists  array of PLANCAKE.list
 */
PLANCAKE.initLists = function(lists) {
    var i = 0;
    var listsCounter = lists.length;
    var list;

    for (i; i<listsCounter; i++) {
        list = lists[i];
        /// list
        PLANCAKE.addList(list);   
    }
    
    var firstList = $('ul#lists li').first();
    
    firstList.addClass('systemList')
             .addClass('inbox')
             .next().addClass('systemList').addClass('todo');
    
    if (! PLANCAKE.isMobile) {
        firstList.prepend('<div class="counter inboxCounter"></div>');
    } else {
        firstList.prepend('<span class="ui-li-count inboxCounter"></span>');        
    }
    
    if (!PLANCAKE.userSettings.isPremium) {
        if (PLANCAKE.lists.length > PLANCAKE.config.maxListsForFreeAccount) {
            $('ul#lists li:gt(' + (parseInt(PLANCAKE.config.maxListsForFreeAccount)-1) + ')').block({
                message: '',
                applyPlatformOpacityRules: false
            })
            .addClass('exceedingAllowance');
            $('#maxListsAllowanceAlert').html(sprintf(PLANCAKE.lang.ACCOUNT_ERROR_MAX_LISTS_FOR_FREE_ACCOUNTS, 
                PLANCAKE.config.maxListsForFreeAccount, PLANCAKE.BASE_URL + '/upgrade')).show();
        }
    }
    
    if (PLANCAKE.isMobile) { // without this, the styling of the lists screen on reloading would be broken
        $('#lists-screen').page();
        $('ul#lists').listview();    
        $('ul#lists').listview('refresh');
    }
}

/**
 * @param PLANCAKE.List list
 */
PLANCAKE.getHtmlListObj = function(list) {
    var htmlForList = $("<li id='list_" + list.id + "'>" +
                    '<span class="name">' + PLANCAKE.encodeEntities(list.name) + '</span>' +
                    "</li>");
                
    if (! PLANCAKE.isMobile) {
        htmlForList.prepend('<a href="#" class="editList listAction">' + PLANCAKE.lang.ACCOUNT_MISC_EDIT + '</a>' +
                            '<a href="#" class="addBelowList listAction">' + PLANCAKE.lang.ACCOUNT_MISC_ADD_BELOW + '</a>');
    } else {
        if (! list.isHeader) {
            htmlForList.find('span.name').wrap('<a href="#tasks-screen?type=list&id=' + list.id + '" />');
        }
    }

    if (list.isHeader) {
        htmlForList.addClass('header');
    }
    
    return htmlForList;    
}

/**
 * @param PLANCAKE.List list
 * @param int aboveListId
 * @param bool highlight (=false)
 */
PLANCAKE.addList = function (list, aboveListId, highlight) {
    if ( (highlight === null) || (highlight === undefined) ) {
        highlight = false;
    } 
    
    /**
     * @param PLANCAKE.List list
     */
    function addListToLayout(list) {
        var htmlForList =  PLANCAKE.getHtmlListObj(list);

        if ((aboveListId === null) || (aboveListId === undefined)) {
            $("ul#lists").append(htmlForList);
            if (highlight) {
                $('form#hackToScrollToBottomList input').focus();
                PLANCAKE.flashBackground(htmlForList);
            }
        } else {
            $().plancake().getList(aboveListId).after(htmlForList);        
        }        
    }
    
    
    if (list.id) {
        addListToLayout(list);    
    } else {
        var ajaxParams = 'op=add&listId=0&listTitle=' + 
            PLANCAKE.prepareForAjaxTransmission(list.name) + 
            '&isHeader=' + (+list.isHeader);
        if ((aboveListId !== null) && (aboveListId !== undefined)) {
            ajaxParams += '&beforeListId=' + aboveListId;  
        }

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_MANAGE_LISTS, 
                                 ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_LIST_ADDED, function(listFromServer) {
            addListToLayout(listFromServer);
        });
    }
}