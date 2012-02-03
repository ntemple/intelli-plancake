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

PLANCAKE.EDIT_TAGS_MODE_NEW = "new";
PLANCAKE.EDIT_TAGS_MODE_EDIT = "edit";

$(document).ready(function () {
    $("ul#tags li:not('.exceedingAllowance')").live('mouseover', function() {
        $(this).addClass('hover');
        $(this).find('.tagAction').show();
    })
    .live('mouseout', function() {
        $(this).removeClass('hover');
        $(this).find('.tagAction').hide();        
    })
    .live('click', function() {
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_TAG, 
            extraParam: $(this).plancake().getId()       
        })
    });     
    
    $("ul#tags").sortable({
        start: function(event, ui) {
            ui.item.find('.tagAction').hide();
        },
        stop: function() {
            var ajaxParam = $("ul#tags").sortable('serialize');
            PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_SORT_TAGS, 
                                     ajaxParam, PLANCAKE.lang.ACCOUNT_SUCCESS_TAGS_REORDERED, null);
        },
        distance: 10,
        items: "li:not(.exceedingAllowance)",        
        containment: 'parent',        
        cursor:'move',
        axis: "y"}); 

    $("ul#tags li:not('.exceedingAllowance')").livequery ( function() {
        $(this).droppable({
            accept: "ul.tasks > li.task",        
            activeClass: 'active',
            hoverClass:'hovered',
            drop:function(event, ui){
                PLANCAKE.taskDropped = true;
                $(event.target).addClass('dropped');
                PLANCAKE.tagIdForTaskDropped = $(this).plancake().getId();                
            }
        });
    });
    
    $( "#newTagButton" ).button();
    
    $( "#newTagButton" ).live('click', function() {
        
        if (!PLANCAKE.userSettings.isPremium &&
            $("ul#tags li").size() > PLANCAKE.config.maxTagsForFreeAccount) {
            jAlert(sprintf(PLANCAKE.lang.ACCOUNT_ERROR_MAX_TAGS_FOR_FREE_ACCOUNTS, 
                    PLANCAKE.config.maxTagsForFreeAccount, PLANCAKE.BASE_URL + '/upgrade'));
        } else {
            PLANCAKE.openTagDialog(PLANCAKE.EDIT_TAGS_MODE_NEW);
        }
    });
    
    $( ".editTag" ).live('click', function() {
        PLANCAKE.openTagDialog(PLANCAKE.EDIT_TAGS_MODE_EDIT, $(this).parent('li') );
    });  

    $('.editTag').livequery( function() {
        $(this).button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: false
        });
    });
});


/**
 * @param PLANCAKE.Tag tag
 */
PLANCAKE.editTag = function (tag) {
    var ajaxParams = 'op=edit&id=' + tag.id + '&name=' + 
        PLANCAKE.prepareForAjaxTransmission(tag.name);

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_MANAGE_TAGS, 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TAG_UPDATED, function(tagFromServer) {
        var htmlForTag =  PLANCAKE.getHtmlTagObj(tagFromServer);
        $().plancake().getTag(tag.id).replaceWith(htmlForTag);
        
        // changing the title of the panel if the tag is loaded there
        PLANCAKE.reloadPanelIfTagLoaded(tag);        
    });    
}

/**
 * @param PLANCAKE.Tag tag
 */
PLANCAKE.reloadPanelIfTagLoaded = function (tag) {
    var activePanel = PLANCAKE.activePanel;
    
    var panel1Config = PLANCAKE.getActivePanelContentConfig($('#panel1'));
    if ( (panel1Config.type === PLANCAKE.CONTENT_TYPE_TAG) &&
        (panel1Config.extraParam === tag.id)) {
        PLANCAKE.loadContent(panel1Config, $('#panel1'));
    }
    
    var panel2Config = PLANCAKE.getActivePanelContentConfig($('#panel2'));
    if ( (panel2Config.type === PLANCAKE.CONTENT_TYPE_TAG) &&
        (panel2Config.extraParam === tag.id)) {
        PLANCAKE.loadContent(panel2Config, $('#panel2'));
    }
    
    PLANCAKE.setActivePanel(activePanel);    
} 

