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

PLANCAKE.MAX_TASK_DESCRIPTION_LENGTH = 255;

PLANCAKE.EDIT_TASKS_MODE_EDIT = "edit";
PLANCAKE.EDIT_TASKS_MODE_ADDBELOW = "addBelow";
PLANCAKE.EDIT_TASKS_MODE_ADD = "add";

PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL1 = "panel1";
PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL2 = "panel2";
PLANCAKE.TASK_OPTIONS_CONTEXT_DIALOG = "dialog";

PLANCAKE.JQUERY_TASK_DATA_KEY = "taskDetails";

$(document).ready(function () {
        
    var draggableSibling;
           
    var focusOnNoteTextareaWhileEditing = false;
    $('.taskOptionNote').focus(function() {
        focusOnNoteTextareaWhileEditing = true;
    });
    $('.taskOptionNote').blur(function() {
        focusOnNoteTextareaWhileEditing = false;
    });
    
    $('a.taskGmailLink').live('click', function(e) {
        e.stopPropagation();
    });

$('.taskOptionsWrapper').html($('.taskOptions'));
    $('.panelContent').find('div.taskOptionsWrapper').hide();

    $('.tagLinkInList').live('click', function(e) {
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_TAG, 
            extraParam: $(this).attr('class').split(' ').slice(-1).toString().replace('tlil_', '')      
        });
        e.stopPropagation();
        return false;
    });
    
    $('.listLinkInList').live('click', function(e) {
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_LIST, 
            extraParam: $(this).attr('class').split(' ').slice(-1).toString().replace('llil_', '')      
        });
        e.stopPropagation();
        return false;
    });    

    $("ul.tasks").sortable({
        placeholder: "ui-state-highlight",
        items: "li.task",
        helper: function(e, element)
            {return $("<div class='dragging'>" + $(element).find('.description').text() + "</div>")},
        cursorAt: {top:15, left:15},
        cursor:'move',
        distance: 10,
        start: function(event, ui) {
            draggableSibling = $(ui.item).prev();
            PLANCAKE.setActivePanel($(ui.item).parents('.panel'));
        }, 
        beforeStop: function(event, ui) {
            if (PLANCAKE.areTasksSortedByDueDate()) {
                alert(PLANCAKE.lang.ACCOUNT_ERROR_CANT_DRAG_WHEN_SORTED_BY_DATE);
                $(this).sortable('cancel');
            }
        },       
        stop: function(event, ui) {
            if (PLANCAKE.taskDropped) { // the task was dropped on a list or a tag
                
                // {{{ START: I don't remember exactly why I needed this - search on StackOverflow
                // if (draggableSibling.length === 0)
                //    PLANCAKE.setActivePanel.find("ul.tasks").prepend(ui.item);
                // draggableSibling.after(ui.item);
                // END }}}
                
                PLANCAKE.taskDropped = false;                
                
                if (PLANCAKE.listIdForTaskDropped > 0) { // the task has been dropped on a list
                    var task = PLANCAKE.getTaskObjFromHtml(ui.item);
                    task.listId = PLANCAKE.listIdForTaskDropped;

                    var ajaxParams = PLANCAKE.getAjaxParams(task);

                    ajaxParams += "&op=edit";

                    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_EDIT_TASK , 
                                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_UPDATED, function(taskFromServer) {
                        PLANCAKE.listIdForTaskDropped = 0;                                                 
                      
                        var panelConfig = PLANCAKE.getActivePanelContentConfig();

                        if ( (panelConfig.type === PLANCAKE.CONTENT_TYPE_LIST) &&
                            (panelConfig.extraParam != PLANCAKE.listIdForTaskDropped) ) { // the task has been moved to another list
                            ui.item.remove();
                        } else {
                            var taskHtml =  PLANCAKE.getHtmlTaskObj((new PLANCAKE.Task()).init(taskFromServer));
                            ui.item.replaceWith(taskHtml);                            
                        }
                        PLANCAKE.updateTaskCounters();
                    });
                } else { // the task has been dropped on a tag
                    var task = PLANCAKE.getTaskObjFromHtml(ui.item);
                    task.addTag(PLANCAKE.tagIdForTaskDropped);
                    var ajaxParams = PLANCAKE.getAjaxParams(task);

                    ajaxParams += "&op=edit";

                    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_EDIT_TASK , 
                                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_UPDATED, function(taskFromServer) {
                        PLANCAKE.tagIdForTaskDropped = 0;
                        ui.item.replaceWith(PLANCAKE.getHtmlTaskObj((new PLANCAKE.Task()).init(taskFromServer)));
                        PLANCAKE.updateTaskCounters();
                    });                    
                }                               
            } else { // the task was dragged in order to change its order
                var contentConfig = PLANCAKE.getActivePanelContentConfig();
                if ( (contentConfig.type === PLANCAKE.CONTENT_TYPE_LIST) && 
                     (contentConfig.done === false) ) {
                    var ajaxParam = PLANCAKE.activePanel.find('ul.tasks').sortable('serialize');
                    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_SORT_TASKS, 
                                             ajaxParam, PLANCAKE.lang.ACCOUNT_SUCCESS_TASKS_REORDERED, null);  
                } else if ( (contentConfig.type === PLANCAKE.CONTENT_TYPE_TODAY) && 
                     (contentConfig.done === false) ) {
                     PLANCAKE.storeTodayOrder();
                     PLANCAKE.rescheduleTodayTasks(ui.item); // has the user dragged tasks to another day?
                } else {
                    PLANCAKE.activePanel.find("ul.tasks").sortable("cancel");
                    alert(PLANCAKE.lang.ACCOUNT_ERROR_CANT_REORDER_WHILE_FILTER_BY_TAG);                                        
                }                
            }
        }
    });
    
    $(".panel").livequery ( function() {
        $(this).droppable({
            accept: "ul.tasks > li.task",        
            drop:function(event, ui){
                if ($(this).attr('id') !== $(ui.draggable).plancake().getTaskPanelId()) {
                    alert(PLANCAKE.lang.ACCOUNT_ERROR_CANT_DROP_TO_PANEL);
                }
            }
        });
    });    

    $('form.addTask').submit(function() {
        var task = PLANCAKE.createTaskFromForm($(this));

        PLANCAKE.addTask(task, true, null, true);

        PLANCAKE.populateTaskMainProperties($(this));
        
        PLANCAKE.populateTaskOptions($(this));
        PLANCAKE.hideTaskOptions();
        
        return false;
    });
    
    $('form.addTaskBottom').submit(function() {
        var taskDescriptionInput = $(this).find('input.addTaskDescriptionBottom');
        
        var task = new PLANCAKE.Task();
        task.description = taskDescriptionInput.val();
        task.listId = PLANCAKE.getActivePanelContentConfig().extraParam;
        
        PLANCAKE.addTask(task, false, null, true);  
        
        taskDescriptionInput.val('');
        return false;
    });
    
    $('.taskDescrShortcutsHelp').qtip({
       content: $('#taskDescrShortcutsTooltip'),
       show: 'mouseover',
       hide: 'mouseleave',
       position: {
          corner: {
             tooltip: 'topLeft'
          }
       },   
       style: PLANCAKE.getQtipStyleObject()
    });
        
    $('a.taskOptionsLink').click(function() {
        
        // without this line we wouldn't change the active panel appropriately
        PLANCAKE.setActivePanel($(this).parents('.panel'));
        
        var form = $(this).parent('form');
        var taskOptionsWrapper = form.find('div.taskOptionsWrapper');
        var isVisible = taskOptionsWrapper.is(':visible');
        var activePanelId = PLANCAKE.activePanel.attr('id');
        var context = (activePanelId === 'panel1') ? PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL1 :
            PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL2;
        
        taskOptionsWrapper.slideToggle("fast");
        PLANCAKE.populateTaskOptions(form.find('.taskOptions'), context);
        
        $(this).parents('.addTask').toggleClass('addTaskLighterBackground');
        
        $(this).parent().find('a.taskOptionsLink').toggle();
    });


    $("ul.tasks li.task").live('mouseover', function() {
        $(this).addClass('hover');
        $(this).find('.taskAction').show();
    })
    .live('mouseout', function() {
        $(this).removeClass('hover');
        $(this).find('.taskAction').hide();        
    });
    
    $("ul.tasks li.task img.star").live('click', function (e) {
        var task = $(this).parents('li.task');
        if (task.plancake().isStarred()) {
            PLANCAKE.unstarTask(task);
        } else {
            PLANCAKE.starTask(task);            
        }
        e.stopPropagation();
    }); 

    $('.editTask').livequery( function() {
        $(this).button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: false
        });
    });
    $('.addBelowTask').livequery( function() {
        $(this).button({
            icons: {
                primary: "ui-icon-arrowreturnthick-1-e"
            },
            text: false
        });
    });

    $('form.addTask img.star').click(function () {
        var p = $(this).parent();
        if (p.plancake().isStarred()) {
            p.plancake().star(false);
        } else {
            p.plancake().star(true);            
        }
    });
    
    $( ".editTask" ).live('click', function(e) {
        openTaskDialog(PLANCAKE.EDIT_TASKS_MODE_EDIT, $(this).parents('li.task') );
        e.stopPropagation();
    });
    $( ".addBelowTask" ).live('click', function(e) {
        openTaskDialog(PLANCAKE.EDIT_TASKS_MODE_ADDBELOW, $(this).parents('li.task'));
        e.stopPropagation();        
    });

    $('.task .description a').live('click', function(e) {
        e.stopPropagation();
    });
        
    $('.task .taskNote a').live('click', function(e) {
        e.stopPropagation();
    });
    
    $("#dialogFormTask img.star").click( function () {
        var p = $(this).parent();
        if (p.plancake().isStarred()) {
            p.plancake().star(false);
        } else {
            p.plancake().star(true);            
        }
    });
    
    $('ul.tasks li.task').live('click', function() {
        openTaskDialog(PLANCAKE.EDIT_TASKS_MODE_EDIT, $(this));
    });
    
    $('input.markAsCompleted').live('click', function (e) {
        if ($(this).is(':checked')) {
            PLANCAKE.markTaskAsCompleted($(this).parents('li.task'));
        } else {
            PLANCAKE.markTaskAsToComplete($(this).parents('li.task'));            
        }
        e.stopPropagation();
    });
    
    /**
     * @param string mode (EDIT_TASKS_MODE_EDIT or EDIT_TASKS_MODE_ADDBELOW or EDIT_TASKS_MODE_ADD)
     * @param mixed task
     *        _ JQuery object of the 'li' element to edit, if mode=edit
     *        _ JQuery object of the 'li' element to add below, if mode=addBelow
     *        _ Plancake.Task object where ONLY the dueDate is relevant, if mode=add
     */
    function openTaskDialog(mode, task) {
        var taskDescription = $( "#dialogFormTask .taskDescription" ),
        allFields = $( [] ).add( taskDescription ),
        tips = $( ".validateTips" ),
        dialogForm = $( "#dialogFormTask" ),
        dialogTitle = '',
        plancakeTask = null,
        buttons = new Array;

        function submitForm() {
            var task = null;
            var bValid = true;
            allFields.removeClass( "ui-state-error" );

            bValid = bValid && PLANCAKE.dialogCheckLength(tips, taskDescription, PLANCAKE.lang.ACCOUNT_NEW_TASK_DESCRIPTION, 1, 1000 );

            if ( bValid ) {
                    task = PLANCAKE.createTaskFromForm($('#dialogFormTask form'));

                    switch ($("#operationTaskForm").val()) {
                        case PLANCAKE.EDIT_TASKS_MODE_EDIT:
                            PLANCAKE.editTask($("#taskIdForm").val(), task, function () {
                                dialogForm.dialog( "close" ); 
                            });
                            break;
                        case PLANCAKE.EDIT_TASKS_MODE_ADDBELOW:
                            task.id = null; // just to make sure it is clear
                            PLANCAKE.addTask(task, $("#aboveTaskIdForm").val(), null, true, function () {
                                dialogForm.dialog( "close" );                                 
                            });                                                   
                            break;
                        case PLANCAKE.EDIT_TASKS_MODE_ADD:
                            task.id = null; // just to make sure it is clear
                            PLANCAKE.addTask(task, null, null, true, function () {
                                dialogForm.dialog( "close" );                                 
                            });                                                   
                            break;                            
                    }
            }        
        }

        if (mode === PLANCAKE.EDIT_TASKS_MODE_EDIT) {
            PLANCAKE.populateTaskMainProperties($('#dialogFormTask form'), task);
            PLANCAKE.populateTaskOptions($('#dialogFormTask .taskOptionsWrapper'), null, PLANCAKE.getTaskObjFromHtml(task));            
            dialogTitle = PLANCAKE.lang.ACCOUNT_EDIT_TASK;        
            buttons.push({
                        text: PLANCAKE.lang.ACCOUNT_MISC_DELETE,
                        'class': 'deleteButton',
                        click: function () {
                            if (confirm(PLANCAKE.lang.ACCOUNT_MISC_CONFIRM_MSG)) {
                                var taskId = $("#taskIdForm").val();
                                PLANCAKE.deleteTask(taskId);
                                dialogForm.dialog( "close" );
                            }
                        }
                    });
            plancakeTask = task.plancake();
            $("#taskIdForm").val(plancakeTask.getId());
        } else if (mode === PLANCAKE.EDIT_TASKS_MODE_ADDBELOW) {
            PLANCAKE.populateTaskMainProperties($('#dialogFormTask form'));
            PLANCAKE.populateTaskOptions($('#dialogFormTask .taskOptionsWrapper'), null);            
            dialogTitle = PLANCAKE.lang.ACCOUNT_ADD_TASK_BELOW;
            $("#aboveTaskIdForm").val(task.plancake().getId());
        } else if (mode === PLANCAKE.EDIT_TASKS_MODE_ADD) {
            PLANCAKE.populateTaskMainProperties($('#dialogFormTask form'));
            PLANCAKE.populateTaskOptions($('#dialogFormTask .taskOptionsWrapper'), null);            
            dialogTitle = PLANCAKE.lang.ACCOUNT_ADD_TASK.capitalize();
            $('#dialogFormTask form input.taskOptionDueDate').val(PLANCAKE.formatDateForUser(task.dueDate));
        }
        $("#operationTaskForm").val(mode);

        buttons.push({
            text: PLANCAKE.lang.ACCOUNT_MISC_SAVE,
            click: function() {
                submitForm();
            }
        });    

        dialogForm.dialog({
                autoOpen: false,
                width: 600,                        
                modal: true,
                resizable: false,
                buttons: buttons,
                position: ['center', 10],
                title: dialogTitle,
                open: function() {
                    if (PLANCAKE.isIE6() || PLANCAKE.isIE7()) {
                        dialogForm.unbind('keyup.taskDialog'); // to prevent many event handlers from being registered
                        dialogForm.bind('keyup.taskDialog', function(e) {
                            if (e.keyCode === PLANCAKE.ENTER_KEY_CODE) {
                                // if they press enter while typing on the note textarea, we
                                // don't want to submit the form
                                if (!focusOnNoteTextareaWhileEditing) {
                                    submitForm();
                                    return false;
                                }
                            }
                        });                   
                    } else {
                        dialogForm.unbind('keydown.taskDialog'); // to prevent many event handlers from being registered
                        dialogForm.bind('keydown.taskDialog', function(e) {
                            if (e.keyCode === PLANCAKE.ENTER_KEY_CODE) {
                                // if they press enter while typing on the note textarea, we
                                // don't want to submit the form
                                if (!focusOnNoteTextareaWhileEditing) {
                                    submitForm();
                                    return false;
                                }                        
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
    
    
    $("input.taskOptionDueDate").datepicker({
        constrainInput: false,
        showOn: 'both',
        buttonImage: '/app/desktop/img/calendar.gif',
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: [PLANCAKE.lang.ACCOUNT_DOW_SUN, PLANCAKE.lang.ACCOUNT_DOW_MON, PLANCAKE.lang.ACCOUNT_DOW_TUE, 
            PLANCAKE.lang.ACCOUNT_DOW_WED, PLANCAKE.lang.ACCOUNT_DOW_THU, PLANCAKE.lang.ACCOUNT_DOW_FRI, 
            PLANCAKE.lang.ACCOUNT_DOW_SAT],
        monthNamesShort: [PLANCAKE.lang.ACCOUNT_MONTH_JAN, PLANCAKE.lang.ACCOUNT_MONTH_FEB, 
            PLANCAKE.lang.ACCOUNT_MONTH_MAR, PLANCAKE.lang.ACCOUNT_MONTH_APR, PLANCAKE.lang.ACCOUNT_MONTH_MAY, 
            PLANCAKE.lang.ACCOUNT_MONTH_JUN, PLANCAKE.lang.ACCOUNT_MONTH_JUL, PLANCAKE.lang.ACCOUNT_MONTH_AUG,
            PLANCAKE.lang.ACCOUNT_MONTH_SEP, PLANCAKE.lang.ACCOUNT_MONTH_OCT, PLANCAKE.lang.ACCOUNT_MONTH_NOV, 
            PLANCAKE.lang.ACCOUNT_MONTH_DEC],
        nextText: PLANCAKE.lang.ACCOUNT_MISC_NEXT,
        prevText: PLANCAKE.lang.ACCOUNT_MISC_PREV,
        firstDay: PLANCAKE.userSettings.weekStart,
        dateFormat: PLANCAKE.getDateFormatForDatePicker()
    });


    $('.whatsTaskHeaderHelp').qtip({
        content: $('#whatsTaskHeaderHelpTooltip'),
        show: 'mouseover',
        hide: 'mouseleave',
        position: {
          corner: {
             tooltip: 'topMiddle'
          }
       },   
       style: PLANCAKE.getQtipStyleObject()
    });
    
    $('.dueDateHelpLink').qtip({
        content: $('#dueDateHelpTooltip'),
        show: 'mouseover',
        hide: 'mouseleave',
        position: {
          corner: {
             tooltip: 'topRight'
          },
          adjust: {
              x: 0,
              y: -10
          }
       },   
       style: PLANCAKE.getQtipStyleObject()
    });

    $('.submitTask').button()
    .click(function() {
       $(this).parents('form').submit();
       return false;
    });
    
    $('.taskNoteIcon').live('click', function (e) {
        PLANCAKE.toggleNote($(this), e);
    });
    
    $('.taskOptionHeader').change(function () {
        if (PLANCAKE.toBoolean($(this).val())) {
            $(this).parents('table').find('.notForHeader').hide();
        } else {
            $(this).parents('table').find('.notForHeader').show();            
        }
    });
    
    $('form.hideScheduledTasks input').click(function() {
        $(this).parents('.panel').find('ul.tasks li.scheduled').toggle();
    });
   
    $('form.sortTasks select').change(function() {
        if ($(this).val() == 'sortTasksByDueDate') {
            $(this).parents('.panel').find('ul.tasks li.task').tsort("span.simpleTimestamp");
        } else {
            // reloading the content
            PLANCAKE.loadContent(PLANCAKE.getActivePanelContentConfig());
        }
    });
    
    $("input.calendarJumpDate").datepicker(PLANCAKE.getDatePickerConfig());
    
    $('.calPrevMonth').click(function () {
        PLANCAKE.loadCalendarPrevMonth($(this));
        return false;
    });
    
    $('.calNextMonth').click(function () {
        PLANCAKE.loadCalendarNextMonth($(this));
        return false;
    }); 
    
    $('.calPrevWeek').click(function () {
        PLANCAKE.loadCalendarPrevWeek($(this));
        return false;
    }); 

    $('.calNextWeek').click(function () {
        PLANCAKE.loadCalendarNextWeek($(this));
        return false;
    });  
    
    
    $('div.newTaskInCalButton a').live('click', function () {
        var task = new PLANCAKE.Task();
        task.dueDate = $(this).parents('li').attr('class').match(/ts_([0-9]{4}-[0-9]{2}-[0-9]{2})/)[1];
        openTaskDialog(PLANCAKE.EDIT_TASKS_MODE_ADD, task );        
    });
});

/**
 * @param PLANCAKE.Task task
 */
PLANCAKE.sanityChecksBeforeSubmittingTask = function(task) {
    if (! task.description) {
        alert(PLANCAKE.lang.ACCOUNT_ERROR_NO_TASK_DESCRIPTION);
        return false;
    } else if (task.description.length > PLANCAKE.MAX_TASK_DESCRIPTION_LENGTH) {
        alert(PLANCAKE.lang.ACCOUNT_ERROR_TASK_DESCRIPTION_TOO_LONG);
        task.description = task.description.substring(0, PLANCAKE.MAX_TASK_DESCRIPTION_LENGTH - 1);
    }
    
    if ( (task.dueTime) && (!task.dueDate)  ) {
        alert(PLANCAKE.lang.ACCOUNT_ERROR_NEED_ALSO_TASK_DUE_DATE);
        return false;
    }
    return true;
}

/**
 * @param PLANCAKE.Task task
 * @param mixed position
 *    - if integer, that's the id of the task this task should be added after
 *    - if true, the task will be placed on top of the other tasks
 *    - if false, the task will be placed at the bottom of the other tasks
 * @param JQuery activePanel - if it is not passed, PLANCAKE.activePanel is used
 * @param bool manual (=false) - whether to highlight the task once has been added
 * @param function successCallback (=null)
 */
PLANCAKE.addTask = function(task, position, activePanel, manual, successCallback) {
    if ((activePanel === null) || (activePanel === undefined)) {
        activePanel = PLANCAKE.activePanel;
    }

    if ((manual === null) || (manual === undefined)) {
        manual = false;
    }
    
    if (!PLANCAKE.sanityChecksBeforeSubmittingTask(task)) {
        return false;
    }
    
    /**
     * @param PLANCAKE.Task task
     */
    function addTaskToLayout(task) {
        
        var activePanelConfig = PLANCAKE.getActivePanelContentConfig(activePanel),
            currentTask = null,
            found = false;
        
        var htmlTask =  PLANCAKE.getHtmlTaskObj(task, activePanel),
            taskSimpleTimestamp = task.getSimpleTimestamp(),
            tasks = activePanel.find('ul.tasks');
        
        if (manual) {
            htmlTask.find('.taskDueDate').show();  // we need this because dueDate is hidden on the Calendar
                                                   // but we want to show it when the user adds tasks
        }
            
        if ( manual &&
            (activePanelConfig.type === PLANCAKE.CONTENT_TYPE_TODAY) ) { // in this case I insert sorting by due date

            tasks.find('li.task').each(function () {
                currentTask = PLANCAKE.getTaskObjFromHtml($(this));
                
               if (taskSimpleTimestamp < currentTask.getSimpleTimestamp()) {
                    found = true;                    
                    $(this).before(htmlTask);
                    
                    return false;  // this breaks the loops
                }
            });

            if (!found) {
                tasks.append(htmlTask);
            }
            
            if (PLANCAKE.isTodayOrderCookieValid()) {
                PLANCAKE.storeTodayOrder();
            }
            
        } else if ( manual &&
            (activePanelConfig.type === PLANCAKE.CONTENT_TYPE_CALENDAR) ) { // in this case I insert sorting by due date

            var calendarDateForTask = tasks.find('li.ts_' + task.dueDate);

            if (calendarDateForTask.length <= 0) { // the task doesn't belong to any date in the current calendar page
                PLANCAKE.hideTaskInCurrentContent(htmlTask);
                tasks.find('li').first().before(htmlTask);
            } else { // inserting the task in the right place
                var taskToTest = calendarDateForTask;
                var inserted = false;
                while (taskToTest = taskToTest.next()) { // looping through the tasks for that day
                    if (taskToTest.length <= 0) { // end of the list
                        break;
                    }
                    if (taskToTest.hasClass('calendarDateNoTasks')) {
                        taskToTest.replaceWith(htmlTask);
                        inserted = true;
                        break;
                    }                    
                    if (taskSimpleTimestamp < PLANCAKE.getTaskObjFromHtml(taskToTest).getSimpleTimestamp()) {                   
                        taskToTest.before(htmlTask);
                        inserted = true;                        
                        break;
                    }
                    if (taskToTest.hasClass('calendarDate')) { // we reach the next calendarDate header                    
                        taskToTest.before(htmlTask);
                        inserted = true;                        
                        break;
                    }
                }
                if (!inserted) {
                    tasks.find('li').last().after(htmlTask);    
                }                
            }
        } else {
            if (position === true) { 
                tasks.prepend(htmlTask);
            } else if (position === false) {
                tasks.append(htmlTask);    
            } else if (PLANCAKE.is_numeric(position)) {
                $().plancake().getTask(parseInt(position)).after(htmlTask);
            }
        }
        
        if (manual) {
            PLANCAKE.flashBackground(htmlTask);
        }       
    }    

    if (task.id) { // when we populate a list on loading
        addTaskToLayout(task);
        activePanel.find('.noTasks').hide();
        if (PLANCAKE.getActivePanelContentConfig(activePanel).type === PLANCAKE.CONTENT_TYPE_LIST &&
            PLANCAKE.getActivePanelContentConfig(activePanel).done === false) {
            activePanel.find('.addTaskBottom').show();
        }    
    } else {
        var ajaxParams = PLANCAKE.getAjaxParams(task);                       
        
        if ((position !== null) && (position !== undefined) && PLANCAKE.is_numeric(position)) {
            ajaxParams += '&taskAboveId=' + position;  
        } else if (position === false) {
            ajaxParams += '&taskAboveId=-100000'; // 100000 is a conventional constant meaning to place the new task at the end of the list
        }

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_ADD_TASK, 
                                 ajaxParams, 
                                 sprintf(PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_ADDED, 
                                            $().plancake().getList(task.listId).plancake().getName()), 
                                 function(taskFromServer) {
                                    var plancakeTask = (new PLANCAKE.Task()).init(taskFromServer);
                                    
                                    addTaskToLayout(plancakeTask);

                                    activePanel.find('.noTasks').hide();
                                    if (PLANCAKE.getActivePanelContentConfig(activePanel).type === PLANCAKE.CONTENT_TYPE_LIST &&
                                        PLANCAKE.getActivePanelContentConfig(activePanel).done === false) {
                                        activePanel.find('.addTaskBottom').show();
                                    }
                                    
                                    PLANCAKE.updateTaskCounters();

                                    if ((successCallback !== null) && (successCallback !== undefined)) {
                                        successCallback();
                                    }
        });
    }    
}

/**
 * @param int taskId
 * @param PLANCAKE.Task task
 * @param function successCallback (=null)
 * 
 */
PLANCAKE.editTask = function (taskId, task, successCallback) {

    if (!PLANCAKE.sanityChecksBeforeSubmittingTask(task)) {
        return false;
    }

    var ajaxParams = PLANCAKE.getAjaxParams(task);
    
    ajaxParams += "&op=edit";

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_EDIT_TASK , 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_UPDATED, function(taskFromServer) {
        var taskHtml =  PLANCAKE.getHtmlTaskObj((new PLANCAKE.Task()).init(taskFromServer));
        
        PLANCAKE.updateTaskCounters();
        if ((successCallback !== null) && (successCallback !== undefined)) {
            successCallback();                
        }        
        
        if (PLANCAKE.getActivePanelContentConfig().type === PLANCAKE.CONTENT_TYPE_CALENDAR) {
            // reloading content as the user may have change the repetition rule of the task, so we need to "redraw"
            PLANCAKE.loadContent(PLANCAKE.getActivePanelContentConfig());
        } else {        
            $().plancake().getTask(taskId).replaceWith(taskHtml);
            PLANCAKE.flashBackground(taskHtml);
        }
    });    
}


PLANCAKE.deleteTask = function(taskId) {    
    var ajaxParams = "&op=delete&taskId=" + taskId;

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_EDIT_TASK , 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_DELETED, function(taskFromServer) {
        $().plancake().getTask(taskId).remove();
        
        PLANCAKE.updateTaskCounters();
    });    
}

/**
 * @param JQuery task - li element
 */
PLANCAKE.unstarTask = function (task) {
    var ajaxParams = "taskId=" + task.plancake().getId();

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_STAR_TASKS , 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_STARRED_UNSTARRED, function() {
        task.data(PLANCAKE.JQUERY_TASK_DATA_KEY).isStarred = 0;     
        task.plancake().star(false);
        
        if (PLANCAKE.getActivePanelContentConfig().type === PLANCAKE.CONTENT_TYPE_STARRED) {
            PLANCAKE.hideTaskInCurrentContent(task);
        }
    });    
}

/**
 * @param JQuery task - li element
 */
PLANCAKE.starTask = function (task) {
    var ajaxParams = "taskId=" + task.plancake().getId();

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_STAR_TASKS , 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_STARRED_UNSTARRED, function() {
        task.data(PLANCAKE.JQUERY_TASK_DATA_KEY).isStarred = 1;    
        task.plancake().star(true);
        
        if (PLANCAKE.getActivePanelContentConfig().type === PLANCAKE.CONTENT_TYPE_STARRED) {
            PLANCAKE.showHiddenTaskInCurrentContent(task);
        }        
    });    
}

/**
 * @param JQuery form
 * @param JQuery task (=null) - li object
 */
PLANCAKE.populateTaskMainProperties = function (form, task) {
    var contentType = PLANCAKE.getActivePanelContentConfig().type;
    
    if (contentType && (contentType !== PLANCAKE.CONTENT_TYPE_STARRED)) {
        form.plancake().star(false);
    } else {
        form.plancake().star(true);        
    }

    if ((task === null) || (task === undefined)) {
        form.find('.taskDescription').val('');
    } else {
        form.find('.taskDescription').val(task.plancake().getDescription());        
        if (task.plancake().isStarred()) {
            form.plancake().star(true);
        } 
    }
}

/**
 * @param JQuery form
 * @return PLANCAKE.Task
 */
PLANCAKE.createTaskFromForm = function (form) {
    var taskDescriptionInput = form.find('.taskDescription');

    var task = new PLANCAKE.Task(),
        dueDateVal = form.find('.taskOptionDueDate').val(),
        dueTimeHourVal = form.find('.taskOptionDueTimeHour').val(),
        dueTimeMinuteVal = form.find('.taskOptionDueTimeMinute').val(),
        taskOptionNote = form.find('.taskOptionNote').val(),
        repetitionIdVal = parseInt(form.find('.taskOptionRepetitions').val()),
        repetitionParamVal = null,
        repetition = null,
        tagIds = [];
    
    task.id = form.find('#taskIdForm').val();
    task.description = PLANCAKE.stripHtmlTags(taskDescriptionInput.val());
    
    task.listId = form.find('.taskOptionList').val();
    
    if (! task.listId) {
        task.listId = $().plancake().getTodo().plancake().getId();
    }
    
    if (PLANCAKE.toBoolean(form.find('.taskOptionHeader').val())) {
        task.isHeader = true;
    } else {
        task.isHeader = false;        
    }

    if (form.plancake().isStarred()) {
        task.isStarred = true;
    }

    if (dueDateVal.length) {
        task.dueDate = PLANCAKE.normalizeDate(dueDateVal, PLANCAKE.userSettings.dateFormat);
    }
    
    if (dueTimeHourVal || dueTimeMinuteVal) {
        dueTimeMinuteVal = (PLANCAKE.is_numeric(dueTimeMinuteVal)) ? parseInt(dueTimeMinuteVal) : 0;
        dueTimeHourVal = (PLANCAKE.is_numeric(dueTimeHourVal)) ? parseInt(dueTimeHourVal) : '00';        
        task.dueTime = dueTimeHourVal + '' + sprintf('%02d', parseInt(dueTimeMinuteVal));
    }
    
    if (repetitionIdVal > 0) {
        task.repetitionId = repetitionIdVal;
        
        repetition = PLANCAKE.getRepetitionById(repetitionIdVal);

        if (repetition.special == 'selected_wkdays') {
            repetitionParamVal = PLANCAKE.getRepetitionParamForSelectedWeekdaysFromForm(form.find('.taskOptionRepetitionParamsWrapper'));
        } else {
            repetitionParamVal = parseInt(form.find('.taskOptionRepetitionParams').val());                
        }
        
        if (repetitionParamVal > 0) {
            task.repetitionParam = repetitionParamVal;
        }
    }
    
    form.find('.taskOptionTag').each(function () {
        var tagId = null;
        if ($(this).is(':checked')) {
            tagId = $(this).attr('id').split('_').slice(-1);
            tagIds.push(tagId);
        }
    });
    
    if (tagIds.length) {
        task.tagIds = tagIds.join(',');
    }

    task.note = null;
    if ( (taskOptionNote !== null) && (taskOptionNote !== undefined) ) {
        task.note = PLANCAKE.encodeEntities(taskOptionNote);    
    }

    return task;
}

/**
 * @param JQuery task - li element
 */
PLANCAKE.markTaskAsCompleted = function (task) {
    var ajaxParams = "taskId=" + task.plancake().getId();

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_COMPLETE_TASKS, 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_MARKED_AS_DONE, function(taskFromServer) {

        if (taskFromServer.id) { // the task is recurrent - just the dueDate will be changed      
            if (PLANCAKE.getActivePanelContentConfig().type === PLANCAKE.CONTENT_TYPE_CALENDAR) {
                // reloading content as  we need to "redraw"
                PLANCAKE.loadContent(PLANCAKE.getActivePanelContentConfig());
            } else {                       
                var taskHtml = PLANCAKE.getHtmlTaskObj((new PLANCAKE.Task()).init(taskFromServer));
                task.replaceWith(taskHtml);
                task = taskHtml;
            }
        } else { // the task is not recurrent
            task.addClass('completed');
            task.data(PLANCAKE.JQUERY_TASK_DATA_KEY).isCompleted = 1;
            PLANCAKE.activePanel.find('ul.completedTasks').append(task);            
        }        
        
        PLANCAKE.updateTaskCounters();
        
        PLANCAKE.flashBackground(task);
        
        PLANCAKE.activePanel.find('.completed_hideableHint').show();        
    });      
}

