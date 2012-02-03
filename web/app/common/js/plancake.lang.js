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
    (function() {
        var langKey = '';
        $('.lang').each(function() {
           // the elements I am interested in have a class string like this:
           // lang lang_ACCOUNT_MAIN_CONTENT_ADD_TASK_OPTIONS_LINK
           // then I need to split and slice
           langKey = $(this).attr('class').split(' ').slice(-1).toString().replace('lang_', '');
           $(this).html(PLANCAKE.lang[langKey]);
        });
    })();
});