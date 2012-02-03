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

(function($){  
 $.fn.plancake = function(options) {  
  
  // applies to <li> elements
  this.getId = function() {
      var id = $(this).attr('id');
      if (!id || (id.indexOf('task_') !== -1)) { // this is true for task LI's as they don't have an id, second condition is just a safety net
          var elClass = $(this).attr('class');
          if (elClass) {
            id = elClass.split(' ').searchByRegexp(/^task_/);
          } else {
              return null;
          }
      }
    return id.split('_')[1];  
  };
  
  // applies to <li> elements
  this.isHeader = function() {
    return $(this).hasClass('header');
  }
  
  // applies to <li> list and tag elements
  this.getName = function() {
    return $(this).find('.name').text();      
  }

  // applies to <li> task elements
  this.getDescription = function() {
    return $(this).find('.description').text();      
  }

  // applies to <li> task elements
  this.getNote = function() {
    return PLANCAKE.br2nl($(this).find('.taskNote').html());      
  }  
  
  // applies to <li> elements
  this.isInbox = function() {
    return $(this).hasClass('inbox');
  }
  
  // applies to <li> elements
  this.isTodo = function() {
    return $(this).hasClass('todo');
  }
  
  // applies to <li> elements
  this.isSystemList = function() {
    return $(this).hasClass('systemList');
  }
  
  // applies to task <li> elements
  this.isCompleted = function() {
    return $(this).hasClass('completed');
  }

  // applies to <li> elements
  this.getList = function(listId) {
    return $("ul#lists li#list_" + listId);
  }  

  // applies to <li> elements
  this.getTag = function(tagId) {
    return $("ul#tags li#tag_" + tagId);
  }
  
  this.getTask = function(taskId, panel) {
    if ((panel === null) || (panel === undefined)) {
        panel = PLANCAKE.activePanel;
    }  
      
    return panel.find("ul.tasks li.task_" + taskId);
  }  
  
  // applies to <li> elements
  this.getInbox = function() {
    return $("ul#lists li.inbox");
  }
  
  this.getTodo = function() {
    return $("ul#lists li.todo");
  }  


  this.isStarred = function() {
    return ($(this).find('img.star').attr('src').indexOf('full_star_micro.png') !== -1);
  }
  
  // applies to task <li> elements
  // return JQuery
  this.getTaskPanelId = function() {
      return $(this).attr('class').split(' ').searchByRegexp(/^fromPanel_/).replace('fromPanel_', '');
  }
  
  this.star = function(markAsStarred) { 
    var taskId = null;
    
    var img = $(this).find('img.star');
    if (markAsStarred) {
        img.attr('src', img.attr('src').replace('empty_star_micro.png', 'full_star_micro.png'));
    } else {
        img.attr('src', img.attr('src').replace('full_star_micro.png', 'empty_star_micro.png'));    
    }    
    
    if ( (PLANCAKE.getActivePanelContentConfig().type === PLANCAKE.CONTENT_TYPE_CALENDAR) &&
         (taskId = $(this).plancake().getId()) ) {
        // in the Calendar there may be many repetition of the same task
        PLANCAKE.activePanel.find('li.task_' + taskId).each(function () {
            if (markAsStarred) {
                $(this).find('img.star').attr('src', $(this).find('img.star').attr('src').replace('empty_star_micro.png', 'full_star_micro.png'));
            } else {
                $(this).find('img.star').attr('src', $(this).find('img.star').attr('src').replace('full_star_micro.png', 'empty_star_micro.png'));
            }
        });
    }      
  }

  return this;
 };  
})(jQuery); 