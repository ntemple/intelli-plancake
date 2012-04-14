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
 * Stores the current order for the 'Overdue & Today' section in a cookie
 * 
 * The first element of the cookie is the today string (because we need to reset the cookie every day).
 * The other elements are the ids of the tasks
 */
PLANCAKE.storeTodayOrder = function () {
    var sortOrderArray = PLANCAKE.activePanel.find('ul.tasks').sortable('toArray');

    sortOrderArray = $.map(sortOrderArray, function (v) {
        return v.split('_').pop();
    });

    sortOrderArray.unshift(PLANCAKE.getTodayStringForTodayOrder()); // inserting today string in the first position

    $.cookie(PLANCAKE.COOKIE_NAME_TODAY_SORT_ORDER, JSON.stringify(sortOrderArray), {expires: 2, path: '/'});   
}

PLANCAKE.getTodayStringForTodayOrder = function () {
    var today = new Date();
    return (today.getFullYear() + '' + today.getMonth() + '' + today.getDate());    
}

/**
 * N.B.: a cookie created with yesterday's task shouldn't be used
 **/
PLANCAKE.isTodayOrderCookieValid = function () {
    
    if ($.cookie(PLANCAKE.COOKIE_NAME_TODAY_SORT_ORDER) == null) {
        return false;
    }
    
    var todaySortCookieContent = JSON.parse($.cookie(PLANCAKE.COOKIE_NAME_TODAY_SORT_ORDER));
    
    if (typeof(todaySortCookieContent) == 'object' && (todaySortCookieContent instanceof Array)) {    
        // check whether the cookie is valid for the day
        var dayStamp = todaySortCookieContent[0];
        var today = new Date();
        var todayString = today.getFullYear() + '' + today.getMonth() + '' + today.getDate();
        
        if (dayStamp == todayString) {
            return true;
        }
    }
    return false;
}

/**
 * Plugs into the method that shows tasks in a list so possibly reorder them
 * according to the order set by the user and stored in the cookie created by the method PLANCAKE.storeTodayOrder
 */
PLANCAKE.repositionTodayTasksAccordingToTodayOrder = function (tasksFromServer) {
    if (PLANCAKE.isTodayOrderCookieValid()) {
        var i, j = 0;
        var numberOfTasks = tasksFromServer.length;

        var tasksFromServerToTest = $.extend(true, [], tasksFromServer); // deep copy
        var todaySortCookieContent = JSON.parse($.cookie(PLANCAKE.COOKIE_NAME_TODAY_SORT_ORDER));

        todaySortCookieContent.shift(); // removing the first element which is the todayString, nothing to do with the sort order

        var tasksFromServerAfterReordering = new Array();
        var todaySortCookieContentLength = todaySortCookieContent.length;
        var currentSortPositionTaskId = null;
        var currentTask = null;  

        for (i = 0; i < todaySortCookieContentLength; i++) {
            currentSortPositionTaskId = todaySortCookieContent[i];

            if (currentSortPositionTaskId > 0) {

                for (j = 0; j < numberOfTasks; j++) { // looping through the tasks to be displayed
                    currentTask = tasksFromServerToTest[j];
                    if ( (currentTask !== null) && // once we move a task to the tasksFromServerAfterReordering array,
                                                   // we set it to null in the original array, thus we need to check for null value 
                            (currentTask.id == currentSortPositionTaskId) ) {
                                tasksFromServerAfterReordering.push(currentTask);
                                tasksFromServerToTest[j] = null;
                                break;
                    }
                }
                
                j++;
                
                // we want to move also the other tasks that are after, until we find another task that is
                                 // in the order array.
                                 // This is because not all the tasks to be displayed are in the order array (because they may have
                                 // been created from another list)
                while (j < numberOfTasks) {
                    currentTask = tasksFromServerToTest[j];

                    if (currentTask !== null) {
                        if (todaySortCookieContent.indexOf((currentTask.id + '')) === -1) { // todaySortCookieContent is an array of strings
                            tasksFromServerAfterReordering.push(currentTask);
                            tasksFromServerToTest[j] = null;
                        } else {
                            break;
                        }
                    }
                    j++;
                }
            }
        }

        // making sure we are not leaving any original task out
        var taskToTest = null;
        for (i = 0; i < numberOfTasks; i++) {
            taskToTest = tasksFromServerToTest[i];
            // in the previous loop we were setting to null every task moved to the tasksFromServerAfterReordering array
            if (taskToTest !== null) {
                tasksFromServerAfterReordering.push(taskToTest);
            }
        }

        return tasksFromServerAfterReordering;
    } else {
        $.cookie(PLANCAKE.COOKIE_NAME_TODAY_SORT_ORDER, null, {expires: 0}); // resetting the cookie, just in case
        // a correct cookie was not found - return the input unchanged
        return tasksFromServer;
    }
}

/**
 * This is used in the case the user not only reorder tasks for the day, but also move them to another day
 */
PLANCAKE.rescheduleTodayTasks = function (sortableUiItem) {
    var task = PLANCAKE.getTaskObjFromHtml(sortableUiItem);

    var prevTask = PLANCAKE.getTaskObjFromHtml(sortableUiItem.prev());
    var nextTask = PLANCAKE.getTaskObjFromHtml(sortableUiItem.next());

    var editTaskDueDate = false;
    if (prevTask && (prevTask.getHumanFriendlyDueDate() == PLANCAKE.lang.ACCOUNT_MISC_TOMORROW) ) { // moving a task to tomorrow                       
        if (task.dueDate != PLANCAKE.lang.ACCOUNT_MISC_TOMORROW) {
            editTaskDueDate = true;
            task.dueDate = prevTask.dueDate;
        }
    } else if (prevTask && (prevTask.getHumanFriendlyDueDate() == PLANCAKE.lang.ACCOUNT_MISC_TODAY) ) {
        if (task.getHumanFriendlyDueDate() == PLANCAKE.lang.ACCOUNT_MISC_TOMORROW) {                        
            if (nextTask.getHumanFriendlyDueDate() == PLANCAKE.lang.ACCOUNT_MISC_TODAY) {
                editTaskDueDate = true;
                task.dueDate = prevTask.dueDate;
            }
        } else if (task.getHumanFriendlyDueDate() != PLANCAKE.lang.ACCOUNT_MISC_TODAY) { // overdue task
            editTaskDueDate = true;
            task.dueDate = prevTask.dueDate;                            
        }
    } else { // task at the top is overdue OR prevTask is null
        // There is no point in moving something from today/tomorrow to overdue.
        // Therefore, we are interested in this case only when a task from tomorrow
        // is moved between the tasks overdue and due today. If I task is due today,
        // we don't need to change it.
        if (prevTask && (nextTask.getHumanFriendlyDueDate() == PLANCAKE.lang.ACCOUNT_MISC_TODAY) &&
            (task.getHumanFriendlyDueDate() == PLANCAKE.lang.ACCOUNT_MISC_TOMORROW)) {
            editTaskDueDate = true;
            task.dueDate = nextTask.dueDate; 
        }
    }


    if (editTaskDueDate) {                   
        var ajaxParams = PLANCAKE.getAjaxParams(task);
        ajaxParams += "&op=edit";

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_EDIT_TASK , 
                             ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TASK_UPDATED, function(taskFromServer) {
            var taskHtml =  PLANCAKE.getHtmlTaskObj((new PLANCAKE.Task()).init(taskFromServer));
            sortableUiItem.replaceWith(taskHtml);                            

            PLANCAKE.updateTaskCounters();
        });
    }
}