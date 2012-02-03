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

/**
  * Notifies the start of an AJAX operation (for lists).
  * 
  * @param bool block - whether to block UI
  */
PLANCAKE.notifyAjaxStart = function (block)
{
  if (block) {
      $('#bottomPanel').block({
        message: '<img src="/app/desktop/img/ajax_loader_small_orange.gif" />',
        css: {border: '1px solid #ff9922', padding: '5px', 'z-index': '1200'},
        applyPlatformOpacityRules: false
      });
      
      $('.ui-dialog').block({
        message: '',
        css: {border: '1px solid #ff9922', padding: '5px', 'z-index': '1200'},
        applyPlatformOpacityRules: false
      });
  }
}

/**
  * Notifies the sucess of an AJAX operation (for lists).
  *
  * @param string successMessage - the message to display if the AJAX request is OK
		  If the message is an empty string, it doesn't show any notification to user
  */
PLANCAKE.notifyAjaxSuccess = function (successMessage)
{
  $('#bottomPanel').unblock();
  $('.ui-dialog').unblock();
  
  if (successMessage != '')
  {
    PLANCAKE.showFeedback(successMessage);
  }
}

/**
  * Notifies an error an AJAX operation (for lists).
  *
  * @param string message
  */
PLANCAKE.notifyAjaxError = function (message)
{
  $('#bottomPanel').unblock();
  $('.ui-dialog').unblock();  
  
  PLANCAKE.showError(message);
}

/**
  * Displays a feedback for the user
  *
  * @param string message the message to display
  * @param boolean error (=false) - whether the message is an error message
  */
PLANCAKE.showFeedback = function(message, error)
{
  if ((error != true) || (error == undefined)) { 
      error=false;
  }

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
                   .html(message);                       
  $('div#feedback').fadeIn(400); // chaining this with the above line was unexpectedly causing problems
  
  setTimeout( function() {
                $('div#feedback').fadeOut(fadeOutLength);
              }, fadeOutDelay);
}

/**
  * Displays an error feedback for the user
  */
PLANCAKE.showError = function(message)
{
  messageToDisplay = PLANCAKE.lang.ACCOUNT_ERROR_ERROR_OCCURRED_PLEASE_RETRY;

  if ( (message != null) ||  (message != undefined) )
  {
    messageToDisplay = message;
  }

  PLANCAKE.showFeedback(messageToDisplay, true);
}

PLANCAKE._afterLocalStorageRetrieval = function() {
    $.mobile.hidePageLoadingMsg();
}