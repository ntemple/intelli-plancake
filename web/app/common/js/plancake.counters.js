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
    PLANCAKE.updateTaskCounters();
    setInterval('PLANCAKE.updateTaskCounters()', 300000); // I update the counters every 5 mins
});

/**
 * @param int counter
 */
PLANCAKE.setInboxCounter = function (counter) {
    var inboxCounter = $('.inboxCounter');
    if (inboxCounter.length) {
        inboxCounter.text(counter);
        if (counter > 0) {
            inboxCounter.show();    
        } else {
            inboxCounter.hide();
        }
    }
}

/**
 * @param int counter
 */
PLANCAKE.setTodayCounter = function (counter) {
    var todayCounter = $('.todayCounter');
    if (todayCounter.length) {
        todayCounter.text(counter);
        if (counter > 0) {
            todayCounter.show();    
        } else {
            todayCounter.hide();
        }
    }
}

/**
 * @param int counter
 */
PLANCAKE.setNewsCounter = function (counter) {
    var newsCounter = $('.newsCounter');
    if (newsCounter.length) {
        newsCounter.text(counter);
        if (counter > 0) {
            newsCounter.show();    
        } else {
            newsCounter.hide();
        } 
    }
}

PLANCAKE.updateTaskCounters = function() {
  // we wait a bit before requesting the counter
  // because otherwise we have some problems, in fact
  // sometimes the counter wasn't updating while adding/remove tasks
  // Probably that is due to the fact the query to count
  // the item runs even before the new item is inserted in table.
  setTimeout(function() {
        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_UPDATE_TASK_COUNTERS, 
                             null, '', function(counters) {
                    counters = counters['counters'];
                    
                    PLANCAKE.setInboxCounter(counters['inboxCounter']);
                    PLANCAKE.setTodayCounter(counters['todayCounter']);
                    // if it is the first time they login, I set the news counter to 2
                    PLANCAKE.setNewsCounter((PLANCAKE.data.isFirstDesktopLogin == 1) ? 2 : counters['newsCounter']);
                });
  }, 1000);      
}