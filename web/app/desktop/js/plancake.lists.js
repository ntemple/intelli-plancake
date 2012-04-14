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

PLANCAKE.EDIT_LISTS_MODE_NEW = "new";
PLANCAKE.EDIT_LISTS_MODE_EDIT = "edit";
PLANCAKE.EDIT_LISTS_MODE_ADDBELOW = "addBelow";

$(document).ready(function () {

    $("ul#lists li:not('.exceedingAllowance')").live('mouseover', function() {
        $(this).addClass('hover');
        if (!$(this).is(':first-child')) { // the first element is the Inbox
            $(this).find('.listAction').show();
        }
    })
    .live('mouseout', function() {
        $(this).removeClass('hover');
        $(this).find('.listAction').hide();        
    })
    .live('click', function() {
        if (! $(this).plancake().isHeader()) {
            PLANCAKE.loadContent({
                done: false, 
                type: PLANCAKE.CONTENT_TYPE_LIST, 
                extraParam: $(this).plancake().getId()       
            });
        }
    });    

    // the following sortable is just to let users know they can't reorder
    // Inbox and Todo lists.
    $("ul#lists li.systemList").sortable({
        helper: function(e, element)
                    {return $("<div />")},        
        beforeStop: function(event, ui) {
            alert(PLANCAKE.lang.ACCOUNT_ERROR_INBOX_TODO_NO_REORDER);
            $(this).sortable('cancel');
        },
        distance: 10,
        containment: 'parent',
        cursor:'move',
        axis: "y"}); 

    $("ul#lists").sortable({
        start: function(event, ui) {
            ui.item.find('.listAction').hide();
        },
        stop: function() {
            var ajaxParam = $("ul#lists").sortable('serialize');
            PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_SORT_LISTS, 
                                     ajaxParam, PLANCAKE.lang.ACCOUNT_SUCCESS_LIST_REORDERED, null);
        },
        distance: 10,        
        items: "li:not(.systemList):not(.exceedingAllowance)",
        containment: 'parent',        
        cursor:'move',
        axis: "y"}); 

    $("ul#lists li:not('.exceedingAllowance')").livequery ( function() {
        $(this).droppable({
            accept: "ul.tasks > li.task",        
            activeClass: 'active',
            hoverClass:'hovered',
            drop:function(event, ui){
                var taskId = null;
                PLANCAKE.taskDropped = true;
                $(event.target).addClass('dropped');
                // taskId = $(ui.draggable).plancake().getId();
                // taskDomId = $(ui.draggable).attr('id');

                PLANCAKE.listIdForTaskDropped = $(this).plancake().getId();
            }
        });
    });
    
    $( "#newListButton" ).button();
    
    $( "#newListButton" ).live('click', function() {
        if (!PLANCAKE.userSettings.isPremium && 
            $("ul#lists li").size() > PLANCAKE.config.maxListsForFreeAccount) {
            jAlert(sprintf(PLANCAKE.lang.ACCOUNT_ERROR_MAX_LISTS_FOR_FREE_ACCOUNTS, 
                    PLANCAKE.config.maxListsForFreeAccount, PLANCAKE.BASE_URL + '/upgrade'));
        } else {
            PLANCAKE.openListDialog(PLANCAKE.EDIT_LISTS_MODE_NEW);
        }
    });
    
    $( ".editList" ).live('click', function(e) {
        PLANCAKE.openListDialog(PLANCAKE.EDIT_LISTS_MODE_EDIT, $(this).parent('li') );
        e.stopPropagation();        
    });
    $( ".addBelowList" ).live('click', function(e) {
        PLANCAKE.openListDialog(PLANCAKE.EDIT_LISTS_MODE_ADDBELOW, $(this).parent('li'));
        e.stopPropagation();
    });  


    $('#whatsListHeaderHelp').qtip({
        content: $('#whatsListHeaderHelpTooltip'),
        show: 'mouseover',
        hide: 'mouseleave',
        position: {
          corner: {
             tooltip: 'topLeft'
          }
       },   
       style: PLANCAKE.getQtipStyleObject()
    });

    $('.editList').livequery( function() {
        $(this).button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: false
        });
    });
    $('.addBelowList').livequery( function() {
        $(this).button({
            icons: {
                primary: "ui-icon-arrowreturnthick-1-e"
            },
            text: false
        });
    });
    
    $('#collapseLists').click(function() {
        $('ul#lists').hide();
        $('#expandLists').show();
        $(this).hide();
    });
    
    $('#expandLists').click(function() {
        $('ul#lists').show();
        $('#collapseLists').show();
        $(this).hide();
    });
    
    $('#collapseLists').attr('title', PLANCAKE.lang.ACCOUNT_LISTS_COLLAPSE).button();
    $('#expandLists').attr('title', PLANCAKE.lang.ACCOUNT_LISTS_EXPAND).button().hide();    

});


