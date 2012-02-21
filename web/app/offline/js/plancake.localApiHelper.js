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


PLANCAKE.localApi_getNextTaskId = function () {
    // We tried to use the jLinq max method for this purpose, but
    // that was causing problems on Blackberry
    
    var maxTaskId = jlinq.from(PLANCAKE.localApi_getTasksDatastore())
         .max('id');
         
    if ( (maxTaskId === null) || (maxTaskId === undefined) ) { // there are no tasks yet
        maxTaskId = 1;        
    } else if (typeof maxTaskId == "object") { // needed for some JS engine - probably Blackberry.
                                               // For other engine, maxTaskId is alread a number
        maxTaskId = maxTaskId.id;
    }      
         
    maxTaskId = parseInt(maxTaskId);         
         
    return (maxTaskId+1);
}

/**
 * @param array params
 * @return array
 */
PLANCAKE.localApi_getTaskFromUrlParams = function (params) {
   var task = params;
   
   // some key adjustments
   task.description = task.content;
   delete(task.content);
   task.tagIds = task.contexts;
   delete(task.contexts);
   task.isStarred = parseInt(task.isStarred);
   task.isHeader = parseInt(task.isHeader);
   
   return (new PLANCAKE.Task()).init(task).turnIntoArrayOfStringsAndInts(); //this way we make sure it is well structure - e.g.: listId is integer and not string
    
}

PLANCAKE.localApi_getTasksDatastore = function () {
    if (localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS)) {
        return JSON.parse(localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS))['tasks'];
    } else {
        return [];
    }
};

/**
 * @param array tasks - array of tasks
 **/
PLANCAKE.localApi_setTasksDatastore = function (tasks) {
    localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS, JSON.stringify({'tasks': tasks}));
};

/**
 * The same methid is in the PHP code PcTask::isOnThisDay
 * 
 * @param task - just an associative array
 * @param day - in the yyyy-mm-dd format
 */
