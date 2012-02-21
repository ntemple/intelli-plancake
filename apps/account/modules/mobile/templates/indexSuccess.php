<!DOCTYPE html> 
<html manifest="/app/mobile/cache.manifest.php"> 
	<head> 
	<title>Plancake Mobile</title> 
	
        <meta http-equiv="X-UA-Compatible" content="chrome=1">        
        
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-114x114-precomposed.png" /> 
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-72x72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57-precomposed.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-114x114.png" /> 
        <link rel="apple-touch-icon" sizes="72x72" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="57x57" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57.png" />
        <link rel="apple-touch-icon" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57.png" />
        <link rel="apple-touch-startup-image" href="https://www.plancake.com/app/mobile/img/apple-icons/startup-320x460.png">

        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- in order to use the entire screen -->
        <meta name="apple-mobile-web-app-status-bar-style" content="translucent black" /> 
        
        
        <!-- START: CSS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
        <link href="/app/common/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="/app/mobile/css/jquery.mobile-1.0.1.min.css" rel="stylesheet" type="text/css" /> <!-- we don't use CDN because it doesnt work with appcache -->
        <link href="/app/mobile/css/jquery.mobile.simpledialog.css" rel="stylesheet" type="text/css" />        
        <link href="/app/mobile/css/jquery.toastmessage.css" rel="stylesheet" type="text/css" />
        <link href="/app/mobile/css/mobiscroll-1.5.3.css" rel="stylesheet" type="text/css" />        
        <link href="/app/common/css/plancake.common.css" rel="stylesheet" type="text/css" /> 
        <link href="/app/common/css/plancake.layout.common.css" rel="stylesheet" type="text/css" />        
        <link href="/app/mobile/css/plancake.layout.css" rel="stylesheet" type="text/css" />
        <link href="/app/mobile/css/plancake.listsAndTags.css" rel="stylesheet" type="text/css" />
        <link href="/app/common/css/plancake.tasks.common.css" rel="stylesheet" type="text/css" />        
        <link href="/app/mobile/css/plancake.tasks.css" rel="stylesheet" type="text/css" />          
        <link href="/app/mobile/css/plancake.layout.css" rel="stylesheet" type="text/css" />
        <link href="/app/mobile/css/plancake.counters.css" rel="stylesheet" type="text/css" />
        <link href="/app/mobile/css/jquery.mobile.performance.css" rel="stylesheet" type="text/css" />        
        <!-- END: CSS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
        
	</head>

<body> 

<!-- Start of first page -->
<div data-role="page" id="homepage" data-title="Plancake Mobile" data-theme="e">

	<div data-role="header" data-position="fixed">
		<h1>Plancake Mobile</h1>
                <!-- <a onclick="location.reload(true); return false;" href=".#" class="ui-btn-right" data-icon="refresh" data-iconpos="notext" data-direction="reverse" data-ajax="false"><span class="lang lang_ACCOUNT_HINT_RELOAD_BTN"></span></a> --> 
                <a href="#" class="ui-btn-right addTaskButton" data-theme="e" data-rel="dialog" data-icon="plus" data-iconpos="notext" data-direction="reverse"><span class="lang lang_ACCOUNT_ADD_TASK"></span></a>                
	</div><!-- /header -->

	<div data-role="content">	

                <div data-role="controlgroup" style="position: relative">
                    <a id="homepageListsLink" href="#lists-screen" data-role="button">Lists</a>
                    <a id="homepageTagsLink" href="#tags-screen" data-role="button">Tags</a>
                    <div class="counter inboxCounter"></div>                    
                </div>

                <div data-role="controlgroup" style="position: relative">
                    <a id="homepageStarredLink" href="#tasks-screen?type=starred" data-role="button">Starred</a>
                    <a  id="homepageCalendarLink" href="#tasks-screen?type=calendar" data-role="button">Calendar</a>                    
                    <a id="homepageTodayLink" href="#tasks-screen?type=today" data-role="button">Overdue & Today</a>
                    <div class="counter todayCounter"></div>                    
                </div>            
                
                <form action=".#" method="post" name="quickAddToInbox" id="quickAddToInbox">
                    <input type="text" class="greyedText" id="quickAddToInboxText" />
                    <div id="quickAddToInboxWrapper">
                        <input type="submit" name="submitQuickTaskToInboxButton" class="saveBtn" value="save" />
                    </div>
                </form>
                
	</div><!-- /content -->
        
	<div data-role="footer" data-position="fixed">
	<div data-role="navbar" class="ui-navbar" data-iconpos="left">
	  <ul class="ui-grid-b">
	    <li><a href=".#" class="syncButton" data-icon="sync" ><span class="lang lang_ACCOUNT_MOBILE_APP_SYNC_BUTTON"></span></a></li>
	    <li><a href=".#" class="helpButton" data-icon="info" ><span class="lang lang_ACCOUNT_MOBILE_APP_HELP_BUTTON"></span></a></li>
	    <li><a href=".#" class="settingsButton" data-icon="gear" ><span class="lang lang_ACCOUNT_MOBILE_APP_SETTINGS_BUTTON"></span></a></li>
          </ul>
	</div>
        </div><!-- /footer -->
