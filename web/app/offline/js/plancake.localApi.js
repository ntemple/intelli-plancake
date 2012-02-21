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
  * Sends a request to the localStorage
  *
  * @param string urlPath - e.g.: /task/complete - see top of plancake.ajax.js file
  * @param string data to transmit - e.g.:  type=list&extraParam=3
  * @param string successMessage - the message to display if the request is OK
		  If the message is an empty string, it doesn't show any notification to user
  * @param callback-function successCallback (optional) - this function could
  *        receive a parameter that is the reply from the server
  */
PLANCAKE.localApi = function(urlPath, data, successMessage, successCallback) {
    var result = null;
    var params = PLANCAKE.getHashParams(data);
   
    switch (urlPath) {
        case PLANCAKE.AJAX_URL_INIT_DATA:
            result = PLANCAKE.localApi_getStartupData(params);
            break;
        case PLANCAKE.AJAX_URL_UPDATE_TASK_COUNTERS:
            result = PLANCAKE.localApi_getTaskCounters(params);
            break;
        case PLANCAKE.AJAX_URL_GET_TASKS:
            result = PLANCAKE.localApi_getTasks(params);
            break;
        case PLANCAKE.AJAX_URL_ADD_TASK:
            result = PLANCAKE.localApi_addTaskLocally(params);
            break;            
        case PLANCAKE.AJAX_URL_COMPLETE_TASKS:
            result = PLANCAKE.localApi_markTaskAsDone(params);
            break;
        case PLANCAKE.AJAX_URL_UNCOMPLETE_TASKS:
            result = PLANCAKE.localApi_markTaskAsTodo(params);
            break;
        case PLANCAKE.AJAX_URL_STAR_TASKS:
            result = PLANCAKE.localApi_starTask(params);
            break;            
    }
    
    if ( (typeof(result) == 'string') && (result.indexOf('ERROR:') == 0) ) {
        PLANCAKE.notifyAjaxError(result);
    } else {
        PLANCAKE.notifyAjaxSuccess(successMessage);
    }
    
    if (successCallback != null)
    {
        successCallback(result);
    }    
};

PLANCAKE.localApi_getStartupData = function(params) {
    return JSON.parse(localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA));
};

PLANCAKE.localApi_getTaskCounters = function(params) {
    var inboxListId = $('ul#lists li.inbox').plancake().getId();

    var tasksInInboxCount = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
                     .equals("listId", parseInt(inboxListId))
                     .equals("isCompleted", 0)                   
                     .count();
                     
    var tasksForTodayCount = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
                     .beforeEqualDate("dueDate", date('Y-m-d', strtotime('today')))
                     .equals("isCompleted", 0)
                     .count();    
                     
    var counters = {
        'counters': {
            inboxCounter: tasksInInboxCount,
            todayCounter: tasksForTodayCount
        }
    };

    return counters;
};

/**
 * N.B.: it doesn't save the changes to the datastore
 *
 * @param int taskId
 * @param Object tasksDatastore (=null) - the object returned by localStorage.getItem
 * @return Object - the tasksDatastore after the modification
 *
 */
PLANCAKE.localApi_deleteTask = function(taskId, tasksDatastore) {
   if ( (tasksDatastore === null) || (tasksDatastore === undefined) ) {
       tasksDatastore = PLANCAKE.localApi_getTasksDatastore();
   }

   var tasksCount = tasksDatastore.length;
   var i = 0,
       t = null;
   
   for (i = 0; i < tasksCount; i++) {
       t = tasksDatastore[i];
       if (t.id == taskId) {
           tasksDatastore.remove(i);
           break;
       }
   }
   
   return tasksDatastore;
}

/**
 * N.B.: it doesn't save the changes to the datastore
 * 
 * This method automatically detects whether the task is to update in the localStorage (in the case it already exists)
 * or to add
 * 
 * @param int taskId
 * @param Object tasksDatastore (=null) - the object returned by localStorage.getItem
 * @return Object - the tasksDatastore after the modification
 *
 */
PLANCAKE.localApi_addOrEditTask = function(task, tasksDatastore) {
   if ( (tasksDatastore === null) || (tasksDatastore === undefined) ) {
       tasksDatastore = PLANCAKE.localApi_getTasksDatastore();
   }
   
   // First we delete the old task...(if exists)
   PLANCAKE.localApi_deleteTask(task.id, tasksDatastore);
   // ...and then we add the new one
   tasksDatastore.push(task);
   
   return tasksDatastore;    
}

PLANCAKE.localApi_addTaskLocally = function (params) {
   task = PLANCAKE.localApi_getTaskFromUrlParams(params);
   var taskId = PLANCAKE.localApi_getNextTaskId();
   task.id = taskId;
   task.isLocal = 1;

   PLANCAKE.localApi_setTasksDatastore(PLANCAKE.localApi_addOrEditTask(task));
}

PLANCAKE.localApi_markTaskAsDone = function (params) {
   var taskId = params['taskId'];
   
   task = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
          .equals("id", parseInt(taskId))
          .select()[0];    

   task.isCompleted = 1;
   task.hasLocalModifications = 1;

   PLANCAKE.localApi_setTasksDatastore(PLANCAKE.localApi_addOrEditTask(task));
}

PLANCAKE.localApi_markTaskAsTodo = function (params) {
   var taskId = params['taskId'];
   
   task = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
          .equals("id", parseInt(taskId))
          .select()[0];    

   task.isCompleted = 0;
   task.hasLocalModifications = 0;    // we are rolling back to the stage before modification

   PLANCAKE.localApi_setTasksDatastore(PLANCAKE.localApi_addOrEditTask(task));
}

