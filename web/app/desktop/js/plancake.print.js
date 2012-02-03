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

    $('.printContentPanel').click(function() {
        
        if (PLANCAKE.userSettings.isPremium) {
            
            // we need to build the error message now, because it is not possible after the hack
            var printErrorMessage = sprintf(PLANCAKE.lang.ACCOUNT_ERROR_NEED_RELOAD_AFTER_PRINT, PLANCAKE.getAppUrl()); 
            
            if (PLANCAKE.isWebkit()) { // we had a problem on webkit browsers and this is the patch
                // basically it reads the entire DOM and then re-writes the whole document back into itself 
                var doct = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
                document.write(doct + document.getElementsByTagName('html')[0].innerHTML);
            }
            
            window.print();
            
            // the only problem with the hack above was that the application was not responsive anymore
            if (PLANCAKE.isWebkit()) {
                jAlert(printErrorMessage);        
            }
            
        } else {
            window.location.href = PLANCAKE.BASE_URL + '/upgrade?feature=print';            
        }
    })    
    .attr('title', PLANCAKE.lang.ACCOUNT_HINT_PRINTER_BTN);

});