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

    $('#searchQuery').click(function() {
        if ( $(this).attr('value') == PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_SEARCH_YOUR_TASKS ) {
            $(this).val('');
            $(this).removeClass('light');
        }
    });
    
    $('#searchForm').submit(function() {
        if (PLANCAKE.userSettings.isPremium) {
            var queryString = PLANCAKE.prepareForAjaxTransmission($('#searchForm #searchQuery').val());

            var contentConfig = {
                    done: false, 
                    type: PLANCAKE.CONTENT_TYPE_SEARCH, 
                    extraParam: queryString             
            }

            PLANCAKE.loadContent(contentConfig);
            $('#searchForm #searchQuery').val('');
        } else {
            window.location.href = PLANCAKE.BASE_URL + '/upgrade?feature=search';            
        }        
        
        return false;
    });
    
    $('#searchQuery').attr('value', PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_SEARCH_YOUR_TASKS);
    
    $('.searchWarning').html(sprintf(PLANCAKE.lang.ACCOUNT_MAIN_CONTENT_SEARCH_WARNING, 2));
});
