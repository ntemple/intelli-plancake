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

$(document).ready(function () {
    $('select.taskOptionRepetitions').change(function () {
        var value = $(this).val(),
            paramWrapper = $(this).parent().find('.taskOptionRepetitionParamsWrapper');
            
        if (parseInt(value) > 0) {
            PLANCAKE.setRepetitionParamOptions(paramWrapper, value);
            paramWrapper.show();
        } else {
            paramWrapper.hide();
        }
    });    
});

/**
 * @param JQuery paramOptionsWrapper
 * @param int repetitionId
 * @param int repetitionParam (=null)
 */
PLANCAKE.setRepetitionParamOptions = function (paramOptionsWrapper, repetitionId, repetitionParam) {
    var options = PLANCAKE.generateRepetitionParamOptions(repetitionId, repetitionParam);
    paramOptionsWrapper.html(options);
    
    if (! options) {
        paramOptionsWrapper.hide();
    }
}

/**
 * @param int repetitionId
 * @param int repetitionParam (=null) 
 * @return string - HTML fragment
 */
PLANCAKE.generateRepetitionParamOptions = function (repetitionId, repetitionParam) {
    
    var uniqueId = 0;
    if ( typeof PLANCAKE.generateRepetitionParamOptions.counter == 'undefined' ) {
        // It has not... perform the initilization
        PLANCAKE.generateRepetitionParamOptions.counter = 0;
    }
    uniqueId = PLANCAKE.generateRepetitionParamOptions.counter;
    PLANCAKE.generateRepetitionParamOptions.counter++;
    
    var repetitionOption = PLANCAKE.getRepetitionById(repetitionId);
    
    var min = 0,
        max = 0,
        tag = '',
        html = '',
        labelForSunday = '',
        idPrefix = '',
        i = 0,
        repetitionSet = null,
        repetitionSetMon = null,
        repetitionSetTue = null,
        repetitionSetWed = null,
        repetitionSetThu = null,
        repetitionSetFri = null,
        repetitionSetSat = null,
        repetitionSetSun = null;
        
    
    if (! repetitionOption['needs_param']) {
        return '';
    } else {
        if (repetitionOption['special'] == 'selected_wkdays') { // special case
            tag = '';
            idPrefix = 'rep_' + uniqueId + '_';
            
            repetitionSet = PLANCAKE.fromIntegerToWeekdaysSetForRepetition(repetitionParam);
            
            repetitionSetMon = repetitionSet['mon'] ? ' checked="checked" ' : '';
            repetitionSetTue = repetitionSet['tue'] ? ' checked="checked" ' : '';
            repetitionSetWed = repetitionSet['wed'] ? ' checked="checked" ' : '';
            repetitionSetThu = repetitionSet['thu'] ? ' checked="checked" ' : '';
            repetitionSetFri = repetitionSet['fri'] ? ' checked="checked" ' : '';
            repetitionSetSat = repetitionSet['sat'] ? ' checked="checked" ' : '';
            repetitionSetSun = repetitionSet['sun'] ? ' checked="checked" ' : '';            
            
            labelForSunday = '<input type="checkbox"' + repetitionSetSun + ' id="' + idPrefix + 'sun" class="rep_sun" name="weekdaysForRepetition" value="sun"><label for="' + idPrefix + 'sun">' + PLANCAKE.lang.ACCOUNT_DOW_SUN + '</label>';
            
            if (! PLANCAKE.userSettings.weekStart) {
                tag += labelForSunday;
            }            

            tag += '<input type="checkbox"' + repetitionSetMon + ' id="' + idPrefix + 'mon" class="rep_mon" name="weekdaysForRepetition" value="mon"><label for="' + idPrefix + 'mon">' + PLANCAKE.lang.ACCOUNT_DOW_MON + '</label>&nbsp;&nbsp;';
            tag += '<input type="checkbox"' + repetitionSetTue + ' id="' + idPrefix + 'tue" class="rep_tue" name="weekdaysForRepetition" value="tue"><label for="' + idPrefix + 'tue">' + PLANCAKE.lang.ACCOUNT_DOW_TUE + '</label>&nbsp;&nbsp;';
            tag += '<input type="checkbox"' + repetitionSetWed + ' id="' + idPrefix + 'wed" class="rep_wed" name="weekdaysForRepetition" value="wed"><label for="' + idPrefix + 'wed">' + PLANCAKE.lang.ACCOUNT_DOW_WED + '</label>&nbsp;&nbsp;';
            tag += '<input type="checkbox"' + repetitionSetThu + ' id="' + idPrefix + 'thu" class="rep_thu" name="weekdaysForRepetition" value="thu"><label for="' + idPrefix + 'thu">' + PLANCAKE.lang.ACCOUNT_DOW_THU + '</label>&nbsp;&nbsp;';
            tag += '<input type="checkbox"' + repetitionSetFri + ' id="' + idPrefix + 'fri" class="rep_fri" name="weekdaysForRepetition" value="fri"><label for="' + idPrefix + 'fri">' + PLANCAKE.lang.ACCOUNT_DOW_FRI + '</label>&nbsp;&nbsp;';
            tag += '<input type="checkbox"' + repetitionSetSat + ' id="' + idPrefix + 'sat" class="rep_sat" name="weekdaysForRepetition" value="sat"><label for="' + idPrefix + 'sat">' + PLANCAKE.lang.ACCOUNT_DOW_SAT + '</label>&nbsp;&nbsp;';
            
            if (PLANCAKE.userSettings.weekStart) {
                tag += labelForSunday;
            }
            html = tag;            
        } else { // normal case
            min = repetitionOption['min_param'];
            max = repetitionOption['max_param'];
            tag = '<select name="taskOptionRepetitionParams" class="taskOptionRepetitionParams">';

            var selected = '';
            for (i = min; i <= max; i++) {
              selected = '';

              if ((repetitionParam !== null) && (repetitionParam !== undefined) && (repetitionParam == i)) {
                selected = ' selected="selected" ';
              }

              label = repetitionOption['is_param_cardinal'] ? i : PLANCAKE.getOrdinalFromCardinal(i);
              tag += '<option value="' + i + '"' + selected + '>' + label + '</option>';
            }

            tag += "</select>";

            html = repetitionOption['label'].replace(PLANCAKE.lang.ACCOUNT_TASK_REPETITION_SELECT_LATER, tag);  
        }
        
        return html;
    }
}