</div><!-- /page -->

<div data-role="page" id="lists-screen" data-title="Plancake Mobile - Lists" data-theme="e">

	<div data-role="header" data-position="fixed">
		<h1>Plancake Mobile</h1>
                <a href=".#" class="ui-btn-left homeButton" data-icon="home" data-iconpos="notext" data-direction="reverse">home</a>
                <a href="#" class="ui-btn-right addTaskButton" data-theme="e" data-rel="dialog" data-icon="plus" data-iconpos="notext" data-direction="reverse"><span class="lang lang_ACCOUNT_ADD_TASK"></span></a>                
                <!-- <a onclick="location.reload(true); return false;" href=".#" class="ui-btn-right" data-icon="refresh" data-iconpos="notext" data-direction="reverse" data-ajax="false"><span class="lang lang_ACCOUNT_HINT_RELOAD_BTN"></span></a> -->
        </div><!-- /header -->

	<div data-role="content">	
            <h3><span class="lang lang_ACCOUNT_LISTS_HEADER"></span></h3>
            <ul id='lists' class="ui-listview" data-role='listview' data-inset='true'  data-theme="d">
                
            </ul>
            
            <div class="hidden noPrint allowanceAlert" id="maxListsAllowanceAlert"></div>            
	</div><!-- /content -->        
        
	<div data-role="footer" data-position="fixed">
	<div data-role="navbar" class="ui-navbar" data-iconpos="left">
	  <ul class="ui-grid-b">
	    <li><a href=".#" class="syncButton" data-icon="sync" ><span class="lang lang_ACCOUNT_MOBILE_APP_SYNC_BUTTON"></span></a></li>
	    <li><a href=".#" class="helpButton" data-icon="info" ><span class="lang lang_ACCOUNT_MOBILE_APP_HELP_BUTTON"></span></a></li>
	    <li><a href=".#" class="settingsButton" data-icon="gear" ><span class="lang lang_ACCOUNT_MOBILE_APP_SETTINGS_BUTTON"></span></a></li>
          </ul>
	</div>
        </div><!-- /footer -->
</div><!-- /page -->

<div data-role="page" id="tags-screen" data-title="Plancake Mobile - Tag" data-theme="e">
	<div data-role="header" data-position="fixed">
		<h1>Plancake Mobile</h1>
                <a href=".#" class="ui-btn-left homeButton" data-icon="home" data-iconpos="notext" data-direction="reverse">home</a>
                <a href="#" class="ui-btn-right addTaskButton" data-theme="e" data-rel="dialog" data-icon="plus" data-iconpos="notext" data-direction="reverse"><span class="lang lang_ACCOUNT_ADD_TASK"></span></a>                
                <!-- <a onclick="location.reload(true); return false;" href=".#" class="ui-btn-right" data-icon="refresh" data-iconpos="notext" data-direction="reverse" data-ajax="false"><span class="lang lang_ACCOUNT_HINT_RELOAD_BTN"></span></a> -->
	</div><!-- /header -->

	<div data-role="content">	
            <h3><span class="lang lang_ACCOUNT_TAGS_FILTER_HEADER"></span></h3>
            <ul id='tags' class="ui-listview" data-role='listview' data-inset='true' data-theme="d">
                
            </ul>
            
            <div class="hidden noPrint allowanceAlert" id="maxTagsAllowanceAlert"></div>            
	</div><!-- /content -->        
        
	<div data-role="footer" data-position="fixed">
	<div data-role="navbar" class="ui-navbar" data-iconpos="left">
	  <ul class="ui-grid-b">
	    <li><a href=".#" class="syncButton" data-icon="sync" ><span class="lang lang_ACCOUNT_MOBILE_APP_SYNC_BUTTON"></span></a></li>
	    <li><a href=".#" class="helpButton" data-icon="info" ><span class="lang lang_ACCOUNT_MOBILE_APP_HELP_BUTTON"></span></a></li>
	    <li><a href=".#" class="settingsButton" data-icon="gear" ><span class="lang lang_ACCOUNT_MOBILE_APP_SETTINGS_BUTTON"></span></a></li>
          </ul>
	</div>
        </div><!-- /footer -->
