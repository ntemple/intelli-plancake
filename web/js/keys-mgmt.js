/*!************************************************************************************
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

var pc_key_mgmt_list_pointer, // JQuery object
    pc_key_mgmt_task_pointer, // JQuery object
    // whether the user is controlling the lists or the tasks
    pc_key_mgmt_tasks_active = false; // boolean


$(document).ready(function() {
    // This is to make sure you can submit any form by hitting enter
    $('input').keydown(function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            $(this).parents('form').submit();
            return false;
        }
    });

    $(document).keydown(function(e){
        /* Alphanumeric shortcuts */
        $('input, textarea, select').focus(function() {
            alphaKeyboardShortcutsEnabled = false;
        });

        $('input, textarea, select').blur(function() {
            alphaKeyboardShortcutsEnabled = true;
        });

        /* Arrow shortcuts */
        $('input, textarea, select').focus(function() {
            // as soon as Plancake loads a list, it moves the focus to the addTask
            // textfield. That would disable the arrow shortcuts: that is why
            // we inserted the following condition
            if ( ($(this).attr('class') == 'content') &&
                 ($(this).parents('form').attr('id') == 'addTask') &&
                 ($(this).val().length == 0))
            {
                arrowKeyboardShortcutsEnabled = true;
            }
            else
            {
                arrowKeyboardShortcutsEnabled = false;
            }
        });

        $('input, textarea, select').blur(function() {
            arrowKeyboardShortcutsEnabled = true;
        });





        var code = (e.keyCode ? e.keyCode : e.which);
        switch (code)
        {
          case 27:
            return escKeyMgmt();
            break;
          case 37:
            if (e.ctrlKey && arrowKeyboardShortcutsEnabled) return leftKeyMgmt();
            break;
          case 38:
            if (e.ctrlKey && arrowKeyboardShortcutsEnabled) return upKeyMgmt();
            break;
          case 39:
            if (e.ctrlKey && arrowKeyboardShortcutsEnabled) return rightKeyMgmt();
            break;
          case 40:
            if (e.ctrlKey && arrowKeyboardShortcutsEnabled) return downKeyMgmt();
            break;
          case 78:
            if (alphaKeyboardShortcutsEnabled) return nKeyMgmt();
            break;
          case 69:
            if (alphaKeyboardShortcutsEnabled) return eKeyMgmt();
            break;
          case 68:
            if (alphaKeyboardShortcutsEnabled) return dKeyMgmt();
            break;
          case 71:
            if (alphaKeyboardShortcutsEnabled) return gKeyMgmt();
            break;
          case 66:
            if (alphaKeyboardShortcutsEnabled) return bKeyMgmt();
            break;
          case 67:
            if (alphaKeyboardShortcutsEnabled) return cKeyMgmt();
            break;
          case 82:
            if (alphaKeyboardShortcutsEnabled) return rKeyMgmt();
            break;
        }
    });
});

function escKeyMgmt()
{
  alphaKeyboardShortcutsEnabled = true;
  arrowKeyboardShortcutsEnabled = true;

  $('div.popupMessage').each(function(){
    $(this).hide();
  });
  closeReorderLists(true);
  closeReorderTasks(true);
  closeListActions();
  closeTaskActions();
  closeContextActions();
  closeAddTaskBelow();
  hide_overlay();
  $('div#addTaskOptions').slideUp("fast");
  $('#showHelp').hide();
  return false;
}

function leftKeyMgmt()
{
  alphaKeyboardShortcutsEnabled = true;
  arrowKeyboardShortcutsEnabled = true;

  pc_key_mgmt_tasks_active = false;
  pc_key_mgmt_task_pointer = null;
  $('.focusOnTaskItem').removeClass('focusOnTaskItem');
  downKeyMgmt(); // in order to highlight the first item
}


