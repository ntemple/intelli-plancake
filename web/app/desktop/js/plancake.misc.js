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

PLANCAKE.dialogUpdateTips = function (tips, t ) {
        tips
                .text( t )
                .addClass( "ui-state-highlight" );
        setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
}

PLANCAKE.dialogCheckLength = function (tips, o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
                o.addClass("ui-state-error");
                PLANCAKE.dialogUpdateTips(tips, sprinf(ACCOUNT_ERROR_FIELD_LENGTH_ERROR, n, min, max));
                return false;
        } else {
                return true;
        }
}

PLANCAKE.dialogCheckRegexp = function (tips, o, regexp, n ) {
        if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                PLANCAKE.dialogUpdateTips(tips, n );
                return false;
        } else {
                return true;
        }
}

PLANCAKE.getQtipStyleObject = function () {
    return {
          width: 400,
          border: {
             width: 5,
             radius: 10
          },
          'text-align': 'left',
          padding: 10,
          textAlign: 'center',
          tip: true, // Give it a speech bubble tip with automatic corner detection
          name: 'blue' // Style it according to the preset 'cream' style
       };
}