</div><!-- /page -->

<div data-role="page" id="tasks-screen" data-title="Plancake Mobile - Tasks" data-theme="e">

	<div data-role="header" data-position="fixed">
		<h1>Plancake Mobile</h1>
                <a href=".#" class="ui-btn-left homeButton" data-icon="home" data-iconpos="notext" data-direction="reverse">home</a>
                <a href="#" class="ui-btn-right addTaskButton" data-theme="e" data-rel="dialog" data-icon="plus" data-iconpos="notext" data-direction="reverse"><span class="lang lang_ACCOUNT_ADD_TASK"></span></a>                
                <!-- <a onclick="location.reload(true); return false;" href=".#" class="ui-btn-right" data-icon="refresh" data-iconpos="notext" data-direction="reverse" data-ajax="false"><span class="lang lang_ACCOUNT_HINT_RELOAD_BTN"></span></a> -->
	</div><!-- /header -->

	<div data-role="content">
            <div id="panels"> <!-- this is for compatibility with the desktop app -->
                <div id="panel1" class="panel"> <!-- this is for compatibility with the desktop app -->             
                    <h3><span class="lang lang_ACCOUNT_HEADER_TASKS"></span></h3>

                    <p class="noTasks noPrint lang lang_ACCOUNT_MAIN_CONTENT_NO_TASKS"></p>
                    
                     <div id="calendarControls" class="calendarControls noPrint">                       
                         <div class="calendarPrev">
                             <!-- Hidden to keep the interface a bit cleaner -->
                             <!-- <div class="calendarControl calPrevMonth"> -->
                                 <!-- <a href=".#" data-ajax="false"><span class="calendarControlArrowsPrev">&lt;&lt;&lt;</span> <span class="lang lang_ACCOUNT_MAIN_CONTENT_CAL_PREV_MONTH"></span></a> -->
                             <!-- </div> -->
                             <div class="calendarControl calPrevWeek">
                                 <a href=".#" data-ajax="false" data-role="button" data-icon="arrow-l" data-iconpos="notext" data-theme="c"> </a>
                             </div>
                         </div>
                         <div class="calendarNext">
                             <!-- Hidden to keep the interface a bit cleaner -->                             
                            <!-- <div class="calendarControl calNextMonth"> -->
                                <!-- <a href=".#" data-ajax="false"><span class="calendarControlArrowsNext">&gt;&gt;&gt;</span><span class="lang lang_ACCOUNT_MAIN_CONTENT_CAL_NEXT_MONTH"></span></a> -->
                            <!-- </div> -->
                            <div class="calendarControl calNextWeek">
                                <a href=".#" data-ajax="false" data-role="button" data-icon="arrow-r" data-iconpos="notext" data-theme="c"> </a>
                            </div>
                         </div> 
                         <div class="calendarJump">                           
                             <form style="margin: 0px; padding: 0px; margin-top: 3px;"><input type="date" id="calendarJumpDate" class="calendarJumpDate mobiscroll" placeholder="set date" /></form>
                         </div>                            
                     </div>                     
                    
                    <ul data-role="listview" class="tasks" data-theme="d"> <!-- here I use the class 'tasks' for compatibility with the desktop app -->

                    </ul>
                </div>
            </div>
	</div><!-- /content -->        
        
	<div data-role="footer" data-position="fixed">
	<div data-role="navbar" class="ui-navbar" data-iconpos="left">
	  <ul class="ui-grid-b">
	    <li><a href=".#" class="syncButton" data-icon="sync" ><span class="lang lang_ACCOUNT_MOBILE_APP_SYNC_BUTTON"></span></a></li>
	    <li><a href=".#" class="helpButton" data-icon="info" ><span class="lang lang_ACCOUNT_MOBILE_APP_HELP_BUTTON"></span></a></li>
	    <li><a href=".#" class="settingsButton" data-icon="gear" ><span class="lang lang_ACCOUNT_MOBILE_APP_SETTINGS_BUTTON"></span></a></li>
          </ul>
	</div>
        </div><!-- /footer -->
