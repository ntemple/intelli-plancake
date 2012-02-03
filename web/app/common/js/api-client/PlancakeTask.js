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

/*global PLANCAKE */
/*jslint white: true, devel: true, onevar: false, browser: true, undef: true, nomen: true, regexp: true, plusplus: true, bitwise: true, newcap: true, safe: false, maxerr: 50, indent: 4 */

var PLANCAKE = PLANCAKE || {};

PLANCAKE.TASK_DUE_DATE_LABEL_OVERDUE = "overdue";
PLANCAKE.TASK_DUE_DATE_LABEL_TODAY = "today";
PLANCAKE.TASK_DUE_DATE_LABEL_TOMORROW = "tomorrow";

PLANCAKE.Task = function () {
    this.id = null;    
    this.description = null;
    this.listId = null;
    this.isStarred = false;
    this.isHeader = false;
    this.isFromSystem = false;
    this.isCompleted = false;    
    this.dueDate = null; // in the yyyy-mm-dd format
    this.dueTime = null; // in the (H)Hmm 24h format (i.e.: 915, 1913)
    this.repetitionId = null;
    this.repetitionParam = null;
    this.repetitionIcalRrule = null;
    this.note = '';
    this.extra = '';
    this.tagIds = null; // comma-separated
    this.sortOrder = null;
    this.completedAt = null;    
    this.createdAt = null;
    this.updatedAt = null;
    this.hasLocalModifications = false;
    this.isLocal = false; // just added on the client but not existing on the server
    
    /**
     * @param object task - a simple associative array
     * @return PLANCAKE.Task
     **/
    this.init = function (task) {
        if (! task) {
            return this;
        }
        
        if (task.id) {
            this.id = parseInt(task.id);
        }

        if (task.description) {
            this.description = task.description;
        }
        
        if (task.listId) {
            this.listId = parseInt(task.listId);
        }
        
        if (task.isStarred) {
            this.isStarred = true;
        }
        
        if (task.isHeader) {
            this.isHeader = true;
        }
        
        if (task.isFromSystem) {
            this.isFromSystem = true;
        }
        
        if (task.isCompleted) {
            this.isCompleted = true;
        }
        
        if (task.hasLocalModifications) {
            this.hasLocalModifications = true;
        }        
        
        if (task.isLocal) {
            this.isLocal = true;
        }        
        
        if ( (task.dueDate !== undefined) && (task.dueDate !== null) ) {
            this.dueDate = task.dueDate;
        }
        
        if ( (task.dueTime !== undefined) && (task.dueTime !== null) ) {
            this.dueTime = task.dueTime;
        }

        if ( task.repetitionId && (task.repetitionId > 0) ) {
            this.repetitionId = parseInt(task.repetitionId);
        }

        if ( task.repetitionParam && (task.repetitionParam > 0) ) {
            this.repetitionParam = parseInt(task.repetitionParam);
        }

        if ( task.repetitionIcalRrule ) {
            this.repetitionIcalRrule = task.repetitionIcalRrule;
        }

        if ( task.note && (task.note.length > 0) ) {
            this.note = task.note;
        }

        if ( task.extra && (task.extra.length > 0) ) {
            this.extra = task.extra;
        }
        
        if ( task.tagIds && (task.tagIds.length > 0) ) {
            this.tagIds = task.tagIds;
        }

        if ( task.sortOrder && (task.sortOrder > 0) ) {
            this.sortOrder = parseInt(task.sortOrder);
        }        

        if ( task.completedAt && (task.completedAt > 0) ) {
            this.completedAt = task.completedAt;
        }

        if ( task.createdAt && (task.createdAt > 0) ) {
            this.createdAt = task.createdAt;
        }
        
        if ( task.updatedAt && (task.updatedAt > 0) ) {
            this.updatedAt = task.updatedAt;
        }

        return this;
    }
    
    /**
     * Returns all values being either a string (potentially empty) or integers (0 and 1 rather than booleans)
     * See method getTasks of the PlancakeApiServer in the PHP code
     */
    this.turnIntoArrayOfStringsAndInts = function () {
      return {
        id: parseInt(this.id),    
        description: this.description,
        listId: parseInt(this.listId),
        isStarred: this.isStarred ? 1 : 0,
        isHeader: this.isHeader ? 1 : 0,
        isFromSystem: this.isFromSystem ? 1 : 0,
        isCompleted: this.isCompleted ? 1 : 0,    
        hasLocalModifications: this.hasLocalModifications ? 1 : 0,
        isLocal: this.isLocal ? 1 : 0,        
        dueDate: (this.dueDate !== null) ? this.dueDate : '',
        dueTime: (this.dueTime !== null) ? this.dueTime : '',
        repetitionId: (this.repetitionId !== null) ? parseInt(this.repetitionId) : 0,
        repetitionParam: (this.repetitionParam !== null) ? parseInt(this.repetitionParam) : 0,
        repetitionIcalRrule: (this.repetitionIcalRrule !== null) ? this.repetitionIcalRrule : '',
        note: (this.note !== null) ? this.note : '',
        extra: (this.extra !== null) ? this.extra : '',
        tags: (this.tags !== null) ? this.tags : '',
        sortOrder: (this.sortOrder !== null) ? parseInt(this.sortOrder) : 0,
        completedAt: this.completedAt,    
        createdAt: this.createdAt,
        updatedAt: this.updatedAt
      };
    }    
    
    /**
     * @param int date (=null) - in the format yyyymmdd - in the case you want to force a due date
     * @return int
     */
    this.getSimpleTimestamp = function(date) {
        var ret = '';
        if ( (date !== null) && (date !== undefined) ) {
            ret = date;
        } else {
            if (! this.dueDate) {
                return null;
            }

            ret = (this.dueDate).replace(/-/gi, "");
        }
        
        ret += '';
        
        if ( (this.dueTime === null) || (this.dueTime === '') ) {
            ret += '0000';
        } else {
            ret += sprintf('%04d', parseInt(this.dueTime));
        }
        
        return ret;
    }
    
    /**
     * @param int tagId
     */
    this.addTag = function (tagId) {
     
        if (! this.tagIds) {
            this.tagIds = tagId;
        } else {
            this.tagIds += ',' + tagId;
            
            // removing duplicates
            var tagIdsCollection = this.tagIds.split(',');
            tagIdsCollection = $.unique(tagIdsCollection);
            this.tagIds = implode(',', tagIdsCollection);
        }     
    };
    
    /**
     * @param int tagId
     * @return boolean
     */
    this.hasTag = function (tagId) {
     
        if (! this.tagIds) {
            return false;
        } else {
            var tagIds = this.tagIds.split(',');
            
            if ($.inArray(tagId, tagIds) === -1) {
                return false;
            }
        }
        
        return true;
    };    

    /**
     * Returns one of three strings:
     * _ 'overdue'
     * _ 'today'
     * _ 'tomorrow'
     *
     * @return     string
     */
    this.getQuickDateLabel = function() {
        
        var taskDateString = this.dueDate,
            todayDate = Date.today(),
            tomorrowDate = Date.parse('tomorrow'),
            taskDateBits = [],
            taskDate = null;
        
        if (!taskDateString) {
            return null;
        }
        
        taskDateBits = taskDateString.split('-');
        
        taskDate = Date.today().set({
            year: parseInt(taskDateBits[0], 10),
            month: parseInt(taskDateBits[1], 10)-1,
            day:  parseInt(taskDateBits[2], 10)
        });
        
        if (taskDateString == todayDate.toString('yyyy-MM-dd')) {
            return PLANCAKE.TASK_DUE_DATE_LABEL_TODAY;
        } else if (taskDateString == tomorrowDate.toString('yyyy-MM-dd')) {
            return PLANCAKE.TASK_DUE_DATE_LABEL_TOMORROW;
        } else if (Date.compare(taskDate, todayDate) === -1) {
            return PLANCAKE.TASK_DUE_DATE_LABEL_OVERDUE;
        }
        
        return '';
    }
  
  /**
   * Returns whether or not the task is due today
   * N.B.: This doesn't take into account if the task is completed
   *
   * @return boolean
   */
  this.isDueToday = function() {
    return (this.getQuickDateLabel() === PLANCAKE.TASK_DUE_DATE_LABEL_TODAY);
  }

  /**
   * Returns whether or not the task is due tomorrow
   * N.B.: This doesn't take into account if the task is completed
   *
   * @return boolean
   */
  this.isDueTomorrow = function() {
    return (this.getQuickDateLabel() === PLANCAKE.TASK_DUE_DATE_LABEL_TOMORROW);
  }
  

  /**
   * Returns whether or not the task is overdue
   * N.B.: This doesn't take into account if the task is completed
   *
   * @return boolean
   */
  this.isOverdue = function() {
    return (this.getQuickDateLabel() === PLANCAKE.TASK_DUE_DATE_LABEL_OVERDUE);
  }
  
  
  /**
   * If possible, returns one of these strings (comparing today's date with the due date):
   * _ yesterday
   * _ today
   * _ tomorrow
   * _ the week-day corresponding to 'in2days, Wed' (i.e.: Wednesday)
   * _ the week-day corresponding to 'in3days, Thu'
   * _ the week-day corresponding to 'in4days, Fri'
   * _ the week-day corresponding to 'in5days, Sat'
   * If any of those is unapplicable, it returns getFormattedLocalDueDate()
   *
   * @return     string
   */
  this.getHumanFriendlyDueDate = function() {
      
    var quickDateLabel = this.getQuickDateLabel(); 
      
    var taskDateString = this.dueDate,
        taskDateBits = taskDateString.split('-'),
        taskDate = Date.today().set({
            year: parseInt(taskDateBits[0], 10),
            month: parseInt(taskDateBits[1], 10)-1,
            day:  parseInt(taskDateBits[2], 10)
        });      
      
    if (quickDateLabel === PLANCAKE.TASK_DUE_DATE_LABEL_TODAY) {
        return PLANCAKE.lang.ACCOUNT_MISC_TODAY;
    } else if (quickDateLabel === PLANCAKE.TASK_DUE_DATE_LABEL_TOMORROW) {
        return PLANCAKE.lang.ACCOUNT_MISC_TOMORROW;        
    } else if (quickDateLabel === PLANCAKE.TASK_DUE_DATE_LABEL_OVERDUE) {
        var yesterdayDate = Date.parse('yesterday');

        if (taskDateString == yesterdayDate.toString('yyyy-MM-dd')) {
            return PLANCAKE.lang.ACCOUNT_MISC_YESTERDAY;
        }
    } else if (Date.compare(taskDate, Date.parse('tomorrow')) > 0 ) { // here we check whether the due date is in few days
        
	var localizedWeekDays = {'Mon': PLANCAKE.lang.ACCOUNT_DOW_MON,
                                 'Tue': PLANCAKE.lang.ACCOUNT_DOW_TUE,
                                 'Wed': PLANCAKE.lang.ACCOUNT_DOW_WED,
                                 'Thu': PLANCAKE.lang.ACCOUNT_DOW_THU,
                                 'Fri': PLANCAKE.lang.ACCOUNT_DOW_FRI,
                                 'Sat': PLANCAKE.lang.ACCOUNT_DOW_SAT,
                                 'Sun': PLANCAKE.lang.ACCOUNT_DOW_SUN};
                             
        for (var i = 2; i <= 6; i++) {
            if (taskDate.compareTo(Date.today().addDays(i)) === 0) {
                return sprintf(PLANCAKE.lang.ACCOUNT_MISC_IN_X_DAYS, i) + 
                    ', ' + localizedWeekDays[taskDate.toString('ddd')];
            }
        }
    }
   
   return PLANCAKE.formatDateForUser(this.dueDate);
  }    
    
};