function rightKeyMgmt()
{
  alphaKeyboardShortcutsEnabled = true;
  arrowKeyboardShortcutsEnabled = true;

  pc_key_mgmt_tasks_active = true;
  pc_key_mgmt_list_pointer = null;
  $('.focusOnListItem').removeClass('focusOnListItem');
  downKeyMgmt(); // in order to highlight the first item
}

function upKeyMgmt()
{
  alphaKeyboardShortcutsEnabled = true;
  arrowKeyboardShortcutsEnabled = true;

  if (pc_key_mgmt_tasks_active) // tasks mgmt
  {
    if ( (typeof pc_key_mgmt_task_pointer == 'object') && (pc_key_mgmt_task_pointer != null))
    {
      // undoing the old active item
      pc_key_mgmt_task_pointer.removeClass('focusOnTaskItem');
      pc_key_mgmt_task_pointer.blur();
    }

    if ( (typeof pc_key_mgmt_task_pointer != 'object') || (pc_key_mgmt_task_pointer == null))
    {
      // initialization
      if (listWithoutDueDateExists())
      {
        pc_key_mgmt_task_pointer = $('ul#incompletedTasksWithoutDate > li:last');
      }
      else
      {
        pc_key_mgmt_task_pointer = $('ul#incompletedTasksWithDate > li:last');
      }
    }
    else if (pc_key_mgmt_task_pointer.attr('id') == $('ul#incompletedTasksWithoutDate > li:first').attr('id'))
    {
      if (listWithDueDateExists())
      {
        pc_key_mgmt_task_pointer = $('ul#incompletedTasksWithDate > li:last');
      }
      else
      {
        pc_key_mgmt_task_pointer = null;
      }
    }
    else if (pc_key_mgmt_task_pointer.attr('id') == $('ul#incompletedTasksWithDate > li:first').attr('id'))
    {
      pc_key_mgmt_task_pointer = null;
    }
    else
    {
      pc_key_mgmt_task_pointer = pc_key_mgmt_task_pointer.prev();
    }

    if (pc_key_mgmt_task_pointer != null)
    {
      pc_key_mgmt_task_pointer.addClass('focusOnTaskItem');
      pc_key_mgmt_task_pointer.focus();
    }
    $('form#addTask input.content').blur();
  }
  else  // lists mgmt
  {
    if ( (typeof pc_key_mgmt_list_pointer == 'object') && (pc_key_mgmt_list_pointer != null))
    {
      // undoing the old active item
      pc_key_mgmt_list_pointer.removeClass('focusOnListItem');
      pc_key_mgmt_list_pointer.blur();
    }

    if ( (typeof pc_key_mgmt_list_pointer != 'object') || (pc_key_mgmt_list_pointer == null))
    {
      // initialization
      pc_key_mgmt_list_pointer = $('a#todayTomorrowLink');
      $('form#addTask input.content').blur();
    }
    else if ( pc_key_mgmt_list_pointer.attr('id') == $('ul#listsNavigation > li:first').attr('id') )
    {
      pc_key_mgmt_list_pointer = $('ul#systemListsNavigation > li:first').next();
    }
    else if (pc_key_mgmt_list_pointer.find('a.listLink').text() == pc_lang_todo_list)
    {
      pc_key_mgmt_list_pointer = $('ul#systemListsNavigation > li:first');
    }
    else if (pc_key_mgmt_list_pointer.find('a.listLink').text() == pc_lang_inbox_list)
    {
      pc_key_mgmt_list_pointer = $('a#calendarLink');
    }
    else if (pc_key_mgmt_list_pointer.attr('id') == 'calendarLink')
    {
      pc_key_mgmt_list_pointer = $('a#allStarredLink');
    }
    else if (pc_key_mgmt_list_pointer.attr('id') == 'allStarredLink')
    {
      pc_key_mgmt_list_pointer = $('a#todayTomorrowLink');
    }
    else if (pc_key_mgmt_list_pointer.attr('id') == 'todayTomorrowLink')
    {
      pc_key_mgmt_list_pointer = $('ul#listsNavigation > li:last');
    }
    else
    {
      pc_key_mgmt_list_pointer = pc_key_mgmt_list_pointer.prev();
    }
    if (pc_key_mgmt_list_pointer != null)
    {
      pc_key_mgmt_list_pointer.addClass('focusOnListItem');
      pc_key_mgmt_list_pointer.focus();
    }
  }
  return false;
}