PLANCAKE.localApi_starTask = function (params) {
   var taskId = params['taskId'];
   
   task = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
          .equals("id", parseInt(taskId))
          .select()[0];    

   if (task.isStarred) {
       task.isStarred = 0;
   } else {
       task.isStarred = 1;       
   }

   task.hasLocalModifications = 1;

   PLANCAKE.localApi_setTasksDatastore(PLANCAKE.localApi_addOrEditTask(task));
}

PLANCAKE.localApi_getTasks = function(params) {
    var done = parseInt(params.done);
    var type = params.type;
    var extraParam = params.extraParam;
    var tasks = null;

    if (done) { // not implemented yet
        tasks = null;
    } else {
        switch (type) {
            case PLANCAKE.CONTENT_TYPE_LIST:
                tasks = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
                         .equals("listId", parseInt(extraParam))  
                         .sort("-sortOrder")
                         .select();                
            break;
            
            case PLANCAKE.CONTENT_TYPE_TAG:
                 tasks = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
                         .containsCSV("tags", parseInt(extraParam))                        
                         .sort("-sortOrder")                         
                         .select();                    
            break;
            
            case PLANCAKE.CONTENT_TYPE_TODAY:
                 tasks = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
                         .beforeEqualDate("dueDate", date('Y-m-d', strtotime('tomorrow')))                      
                         .sort("dueDate", "dueTime")
                         .select();                
            break;
                
            case PLANCAKE.CONTENT_TYPE_CALENDAR:
                var inputDate = extraParam.trim(),
                    tmpDate = inputDate,
                    scheduledTasksCount = 0,
                    i = 0, j = 0,
                    scheduledTasks = null,
                    scheduledTask = null,
                    tmpTask = null;   
                    
                if ( (inputDate === null) || ((inputDate.length) <= 0) ) {
                    tasks = null;
                }
   
                scheduledTasks = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
                         .hasValue("dueDate")                         
                         .sort("dueTime")
                         .select();

                tasks = [];
                
                scheduledTasksCount = scheduledTasks.length;
                
                if (scheduledTasksCount > 0) {
                    for(i = 0; i < PLANCAKE.numberOfDaysOnCalendar; i++) {
                        for(j = 0; j < scheduledTasksCount; j++)
                        {
                            scheduledTask = scheduledTasks[j];
                            if (PLANCAKE.localAPi_isTaskOnThisDay(scheduledTask, tmpDate)) {
                                tmpTask = jQuery.extend(true, {}, scheduledTask); // deep copy
                                tmpTask.extra = date('D', strtotime(tmpDate));                
                                tasks.push(tmpTask);
                                tmpTask = null;
                            }
                        }

                        tmpDate = date('Y-m-d', strtotime("+1 day", strtotime(tmpDate)));
                    }
                }
                
            break;
                
            case PLANCAKE.CONTENT_TYPE_STARRED:
                tasks = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
                         .equals("isStarred", 1)                         
                         .sort("-sortOrder")
                         .select();                
            break;
                
            case PLANCAKE.CONTENT_TYPE_SEARCH: // not yet implemented
                tasks = null;
            break;
                
        }
    }
    
    return {
        'tasks': tasks
    }
};

/**
 * Used by the sync method and quite customised on that
 * 
 * Returns both tasks that are either modified locally or created locally -
 * it doesn't return those both created and modified locally because those were 
 * created and completed locally, thus no use to send them to the server
 */
PLANCAKE.localApi_getTasksFromLocalStorageToSync = function(params) {

    var tasks = PLANCAKE.localApi_getTasksDatastore();  
    var task = null;
    var tasksCounter = tasks.length;
    var tasksFromLocalStorage = [];
    
    // It is not ideal to fill another array (filteredTasks) but jlinq
    // wasn't powerful enough to perform this query
    for (var i = 0; i < tasksCounter; i++) {
        task = tasks[i];
        
        if ( (task.hasLocalModifications == 1) || (task.isLocal == 1) ) {
            if ( (task.hasLocalModifications == 1) && (task.isLocal == 1) ) {
                // if it is both I am not interested, because that was a task
                // that was created and completed locally 
            } else {
                if (task.isLocal) {
                    // if the task is local, no need to send the local id - even 
                    // better, we reset it (as there could be a live task with that id)
                    //  so we are sure nothing bad is going to 
                    // happen with live tasks in the case we mess things up
                    task.id = 0; 
                }
                tasksFromLocalStorage.push(task);
            }
        }
    } 

    return {
        'tasks': tasksFromLocalStorage
    }    
}

PLANCAKE.localApi_removeLocalTasks = function() {
    var tasks = PLANCAKE.localApi_getTasksDatastore();  
    var task = null;
    var tasksCounter = tasks.length;
    var filteredTasks = [];
    
    // It is not ideal to fill another array (filteredTasks) - we tried to use
    // the 'remove' method (see file array.js) but that was creating problems
    // as the array we looped through would change while looping
    for (var i = 0; i < tasksCounter; i++) {
        task = tasks[i];
        
        if (task) {
            if( (task.hasLocalModifications != 1) && (task.isLocal != 1) ) {
                filteredTasks.push(task);
            }
        }
    }
    
    PLANCAKE.localApi_setTasksDatastore(filteredTasks);
    
    delete tasks;    
}