PLANCAKE.deleteTag = function(tagId) {
    var ajaxParams = 'op=delete&id=' + tagId;
    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_MANAGE_TAGS, 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TAG_DELETED, function() {
        $().plancake().getTag(tagId).remove();
        
        // {{{ START: if the tasks in this tags are displayed, we want the panel to reset
        var panel1 = $('#panel1');
        var panel1Config = PLANCAKE.getActivePanelContentConfig(panel1);
        if ( (panel1Config.type === PLANCAKE.CONTENT_TYPE_TAG) && (panel1Config.extraParam == tagId)) {
             PLANCAKE.resetContent(panel1);
        }

        var panel2 = $('#panel2');
        var panel2Config = PLANCAKE.getActivePanelContentConfig(panel2);
        if ( (panel2Config.type === PLANCAKE.CONTENT_TYPE_TAG) && (panel2Config.extraParam == tagId)) {
             PLANCAKE.resetContent(panel2);
        }
        // }}}          
    });     
}



/**
 * @param string mode (EDIT_TAGS_MODE_NEW or EDIT_TAGS_MODE_EDIT)
 * @param mixed tag
 *        _ null, if mode=new
 *        _ JQuery object of the 'li' element to edit, if mode=edit
 *        _ JQuery object of the 'li' element to add below, if mode=addBelow
 */
PLANCAKE.openTagDialog = function(mode, tag) {
    var tagName = $( "#tagNameForm" ),
    allFields = $( [] ).add( tagName ),
    tips = $( ".validateTips" ),
    dialogForm = $( "#dialogFormTag" ),
    dialogTitle = '',
    buttons = new Array;

    function submitForm() {
        var bValid = true;
        allFields.removeClass( "ui-state-error" );

        bValid = bValid && PLANCAKE.dialogCheckLength(tips, tagName, PLANCAKE.lang.ACCOUNT_TAGS_TAG_NAME, 1, 100 );
        bValid = bValid && PLANCAKE.dialogCheckRegexp(tips, tagName, /^[^ ]+$/i, PLANCAKE.lang.ACCOUNT_ERROR_TAG_CANT_HAVE_SPACE);

        if ( bValid ) {
                var tag = new PLANCAKE.Tag();
                tag.name = PLANCAKE.stripHtmlTags(tagName.val());

                switch ($("#operationTagForm").val()) {
                    case PLANCAKE.EDIT_TAGS_MODE_NEW:
                        PLANCAKE.addTag(tag, true);                        
                        break;
                    case PLANCAKE.EDIT_TAGS_MODE_EDIT:
                        tag.id = $("#tagIdForm").val();
                        PLANCAKE.editTag(tag);
                        break;                     
                }


                dialogForm.dialog( "close" );
        }        
    }

    if (mode === PLANCAKE.EDIT_TAGS_MODE_NEW) {
        dialogTitle = PLANCAKE.lang.ACCOUNT_TAGS_NEW_TAG.capitalize(); 
    } else if (mode === PLANCAKE.EDIT_TAGS_MODE_EDIT) {
        dialogTitle = PLANCAKE.lang.ACCOUNT_TAGS_EDIT_TAG;        
        buttons.push({
                    text: PLANCAKE.lang.ACCOUNT_MISC_DELETE,
                    'class': 'deleteButton',
                    click: function () {
                        if (confirm(PLANCAKE.lang.ACCOUNT_MISC_CONFIRM_MSG)) {
                            PLANCAKE.deleteTag($("#tagIdForm").val());
                            dialogForm.dialog( "close" );
                        }
                    }
                });

        $("#tagNameForm").val(tag.plancake().getName());
        $("#tagIdForm").val(tag.plancake().getId());
    }
    $("#operationTagForm").val(mode);

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
                    dialogForm.unbind('keyup.tagDialog'); // to prevent many event handlers from being registered
                    dialogForm.bind('keyup.tagDialog', function(e) {
                        if (e.keyCode === PLANCAKE.ENTER_KEY_CODE) {
                            submitForm();
                            return false;                        
                        }
                    });                   
                } else {
                    dialogForm.unbind('keydown.tagDialog'); // to prevent many event handlers from being registered
                    dialogForm.bind('keydown.tagDialog', function(e) {
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