PLANCAKE.localAPi_isTaskOnThisDay = function(task, day) {
    
    if ( (day === null) || (day.length <= 0) ) 
    {
        return false;
    }

    var dayTimestamp = strtotime(day);
    var dayDowIndex = date('w', dayTimestamp); // 0 -> Sun ...... 6-> Sat

    var taskDueDate = task.dueDate;
    var taskDueDateTimestamp = strtotime(taskDueDate);
    var taskDueDateDowIndex = date('w', taskDueDateTimestamp); // 0 -> Sun ...... 6-> Sat

    var taskRepetitionId = task.repetitionId;
    var taskRepetitionParam = task.repetitionParam;

    var daysBetweenDayAndDueDate = Math.round((dayTimestamp - taskDueDateTimestamp) / 86400); // you would think you don't need to round up
    var weeksBetweenDayAndDueDate = Math.round(daysBetweenDayAndDueDate / 7); // you would think you don't need to round up
    var monthsBetweenDayAndDueDate = ((parseInt(date('Y', dayTimestamp)) - parseInt(date('Y', taskDueDateTimestamp))) * 12) + 
                    (parseInt(date('n', dayTimestamp)) - parseInt(date('n', taskDueDateTimestamp)));

    if (!taskDueDate) {         
        return false;
    }        

    // this is a repetiting task starting in the future, not on the current day
    if ( taskRepetitionId && (taskDueDateTimestamp > dayTimestamp) ) {
       return false;
    }        

    if (taskDueDate == day) {
        return true;
    }

    if (taskRepetitionId < 7) { // every Sun, every Mon, ... or every Sat            
        if ((taskRepetitionId-1) === dayDowIndex)
        {
            return true;
        }
    }        

    if (taskRepetitionId == 8) { // every day
        return true;
    }

    if (taskRepetitionId == 9) { // every weekday
        if ( (dayDowIndex > 0) && (dayDowIndex < 6) )  
        {
            return true;
        }
    }

    if ( (taskRepetitionId == 10) && taskRepetitionParam) { // every X days
        if ( !(Math.round(daysBetweenDayAndDueDate % taskRepetitionParam)) )  
        {
            return true;
        }
    }      

    if ( taskRepetitionId == 11 ) { // every week
        if ( dayDowIndex === taskDueDateDowIndex )  
        {
            return true;
        }
    }         

    if ( taskRepetitionId == 12 ) { // every X weeks
        if ( (dayDowIndex === taskDueDateDowIndex) &&
             !(Math.round(weeksBetweenDayAndDueDate % taskRepetitionParam)) )  
        {
            return true;
        }
    }        

    if ( taskRepetitionId == 13 ) { // every month on the due date day
        if ( date('d', taskDueDateTimestamp) === date('d', dayTimestamp) )  
        {
            return true;
        }
    }

    if ( taskRepetitionId == 14 ) { // every X months on the due date day
        if ( date('d', taskDueDateTimestamp) === date('d', dayTimestamp) &&
             !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) )  
        {
            return true;
        }
    }         

    if ( taskRepetitionId == 15 ) { // every year
        if ( (date('d', taskDueDateTimestamp) === date('d', dayTimestamp)) &&
             (date('n', taskDueDateTimestamp) === date('n', dayTimestamp)) )  
        {
            return true;
        }
    }

    if ( taskRepetitionId == 16 ) { // every X years
        if ( (date('d', taskDueDateTimestamp) === date('d', dayTimestamp)) &&
             (date('n', taskDueDateTimestamp) === date('n', dayTimestamp)) &&
             !(Math.round((date('Y', dayTimestamp) - date('Y', taskDueDateTimestamp)) % taskRepetitionParam)) )  
        {
            return true;
        }
    }

    if ( taskRepetitionId == 18 ) { // every [select later] month(s) on the last day
        if ( !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) &&
             (date('t', dayTimestamp) == date('d', dayTimestamp)) )  
        {
            return true;
        }
    }

    if ( taskRepetitionId == 19 ) { // every [select later] month(s) on the second last day
        if ( !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) &&
             ((date('t', dayTimestamp)-1) == date('d', dayTimestamp)) )  
        {
            return true;
        }
    }

    if ( (taskRepetitionId >= 20) && (taskRepetitionId <= 26) ) { // every X month(s) on the first Sun/Mon..../Sat
        if ( !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) &&  // correct "every X months"
             (dayDowIndex ==  (taskRepetitionId - 20)) &&  // correct dow
             (date('j', dayTimestamp) <= 7) ) // first week
        {
            return true;
        }            
    }

    if ( (taskRepetitionId >= 27) && (taskRepetitionId <= 33) ) { // every X month(s) on the last Sun/Mon..../Sat
        if ( !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) &&  // correct "every X months"
             (dayDowIndex ==  (taskRepetitionId - 27)) &&  // correct dow
             ( (date('j', dayTimestamp) > (date('t', dayTimestamp) -7)) ) ) // last week
        {
            return true;
        }             
    }        

    if ( taskRepetitionId == 34 ) { // repeat weekly on some weekdays
        var weekdaysSet = PLANCAKE.fromIntegerToWeekdaysSetForRepetition(taskRepetitionParam);
        var key = strtolower(date('D', dayTimestamp));
        if ( weekdaysSet[key] )
        {
            return true;
        }
    }

    if ( (taskRepetitionId >= 40) && (taskRepetitionId <= 46) ) { // every X month(s) on the second Sun/Mon..../Sat
        if ( !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) &&  // correct "every X months"
             (dayDowIndex ==  (taskRepetitionId - 40)) &&  // correct dow
             ( (date('j', dayTimestamp) > 7) && (date('j', dayTimestamp) <= 14)  ) ) // second week
        {
            return true;
        }            
    }

    if ( (taskRepetitionId >= 50) && (taskRepetitionId <= 56) ) { // every X month(s) on the third Sun/Mon..../Sat
        if ( !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) &&  // correct "every X months"
             (dayDowIndex ==  (taskRepetitionId - 50)) &&  // correct dow
             ( (date('j', dayTimestamp) > 14) && (date('j', dayTimestamp) <= 21)  ) ) // third week
        {
            return true;
        }            
    }

    if ( (taskRepetitionId >= 60) && (taskRepetitionId <= 66) ) { // every X month(s) on the fourth Sun/Mon..../Sat
        if ( !(Math.round(monthsBetweenDayAndDueDate % taskRepetitionParam)) &&  // correct "every X months"
             (dayDowIndex ==  (taskRepetitionId - 60)) &&  // correct dow
             ( (date('j', dayTimestamp) > 21) && (date('j', dayTimestamp) <= 28)  ) ) // second week
        {
            return true;
        }            
    }         

    return false;
};