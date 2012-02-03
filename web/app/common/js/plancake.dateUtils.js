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
 * @param string dueDate - in the original format, can be also a shortcut, such as 'tomorrow'
 * @param string originalFormat - in PHP date format - Valid formats:  m-d-Y, d-m-Y or Y-m-d
 * @param string targetFormat - in PHP date format - Valid formats:  m-d-Y, d-m-Y or Y-m-d
 * @return string dueDate in the PHP date format Y-m-d (if a shortcut is provided, a shortcut is returned)
 */
PLANCAKE.formatDate = function(date, originalFormat, targetFormat) {
    if (! date) {
        return '';
    }
    
    var regExp = originalFormat.replace('d', '(\\d\\d)').
                                replace('m', '(\\d\\d)').
                                replace('Y', '(\\d\\d\\d\\d)');
                         
    regExp = new RegExp(regExp, 'i');
    var dateParts = regExp.exec(date);
    
    if (! dateParts) { // the input is a shortcut
        return date;
    }
    
    var originalFormatParts = originalFormat.split('-');
    
    var mapping = {};
    
    mapping[originalFormatParts[0]] = dateParts[1];
    mapping[originalFormatParts[1]] = dateParts[2];
    mapping[originalFormatParts[2]] = dateParts[3];
    
    var targetFormatParts = targetFormat.split('-');    
    
    return (mapping[targetFormatParts[0]] + '-' + mapping[targetFormatParts[1]] + '-' + mapping[targetFormatParts[2]]);
}

/**
 * @param string date - in the original format, can be also a shortcut, such as 'tomorrow'
 * @param string originalFormat - in PHP date format - Valid formats:  m-d-Y, d-m-Y or Y-m-d
 * @return string date in the PHP date format Y-m-d (if a shortcut is provided, a shortcut is returned)
 */
PLANCAKE.normalizeDate = function(date, originalFormat) {
    return PLANCAKE.formatDate(date, originalFormat, 'Y-m-d');
}

/**
 * @param string date - in the format Y-m-d (from PHP date())
 * @return string 
 */
PLANCAKE.formatDateForUser = function(date) {
    return PLANCAKE.formatDate(date, 'Y-m-d', PLANCAKE.userSettings.dateFormat);
}


/**
 * @param string time - in the (H)Hmm 24h format (i.e.: 915, 1913)
 * @return string 
 */
PLANCAKE.formatTimeForUser = function(time) {
    var hours = Math.floor(parseInt(time)/100),
        minutes = parseInt(time)%100,
        formattedTime = '',
        amPm = '';
       
    if (PLANCAKE.userSettings.timeFormat) {  // i.e.: 17:00
        formattedTime = sprintf('%02d', hours) + ':' + sprintf('%02d', minutes);
    } else { // i.e.: 5:00pm
        if ((hours >=0) && (hours <=11)) {
            amPm = 'am';
        } else {
            amPm = 'pm';
            hours = hours - 12;            
        }
        if (hours === 0) {
            hours = 12;
        }        
        
        formattedTime = hours + ':' + sprintf('%02d', minutes) + amPm;
    }
    
    return formattedTime;
}


/**
 * @param PLANCAKE.Task task
 * @return string 
 */
PLANCAKE.formatRepetitionForUser = function(task) {
    var repetition = PLANCAKE.getRepetitionById(task.repetitionId),
        repetitionLabel = repetition.label,
        weekdaysSet = null,
        selectedWeekdays = [];
    
    if (repetition.special == 'selected_wkdays') {
        repetitionLabel = PLANCAKE.lang.ACCOUNT_DOW_ON_PREPOSITION + ' ';
        
        weekdaysSet = PLANCAKE.fromIntegerToWeekdaysSetForRepetition(task.repetitionParam);

        for (var i in weekdaysSet) {
            if (weekdaysSet[i] === true) {
                selectedWeekdays.push(PLANCAKE.fromAbbreviationToWeekday(i));
            }
        }

        repetitionLabel += implode(',', selectedWeekdays);
    } else {
        if (task.repetitionParam > 0) {
            repetitionLabel = repetitionLabel.replace(PLANCAKE.lang.ACCOUNT_TASK_REPETITION_SELECT_LATER, task.repetitionParam);
        }       
    }
    return repetitionLabel;
}


  /**
   *
   * @param string weekdayAbbreviation - i.e.: sun, mon
   * @return string - i.e. Sunday, Monday
   */
