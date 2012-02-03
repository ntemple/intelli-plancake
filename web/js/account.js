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

/*
 * This variable control whether the alphabet shortcuts (they are just letters)
 * are enable or not.
 * We have to make sure they are not enable when the user input text in a
 * textarea or textfield
 */
var alphaKeyboardShortcutsEnabled = false;

var arrowKeyboardShortcutsEnabled = true;

var sendingAJAXRequest = false;

/**
 * Whether the user is trying to drap items before clicking the 'reorder' icon
 */
var isDraggingAttempt = false;

var reorderingListsOrTasks = false;

$(document).ready(function() {
  $('input, textarea, select').focus(function() {
    alphaKeyboardShortcutsEnabled = false;
  });

  $('a#gcalActivationFinalStep').click(function() {
    $('div#gcalActivationFinalStepPleaseWait').show();
    $(this).hide();
  });

  prepareTooltips(false);
  
  $('#importFileButton').click(function() {
      $('#importFile').block({
        message: '',
        css: {border: '1px solid #ff9922', padding: '5px'},
        applyPlatformOpacityRules: false
      });
  });
});

/**
 * @param boolean onlyInMainContent
 */
function prepareTooltips(onlyInMainContent)
{
  var anchor = $('a.help');
  if (onlyInMainContent)
  {
    $('div#mainContent a.help');
  }

  anchor.click(function(e) {
    if ($(this).attr('href') != '#')
    {
        // in this case, the link points to a proper url
        return;
    }


    $('#showHelp span').html($(this).find('span').html());
    $('#showHelp').css('top', (e.pageY+3) + 'px');

    var xOffset = 3;

    // {{{ if the click is very close to the right edge of the monitor, we should
    //     move the showHelp box more on the left
    var browserViewPortWidth = $(window).width();
    var showHelpWidth = "250";  // see account.css
    if ( (e.pageX + showHelpWidth) >= browserViewPortWidth)
    {
      xOffset = 0-showHelpWidth;
    }
    // }}}

    $('#showHelp').css('left', (e.pageX+xOffset) + 'px');
    $('#showHelp').show();
    // We used to use toggle() instead of show() (2 lines above) but the problem was
    // this event was triggered twice on production (no idea why) so we had to stop
    // using toggle() otherwise the help wouldn't have been hidden straight after
    // been displayed (very weird issue).
    //$('#showHelp').toggle();

    return false;
  });

  $('#showHelpClose').click(function() {
    $('#showHelp').hide();
  });
}

/**
  * Notifies the start of an AJAX operation (for lists).
  */
function notifyAjaxStart()
{
  $('div#ajaxLoading').show();
}

/**
  * Notifies the sucess of an AJAX operation (for lists).
  *
  * @param string successMessage - the message to display if the AJAX request is OK
		  If the message is an empty string, it doesn't show any notification to user
  */
function notifyAjaxSuccess(successMessage)
{
  $('div#ajaxLoading').hide();
  if (successMessage != '')
  {
    showFeedback(successMessage);
  }
}

/**
  * Notifies an error an AJAX operation (for lists).
  *
  * @param string message
  */
function notifyAjaxError(message)
{
  $('div#ajaxLoading').hide();
  showError(message);
}

/**
  * Sends an AJAX request (via the POST method) and
  * calls the notification functions.
  *
  * @param string url
  * @param string data to transmit
  * @param string successMessage - the message to display if the AJAX request is OK
		  If the message is an empty string, it doesn't show any notification to user
  * @param callback-function successCallback (optional) - this function could
  *        receive a parameter that is the reply from the server
  * @param JQuery submitButtonObject (optional) - the submit button to replace with a loader icon
  */
function sendAjaxRequest(url, data, successMessage, successCallback, submitButtonObject)
{
  // DO NOT DECLARE THE VARIABLE submitButtonReplacement AS LOCAL (by prepending var)
  // BECAUSE IT IS NEEDED BY ANOTHER FUNCTION
  submitButtonReplacement = $('<span class="buttonAjaxLoader">&nbsp;&nbsp;&nbsp;&nbsp;</span>');
  if ((typeof(submitButtonObject) == 'object') && (submitButtonObject != null) && (submitButtonObject != undefined))
  {
    submitButtonObject.replaceWith(submitButtonReplacement);
  }
  notifyAjaxStart();
  sendingAJAXRequest = true;
  $.ajax({
    type: 'POST',
    timeout: 30000,
    url: url,
    data: data,
    success: function(dataFromServer){
      if ( (typeof(dataFromServer) == 'string') && (dataFromServer.indexOf('ERROR:') == 0) )
      {
      	notifyAjaxError(dataFromServer);
      }
      else
      {
	      notifyAjaxSuccess(successMessage);
	      if (successCallback != null)
	      {
	        successCallback(dataFromServer);
	      }
      }
      _afterAjaxRequest(submitButtonObject);
    },
    error: function(){
      notifyAjaxError();
      _afterAjaxRequest(submitButtonObject);
    }
  });
}

/**
  * Helper for sendAJAXRequest
  *
  * @param JQuery submitButtonObject (optional) - the submit button to replace with a loader icon
  */
function _afterAjaxRequest(submitButtonObject)
{
      if ((typeof(submitButtonObject) == 'object') && (submitButtonObject != null) && (submitButtonObject != undefined))
      {
	      submitButtonReplacement.replaceWith(submitButtonObject);
      }
      var duplicateAddTaskButton = $('input#duplicateAddTaskButton');
      if ((typeof(duplicateAddTaskButton) == 'object') && (duplicateAddTaskButton != null) && (duplicateAddTaskButton != undefined))
      {
	      duplicateAddTaskButton.show();
      }
      sendingAJAXRequest = false;
}

/**
  * Displays a feedback for the user
  *
  * @param string message the message to display
  * @param boolean error (=false) - whether the message is an error message
  */
function showFeedback(message, error)
{
  if ((error != true) || (error == undefined)) error=false;

  // resetting
  $('div#feedback').removeClass('feedbackSuccess');
  $('div#feedback').removeClass('feedbackError');

  var fadeOutLength = 3000,
      fadeOutDelay = 2000,
      cssClass = 'feedbackSuccess';

  if (error)
  {
    fadeOutDelay = 2000,
    fadeOutLength = 5000;
    cssClass = 'feedbackError';
  }

  // we want to center the feedback message
  var feedbackDivOffset = ($(window).width() - 350) / 2;

  $('div#feedback').addClass(cssClass)
                   .css('left', feedbackDivOffset + 'px')
                   .html(message)
                   .fadeIn(400);
  setTimeout( function() {
                $('div#feedback').fadeOut(fadeOutLength);
              }, fadeOutDelay);
}

/**
  * Displays an error feedback for the user
  */
function showError(message)
{
  messageToDisplay = pc_lang_error_occurred_retry;

  if ( (message != null) ||  (message != undefined) )
  {
    messageToDisplay = message;
  }

  showFeedback(messageToDisplay, true);
}