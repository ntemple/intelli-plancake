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

PLANCAKE.sendingAJAXRequest = false;
PLANCAKE.counterToAvoidInfiniteLoopInSendAjaxRequestMethod = 0;

PLANCAKE.AJAX_MAINTENANCE_STRING = 'Sorry, Plancake is under maintenance.';

PLANCAKE.AJAX_URL_INIT_DATA = '/main/startupData';
PLANCAKE.AJAX_URL_GET_TASKS = '/main/getTasks';
PLANCAKE.AJAX_URL_MANAGE_LISTS = '/list/edit';
PLANCAKE.AJAX_URL_MANAGE_TAGS = '/context/addEdit';

PLANCAKE.AJAX_URL_SORT_LISTS = '/lists/reorder';
PLANCAKE.AJAX_URL_SORT_TAGS = '/contexts/reorder';

PLANCAKE.AJAX_URL_GET_LISTS = '/lists/get';
PLANCAKE.AJAX_URL_GET_TAGS = '/contexts/get';

PLANCAKE.AJAX_URL_ADD_TASK = '/task/add';
PLANCAKE.AJAX_URL_EDIT_TASK = '/task/edit';
PLANCAKE.AJAX_URL_SORT_TASKS = '/tasks/reorder';
PLANCAKE.AJAX_URL_STAR_TASKS = '/task/starTaskToggle';
PLANCAKE.AJAX_URL_COMPLETE_TASKS = '/task/complete';
PLANCAKE.AJAX_URL_UNCOMPLETE_TASKS = '/task/incomplete';

PLANCAKE.AJAX_URL_SEND_FEEDBACK = '/user/sendFeedback';
PLANCAKE.AJAX_URL_HIDE_BREAKING_NEWS = '/user/hideBreakingNews';
PLANCAKE.AJAX_URL_HIDE_HINT = '/user/hideHint';

PLANCAKE.AJAX_URL_UPDATE_TASK_COUNTERS = '/lists/getTaskCounters';

PLANCAKE.AJAX_URL_SYNC_GET_SERVER_TIME = '/sync/getServerTime';
PLANCAKE.AJAX_URL_SYNC = '/sync/sync';

PLANCAKE.AJAX_URL_LOG_ERROR = '/user/logError';

/**
  * Sends an AJAX request (via the POST method) and
  * calls the notification functions.
  *
  * @param string urlPath - e.g.: /task/complete - see top of this file
  * @param string data to transmit - e.g.:  type=list&extraParam=3
  * @param string successMessage - the message to display if the AJAX request is OK
		  If the message is an empty string, it doesn't show any notification to user
  * @param callback-function successCallback (optional) - this function could
  *        receive a parameter that is the reply from the server
  */
PLANCAKE.sendAjaxRequest = function(urlPath, data, successMessage, successCallback)
{
  if ( (successMessage === null) || (successMessage === undefined) ) {
      successMessage = '';
  }  
    
  var url =  PLANCAKE.BASE_URL +  urlPath;
    
  var block = (successMessage.length > 0);
  PLANCAKE.notifyAjaxStart(block);
  PLANCAKE.sendingAJAXRequest = true;
  
  
  if (PLANCAKE.willServeAjaxRequestLocally(urlPath)) { // retrieve data from localStorage
      try {
        PLANCAKE.localApi(urlPath, data, successMessage, successCallback);
      } catch (e) {
          var errorMessage = "An error occurred E1: " + e.message;

          PLANCAKE.counterToAvoidInfiniteLoopInSendAjaxRequestMethod ++;
          
          if (PLANCAKE.counterToAvoidInfiniteLoopInSendAjaxRequestMethod < 2) {
              PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_LOG_ERROR, 
                    'error=' + PLANCAKE.prepareForAjaxTransmission(errorMessage + '  --  ' + urlPath + '\n\n' + printStackTrace().join('\n\n')));
          }

          PLANCAKE.notifyAjaxError(errorMessage);
      }
      PLANCAKE._afterLocalStorageRetrieval();
  } else {
      var ajaxOptions = {
        type: 'POST',
        timeout: 10000,
        cache: false,
        url: url,
        data: data,
        success: function(dataFromServer){

          if(dataFromServer === "") { // each AJAX request should return something - if not it means the user is logged out
              if (!PLANCAKE.isMobile && $('a#logoutLink').length) { // in the mobile app, if is not likely to have different tabs, where
                                                                    // you are logged out from one of them
                window.location.replace($('a#logoutLink').attr('href'));
              }
          }

          if( (typeof(dataFromServer) == 'string') && 
              dataFromServer.indexOf(PLANCAKE.AJAX_MAINTENANCE_STRING) != -1) { // website under maintenance
              if (!PLANCAKE.isMobile && $('a#logoutLink').length) { // in the mobile app, if is not likely to have different tabs, where
                                                                    // you are logged out from one of them                  
                window.location.replace($('a#logoutLink').attr('href'));
              }
          }

          if ( (typeof(dataFromServer) == 'string') && (dataFromServer.indexOf('ERROR:') == 0) ) {
            if (urlPath != PLANCAKE.AJAX_URL_UPDATE_TASK_COUNTERS) { // this is an automatic request and we don't need error message
                PLANCAKE.notifyAjaxError(dataFromServer);
            }
          } else {
            PLANCAKE.notifyAjaxSuccess(successMessage);
            
            if (successCallback != null)
            {
                successCallback(dataFromServer);
            }            
            
          }
          PLANCAKE._afterAjaxRequest();
        },
        error: function(jqXHR, textStatus, errorThrown){
          var errorMessage = null;
          
          if (PLANCAKE.isMobile === true) {
              errorMessage = 'Error - are you trying to sync without Internet connection?';
          }
          
          if (urlPath != PLANCAKE.AJAX_URL_UPDATE_TASK_COUNTERS) { // this is an automatic request and we don't need error message            
            PLANCAKE.notifyAjaxError(errorMessage);
          }
          PLANCAKE._afterAjaxRequest();
        }
      };
      
      // Most of the time we sent a query string as parameter for AJAX calls.
      // But we may want to send objects (one example is the sync method of the API)
      if (data instanceof Object) {
          ajaxOptions['contentType'] = "application/json; charset=utf-8";
          ajaxOptions['dataType'] = "json";
      }
      
      $.ajax(ajaxOptions);
  }
}

