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
 * Keeps all the records whose field (usually a date) is before or Equal the data passed as input
 * 
 * both the parameter 'date' and the field must be in the format: yyyy-mm-dd
 */
jlinq.extend({
    name:"beforeEqualDate",
    type:jlinq.command.query,
    method:function(date) {
        return  (this.value.length > 0) &&
            (this.value.replace('-', '') <= date.replace('-', ''));
    }
});


/**
 * Given a record field containing CSV values, it keeps the records containing the search value passed as input
 * 
 */
jlinq.extend({
    name:"containsCSV",
    type:jlinq.command.query,
    method:function(searchValue) {
        var values = this.value.split(',');
        for (key in values) {
            if (values[key] == searchValue) {
                return true;
            }
        }
        return false;
    }
});


jlinq.extend({
    name:"hasValue",
    type:jlinq.command.query,
    method:function() {
        return ( (this.value !== null) && (this.value.length > 0) );
    }
});