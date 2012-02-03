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
    
    $('div#socialWidgets').css('opacity',0.7)
    .hover(
        function(){
            $(this).stop().animate({opacity: 1}, 200);
        },
        function(){
            $(this).stop().animate({opacity: 0.7}, 200);
    });
    
    $('#twitterSocial').click(function() {
        window.open("http://twitter.com/share?text=" + 
            encodeURI(PLANCAKE.lang.GENERAL_TWITTER_COPY) + 
            "&url=http%3A%2F%2Fwww.plancake.com",
            "Share this on Twitter", 
            "menubar=no,width=550,height=450,toolbar=no");
        return false;
    });
});