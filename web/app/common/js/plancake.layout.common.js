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

PLANCAKE.CONTENT_TYPE_LIST = "list";
PLANCAKE.CONTENT_TYPE_TAG = "tag";
PLANCAKE.CONTENT_TYPE_TODAY = "today";
PLANCAKE.CONTENT_TYPE_CALENDAR = "calendar";
PLANCAKE.CONTENT_TYPE_STARRED = "starred";
PLANCAKE.CONTENT_TYPE_SEARCH = "search";

/**
 * @param JQuery panel (=null) - if null, the active panel is used
 * @param boolean resetTaskFilters (=true)
 */
PLANCAKE.resetContent = function (panel, resetTaskFilters) {
    var panel = panel ? panel : PLANCAKE.activePanel;
    
    if ( (resetTaskFilters === null) || (resetTaskFilters === undefined) ) {
        resetTaskFilters = true;
    }    
    
    if (! PLANCAKE.isMobile) {
        panel.find('.completed_hideableHint').hide();
    }
    
    if (panel === null) {
        panel = $('#panel1');
    }
    
    PLANCAKE.setPanelTitle('.....................', panel);
    
    panel.find('ul.tasks').html('');
    
    // resetting task filters
    if (resetTaskFilters) {
        panel.find('form.hideScheduledTasks input').removeAttr('checked');
        panel.find('form.sortTasks select').val('sortTasksByDragAndDropOrder');
    }
}

PLANCAKE.setPanelTitle = function(title, _activePanel) {
    var activePanel = _activePanel ? _activePanel : PLANCAKE.activePanel;
    
    activePanel.find('h3').text(title);
}

/**
 * @param JQuery activePanel (=null)
 */
PLANCAKE.getActivePanelContentConfig = function (activePanel) {
    activePanel = ((activePanel === null) || (activePanel === undefined) ) ? PLANCAKE.activePanel : activePanel;
    return activePanel.data('contentConfig') || {};
}

PLANCAKE.setActivePanelContentConfig = function (contentConfig) {
    return PLANCAKE.activePanel.data('contentConfig', contentConfig);
}

/**
 * After the tasks for the calendar have been retrieved (the same way as for any list),
 * this method inserts the elements peculiar for the calendar:
 * _ heading for the day (e.g. 'Thursday 15')
 * _ message 'there are no tasks for today' if applicable
 */