/**
 * @param JQuery task - li element
 */
PLANCAKE.markTaskAsToComplete = function (task) {
    var ajaxParams = "taskId=" + task.plancake().getId();

    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_UNCOMPLETE_TASKS, 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_MARKED_AS_TO_DO, function() {        
        
        if (PLANCAKE.getActivePanelContentConfig().done === false) { // not in the done page
            task.removeClass('completed');
            task.data(PLANCAKE.JQUERY_TASK_DATA_KEY).isCompleted = 0;    
            PLANCAKE.activePanel.find('ul.tasks').append(task);
            PLANCAKE.flashBackground(task);
        } else {
            task.remove();
        }

        PLANCAKE.updateTaskCounters();
    });
}

/**
 * @param JQuery taskOptions div
 * @param string context - see PLANCAKE.TASK_OPTIONS_CONTEXT_* constants
 * @param Plancake.Task task (=null)
 */
PLANCAKE.populateTaskOptions = function (taskOptions, context, task) {
    var dateFormat = PLANCAKE.userSettings.dateFormat,
        listOptions = '',
        tagOptions = '',
        tagId = 0,
        tagName = '',
        taskOptionList = taskOptions.find('.taskOptionList'),
        taskOptionTags = taskOptions.find('.taskOptionTags'),
        taskOptionDueDate = taskOptions.find('.taskOptionDueDate'),
        taskOptionHours = '',
        taskOptionMinutes = '',
        taskOptionHoursSelect = null,
        taskOptionMinutesSelect = null,        
        hourFormat0Values = null,
        taskOptionRepetitionOptions = '',
        taskOptionRepetitionSelect = null,        
        repetitionOptionsCounter = 0,
        repetitionOption = null,
        hours= null,
        minutes = null,
        i = 0;    
    
    var isEditMode = true;
    if ( (task === null) || (task === undefined) ) {
        task = null;
        isEditMode = false;
    }
    
    if (isEditMode && task.isHeader) {
        taskOptions.find('.notForHeader').hide();
        taskOptions.find('.taskOptionHeader').val('1');
    } else {
        taskOptions.find('.notForHeader').show();
        taskOptions.find('.taskOptionHeader').val('0');        
    }    
    
    $('ul#lists li').each(function() {
        listOptions += '<option ' + ($(this).plancake().isHeader() ? 'class="header"' : '') +
            ' value="' + $(this).plancake().getId() + '">' + $(this).plancake().getName() + '</option>';
    });
    
    taskOptionList.html(listOptions);
    
    $('ul#tags li').each(function() {
        tagId = $(this).plancake().getId();
        tagName = $(this).plancake().getName();
        
        tagOptions += '<label for="taskOptionTag_' +  context + '_' +
            tagId + '">' + tagName + '<input type="checkbox" class="taskOptionTag taskOptionTag_' + tagId + 
            '" name="taskTags" id="taskOptionTag_' +  context + '_' + tagId + '"></label>&nbsp;&nbsp;&nbsp;';
    });
    
    taskOptionTags.html(tagOptions);

    PLANCAKE.setBasicTaskOptions(taskOptionList, taskOptionTags, taskOptionDueDate, task);

    if ( (context === PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL1) ||
        (context === PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL2)) {        
        taskOptions.find('.submitTask').show();
    } else {
        taskOptions.find('.submitTask').hide();        
    }
    
    hourFormat0Values = ['12am', '1am', '2am', '3am', '4am', '5am', '6am', '7am', '8am', '9am', '10am', '11am', 
                        '12pm', '1pm', '2pm', '3pm', '4pm', '5pm', '6pm', '7pm', '8pm', '9pm', '10pm', '11pm'];
        
    taskOptionHours = '<option value=""></option>';
    for(i = 0; i <= 23; i++) {
        taskOptionHours += '<option value="' + i + '">' + 
            ((dateFormat === '0') ? hourFormat0Values[i] : sprintf('%02d', i)) + 
            '</option>';
    }
    
    taskOptionMinutes = '<option value=""></option>';
    for(i = 0; i <= 59; i++) {
        taskOptionMinutes += '<option value="' + i + '">' + sprintf('%02d', i) + '</option>';
    }
    
    taskOptionHoursSelect = taskOptions.find('.taskOptionDueTimeHour');
    taskOptionMinutesSelect = taskOptions.find('.taskOptionDueTimeMinute');
    
    taskOptionHoursSelect.html(taskOptionHours);
    taskOptionMinutesSelect.html(taskOptionMinutes);

    if (task && (task.dueTime !== null) && (task.dueTime !== '')) {
        hours = Math.floor(task.dueTime / 100);
        minutes = Math.floor(task.dueTime % 100);
        taskOptionHoursSelect.val(hours);
        taskOptionMinutesSelect.val(minutes);
    }

    repetitionOptionsCounter = PLANCAKE.repetitionOptions.length;
    taskOptionRepetitionOptions = '<option value="-1">' + PLANCAKE.lang.ACCOUNT_TASK_REPETITION_DO_NOT_REPEAT + '</option>';
    for (i = 0; i < repetitionOptionsCounter; i++) {
        taskOptionRepetitionOptions += "";
        repetitionOption = PLANCAKE.repetitionOptions[i];
        taskOptionRepetitionOptions += '<option value="' + repetitionOption.id + '">' + repetitionOption.label + '</option>';
        
        // change in other place in plancake.taskRepetitionParam.js
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // taskOptionRepetitionOptions += '<option value="' + repetitionOption.id + '">' + 
        //      window.PLANCAKE.lang['ACCOUNT_TASK_REPETITION_' + repetitionOption.id]  + '</option>';        
        
        if (repetitionOption.has_divider_below) {
            taskOptionRepetitionOptions += '<option value="0">-------------------</option>';
        }
    };
    taskOptionRepetitionSelect = taskOptions.find('.taskOptionRepetitions');
    taskOptionRepetitionSelect.html(taskOptionRepetitionOptions);
    
    if (task && (task.repetitionId > 0)) {
        taskOptionRepetitionSelect.val(task.repetitionId);
        PLANCAKE.setRepetitionParamOptions(taskOptions.find('.taskOptionRepetitionParamsWrapper'), 
                                           task.repetitionId, 
                                           task.repetitionParam);
    } else {
        taskOptions.find('.taskOptionRepetitionParamsWrapper').hide();
    }
    
    taskOptions.find('.taskOptionNote').val( (task && (task.note.length > 0)) ? task.note : '');
}

