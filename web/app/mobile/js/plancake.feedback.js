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
    $().toastmessage({
        position: 'top-center'
    });
});

/**
 * @param string message
 * @param function closeCallback (=null)
 */
PLANCAKE.showToastError = function (message, closeCallback) {

    if (closeCallback === undefined) {
        closeCallback = null;
    }

    $().toastmessage('showToast', {
        text     : message,
        sticky   : false,
        close    : closeCallback,
        type     : 'error'
    });    
};

/**
 * @param string message
 * @param function closeCallback (=null)
 */
PLANCAKE.showToastSuccess = function (message, closeCallback) {

    if (closeCallback === undefined) {
        closeCallback = null;
    }
    
    $().toastmessage('showToast', {
        text     : message,
        sticky   : false,
        close    : closeCallback,
        type     : 'success'
    });    
};

/**
 * @param string message
 * @param function closeCallback (=null)
 */
PLANCAKE.showToastNotice = function (message, closeCallback) {

    if (closeCallback === undefined) {
        closeCallback = null;
    }
    
    $().toastmessage('showToast', {
        text     : message,
        sticky   : true,
        close    : closeCallback,
        type     : 'notice'
    });    
};