PLANCAKE.fromAbbreviationToWeekday = function (weekdayAbbreviation) {
    weekdayAbbreviation =  (weekdayAbbreviation + '').toLowerCase();

    var weekdaysArray = [];
    weekdaysArray['sun'] = PLANCAKE.lang.ACCOUNT_DOW_SUNDAY;
    weekdaysArray['mon'] = PLANCAKE.lang.ACCOUNT_DOW_MONDAY;
    weekdaysArray['tue'] = PLANCAKE.lang.ACCOUNT_DOW_TUESDAY;
    weekdaysArray['wed'] = PLANCAKE.lang.ACCOUNT_DOW_WEDNESDAY;
    weekdaysArray['thu'] = PLANCAKE.lang.ACCOUNT_DOW_THURSDAY;
    weekdaysArray['fri'] = PLANCAKE.lang.ACCOUNT_DOW_FRIDAY;
    weekdaysArray['sat'] = PLANCAKE.lang.ACCOUNT_DOW_SATURDAY;

    return weekdaysArray[weekdayAbbreviation];
}
  
  
    /**
   * Useful for task repetitions in the case of some weekdays
   *
   * @param int repetitionParam
   * @return array associative array with keys 'sun', 'mon', 'tue', ... and boolean values
   */
PLANCAKE.fromIntegerToWeekdaysSetForRepetition = function(repetitionParam) {
        var binaryMask = parseInt(repetitionParam).toString(2),
        ret = [];       
        
    binaryMask = sprintf('%07s', binaryMask);  // i.e.: from 1001 to 0001001

    ret['sun'] = (binaryMask.charAt(0) == 1);  // rightmost digit
    ret['mon'] = (binaryMask.charAt(1) == 1);
    ret['tue'] = (binaryMask.charAt(2) == 1);
    ret['wed'] = (binaryMask.charAt(3) == 1);
    ret['thu'] = (binaryMask.charAt(4) == 1);
    ret['fri'] = (binaryMask.charAt(5) == 1);
    ret['sat'] = (binaryMask.charAt(6) == 1);  // leftmost digit
    
    return ret;
}


/**
 * @param int monthIndex - 1->January
 */
PLANCAKE.fromMonthIndexToString = function(monthIndex) {
    var monthLabels = [PLANCAKE.lang.ACCOUNT_MONTH_FULL_JAN, PLANCAKE.lang.ACCOUNT_MONTH_FULL_FEB,
                       PLANCAKE.lang.ACCOUNT_MONTH_FULL_MAR, PLANCAKE.lang.ACCOUNT_MONTH_FULL_APR,
                       PLANCAKE.lang.ACCOUNT_MONTH_FULL_MAY, PLANCAKE.lang.ACCOUNT_MONTH_FULL_JUN,
                       PLANCAKE.lang.ACCOUNT_MONTH_FULL_JUL, PLANCAKE.lang.ACCOUNT_MONTH_FULL_AUG,
                       PLANCAKE.lang.ACCOUNT_MONTH_FULL_SEP, PLANCAKE.lang.ACCOUNT_MONTH_FULL_OCT,
                       PLANCAKE.lang.ACCOUNT_MONTH_FULL_NOV, PLANCAKE.lang.ACCOUNT_MONTH_FULL_DEC];
                   
    return monthLabels[(monthIndex-1)];               
}