function downKeyMgmt()
{
  alphaKeyboardShortcutsEnabled = true;
  arrowKeyboardShortcutsEnabled = true;

  if (pc_key_mgmt_tasks_active) // tasks mgmt
  {
    if ( (typeof pc_key_mgmt_task_pointer == 'object') && (pc_key_mgmt_task_pointer != null))
    {
      // undoing the old active item
      pc_key_mgmt_task_pointer.removeClass('focusOnTaskItem');
      pc_key_mgmt_task_pointer.blur();
    }

    if ( (typeof pc_key_mgmt_task_pointer != 'object') || (pc_key_mgmt_task_pointer == null))
    {
      // initialization
      if (listWithDueDateExists())
      {
        pc_key_mgmt_task_pointer = $('ul#incompletedTasksWithDate > li:first');
      }
      else
      {
        pc_key_mgmt_task_pointer = $('ul#incompletedTasksWithoutDate > li:first');
      }
    }
    else if (pc_key_mgmt_task_pointer.attr('id') == $('ul#incompletedTasksWithDate > li:last').attr('id'))
    {
      if (listWithoutDueDateExists())
      {
        pc_key_mgmt_task_pointer = $('ul#incompletedTasksWithoutDate > li:first');
      }
      else
      {
        pc_key_mgmt_task_pointer = null;
      }
    }
    else if (pc_key_mgmt_task_pointer.attr('id') == $('ul#incompletedTasksWithoutDate > li:last').attr('id'))
    {
      pc_key_mgmt_task_pointer = null;
    }
    else
    {
      pc_key_mgmt_task_pointer = pc_key_mgmt_task_pointer.next();
    }

    if (pc_key_mgmt_task_pointer != null)
    {
      pc_key_mgmt_task_pointer.addClass('focusOnTaskItem');
      pc_key_mgmt_task_pointer.focus();
    }
    $('form#addTask input.content').blur();
  }
  else // lists mgmt
  {
    if ( (typeof pc_key_mgmt_list_pointer == 'object') && (pc_key_mgmt_list_pointer != null))
    {
      // undoing the old active item
      pc_key_mgmt_list_pointer.removeClass('focusOnListItem');
      pc_key_mgmt_list_pointer.blur();
    }

    if ( (typeof pc_key_mgmt_list_pointer != 'object') || (pc_key_mgmt_list_pointer == null))
    {
      // initialization
      pc_key_mgmt_list_pointer = $('a#todayTomorrowLink');
      $('form#addTask input.content').blur();
    }
    else if (pc_key_mgmt_list_pointer.find('a.listLink').text() == pc_lang_inbox_list)
    {
      pc_key_mgmt_list_pointer = $('ul#systemListsNavigation > li:first').next();
    }
    else if (pc_key_mgmt_list_pointer.find('a.listLink').text() == pc_lang_todo_list)
    {
      pc_key_mgmt_list_pointer = $('ul#listsNavigation > li:first');
    }
    else if (pc_key_mgmt_list_pointer.attr('id') == 'todayTomorrowLink')
    {
      pc_key_mgmt_list_pointer = $('a#allStarredLink');
    }
    else if (pc_key_mgmt_list_pointer.attr('id') == 'allStarredLink')
    {
      pc_key_mgmt_list_pointer = $('a#calendarLink');
    }
    else if (pc_key_mgmt_list_pointer.attr('id') == 'calendarLink')
    {
      pc_key_mgmt_list_pointer = $('ul#systemListsNavigation > li:first');
    }
    else if (pc_key_mgmt_list_pointer.attr('id') == $('ul#listsNavigation > li:last').attr('id'))
    {
      pc_key_mgmt_list_pointer = null;
    }
    else
    {
      pc_key_mgmt_list_pointer = pc_key_mgmt_list_pointer.next();
    }
    if (pc_key_mgmt_list_pointer != null)
    {
      pc_key_mgmt_list_pointer.addClass('focusOnListItem');
      pc_key_mgmt_list_pointer.focus();
    }
  }
  return false;
}