</div><!-- /page -->

<div data-role="page" id="task-menu-screen">
        <div data-role="header" data-position="inline" class="ui-corner-top ui-header" role="banner">
                <span class="ui-title"></span>
       </div>    
        <div data-role="content">	
            <div data-role="controlgroup" style="position: relative" id="taskActions">
                <a id="viewNoteAction" class="lang lang_ACCOUNT_MOBILE_VIEW_NOTE_BTN" href="#." data-role="button"></a>
                <a id="markDoneTaskAction" class="lang lang_ACCOUNT_MOBILE_MARK_AS_DONE_BTN" href="#." data-role="button"></a>
                <a id="markToDoTaskAction" class="lang lang_ACCOUNT_MOBILE_MARK_TO_DO_BTN" href="#." data-role="button"></a>
                <!-- if we want to let user star/unstar, we have tp change the sync method -->
                <!-- <a id="starTaskAction" class="lang lang_ACCOUNT_MOBILE_STAR_BTN" href="#." data-role="button"></a> -->
                <!-- <a id="unstarTaskAction" class="lang lang_ACCOUNT_MOBILE_UNSTAR_BTN" href="#." data-role="button"></a> -->                  
            </div>
        </div><!-- /content -->        
</div><!-- /page -->

<div data-role="page" id="settings-menu-screen">
        <div data-role="header" data-position="inline" class="ui-corner-top ui-header" role="banner">
                <span class="ui-title lang lang_ACCOUNT_MOBILE_APP_SETTINGS_BUTTON"></span>
       </div>
        <div data-role="content">	
            <div data-role="controlgroup" style="position: relative" id="settingsActions">
                <a id="logoutAction" class="lang lang_ACCOUNT_MOBILE_LOGOUT_AND_RESET_LOCAL_DATA_BTN" style="text-transform: lowercase" href="#." data-role="button"></a>                
                <a id="resetDataAction" class="lang lang_ACCOUNT_MOBILE_RESET_LOCAL_DATA_BTN" href="#." data-role="button"></a>                   
            </div>
        </div><!-- /content -->        
</div><!-- /page -->


<div data-role="page" id="add-task-screen">
        <div data-role="header" data-position="inline" class="ui-corner-top ui-header" role="banner">
                <span class="ui-title lang lang_ACCOUNT_ADD_TASK"></span>
       </div>    
        <div data-role="content">
            
            <form name="addTaskForm" id="addTaskForm" style="padding-left: 20px; padding-right: 20px;">
                <p>
                    <span class="lang lang_ACCOUNT_NEW_TASK_DESCRIPTION"></span> <br />
                    <input type="text" id="addTaskDescription" style="margin-top: 10px;" />
                    <br />
                </p>
                <p>
                    <span class="lang lang_ACCOUNT_NEW_TASK_LIST"></span> <br />
                    <select id="addTaskListsSelect">
                        
                    </select>
                    <br />
                </p>
                <p>
                    <a class="lang lang_ACCOUNT_MISC_SAVE" id="addTaskSubmitBtn" href="#" data-rel="back" data-role="button"></a>
                </p>
            </form>
        </div><!-- /content -->        