/**
 * @param PLANCAKE.List list
 */
PLANCAKE.editList = function (list) {
    var ajaxParams = 'op=edit&listId=' + list.id + '&listTitle=' + 
        PLANCAKE.prepareForAjaxTransmission(list.name) + 
        '&isHeader=' + (+list.isHeader);

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_MANAGE_LISTS, 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_LIST_UPDATED, function(listFromServer) {
        var htmlForList =  PLANCAKE.getHtmlListObj(listFromServer);
        $().plancake().getList(list.id).replaceWith(htmlForList);
        
        // changing the title of the panel if the list is loaded there
        PLANCAKE.reloadPanelIfListLoaded(list);
    });
}

/**
 * @param PLANCAKE.List list
 */
PLANCAKE.reloadPanelIfListLoaded = function (list) {
    var activePanel = PLANCAKE.activePanel;
    
    var panel1Config = PLANCAKE.getActivePanelContentConfig($('#panel1'));
    if ( (panel1Config.type === PLANCAKE.CONTENT_TYPE_LIST) &&
        (panel1Config.extraParam === list.id)) {
        PLANCAKE.loadContent(panel1Config, $('#panel1'));
    }
    
    var panel2Config = PLANCAKE.getActivePanelContentConfig($('#panel2'));
    if ( (panel2Config.type === PLANCAKE.CONTENT_TYPE_LIST) &&
        (panel2Config.extraParam === list.id)) {
        PLANCAKE.loadContent(panel2Config, $('#panel2'));
    }
    
    PLANCAKE.setActivePanel(activePanel);
} 


PLANCAKE.deleteList = function(listId) {
    var ajaxParams = 'op=delete&listId=' + listId;
    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_MANAGE_LISTS, 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_LIST_DELETED, function() {
        $().plancake().getList(listId).remove();
        
        // {{{ START: if the tasks in this lists are displayed, we want the panel to reset
        var panel1 = $('#panel1');
        var panel1Config = PLANCAKE.getActivePanelContentConfig(panel1);
        if ( (panel1Config.type === PLANCAKE.CONTENT_TYPE_LIST) && (panel1Config.extraParam == listId)) {
             PLANCAKE.resetContent(panel1);
        }

        var panel2 = $('#panel2');
        var panel2Config = PLANCAKE.getActivePanelContentConfig(panel2);
        if ( (panel2Config.type === PLANCAKE.CONTENT_TYPE_LIST) && (panel2Config.extraParam == listId)) {
             PLANCAKE.resetContent(panel2);
        }
        // }}}        
    });
}

/**
 * @param string mode (EDIT_LISTS_MODE_NEW, EDIT_LISTS_MODE_EDIT or EDIT_LISTS_MODE_ADDBELOW)
 * @param mixed list
 *        _ null, if mode=new
 *        _ JQuery object of the 'li' element to edit, if mode=edit
 *        _ JQuery object of the 'li' element to add below, if mode=addBelow
 */