/**
 * @param JQuery taskOptionList
 * @param JQuery taskOptionTags 
 * @param JQuery taskOptionDueDate
 * @param Plancake.Task task (=null) - if !null, we are in edit mode
 */
PLANCAKE.setBasicTaskOptions = function (taskOptionList, taskOptionTags, taskOptionDueDate, task) {
    var contentConfig = PLANCAKE.getActivePanelContentConfig(),
        tags = [];

    var isEditMode = true;
    if ( (task === null) || (task === undefined) ) {
        task = null;
        isEditMode = false;
    }

    if (! isEditMode) {
        if (contentConfig.type === PLANCAKE.CONTENT_TYPE_LIST) {
            taskOptionList.val(contentConfig.extraParam);    
        } else { // setting the Todo list as default
            taskOptionList.val($().plancake().getTodo().plancake().getId());
        }

        if (contentConfig.type === PLANCAKE.CONTENT_TYPE_TAG) {
            taskOptionTags.find('input.taskOptionTag_' + contentConfig.extraParam).attr('checked', true);  
        }

        if ( (contentConfig.type === PLANCAKE.CONTENT_TYPE_TODAY) || 
             (contentConfig.type === PLANCAKE.CONTENT_TYPE_CALENDAR)) {
             taskOptionDueDate.val('today');
        } else {
            taskOptionDueDate.val('');
        }
    } else {
        taskOptionList.val(task.listId);

        if (task.tagIds) {
            tags = task.tagIds.split(',');
        }
        
        for (var i = 0; i < tags.length; i++) {
            taskOptionTags.find('input.taskOptionTag_' + tags[i]).attr('checked', true);            
        }
        
        if (task) {
            taskOptionDueDate.val(PLANCAKE.formatDateForUser(task.dueDate));
        }
    }
} 


/**
 * @return boolean
 */
PLANCAKE.areTasksSortedByDueDate = function () {
    return (PLANCAKE.activePanel.find('.sortTasks select').val() == 'sortTasksByDueDate');
}