PLANCAKE.loadCalendarElements = function () {
    var activePanel = PLANCAKE.activePanel;
    
    var calendarStartDate = strtotime(PLANCAKE.getActivePanelContentConfig().extraParam);

    activePanel.find('h3').append(' - ' + date('j', calendarStartDate) + ' ' + PLANCAKE.fromMonthIndexToString(date('n', calendarStartDate))
        + ' ' + date('Y', calendarStartDate));
    
    var weekdays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
        weekday = null,
        currentWeekdayIndex = date('w', calendarStartDate),
        currentTask = activePanel.find('ul.tasks li.task').first(),
        tasksForTheDayCount = 0,
        tasksLeft = true,
        nextTask = null,
        calendarDate = null,
        calendarDateTimestamp = null,
        calendarDateButtonClass = null,
        calendarDateNoTasks = null,
        isCalendarEmpty = (activePanel.find('ul.tasks').children('li').length > 0) ? false : true ;

    for (var i = 0; i < PLANCAKE.numberOfDaysOnCalendar; i++) {
        weekday = weekdays[currentWeekdayIndex];
        
        calendarDateTimestamp = strtotime("+" + i + " days", calendarStartDate);

        calendarDate = '<li class="calendarDate nonTask">' + PLANCAKE.fromAbbreviationToWeekday(weekday) + 
            ' ' + date('j', calendarDateTimestamp)  + '</li>';
        calendarDateNoTasks = '<li class="calendarDateNoTasks nonTask">' + PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_CAL_NO_TASKS + '</li>';
        
        if (! PLANCAKE.isMobile) {
           calendarDateButtonClass = 'ts_' + date('Y-m-d', calendarDateTimestamp);
           calendarDate = $(calendarDate).
                          addClass(calendarDateButtonClass).
                          append('&nbsp;&nbsp;&nbsp;<div class="newTaskInCalButton">\n\
                                  <a class="btn" href="#">' + PLANCAKE.lang.ACCOUNT_ADD_TASK +
                                  '</a></div>');
           calendarDate.find('div.newTaskInCalButton a').
                        button();
        }
        
        if (isCalendarEmpty) {
            activePanel.find('ul.tasks').append(calendarDate).append(calendarDateNoTasks);
        } else {
            if (tasksLeft) {
                currentTask.before(calendarDate);
            } else {
                currentTask.after(calendarDate);
                currentTask = currentTask.next();
            }

            tasksForTheDayCount = 0;
            while(currentTask.attr('class') && currentTask.attr('class').indexOf('dow_' + weekdays[currentWeekdayIndex]) !== -1 ) {
                nextTask = currentTask.next();
                tasksForTheDayCount++;
                if (nextTask.plancake().getId() !== null) {
                    currentTask = nextTask;
                } else {
                    tasksLeft = false;
                    break;
                }
            }
            if (tasksForTheDayCount === 0) {
                if (tasksLeft) {
                    currentTask.before(calendarDateNoTasks);
                } else {
                    currentTask.after(calendarDateNoTasks);
                    currentTask = currentTask.next();
                }         
            }
        }
        
        if (currentWeekdayIndex == (PLANCAKE.numberOfDaysOnCalendar -1)) {
            currentWeekdayIndex = 0;
        } else {
            currentWeekdayIndex++;
        }
        
        $('span.newTaskInCalButton a').button();
    }
    
    // we also need to change the simpleTimestamp to reflect the repetition
    var currentDate = null; // yyyymmdd format
    var task = null;
    activePanel.find('ul.tasks li').not('.nonTask').each(function () {
        currentListItem = $(this);
        if (currentListItem.hasClass('calendarDate')) {
            currentDate = currentListItem.attr('class').match(/ts_([0-9]{4}-[0-9]{2}-[0-9]{2})/)[1].replace(/-/gi, "");  
        } else { // the item is a task
            task = PLANCAKE.getTaskObjFromHtml(currentListItem);
            currentListItem.find('span.simpleTimestamp').text(task.getSimpleTimestamp(currentDate));
        }
    });
}

/**
 * @param Object contentConfig, it has got these keys:
 * _ boolean done - whether to display the tasks that has been done
 * _ string type - the type of content - see PLANCAKE.CONTENT_TYPE_* constants
 * _ int extraParam - i.e. listId or tagId
 * @param JQuery _activePanel (=null)
 * @param boolean resetTaskFilters (=true)
 * @param function afterLoadingCallback (=null)
 */