PLANCAKE.openListDialog = function (mode, list) {
    var listName = $( "#listNameForm" ),
    listHeader = $( "#listHeaderForm" ),
    allFields = $( [] ).add( listName ).add( listHeader ),
    tips = $( ".validateTips" ),
    dialogForm = $( "#dialogFormList" ),
    dialogTitle = '',
    buttons = new Array;

    function resetForm() {
        $("#listNameForm").val('');
        $("#listIdForm").val('');
        $("#listHeaderForm").val('0');
        $("#aboveListIdForm").val('');            
    }

    function submitForm() {
        var bValid = true,
            list = null;
        allFields.removeClass( "ui-state-error" );

        bValid = bValid && PLANCAKE.dialogCheckLength(tips, listName, PLANCAKE.lang.ACCOUNT_LISTS_LIST_NAME, 1, 100 );

        list = new PLANCAKE.List;
        list.id = 0;
        list.name = PLANCAKE.stripHtmlTags(listName.val());
        list.isHeader = PLANCAKE.toBoolean(listHeader.val());

        if ( bValid ) {
                switch ($("#operationListForm").val()) {
                    case PLANCAKE.EDIT_LISTS_MODE_NEW:
                        PLANCAKE.addList(list, null, true);                        
                        break;
                    case PLANCAKE.EDIT_LISTS_MODE_EDIT:
                        list.id = $("#listIdForm").val();
                        PLANCAKE.editList(list);
                        break;
                    case PLANCAKE.EDIT_LISTS_MODE_ADDBELOW:
                        PLANCAKE.addList(list, $("#aboveListIdForm").val());                        
                        break;                        
                }

                dialogForm.dialog( "close" );
        }        
    }

    resetForm();
    if (mode === PLANCAKE.EDIT_LISTS_MODE_NEW) {
        dialogTitle = PLANCAKE.lang.ACCOUNT_NEW_LIST.capitalize(); 
    } else if (mode === PLANCAKE.EDIT_LISTS_MODE_EDIT) {
        dialogTitle = PLANCAKE.lang.ACCOUNT_EDIT_LIST;        
        buttons.push({
                    text: PLANCAKE.lang.ACCOUNT_MISC_DELETE,
                    'class': 'deleteButton',
                    click: function () {
                        var listId = $("#listIdForm").val();
                        if ($().plancake().getList(listId).plancake().isSystemList()) {
                            alert(PLANCAKE.lang.ACCOUNT_ERROR_CANT_DELETE_TODO_LIST);
                        } else if (confirm(PLANCAKE.lang.ACCOUNT_MISC_CONFIRM_MSG)) {
                            PLANCAKE.deleteList(listId);
                            dialogForm.dialog( "close" );
                        }
                    }
                });

        $("#listNameForm").val(list.plancake().getName());
        $("#listIdForm").val(list.plancake().getId());
        if (list.plancake().isHeader()) {
            $( "#listHeaderForm" ).val('1');
        }

    } else if (mode === PLANCAKE.EDIT_LISTS_MODE_ADDBELOW) {
        dialogTitle = PLANCAKE.lang.ACCOUNT_LISTS_ADD_LIST_BELOW;
        $("#aboveListIdForm").val(list.plancake().getId());
    }
    $("#operationListForm").val(mode);

    buttons.push({
        text: PLANCAKE.lang.ACCOUNT_MISC_SAVE,
        click: function() {
            submitForm();
        }
    });    

    dialogForm.dialog({
            autoOpen: false,
            width: 450,                        
            modal: true,
            resizable: false,
            buttons: buttons,
            position: ['center', 10],            
            title: dialogTitle,
            open: function() {
                if (PLANCAKE.isIE6() || PLANCAKE.isIE7()) {
                    dialogForm.unbind('keyup.listDialog'); // to prevent many event handlers from being registered
                    dialogForm.bind('keyup.listDialog', function(e) {
                        if (e.keyCode === PLANCAKE.ENTER_KEY_CODE) {
                            submitForm();
                            return false;                        
                        }
                    });                   
                } else {
                    dialogForm.unbind('keydown.listDialog'); // to prevent many event handlers from being registered
                    dialogForm.bind('keydown.listDialog', function(e) {
                        if (e.keyCode === PLANCAKE.ENTER_KEY_CODE) {
                            submitForm();
                            return false;                        
                        }
                    });
                }
            },                        
            close: function() {
                    allFields.val( "" ).removeClass( "ui-state-error" );
            }
    });   
    dialogForm.dialog( "open" );
}