/**
 * Returns whether the AJAX call should be served from the localStorage or from 
 * the remove Plancake server.
 * 
 * We force the use of the remove server for all those methods involving syncing
 * (initial sync and delta syncs later on).
 * 
 * Obviously we check the browser supports localStorage and offlineMode is enabled
 *
 * @param string urlPath - e.g.: /task/complete - see top of this file
 * @return boolean 
 *
 */
PLANCAKE.willServeAjaxRequestLocally = function(urlPath) {
  var getDataLocally = true;
  
  if (!PLANCAKE.isOfflineEnabled || !PLANCAKE.supportsHtml5Storage()) {
      getDataLocally = false;
  }
  
  if (getDataLocally) {
      if ( ((urlPath === PLANCAKE.AJAX_URL_GET_TASKS) && !localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS)) ||
           (urlPath === PLANCAKE.AJAX_URL_SYNC_GET_SERVER_TIME) ||
           (urlPath === PLANCAKE.AJAX_URL_SYNC) ||
           (urlPath === PLANCAKE.AJAX_URL_LOG_ERROR) ||           
           ((urlPath === PLANCAKE.AJAX_URL_INIT_DATA) && !localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA))) {
          getDataLocally = false;
      }  
  }
  
  // if startup data are stored locally but the updatable ones have been remove to force an update of that...
  // (see /web/app/offline/js/applicationCache.js file )
  if (getDataLocally && (urlPath === PLANCAKE.AJAX_URL_INIT_DATA)) {
      if ( PLANCAKE.isUpdatableStartupDataMissing() ) {
          getDataLocally = false;
      }  
  }  
  
  return getDataLocally;
};

/**
  * Helper for sendAJAXRequest
  *
  * @param JQuery submitButtonObject (optional) - the submit button to replace with a loader icon
  */
PLANCAKE._afterAjaxRequest = function()
{
      PLANCAKE.sendingAJAXRequest = false;
}

PLANCAKE.appendToUrl = function(url, param, value)
{
    var paramAndValue = param + '=' + value;

    return url + (url.indexOf('?') != -1 ? ("&" + paramAndValue) : ("?" + paramAndValue));
}

/**
  *
  */
PLANCAKE.prepareForAjaxTransmission = function(text)
{
  // the escape function was replacing non-ASCII characters with their entity,
  // that is why we are using encodeURIComponent();
  //text = escape(text);

  // without escaping/encoding, in "buy milk %%12-03-2010" PHP would consider
  // %12 as a Unicode character

  text = encodeURIComponent(text);


  // Symfony would replace + with spaces
  text = text.replace(/\+/g,'%2B');

  return text;
}

/**
 * @param PLANCAKE.Task task
 * @return string 
 * 
 */
PLANCAKE.getAjaxParams = function (task) {
    var taskNote = ( (task.note !== null) && (task.note !== undefined) ) ? task.note : '';
    var ajaxParams = 'content=' + PLANCAKE.prepareForAjaxTransmission(task.description) + '&' +
                    'isHeader=' + (+task.isHeader) + '&' +
                    'dueDate=' + ((task.dueDate !== null) ? PLANCAKE.prepareForAjaxTransmission(task.dueDate) : '') + '&' +
                    'dueTime=' + ((task.dueTime !== null) ? task.dueTime : '') + '&' +
                    'isStarred=' + (+task.isStarred) + '&' +
                    'repetitionId=' + (+task.repetitionId) + '&' +
                    'repetitionParam=' + (+task.repetitionParam) + '&' +
                    'listId=' + (+task.listId) + '&' +
                    'note=' + PLANCAKE.prepareForAjaxTransmission(taskNote) + '&' +
                    'contexts=' + ((task.tagIds !== null) ?  PLANCAKE.prepareForAjaxTransmission(task.tagIds) : '');
                
    if (PLANCAKE.is_numeric(task.id)) {
        ajaxParams += '&taskId=' + task.id;  
    }                
                
    return ajaxParams;
}