PLANCAKE.loadContent = function (contentConfig, _activePanel, resetTaskFilters, afterLoadingCallback) {
    var activePanel = _activePanel ? _activePanel : PLANCAKE.activePanel;  
    if (activePanel === null) {
        activePanel = $('#panel1');
    }

    if ( (resetTaskFilters === null) || (resetTaskFilters === undefined) ) {
        resetTaskFilters = true;
    }
    
    if ( (afterLoadingCallback === null) || (afterLoadingCallback === undefined) ) {
        afterLoadingCallback = null;
    }    

    PLANCAKE.resetContent(activePanel, resetTaskFilters);
    
    PLANCAKE.setActivePanel(activePanel);    

    // disabled the automatic restore of the content from last visit
    /*
    if (activePanel.attr('id') === "panel1") {
        $.cookie(PLANCAKE.COOKIE_NAME_FOR_PANEL1_CONTENT_CONFIG, JSON.stringify(contentConfig), {expires: 70});
    } else {
        $.cookie(PLANCAKE.COOKIE_NAME_FOR_PANEL2_CONTENT_CONFIG, JSON.stringify(contentConfig), {expires: 70});        
    }
   */
 
    PLANCAKE.setActivePanelContentConfig(contentConfig);
    
    var panelTitle = '',
        listId = 0,
        tagId = 0,
        list = null,
        tag = null,
        ajaxParams = null,
        tasks = activePanel.find('ul.tasks');

    if (! PLANCAKE.isMobile) {
        PLANCAKE.setContentSelection(contentConfig);

        PLANCAKE.hideTaskOptions(activePanel);
    }

    switch(contentConfig.type) {
        case PLANCAKE.CONTENT_TYPE_LIST:
            listId = contentConfig.extraParam;
            list = $().plancake().getList(listId);
            
            if (! contentConfig.done) {
                panelTitle = sprintf(PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_TASKS_BY_LIST, list.plancake().getName());
            } else {
                panelTitle = sprintf(PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_COMPLETED_TASKS_BY_LIST, list.plancake().getName());               
            }
            
            break;
        case PLANCAKE.CONTENT_TYPE_TAG:
            tagId = contentConfig.extraParam;
            tag = $().plancake().getTag(tagId);
            if (! contentConfig.done) {            
                panelTitle = sprintf(PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_TASKS_BY_TAG, tag.plancake().getName());
            } else {
                panelTitle = sprintf(PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_COMPLETED_TASKS_BY_TAG, tag.plancake().getName());                
            }                
            break;
        case PLANCAKE.CONTENT_TYPE_TODAY:
            if (! contentConfig.done) {            
                panelTitle = PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_TASKS_OVERDUE_AND_TODAY;
            } else {
                panelTitle = PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_COMPLETED_TASKS_OVERDUE_AND_TODAY;                
            }           
            
            break;
        case PLANCAKE.CONTENT_TYPE_CALENDAR:
            if (! contentConfig.done) {                
                panelTitle = PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_TASKS_WITH_DUE_DATE;               
            } else {
                panelTitle = PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_COMPLETED_TASKS_WITH_DUE_DATE;
            }          
            
            break;
        case PLANCAKE.CONTENT_TYPE_STARRED:
            if (! contentConfig.done) {            
                panelTitle = PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_TASKS_STARRED;
            } else {
                panelTitle = PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_COMPLETED_TASKS_STARRED; 
            }
            break;
        case PLANCAKE.CONTENT_TYPE_SEARCH:
            panelTitle = PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_TASKS_SEARCH + ' ' + decodeURIComponent(contentConfig.extraParam);
            break;            
    }
    
    if (contentConfig.done) {
        tasks.addClass('completedTasks');
        tasks.find('.markAsCompleted').prop("checked", true);
        activePanel.find('form.addTask').hide();
    } else {
        tasks.removeClass('completedTasks');
        tasks.find('.markAsCompleted').prop("checked", false);
        activePanel.find('form.addTask').show();
    }
    
    if (contentConfig.type === PLANCAKE.CONTENT_TYPE_SEARCH) {
       activePanel.find('form.addTask').hide();
       activePanel.find('.searchWarning').show();       
    } else {
       activePanel.find('.searchWarning').hide();        
    }
    
    // if (contentConfig.type === PLANCAKE.CONTENT_TYPE_CALENDAR) {
    //   activePanel.find('form.addTask').hide();      
    // }    
    
    if (! PLANCAKE.isMobile) {
        if ( ((contentConfig.type === PLANCAKE.CONTENT_TYPE_LIST) ||
             (contentConfig.type === PLANCAKE.CONTENT_TYPE_TAG)) &&
             (!contentConfig.done)) {
            activePanel.find('.editPanel').show();
        } else {
            activePanel.find('.editPanel').hide();
        }
    }
    
    if ( (contentConfig.done === true) ||
         (contentConfig.type === PLANCAKE.CONTENT_TYPE_SEARCH) ||
         (contentConfig.type === PLANCAKE.CONTENT_TYPE_CALENDAR) ||
         (contentConfig.type === PLANCAKE.CONTENT_TYPE_TODAY)) {
        activePanel.find('.taskFilters').hide();
    } else {
        activePanel.find('.taskFilters').show();
    }      

    if ( (contentConfig.done === false) &&
         (contentConfig.type == PLANCAKE.CONTENT_TYPE_CALENDAR)) {
        activePanel.find('.calendarControls').show();
    } else {
        activePanel.find('.calendarControls').hide();
    }    
    
    if (! PLANCAKE.isMobile) {
        PLANCAKE.populateTaskMainProperties(activePanel.find('form.addTask')); 
    }
 
    PLANCAKE.setPanelTitle(panelTitle, activePanel);
    document.title = 'Plancake - ' + panelTitle;
    
    if (! PLANCAKE.isMobile) {
        if (activePanel.attr('id') === "panel1") {
            PLANCAKE.populateTaskOptions(activePanel.find('.taskOptions'), PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL1);
        } else {
            PLANCAKE.populateTaskOptions(activePanel.find('.taskOptions'), PLANCAKE.TASK_OPTIONS_CONTEXT_PANEL2);       
        }

        activePanel.find('.taskDescription').focus();
        
        activePanel.find('ul.completedTasks').html('');    

        activePanel.find('.addTaskBottom').hide();

        activePanel.find('.tasksLoader').show();
    }
    
    tasks.html('');

    ajaxParams = 'done=' + (contentConfig.done ? '1' : '0') + '&type=' + contentConfig.type + '&extraParam= ' + contentConfig.extraParam;
    
    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_GET_TASKS, 
                             ajaxParams, '', function(tasksFromServer) {
        if (! PLANCAKE.isMobile) {
            activePanel.find('.tasksLoader').hide();
            activePanel.find('.noTasks').show();
        }
        
        tasksFromServer = tasksFromServer['tasks'];
        var tasks = activePanel.find('ul.tasks');

        var numberOfTasks = tasksFromServer.length,
            task = null,
            i = 0;
        
        tasks.html(''); // resetting task list
        for (i = 0; i < numberOfTasks; i++) {
            task = tasksFromServer[i];
            
            task['tagIds'] = task['tags'];
            delete task['tags'];
            
            var plancakeTask = (new PLANCAKE.Task()).init(task);

            PLANCAKE.addTask(plancakeTask, false, activePanel);
        }
        
        if (contentConfig.done) {
            tasks.addClass('completedTasks');
            tasks.find('.markAsCompleted').each(function() {
                $(this).prop("checked", true);
            });
        } else {
            tasks.removeClass('completedTasks');
            tasks.find('.markAsCompleted').prop("checked", false);        
        }

        if (! PLANCAKE.isMobile) {
            if ( (contentConfig.type === PLANCAKE.CONTENT_TYPE_LIST) && 
                 ( $('li#list_' + contentConfig.extraParam).plancake().isTodo()) &&
                 (contentConfig.done === false)) { // loading Todo list
                activePanel.find('.todo_hideableHint').show();
            } else {
                activePanel.find('.todo_hideableHint').hide();
            }

            if ( (contentConfig.type === PLANCAKE.CONTENT_TYPE_LIST) && 
                 ( $('li#list_' + contentConfig.extraParam).plancake().isInbox()) &&
                 (contentConfig.done === false)) { // loading Todo list
                activePanel.find('.inbox_hideableHint').show();
            } else {
                activePanel.find('.inbox_hideableHint').hide();
            }
        }
        
        // re-applying the task filters if they reload the panel
        if (activePanel.find('form.hideScheduledTasks input').is(':checked')) {
            activePanel.find('ul.tasks li.scheduled').hide();
        };
        if (activePanel.find('form.sortTasks select').val() == 'sortTasksByDueDate') {
            activePanel.find('ul.tasks li').tsort("span.simpleTimestamp");
        };
        
        if ($('#panel2').is(':hidden')) {
            $('#panel1 .taskScheduleDetails').addClass('extraPaddingForTaskScheduleDetails');
        }
        
        if (contentConfig.type === PLANCAKE.CONTENT_TYPE_CALENDAR) {
            PLANCAKE.loadCalendarElements();
        }
       
        if (PLANCAKE.isMobile) {
            var page = $('#tasks-screen');
            var content = page.children( ":jqmData(role=content)" );
            page.page();
            var listView = content.find( ":jqmData(role=listview)" );
            listView.listview();
            listView.listview('refresh'); // we need this otherwise the second time the listview                                          // is showed (probably with different data) it will not be styled.            
        }
       
        if (jQuery.type(afterLoadingCallback) === "function") {
            afterLoadingCallback();
        }
    });
}

/**
 * @param JQuery activePanel
 */
PLANCAKE.hideTaskOptions = function (activePanel) {
    if ( (activePanel === null) || (activePanel === undefined) ) {
        activePanel = PLANCAKE.activePanel;
    }
    
    activePanel.find('.taskOptionsWrapper').slideUp('fast');    
    activePanel.find('.hideTaskOptionsLink').hide();
    activePanel.find('.showTaskOptionsLink').show();    
}