/**
 * @param int repetitionId
 * @return Object
 */
PLANCAKE.getRepetitionById = function (repetitionId) {
    var repetitionOption = null;
    var repetitionOptionsCounter = PLANCAKE.repetitionOptions.length;

    for (i = 0; i < repetitionOptionsCounter; i++) {
        repetitionOption = PLANCAKE.repetitionOptions[i];
        if (parseInt(repetitionOption.id) === parseInt(repetitionId)) {
            return repetitionOption;
        }
    }
}

/**
 * @param JQuery wrapper
 * @return Object
 */
PLANCAKE.getRepetitionParamForSelectedWeekdaysFromForm = function (wrapper) {        
    var sun = wrapper.find('.rep_sun').is(":checked");
    var mon = wrapper.find('.rep_mon').is(":checked");
    var tue = wrapper.find('.rep_tue').is(":checked");
    var wed = wrapper.find('.rep_wed').is(":checked");
    var thu = wrapper.find('.rep_thu').is(":checked");    
    var fri = wrapper.find('.rep_fri').is(":checked");
    var sat = wrapper.find('.rep_sat').is(":checked");

    var binaryMask = sun ? '1' : '0';
    binaryMask += mon ? '1' : '0';
    binaryMask += tue ? '1' : '0';
    binaryMask += wed ? '1' : '0';
    binaryMask += thu ? '1' : '0';
    binaryMask += fri ? '1' : '0';
    binaryMask += sat ? '1' : '0';
    
    return parseInt(parseInt(binaryMask, 2).toString(10), 10);
}