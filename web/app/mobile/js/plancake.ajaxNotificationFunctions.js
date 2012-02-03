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
    $.mobile.showPageLoadingMsg();
}

/**
  * Notifies the sucess of an AJAX operation (for lists).
  *
  * @param string successMessage - the message to display if the AJAX request is OK
		  If the message is an empty string, it doesn't show any notification to user
  */
PLANCAKE.notifyAjaxSuccess = function (successMessage)
{
    $.mobile.hidePageLoadingMsg();
  
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
  $.mobile.hidePageLoadingMsg();  
  
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
    // TODO
}

/**
  * Displays an error feedback for the user
  */
PLANCAKE.showError = function(message)
{
  messageToDisplay = "An error occurred - please retry.";

  if ( (message != null) ||  (message != undefined) )
  {
    messageToDisplay = message;
  }

  PLANCAKE.showToastError(messageToDisplay);
}

PLANCAKE._afterLocalStorageRetrieval = function() {
    $.mobile.hidePageLoadingMsg();
}