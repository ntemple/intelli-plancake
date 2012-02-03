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
    var contentConfig = null;
    var inboxId = null;

    // next line shouldn't be moved down
    // It is very important we manage to activate a panel whatever 
    // appends later on (even if errors)
    PLANCAKE.setActivePanel($('#panel2')); 
    contentConfig = {done: false, type: "today"};

    // disabled the automatic restore of the content from last visit
    /*
    if (contentConfig = JSON.parse($.cookie(PLANCAKE.COOKIE_NAME_FOR_PANEL2_CONTENT_CONFIG))) {
        
    } else {
        // default
        contentConfig = {done: false, type: "today"};
    }
    */
      
    PLANCAKE.loadContent(contentConfig);


    inboxId = $().plancake().getInbox().plancake().getId();
    contentConfig = {done: false, type: "list", extraParam: inboxId};

    // disabled the automatic restore of the content from last visit    
    /*
    if (contentConfig = JSON.parse($.cookie(PLANCAKE.COOKIE_NAME_FOR_PANEL1_CONTENT_CONFIG))) {

    } else {
        inboxId = $().plancake().getInbox().plancake().getId();
        contentConfig = {done: false, type: "list", extraParam: inboxId};
    }
    */

    PLANCAKE.setActivePanel($('#panel1'));
    PLANCAKE.loadContent(contentConfig, $('#panel1'));    
});