// return boolean - whether or not the the list of tasks without due date is on the page
function listWithoutDueDateExists()
{
  return (! (typeof $('ul#incompletedTasksWithoutDate') == 'undefined'));
}

// return boolean - whether or not the the list of tasks with due date is on the page
function listWithDueDateExists()
{
  return (! (typeof $('ul#incompletedTasksWithDate') == 'undefined'));
}

function nKeyMgmt()
{
  if (pc_key_mgmt_tasks_active)
  {
    newTaskRequestCallback();
  }
  else
  {
    newListRequestCallback();
  }
  return false;
}

function eKeyMgmt()
{
  if (pc_key_mgmt_tasks_active && pc_key_mgmt_task_pointer)
  {
    editTaskRequestCallback(pc_key_mgmt_task_pointer.attr('id').substring(4), // the id is like: task23
			    $('form#addTask input.listId').val());
  }
  else if (pc_key_mgmt_list_pointer)
  {
    editListRequestCallback(pc_key_mgmt_list_pointer.attr('id').substring(4),  // the id is like:  list23
			        pc_key_mgmt_list_pointer.find('a.listLink').text());
  }
  return false;
}

function dKeyMgmt()
{
  if (pc_key_mgmt_tasks_active && pc_key_mgmt_task_pointer)
  {
    deleteTaskCallback(pc_key_mgmt_task_pointer);
  }
  if (pc_key_mgmt_list_pointer)
  {
    deleteListCallback(pc_key_mgmt_list_pointer.attr('id').substring(4)); // the id is like:  list23
  }
  return false;
}

function gKeyMgmt()
{
  if (!pc_key_mgmt_tasks_active && pc_key_mgmt_list_pointer)
  {
    var link = '';
    if ( (pc_key_mgmt_list_pointer.attr('id') == 'calendarLink') ||
         (pc_key_mgmt_list_pointer.attr('id') == 'allStarredLink') ||
         (pc_key_mgmt_list_pointer.attr('id') == 'todayTomorrowLink') )
    {
      link = pc_key_mgmt_list_pointer;
    }
    else
    {
      link = pc_key_mgmt_list_pointer.find('a.listLink');
    }

    window.location = link.attr('href');

    // redirecting to the list page (unless the list is actually a header)
    if (pc_key_mgmt_list_pointer.hasClass('header')) {
    } else {
        loadPageViaAjax(link);
    }
    closePopupWindow($('form#editList'));
    return false;
  }
}

function bKeyMgmt()
{
  if ((pc_key_mgmt_tasks_active) && pc_key_mgmt_task_pointer)
  {
    if (pc_key_mgmt_task_pointer.find('input.simpleDueDate').val() > 0)
    {
      alert("You can't add below a task with due date.");
    }
    else
    {
      addTaskBelowRequestCallback(pc_key_mgmt_task_pointer);
    }
  }
  else if ((!pc_key_mgmt_tasks_active) && pc_key_mgmt_list_pointer)
  {
    addListBelowRequestCallback(pc_key_mgmt_list_pointer);
  }
  return false;
}

function cKeyMgmt()
{
  if ((pc_key_mgmt_tasks_active) && pc_key_mgmt_task_pointer)
  {
    if (pc_key_mgmt_task_pointer.hasClass('header'))
    {
      alert("You can't complete a header.");
    }
    else
    {
      markTaskCompleteCallback(pc_key_mgmt_task_pointer);
    }
    return false;
  }
}

function rKeyMgmt()
{
  if (pc_key_mgmt_tasks_active)
  {
    reorderTasksRequestCallback();
  }
  else
  {
    reorderListsRequestCallback();
  }
  return false;
}