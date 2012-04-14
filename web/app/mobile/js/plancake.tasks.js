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

PLANCAKE.latestSelectedTaskId = null;
PLANCAKE.latestTaskScreenRelativeUrl = null;

$(document).ready(function () {
    
    // I use unbind to make sure the event is not triggered twice
    var datePickerConfig = PLANCAKE.getDatePickerConfig();
    $('#calendarJumpDate').scroller(datePickerConfig);
    
    // Link not used anymore
    // I use unbind to make sure the event is not triggered twice
    //$('.calPrevMonth').unbind('tap').bind('tap', function () {
    //    PLANCAKE.loadCalendarPrevMonth($(this));
    //    return false;
    // });
    
    // Link not used anymore    
    // I use unbind to make sure the event is not triggered twice
    // $('.calNextMonth').unbind('tap').bind('tap', function () {
    //    PLANCAKE.loadCalendarNextMonth($(this));
    //    return false;
    // }); 
    
    // I use unbind to make sure the event is not triggered twice
    $('.calPrevWeek').unbind('tap').bind('tap', function () {
        PLANCAKE.loadCalendarPrevWeek($(this));
        return false;
    }); 

    // I use unbind to make sure the event is not triggered twice
    $('.calNextWeek').unbind('tap').bind('tap', function () {
        PLANCAKE.loadCalendarNextWeek($(this));
        return false;
    });
    
    $('form#quickAddToInbox input.saveBtn').parent().find('.ui-btn-text').text(PLANCAKE.lang['ACCOUNT_MISC_SAVE']);
    $('#quickAddToInboxText').val(PLANCAKE.lang['ACCOUNT_MOBILE_ADD_TASK_TO_INBOX']);
 
    $('#quickAddToInboxText').tap(function() {
        if ($(this).val() == PLANCAKE.lang['ACCOUNT_MOBILE_ADD_TASK_TO_INBOX']) {
            $(this).val('')
                   .removeClass('greyedText');
        }
    });
    
    $('form#quickAddToInbox').submit(function(e) {
        var taskContent = $(this).find('#quickAddToInboxText').val();
        var inboxListId = null,
            ajaxParams = null,
            task = null;
        
        if (taskContent.length) {
            inboxListId = $('ul#lists li.inbox').plancake().getId();
            task = (new PLANCAKE.Task()).init({
                listId: inboxListId,
                description: taskContent
            });

            ajaxParams = PLANCAKE.getAjaxParams(task);                       
            PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_ADD_TASK, ajaxParams, '', function () {
                $('#quickAddToInboxText').val('');
                
                var inboxCounter = $('div.inboxCounter').text();
                var newInboxCounter = (inboxCounter > 0) ? (parseInt(inboxCounter)+1) : 1;
                $('div.inboxCounter').text(newInboxCounter);
                               
                PLANCAKE.showToastSuccess(sprintf(PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_ADDED, 
                                                 $('ul#lists li.inbox').plancake().getName()));
            });
        }
        
        e.preventDefault();
        return false;
    });
    
    submitAddTaskForm = function () {
        var taskContent = $('#addTaskDescription').val();
        var listId = $('select#addTaskListsSelect').val(),
            ajaxParams = null,
            task = null;
            
        if ( !(parseInt(listId) > 0) ) {
            listId = $('ul#lists li.inbox').plancake().getId();
        }
        
        if (taskContent.length) {
            task = (new PLANCAKE.Task()).init({
                listId: listId,
                description: taskContent
            });

            ajaxParams = PLANCAKE.getAjaxParams(task);                       
            PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_ADD_TASK, ajaxParams, '', function () {
                $('#addTaskDescription').val('');
                
                if (listId == $('ul#lists li.inbox').plancake().getId()) { // task added to Inbox
                    var inboxCounter = $('div.inboxCounter').text();
                    var newInboxCounter = (inboxCounter > 0) ? (parseInt(inboxCounter)+1) : 1;
                    $('div.inboxCounter').text(newInboxCounter);   
                }
                
                PLANCAKE.showToastSuccess(sprintf(PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_ADDED, 
                                                 $('ul#lists li#list_' + listId).plancake().getName()));
            });
        }        
    }
    
    $('#addTaskSubmitBtn').bind('tap', function(e) {
        submitAddTaskForm();
    });
    
    $('#addTaskDescription, #addTaskListsSelect').keypress(function(e){
        if(e.which == 13){
            submitAddTaskForm();
            $('.ui-dialog').dialog ('close');
            e.preventDefault();
            return false;
        }
    });    
});

