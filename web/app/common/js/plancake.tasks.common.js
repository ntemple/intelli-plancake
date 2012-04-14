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

$(document).ready( function() {

});

/**
 * @param JQuery noteIcon
 * @param JQueryEvent e
 **/
PLANCAKE.toggleNote = function (noteIcon, e) {
    noteIcon.parents('li.task').find('.taskNote').toggle();
    e.stopPropagation();
}

/**
 * @param PLANCAKE.Task task
 * @param JQuery _activePanel (=null)
 * @return JQuery - li element
 */
PLANCAKE.getHtmlTaskObj = function(task, _activePanel) {
    var activePanel = _activePanel ? _activePanel : PLANCAKE.activePanel;
    var taskDescription = '',
        tagIds = null,
        tagsCounter = null,
        i = 0,
        tags = [],
        tagsString = '',
        displayInList = false,
        repetitionHtml = '';
        
    if (task.repetitionId) {
        repetitionHtml = '<span class="taskRepetitionString">' + PLANCAKE.formatRepetitionForUser(task) + '</span>' +
                         '<img src="/app/common/img/repetition_icon.gif" class="taskRepetition" title="' + PLANCAKE.formatRepetitionForUser(task) + '" />';

        if (! PLANCAKE.isMobile) {
            repetitionHtml += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        
    }
        
    var taskScheduleDetails =   '<div style="text-align: right" class="notForHeader taskScheduleDetails">' + 
                ( ((task.dueTime !== null) && task.dueTime.toString().length) ? '<span class="taskDueTime">@' + PLANCAKE.formatTimeForUser(task.dueTime) + '</span>' : '') +           
                ( ((task.dueDate !== null) && task.dueDate.length) ? '<span class="taskDueDate">' + task.getHumanFriendlyDueDate() + '</span>' : '') +
                ( PLANCAKE.isMobile ? '' : repetitionHtml) + // for the mobile version, we want to insert the repetitionHTML in another div
            '</div>';
    
    if (PLANCAKE.isMobile) {
        taskScheduleDetails += '<div class="repetitionInfoForMobile">' + repetitionHtml + '</div>';
    }
        
        
    var descrWrapper =            '<div class="descrWrapper">' + 
                '<span class="description">' + PLANCAKE.linkify(PLANCAKE.encodeEntities(task.description)) + '</span>' +
            '</div>' +

            '<div class="taskNote notForHeader">' + ( (task.note && task.note.length) ? PLANCAKE.linkify(PLANCAKE.nl2br(htmlspecialchars(task.note))) : '' )  + '</div>';    
        

    var taskHtml = $("<li class='task_" + task.id + " fromPanel_" + activePanel.attr('id') + "  task'>" +
            '<span class="simpleTimestamp hidden">' + task.getSimpleTimestamp() + '</span>' +
            '<div class="notForHeader doneWrapper"><input type="checkbox" name="markAsCompleted" class="markAsCompleted" />&nbsp;</div>' +
            '<div class="notForHeader starWrapper"><img class="star" src="/app/common/img/empty_star_micro.png" />&nbsp;</div>' +            

            (PLANCAKE.isMobile ? (descrWrapper + '<div class="descriptionAnchor"></div>') : taskScheduleDetails) +
            (PLANCAKE.isMobile ? taskScheduleDetails : descrWrapper) +
            
            '<a href="#" class="editTask taskAction">' + PLANCAKE.lang.ACCOUNT_MISC_EDIT + '</a>' +
            '<a href="#" class="addBelowTask taskAction">' + PLANCAKE.lang.ACCOUNT_MISC_ADD_BELOW + '</a>' +

    "</li>");

    taskDescription = taskHtml.find('.description');
    taskDescriptionAnchor = taskHtml.find('.descriptionAnchor');
    
    if (task.isHeader) {
        taskHtml.addClass('header');
        taskHtml.find('.notForHeader').hide();
    } else {
        taskHtml.find('.descrWrapper').addClass('leftIndent');        
    }
    
    if (task.isStarred) {
        taskHtml.plancake().star(true);
    }
    
    if ( (PLANCAKE.getActivePanelContentConfig(activePanel).type !== PLANCAKE.CONTENT_TYPE_LIST) &&
         (! task.isHeader) ) {
         displayInList = true;
    }    
    if ( (PLANCAKE.getActivePanelContentConfig().type === PLANCAKE.CONTENT_TYPE_LIST) &&
         (parseInt(PLANCAKE.getActivePanelContentConfig().extraParam) !== task.listId) ) {
         displayInList = true;
    }
    if (displayInList) {
        var listLinkInList = (PLANCAKE.isMobile) ? '<a href="#tasks-screen?type=list&id=' + task.listId + '">' : 
                                                   '<a class="listLinkInList llil_' + task.listId + '" href=".#">';
                                               
        var inList = '<span class="inList">&nbsp;| ' + PLANCAKE.lang.ACCOUNT_MISC_IN_LIST + ' ' + listLinkInList + 
                    $().plancake().getList(task.listId).plancake().getName() + '</a></span>';                                         
                               
        if (PLANCAKE.isMobile) {
            taskDescriptionAnchor.append(inList);
        } else {
            taskDescription.after(inList);
        }                
    }
    
    if((task.note && task.note.length)) {
        taskDescription.after('&nbsp;&nbsp;<img class="taskNoteIcon" title="' + PLANCAKE.lang.ACCOUNT_HINT_CLICK_TO_SEE_NOTE + '" alt="' + PLANCAKE.lang.ACCOUNT_HINT_CLICK_TO_SEE_NOTE + '" src="/app/common/img/note_icon.png" />');
    }
    
    if (!PLANCAKE.isMobile) { // we don't do it on mobike in order not to increase loading time and also because it is not really needed
        if((task.description + task.note).indexOf('mail.google.com/mail') >= 0) {
            var gmailRegExp = /http(s)?:\/\/mail.google.com\/mail[^ ]+/;
            try {
                var gmailUrl = (task.description + ' ' + task.note).replace(/(\n|\t)/, ' ').match(gmailRegExp)[0];
                taskDescription.after('&nbsp;&nbsp;<a class="taskGmailLink" target="_blank" href="' + gmailUrl + '"><img style="border: 0px" class="taskGmailIcon" title="' + PLANCAKE.lang.ACCOUNT_HINT_CLICK_TO_SEE_GMAIL + '" alt="' + PLANCAKE.lang.ACCOUNT_HINT_CLICK_TO_SEE_GMAIL + '" src="/app/common/img/gmail_icon.png" /></a>');
                if (task.note.trim().length === gmailUrl.length) { // the note contains only the link to GMail that we show via the Gmail icon, therefore
                    taskHtml.find('.taskNoteIcon').remove();       // no need to show note icon
                }
            } catch (e) {
                // nothing serious - just the match() call failed - no valid gmail link
            }
        } 
    }
    
    if(task.tagIds) {
        tagIds = task.tagIds.split(',');
        tagsCounter = tagIds.length;
        var tagLink = '';
                
        for(i = 0; i < tagsCounter; i++) {
            tagLink = (PLANCAKE.isMobile) ? '<a href="#tasks-screen&type=tag&id=' + tagIds[i] + '">' :
                                            '<a class="tagLinkInList tlil_' + tagIds[i] + '" href=".#">';
            tags.push( tagLink + 
                $().plancake().getTag(tagIds[i]).plancake().getName() + '</a>');           
        }
        tagsString = '&nbsp;<span class="taskTags">';
        tagsString += tags.join(', ');
        tagsString += '</span>';
        
        if (PLANCAKE.isMobile) {
            taskDescriptionAnchor.prepend(tagsString);
        } else {
            taskDescription.after(tagsString);
        }
    } 
    
    if (task.isFromSystem) {
        // taskDescription.before('<img title="message from the team" src="/app/desktop/img/fire_icon_small.png" />');
    }
    
    if ( (PLANCAKE.getActivePanelContentConfig(activePanel).type !== PLANCAKE.CONTENT_TYPE_LIST) ) {
        taskHtml.find('.addBelowTask').remove();
    }

    if (PLANCAKE.getActivePanelContentConfig(activePanel).type !== PLANCAKE.CONTENT_TYPE_CALENDAR) {
        if (task.isOverdue()) {
            taskHtml.addClass('overdue');
        } else if (task.isDueToday()) {
            taskHtml.addClass('dueToday');        
        } else if (task.isDueTomorrow()) {
            taskHtml.addClass('dueTomorrow');
        } else {
            taskHtml.removeClass('overdue today tomorrow');
        }
    } else {
        taskHtml.find('.taskDueDate').hide();
    }
    
    if ((task.dueDate !== null) && task.dueDate.length) {
        taskHtml.addClass('scheduled');
    }

    if ( (PLANCAKE.getActivePanelContentConfig(activePanel).type === PLANCAKE.CONTENT_TYPE_CALENDAR) && 
         (task.extra) ) {
        taskHtml.addClass('dow_' + task.extra.toLowerCase());
    }

    taskHtml.data(PLANCAKE.JQUERY_TASK_DATA_KEY, task);
    
    if (! PLANCAKE.isTaskToBeShownInActiveContent(task, PLANCAKE.getActivePanelContentConfig(activePanel))) {
        PLANCAKE.hideTaskInCurrentContent(taskHtml);
    }    
    
    if ( (PLANCAKE.getActivePanelContentConfig(activePanel).type === PLANCAKE.CONTENT_TYPE_LIST) ||
         (PLANCAKE.getActivePanelContentConfig(activePanel).type === PLANCAKE.CONTENT_TYPE_TODAY) ){
        // tasks need to have an id to serialize when we reorder them
        taskHtml.attr('id', 'task_' + activePanel.attr('id') + '_' + task.id);
    }
    
    if (task.isCompleted) {
        taskHtml.addClass('completed');
    }   
    
    if (task.hasLocalModifications) {
        taskHtml.addClass('hasLocalModifications');
    }
    
    if (task.isLocal) {
        taskHtml.addClass('isLocal');
    }    

    return taskHtml;    
}


/**
 * @param Plancake.Task task
 * @param JQuery activeContent
 * @return boolean
 */
PLANCAKE.isTaskToBeShownInActiveContent = function(task, activeContent) {
    var toBeShown = true;

    if ( (activeContent.type === PLANCAKE.CONTENT_TYPE_LIST) && (activeContent.extraParam != task.listId) ) {
        toBeShown = false;
    } else if ( (activeContent.type === PLANCAKE.CONTENT_TYPE_TAG) && (!task.hasTag(activeContent.extraParam)) ) {
        toBeShown = false;
    } else if ( (activeContent.type === PLANCAKE.CONTENT_TYPE_STARRED) && (!task.isStarred) ) {
        toBeShown = false;
    } else if ( (activeContent.type === PLANCAKE.CONTENT_TYPE_TODAY) && (!task.getQuickDateLabel()) ) {
        toBeShown = false;
    } else if ( (activeContent.type === PLANCAKE.CONTENT_TYPE_CALENDAR) && (!task.dueDate) ) {
        toBeShown = false;
    } 
    
    return toBeShown;
}


/**
 * see PLANCAKE.showHiddenTaskInCurrentContent 
 *
 * @param JQuery - li element
 */
PLANCAKE.hideTaskInCurrentContent = function (taskHtml) {
    taskHtml.fadeTo('fast', 0.4);    
}

/**
 * see PLANCAKE.hideTaskInCurrentContent
 *
 * @param JQuery - li element
 */
PLANCAKE.showHiddenTaskInCurrentContent = function (taskHtml) {
    taskHtml.fadeTo('fast', 1);    
}

PLANCAKE.getCalendarCurrentDateTs = function(activePanel) {
    var currentDate = PLANCAKE.getActivePanelContentConfig(activePanel).extraParam;      
    var currentDateParts = currentDate.match(/([0-9]{4})-([0-9]{2})-([0-9]{2})/);
    return strtotime(currentDateParts[2] + '/' + currentDateParts[1] + '/' + currentDateParts[3]);        
}

PLANCAKE.sendCalendarJumpToDateValue = function(dateText, inst) {
    var selectedDay = null;
    var selectedMonth = null;
    var selectedYear = null;
    
    if (PLANCAKE.isMobile) { // we use another datepicker for mobile app - in a way compatible with JQUery UI one    
        selectedDay = inst.values[1];
        selectedMonth = parseInt(inst.values[0]) + 1;
        selectedYear = inst.values[2];    
    } else {
        selectedDay = inst.selectedDay;
        selectedMonth = parseInt((inst.selectedMonth)) + 1;
        selectedYear = inst.selectedYear;        
    }

    var valToSend = selectedYear.toString(10) + '-' + 
        str_pad(selectedMonth.toString(10), 2, '0', 'STR_PAD_LEFT') + '-' + 
        str_pad(selectedDay.toString(10), 2, '0', 'STR_PAD_LEFT');

    PLANCAKE.loadContent({
        done: false, 
        type: PLANCAKE.CONTENT_TYPE_CALENDAR,
        extraParam: valToSend
    });               
    
    PLANCAKE.activePanel.find('input.calendarJumpDate').parent().find('.ui-datepicker').hide();
}

PLANCAKE.getDateFormatForDatePicker = function () {
    return PLANCAKE.userSettings.dateFormat.replace('d', 'dd').
        replace('m', 'mm').replace('Y', 'yy');
}

PLANCAKE.getDatePickerConfig = function () {
    var o = {
        constrainInput: false,
        showOn: 'both',
        buttonImage: '/app/desktop/img/calendar.gif',
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        dayNamesShort: [PLANCAKE.lang.ACCOUNT_DOW_SUN, PLANCAKE.lang.ACCOUNT_DOW_MON, PLANCAKE.lang.ACCOUNT_DOW_TUE, 
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
        dateFormat: PLANCAKE.getDateFormatForDatePicker(),
        onSelect: function(dateText, inst) {
            PLANCAKE.sendCalendarJumpToDateValue(dateText, inst);
        }    
    };
    
    if (PLANCAKE.isMobile) { // we use another datepicker for mobile app - in a way compatible with JQUery UI one
        delete o['constrainInput'];
        delete o['showOn'];        
        delete o['buttonImage'];
        delete o['buttonImageOnly'];
        delete o['changeMonth'];
        delete o['changeYear'];
        delete o['nextText']; 
        delete o['prevText'];        
        o['mode'] = 'clickpick';
        o['dateFormat'] = o['dateFormat'].replace('mm', 'M');
        o['cancelText'] = PLANCAKE.lang.ACCOUNT_MISC_CANCEL;
        o['setText'] = PLANCAKE.lang.ACCOUNT_MISC_SUBMIT;
        o['yearText'] = PLANCAKE.lang.ACCOUNT_MISC_YEAR;
        o['monthText'] = PLANCAKE.lang.ACCOUNT_MISC_MONTH;
        o['dayText'] = PLANCAKE.lang.ACCOUNT_MISC_DAY;
    }
    
    return o;
}

/*
 * @param JQuery link
 */
PLANCAKE.loadCalendarPrevMonth = function (link) {
    var calPanel = link.parents('.panel');
    PLANCAKE.loadContent({
        done: false, 
        type: PLANCAKE.CONTENT_TYPE_CALENDAR,
        extraParam: date('Y-m-d', strtotime("-1 month", PLANCAKE.getCalendarCurrentDateTs(calPanel)))
    }, calPanel);
    $('.calendarJumpDate').val('');    
}

/*
 * @param JQuery link
 */
PLANCAKE.loadCalendarNextMonth = function (link) {
        var calPanel = link.parents('.panel');        
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_CALENDAR,
            extraParam: date('Y-m-d', strtotime("+1 month", PLANCAKE.getCalendarCurrentDateTs(calPanel)))
        }, calPanel);
        $('.calendarJumpDate').val('');     
}

