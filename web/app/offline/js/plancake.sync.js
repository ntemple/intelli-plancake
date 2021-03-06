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
    // initial importing of all tasks
    if ( PLANCAKE.isOfflineEnabled && PLANCAKE.supportsHtml5Storage() &&
        !localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS) ) {
        // NON-completed tasks will be stored locally by the PLANCAKE.sendAjaxRequest method
        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_GET_TASKS, 
                                 '', '', function (dataFromServer) {
                                                 if ( !localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS)) { // we don't want
                                                                                                                 // to overwrite tasks
                                                    localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_TASKS, JSON.stringify(dataFromServer));
                                                 } 
                                                 PLANCAKE.refreshLastSyncTimestamp();
                                 });
    }
});

PLANCAKE.sync = function () {
    var errorOccurred = false;
    try {
        var ajaxParam = {
            'from_ts' : PLANCAKE.getLastSyncTimestamp(),
            'tasks' : PLANCAKE.localApi_getTasksFromLocalStorageToSync()['tasks']
        };
    } catch(e) {
        errorOccurred = true;
        var errorMessage = "An error occurred E2: " + e.message;

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_LOG_ERROR, 
                'error=' + PLANCAKE.prepareForAjaxTransmission(errorMessage + '\n\n' + printStackTrace().join('\n\n')));    
        
        PLANCAKE.showToastError(errorMessage);
    }
    
    if (!errorOccurred) {
        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_SYNC, 
             ajaxParam, '', function (dataFromServer) {
                 var syncErrorCode = 0;
                 var serverTime = 0;
                 
                 try {
                     try {
                         if ( (dataFromServer === null) || (dataFromServer === undefined) ) {
                            throw { 
                                name:        "Communication Error",
                                message:     "dataFromServer is null"
                            };                             
                         }

                         changes = dataFromServer['changes'];

                         var serverTime = changes['serverTime'];
                     } catch (e) {
                         syncErrorCode = 13;
                         throw e;
                     }

                    try {
                         // local tasks have already been sent and added to the server so we can delete them locally...
                         PLANCAKE.localApi_removeLocalTasks();
                         // ...anyway they have been sent back from the server via AJAX with a valid Id and we are going to insert them
                         // in the local datastore
                     } catch (e) {
                         syncErrorCode = 14;
                         throw e;
                     }

                     // I'm NOT interested in this because at the end of this process I just overwrite the whole startupData,
                     // which includes lists, tags and repetitionOptions
                     /*
                     var changedLists = changes['lists'];
                     var deletedLists = changes['deletedLists'];
                     var changedTags = changes['tags'];
                     var deletedTags = changes['deletedTags'];             
                     var changedRepetitions = changes['repetitions'];
                     */

                    try {
                        var changedTasks = changes['tasks'];
                        var deletedTasks = changes['deletedTasks'];

                        var changedTasksCount = changedTasks.length,
                            deletedTasksCount = deletedTasks.length,
                            i = 0,
                            changedTask = null,
                            deletedTaskId = null;
                     } catch (e) {
                         syncErrorCode = 15;
                         throw e;
                     }


                    try {
                        var tasksDatastore = PLANCAKE.localApi_getTasksDatastore();
                        for(i = 0; i < changedTasksCount; i++) {
                            changedTask = changedTasks[i];
                            if (changedTask.isCompleted == 1) {
                                // we store only non-completed tasks
                                tasksDatastore = PLANCAKE.localApi_deleteTask(changedTask.id, tasksDatastore);
                            } else {
                                tasksDatastore = PLANCAKE.localApi_addOrEditTask(changedTask, tasksDatastore);                    
                            }
                        }
                     } catch (e) {
                         syncErrorCode = 16;
                         throw e;
                     }                        

                    try {
                        for(i = 0; i < deletedTasksCount; i++) {
                            deletedTaskId = deletedTasks[i];
                            tasksDatastore = PLANCAKE.localApi_deleteTask(deletedTaskId, tasksDatastore);
                        }
                     } catch (e) {
                         syncErrorCode = 17;
                         throw e;
                     }                         

                    try {
                        PLANCAKE.localApi_setTasksDatastore(tasksDatastore);
                     } catch (e) {
                         syncErrorCode = 18;
                         throw e;
                     }                         

                   try {
                       // We update the last sync timestamp as last step: if something goes wrong during the synchronisation,
                       // next time we try to resubmit all the data again (because the timestamp hasn't changed) - thus we don't lose data
                       localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_LAST_SYNC_TIMESTAMP, serverTime);
                     } catch (e) {
                         syncErrorCode = 19;
                         throw e;
                     }  
                     
                   try {
                       // Now dealing with startup data (lists, tags, langs, ...) - this is not very critical as the sync is one way
                       // only (from server to client) in fact we even overwrite data

                       localStorage.removeItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA); // we need to remove this item otherwise
                                                                                          // the next call will be served from locally (using
                                                                                          // localStorage) rather than downloading a fresh copy
                                                                                          // from the server.
                                                                                          // This is a shortcut to quickly sync lists and tags:
                                                                                          // removing this key will force an update - anyway
                                                                                          // after syncing we always redirect to the homepage of the
                                                                                          // app forcing therefore a sync.
                                                                                          // There can be a problem if next AJAX call doesn't work
                                                                                          // but it would be apparent (as the user won't see any list
                                                                                          // or tag) and the user would try to sync again
                     } catch (e) {
                         syncErrorCode = 20;
                         throw e;
                     }                                                                                           
                                                                                      
                   if (PLANCAKE.config.custom === 1) { // generating exception on purpose for testing
                       // null.getId();
                   }                                                                                      
                                                                                      
                                                                                      
                } catch(e) {
                    errorOccurred = true;
                    if (syncErrorCode == 13) {
                         // this happened most probably because the user hasn't got a valid session on the server anymore:
                         // either they didn't do "rememberme", or they logged out from another window, or
                         // their "rememberme" session has expired
                         alert(PLANCAKE.lang.ACCOUNT_MOBILE_NEED_TO_LOGIN);
                         window.location.href = 'https://www.plancake.com/login?ignorelocalstorage=1';                         
                    } else {
                        var errorMessage = "An error occurred E" + syncErrorCode + ": " + e.message;

                        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_LOG_ERROR, 
                                'error=' + PLANCAKE.prepareForAjaxTransmission(errorMessage + '\n\n' + printStackTrace().join('\n\n')));    

                        PLANCAKE.showToastError(errorMessage);
                    }
                }                                                                                

                if (! errorOccurred) {
                    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_INIT_DATA, 
                           '', '', function (startupData) {
                               try {
                                   localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA, JSON.stringify(startupData));

                                   PLANCAKE.showToastSuccess(PLANCAKE.getOverlayContent_syncSuccess(), function () {
                                        window.location.href = PLANCAKE.BASE_URL_MOBILE;    
                                   });

                                } catch(e) {
                                    var errorMessage = "An error occurred E4: " + e.message;

                                    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_LOG_ERROR, 
                                            'error=' + PLANCAKE.prepareForAjaxTransmission(errorMessage + '\n\n' + printStackTrace().join('\n\n')));    

                                    PLANCAKE.showToastError(errorMessage);
                                }                              
                    });
                }
     });     
    }
};

PLANCAKE.refreshLastSyncTimestamp = function () {
    PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_SYNC_GET_SERVER_TIME, 
                             '', '', function (data) {
                                 localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_LAST_SYNC_TIMESTAMP, data['time']);
                             });    
};

PLANCAKE.getLastSyncTimestamp = function () {
    var ts = localStorage.getItem(PLANCAKE.LOCAL_STORAGE_KEY_LAST_SYNC_TIMESTAMP);
    // if it is not initialised yet, we initialised it - 10 is just a magic number to say very far in the past
    if (!ts) {
        ts = 10;
        localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_LAST_SYNC_TIMESTAMP, ts);
    }
    return ts;
};