</div><!-- /page -->

    <a href="http://www.plancake.com/logout" class="hidden" id="logoutLink">&nbsp;</a>
    <a href="#" class="hidden" id="dummyLinkForSimpleDialog">&nbsp;</a>
    
    <!-- START: JS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
    <script src="/app/mobile/js/jquery-1.6.4.min.js"></script> <!-- we don't use CDN because it doesnt work with appcache -->
    <script src="/app/mobile/js/jquery.mobile-1.0.1.min.js"></script> <!-- we don't use CDN because it doesnt work with appcache -->        
    <script src="/app/common/js/date-en-US.js"></script> <!-- used by PlancakeTask.js -->
    <script src="/app/common/js/json2.js"></script>
    <script src="/app/common/js/sprintf.js"></script>    
    <script src="/app/common/js/php.js"></script>
    <script src="/app/common/js/string.js"></script>    
    <script src="/app/common/js/array.js"></script>
    <script src="/app/common/js/jlinq.js"></script>
    <script src="/app/mobile/js/mobiscroll-1.5.3.js"></script>    
    <script src="/app/common/js/stacktrace.js"></script>    
    <script src="/app/offline/js/jlinq.plancake.extensions.js"></script>
    <script src="/js/offline/localDatastore.detection.js"></script>    
    <script src="/app/offline/js/localStorage.js"></script>    
    <script src="/app/offline/js/applicationCache.js"></script>
    <script src="/app/offline/js/plancake.localApiHelper.js"></script>    
    <script src="/app/offline/js/plancake.localApi.js"></script>
    <script src="/app/offline/js/plancake.sync.js"></script>    
    <script src="/app/common/js/jquery.pngFix.min.js"></script>
    <script src="/app/common/js/jquery.cookie.js"></script>
    <script src="/app/common/js/jquery.blockUI.js"></script>
    <script src="/app/common/js/jquery.tinysort.js"></script>      
    <script src="/app/common/js/jquery.livequery.min.js"></script>
    <script src="/app/common/js/jquery.plancake.js"></script>
    <script src="/app/mobile/js/jquery.toastmessage.js"></script>
    <script src="/app/mobile/js/plancake.feedback.js"></script>    
    <script src="/app/mobile/js/jquery.mobile.simpledialog.js"></script>
    <script src="/app/common/js/plancake.utils.js"></script>
    <script src="/app/common/js/plancake.dateUtils.js"></script> 
    <script src="/app/mobile/js/plancake.ajaxNotificationFunctions.js"></script>    
    <script src="/app/common/js/plancake.ajax.js"></script>    
    <script src="/app/common/js/plancake.lang.js"></script>
    <script src="/app/mobile/js/plancake.overlayContent.js"></script>    
    <script src="/app/mobile/js/plancake.overlay.js"></script> <!-- this plugin is used by plancake.init.js -->
    <script src="/app/common/js/plancake.init.common.js"></script>   
    <script src="/app/mobile/js/plancake.init.js"></script>
    <script src="/app/common/js/plancake.lists.common.js"></script>    
    <script src="/app/mobile/js/plancake.lists.js"></script>
    <script src="/app/common/js/plancake.tags.common.js"></script>    
    <script src="/app/mobile/js/plancake.tags.js"></script>      
    <script src="/app/common/js/plancake.taskRepetitionParam.js"></script>    
    <script src="/app/common/js/plancake.tasks.common.js"></script>
    <script src="/app/mobile/js/plancake.tasks.js"></script>
    <script src="/app/common/js/plancake.layout.common.js"></script>  
    <script src="/app/mobile/js/plancake.layout.js"></script>       
    <script src="/app/common/js/plancake.counters.js"></script>s
    
    <script src="/app/common/js/api-client/Utils.js"></script>
    <script src="/app/common/js/api-client/PlancakeList.js"></script>
    <script src="/app/common/js/api-client/PlancakeTag.js"></script>      
    <script src="/app/common/js/api-client/PlancakeTask.js"></script>    
    <script src="/app/common/js/api-client/PlancakeApiClient.js"></script>
    
    <!-- END: JS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
    
    <script>
    // turn off animated transitions for Android because of the annoying flickering problem
    if (navigator.userAgent.indexOf("Android") != -1)
    {
        $("a").attr("data-transition", "none");
    }
    </script>
</body>
</html>