/*
 * @param JQuery link
 */
PLANCAKE.loadCalendarPrevWeek = function (link) {
        var calPanel = link.parents('.panel');        
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_CALENDAR,
            extraParam: date('Y-m-d', strtotime("-" + PLANCAKE.numberOfDaysOnCalendar + " days", PLANCAKE.getCalendarCurrentDateTs(calPanel)))
        }, calPanel);
        $('.calendarJumpDate').val('');        
}

/*
 * @param JQuery link
 */
PLANCAKE.loadCalendarNextWeek = function (link) {
        var calPanel = link.parents('.panel');        
        PLANCAKE.loadContent({
            done: false, 
            type: PLANCAKE.CONTENT_TYPE_CALENDAR,
            extraParam: date('Y-m-d', strtotime("+" + PLANCAKE.numberOfDaysOnCalendar + " days", PLANCAKE.getCalendarCurrentDateTs(calPanel)))
        }, calPanel);
        $('.calendarJumpDate').val('');              
}

/**
 * @param JQuery - li element
 * @return PLANCAKE.Task task
 */
PLANCAKE.getTaskObjFromHtml = function(taskHtml) {
    
    if ( (taskHtml === null) || (taskHtml === undefined) ) {
        return null;
    }
    
    var taskData = taskHtml.data(PLANCAKE.JQUERY_TASK_DATA_KEY);
    var task = new PLANCAKE.Task();

    for (var key in taskData) {
        if (taskData.hasOwnProperty(key)) {
            task[key] = taskData[key];
        }
    }

    return task;
}