$( '#task-menu-screen' ).live( 'pageinit', function (event) { 
    $('div#taskActions a').bind("tap taphold", function(e) {
        var buttonId = $(this).attr('id');
        
        switch (buttonId) {
            case 'markDoneTaskAction':
                var ajaxParams = "taskId=" + PLANCAKE.latestSelectedTaskId;
                PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_COMPLETE_TASKS, 
                                         ajaxParams, '', null);            
                break;
            case 'markToDoTaskAction':
                var ajaxParams = "taskId=" + PLANCAKE.latestSelectedTaskId;                
                PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_UNCOMPLETE_TASKS, 
                                         ajaxParams, '', null); 
                break;
            case 'starTaskAction':
                var ajaxParams = "taskId=" + PLANCAKE.latestSelectedTaskId;                
                PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_STAR_TASKS, 
                                         ajaxParams, '', null); 
                break;
            case 'unstarTaskAction':
                var ajaxParams = "taskId=" + PLANCAKE.latestSelectedTaskId;                
                PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_STAR_TASKS, 
                                         ajaxParams, '', null); 
                break;                 
            case 'viewNoteAction':
                PLANCAKE.showToastNotice($().plancake().getTask(PLANCAKE.latestSelectedTaskId).plancake().getNote());
                e.stopPropagation();
                e.preventDefault();
                break;      
            case 'goBackTaskAction':
                break;
        };
    });    
});

$(document).bind( "pagebeforechange", function( e, data ) {
    // We only want to handle changePage() calls where the caller is
    // asking us to load a page by URL.
    if ( typeof data.toPage === "string" ) {

            // We are being asked to load a page by URL, but we only
            // want to handle URLs that request the data for a specific
            // category.
            var u = $.mobile.path.parseUrl( data.toPage ),
                tasksUrlRegExp = /^#tasks-screen/,
                extraParam = null,
                type = null;

            if ( u.hash.search(tasksUrlRegExp) !== -1 ) {
                    PLANCAKE.latestTaskScreenRelativeUrl = u.hash;
                    type = u.hash.match(/type=([a-z]+)/);
                    if (type) {
                        type = type[1];
                    } else {
                        document.location.href= "#lists-screen";
                        e.preventDefault();
                    }

                    extraParam = u.hash.match(/id=([0-9]+)/);
                    if (extraParam) {
                        extraParam = extraParam[1];
                    }
                    
                    if (type === 'calendar') {
                        extraParam = date('Y-m-d', strtotime("today"));
                    }
                    
                    var contentConfig = {
                      type: type,
                      extraParam: extraParam,
                      done: false
                    };
                    PLANCAKE.loadContent(contentConfig, $('#panel1'), false, function () {
                            var page = $('#tasks-screen');
                            data.options.dataUrl = u.href;
                            $.mobile.changePage( page, data.options );
                            e.preventDefault();
                            
                            $('ul.tasks li').unbind('taphold').not('.nonTask').bind('taphold', function(e){
                                PLANCAKE.latestSelectedTaskId = $(this).plancake().getId();
                                $.mobile.changePage($('#task-menu-screen'), {transition: "pop", role: "dialog", reverse: false});
                                e.preventDefault();
                            });                             
                    }); 
                    e.preventDefault();
            }
    }    
    
});

$(document).bind( "pagechange", function( e, data ) {
    // We only want to handle changePage() calls where the caller is
    // asking us to load a page by URL.
    if ( $('.ui-page-active').attr('id') === 'task-menu-screen' ) {
        
        $('div#taskActions a').removeClass('ui-disabled');
        
        var task = $().plancake().getTask(PLANCAKE.latestSelectedTaskId).plancake();
        
        if (task.isCompleted()) { 
            $('a#markDoneTaskAction').addClass('ui-disabled');
        } else {
            $('a#markToDoTaskAction').addClass('ui-disabled');            
        }
        
        if (task.isStarred()) { 
            $('a#starTaskAction').addClass('ui-disabled');
        } else {
            $('a#unstarTaskAction').addClass('ui-disabled');            
        }        
               
        if (! $().plancake().getTask(PLANCAKE.latestSelectedTaskId).plancake().getNote().length) { 
            $('a#viewNoteAction').addClass('ui-disabled');
        }        
        
        $('div#taskActions a').attr('href', PLANCAKE.latestTaskScreenRelativeUrl);
    } else if ( $('.ui-page-active').attr('id') === 'add-task-screen' ) {
        var activeListId = PLANCAKE.activeListId > 0 ? PLANCAKE.activeListId : $('ul#lists li.inbox').plancake().getId();
        var listOptions = '';
        $('ul#lists li').each(function() {
            listOptions += '<option ' + ($(this).plancake().isHeader() ? 'class="header"' : '') +
                ' value="' + $(this).plancake().getId() + '">' + $(this).plancake().getName() + '</option>';
        });

        var comboBox = $('select#addTaskListsSelect');
        comboBox.html(listOptions);
        //comboBox[0].selectedIndex = activeListId;
        comboBox.val(activeListId);
        comboBox.selectmenu("refresh");
    }    
});



/**
 * // TO EXPAND FROM DESKTOP VERSION
 *
 * @param PLANCAKE.Task task
 * @param mixed position
 *    - if integer, that's the id of the task this task should be added after
 *    - if true, the task will be placed on top of the other tasks
 *    - if false, the task will be placed at the bottom of the other tasks
 * @param JQuery activePanel - if it is not passed, PLANCAKE.activePanel is used
 */
PLANCAKE.addTask = function(task, position, activePanel) {
    activePanel.find('.noTasks').hide();
    
    var htmlTask =  PLANCAKE.getHtmlTaskObj(task, activePanel),
        tasks = activePanel.find('ul.tasks');
    tasks.append(htmlTask);  
}