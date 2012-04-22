<?php
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
?>
<html>
<head>

    <link href="/app/common/css/reset.css" rel="stylesheet" type="text/css" />
    
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-114x114-precomposed.png" /> 
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-72x72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57-precomposed.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-114x114.png" /> 
    <link rel="apple-touch-icon" sizes="72x72" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57.png" />
    <link rel="apple-touch-icon" href="https://www.plancake.com/app/mobile/img/apple-icons/touch-icon-57x57.png" />
    <link rel="apple-touch-startup-image" href="https://www.plancake.com/app/mobile/img/apple-icons/startup-320x460.png">    

    <meta property="og:title" content="<?php echo __('WEBSITE_HOMEPAGE_META_OG_TITLE') ?>" />
    <meta property="og:description" content="<?php echo __('WEBSITE_HOMEPAGE_SECONDARY_COPY') ?>" />    
    
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" /> 
    <!-- <link href="/app/desktop/css/jqueryui/1.8.13/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
    
    <!-- START: CSS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
    <link href="/app/desktop/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
    <link href="/app/common/css/plancake.common.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.general.css" rel="stylesheet" type="text/css" />
    <link href="/app/common/css/plancake.layout.common.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.layout.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.ajax.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.search.css" rel="stylesheet" type="text/css" />    
    <link href="/app/desktop/css/plancake.listsAndTags.css" rel="stylesheet" type="text/css" />
    <link href="/app/common/css/plancake.tasks.common.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.tasks.css" rel="stylesheet" type="text/css" />  
    <link href="/app/desktop/css/plancake.bottomPanel.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.feedbackBox.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.social.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.counters.css" rel="stylesheet" type="text/css" />     
    <link href="/app/desktop/css/plancake.overlay.css" rel="stylesheet" type="text/css" />
    <link href="/app/desktop/css/plancake.overlayContent.css" rel="stylesheet" type="text/css" />    
    <link href="/app/desktop/css/plancake.print.css" rel="stylesheet" type="text/css" /> <!-- this must be the last one -->    
    <!-- END: CSS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
    
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
    
    <!-- We need to insert JQuery in the HEAD becuase we need to call holdReady -->
    <!-- All the other JS is at the bottom for performance -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <!-- <script src="/app/desktop/js/jquery-1.6.1.min.js"></script> -->
    <script type="text/javascript">
        $.holdReady(true); // this will be released by plancake.init.js
    </script>    

    <!--[if IE]>
        <link href="/app/desktop/css/ie/ie_5.css" rel="stylesheet" type="text/css" />
    <![endif]-->    
    <!--[if IE 6]>
        <link href="/app/desktop/css/ie/ie6.css" rel="stylesheet" type="text/css" />
    <![endif]-->        
    <!--[if IE 7]>
        <link href="/app/desktop/css/ie/ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->      
    
</head>
<body> <!-- we hide the body while the layout adjusts itself -->
    
    <div id="feedback"></div>
    
    <div class="loadingElements" id="initialLoader">
        <div></div>
    </div>
    
    <a class="loadingElements" id="loadingProblemLink" href="/contact?re=problem">Problems loading the app?</a>

    <div id="hiddenDuringInitialLoading" style="display: none">
        <div id="content">             

            <?php if (0 && $updateAvailable): ?>
                <div id="updatesNotification" class="noPrint">
                    There is a newer release available for download <a class="inboundLink" href="/open-source">here</a>.
                </div>
            <?php endif ?>        

            <div id="sidebar"  class="noPrint">
<?php /* NLT for whitelabel 
                <h1>Plancake</h1>                 

                <div id="socialWidgets">
                    <a id="twitterSocial" href="#" >&nbsp;</a>

                    <div id="facebookSocial">
                        <script src="https://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                        <fb:like href="http://www.plancake.com" layout="button_count"></fb:like>

                        <div id="fb-root"></div>
                        <script>
                          window.fbAsyncInit = function() {
                            FB.init({appId: '157356510972189', status: true, cookie: true,
                                     xfbml: true});
                          };
                          (function() {
                            var e = document.createElement('script');
                            e.type = 'text/javascript';
                            e.src = document.location.protocol +
                              '//connect.facebook.net/en_GB/all.js';
                            e.async = true;
                            document.getElementById('fb-root').appendChild(e);
                          }());
                        </script>
                    </div>

                    <div id="googleSocial">
                        <g:plusone size="medium" count="false" href="http://www.plancake.com"></g:plusone>
                    </div>                
                </div>
*/ ?>
<?php 
       // Search requires a separate indexing engine, so is disabled for now 

       if (sfConfig::get('app_feature_search')) { ?>
          
        <br style="clear: both;" /><br />

                <form name="search" id="searchForm" method="post">
                    <input type="text" class="light" name="searchQuery" id="searchQuery" value="" />
                </form>            
<?php } ?>

                <br style="clear: both;" />           

                <div id="listsTitle">
                    <h3><span class="lang lang_ACCOUNT_LISTS_HEADER"></span></h3>
                    
                    <div id="listsActions">
                        <a id="newListButton" class="btn" href="#"><span class="lang lang_ACCOUNT_NEW_LIST"></span></a>                        
                        <a class="collapseListsBtn" id="collapseLists" href="#">-</a>    
                        <a class="collapseListsBtn" id="expandLists" href="#">+</a>                    
                    </div>
                </div>
                <ul id="lists">

                </ul>

                <form id="hackToScrollToBottomList"><input type="text" /></form>

                <div class="hidden noPrint allowanceAlert" id="maxListsAllowanceAlert"></div>

                <div style="margin-bottom: 30px">&nbsp;</div>

                <div id="tagsTitle">            
                    <h3><span class="lang lang_ACCOUNT_TAGS_FILTER_HEADER"></span></h3>
                    
                    <div id="tagsActions">                    
                        <a id="newTagButton" class="btn" href="#"><span class="lang lang_ACCOUNT_TAGS_NEW_TAG"></span></a> 
                    </div>
                </div>
                <ul id="tags">

                </ul>

                <form id="hackToScrollToBottomTag"><input type="text" /></form>            

                <div class="hidden noPrint allowanceAlert" id="maxTagsAllowanceAlert"></div>

                <div style="margin-bottom: 15px">&nbsp;</div>            

                <br style="clear: both" /> 

                <?php if(! PcUserPeer::getLoggedInUser()->isSupporter()): ?>
                    <div id="mainAd">
                        <a  class="removeAd" class="inboundLink" href="/account.php/upgrade?feature=ad"><span class="lang lang_ACCOUNT_MISC_REMOVE_THIS_AD"></span></a>
                        <!-- place ad here -->   
                        <div>
                        Would you like to get things done with a team? <br />
                        Check out the <a target="_blank" href="http://team.plancake.com">other product</a> we have been developing for you.
                        </div>
                        
                    </div>
                <?php endif ?>

                <br style="clear: both" />            

                <br /><br /><br /> <!-- this is needed otherwise the footer bar will cover some tags -->

            </div>

            <div id="panels">

                <div id="breakingNews" class="noPrint hidden">
                    <span id="breakingNewsId" class="hidden"></span>
                    <span id="breakingNewsHeadline"></span>                
                    <a href=".#" id="breakingNewsClose">&#215;</a>
                </div>

                <div id="panel1" class="panel">
                    <div class="panelActions">
                        <div class="hidePanel2 panelAction" /></div>                    
                        <div class="showPanel2 panelAction hidden" /></div>                
                        <div class="reloadContentPanel panelAction" /></div>
                        <div class="printContentPanel panelAction" /></div>
                        <div class="editPanel panelAction hidden" /></div>
                    </div>
                    <div class="clearfix"></div>
                    <h3 class="panelHeader"></h3>
                    <div class="panelContent"></div>                         


                    <div id="panelSeparator" class="noPrint">&nbsp;</div>

                </div>



                <div id="panel2" class="panel">
                    <div class="panelActions">
                        <div class="hidePanel2 panelAction" /></div>                        
                        <div class="reloadContentPanel panelAction" /></div>           
                        <div class="editPanel panelAction hidden" /></div>
                    </div>
                    <div class="clearfix"></div>                    
                    <h3 class="panelHeader"></h3>
                    <div class="panelContent"></div>                    
                </div>
                
            </div>       

        </div>     

        <div id="bottomPanel" class="noPrint">
            <div>            
                <a href="#" id="accountButton"><span class="lang lang_GENERAL_MY_ACCOUNT">help</span></a>

                <a id="helpButton" href="#"><span class="lang lang_ACCOUNT_MISC_HELP_LINK">help</span></a> 

                <a id="videoTutorialButton" href="#">video</a>                 
                
                <div id="blogLinkWrapper">
                    <div class="counter newsCounter"></div>
                    <a href="/blog" target="_blank" id="blogLink" class="inboundLink"><span class="lang lang_ACCOUNT_MISC_NEWS_LINK"></span></a>            
                </div>



                <a id="upgradeButton" href="/account.php/upgrade" class="inboundLink"><span class="lang lang_ACCOUNT_HEADER_UPGRADE"></span></a>

                <div id="bottomFilters">
                    <div class="bottomPanelFiller" style="height: 6px; font-size: 50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="bottomPanelFiller" style="display: inline; color: #4696FD; font-size: 12px;">........................................</div>
                    <div style="position: relative; display: inline;">
                        <div class="counter todayCounter"></div>
                        <input type="radio" id="filterToday" name="bottomFilters" /><label for="filterToday"><span class="lang lang_ACCOUNT_LISTS_OVERDUE_DUE_TODAY"></span></label>
                    </div>
                    <input type="radio" id="filterCalendar" name="bottomFilters" /><label for="filterCalendar"><span class="lang lang_ACCOUNT_LISTS_ALL_SCHEDULED"></span></label>
                    <input type="radio" id="filterStarred" name="bottomFilters" /><label for="filterStarred"><span class="lang lang_ACCOUNT_LISTS_STARRED"></span></label>
                    <input type="radio" id="filterCompleted" name="bottomFilters" /><label for="filterCompleted"><span class="lang lang_ACCOUNT_LISTS_COMPLETED"></span></label> 
                </div>  

                <div id="feedbackBox">
                    <a id="closeFeedbackBox" href="#">&#215;</a>
                    <form>
                        <textarea id="feedbackBoxMessage" class="lang lang_ACCOUNT_FEEDBACK_BOX_MSG"></textarea>
                        <br />
                        <a href="#" id="sendFeedback"><span class="lang lang_ACCOUNT_FEEDBACK_BOX_SEND_BTN"></span></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" id="cancelFeedback"><span class="lang lang_ACCOUNT_MISC_CANCEL"></span></a>
                        <img src="/app/desktop/img/support_team_member_en.jpg" />
                    </form>    
                </div>

                <ul id="secondaryNav" class="ui-corner-top">
                    <li><div class="secondaryNavItemWrapper">
                        <a class="inboundLink" href="/account.php/settings"><span class="lang lang_ACCOUNT_HEADER_SETTINGS"></span></a>
                    </div></li>                    
                    <li class="secondaryNavDivider"><div class="secondaryNavItemWrapper"></div></li>
                    <li><div class="secondaryNavItemWrapper">
                        <a class="inboundLink" href="/services"><span class="lang lang_ACCOUNT_HEADER_SERVICES"></span></a>
                    </div></li>                     
                    <li><div class="secondaryNavItemWrapper">
                        <a class="inboundLink" href="/services/smartphone-application"><span class="lang lang_ACCOUNT_HEADER_SMARTPHONE_APP_GUIDE"></span></a>
                    </div></li>
                    <li><div class="secondaryNavItemWrapper">
                        <a class="inboundLink" href="/services/offline-use"><span class="lang lang_ACCOUNT_HEADER_OFFLINE_USE_GUIDE"></span></a>
                        <a id="linkToMobileApp" target="_blank" href="https://www.plancake.com/account.php/mobile"></a>
                    </div></li>                     
                    <li class="secondaryNavDivider"><div class="secondaryNavItemWrapper"></div></li>
                    
                    <li><div class="secondaryNavItemWrapper">
                        <a href="/account.php/notes" class="inboundLink"><span class="lang lang_ACCOUNT_HEADER_NOTES"></span></a>
                    </div></li>                 

                    <li class="secondaryNavDivider"><div class="secondaryNavItemWrapper"></div></li>
                    <li><div class="secondaryNavItemWrapper" style="padding-right: 0px;"><?php echo __('WEBSITE_MISC_FOLLOW_US') ?>
                        <a class="followUsBottomPanel" target="_blank" href="https://www.facebook.com/plancake"><img src="/images/facebook_icon.png" /></a>
                        <a class="followUsBottomPanel" target="_blank" href="https://twitter.com/#!/plancakeGTD"><img src="/images/twitter_icon.png" /></a>                        
                        <a class="followUsBottomPanel" target="_blank" href="/blog" class="inboundLink"><img src="/images/feed_icon.png" /></a>
                    </div></li>
                    <li><div class="secondaryNavItemWrapper">
                        <a href="/jobs" class="inboundLink">We are hiring!</a>
                    </div></li>                    
                    <li><div class="secondaryNavItemWrapper">
                        <a href="/contact" class="inboundLink"><span class="lang lang_ACCOUNT_HEADER_CONTACT_US"></span></a>
                    </div></li>                
                    <li><div class="secondaryNavItemWrapper">
                        <a href="/logout" id="logoutLink" class="inboundLink"><span class="lang lang_GENERAL_LOGOUT"></span></a>
                    </div></li>        
                </ul>

            </div>
        </div>

        <div id="templateParts">
            <div id="taskDescrShortcutsTooltip" class="tip noPrint"><span class="lang lang_ACCOUNT_HINT_TASK_DESCRIPTION_SHORTCUTS"></span></div>

            <div id="dialogFormList" class="dialogForm" title="">
                <p class="validateTips"></p>

                <form method="post">
                <fieldset>
                        <input type="hidden" name="operationListForm"  id="operationListForm" value="" />                     
                        <input type="hidden" name="listIdForm"  id="listIdForm" value="" />
                        <input type="hidden" name="aboveListIdForm"  id="aboveListIdForm" value="" />                         

                        <label for="name"><span class="lang lang_ACCOUNT_LISTS_LIST_NAME"></span></label>
                        <input type="text" name="listNameForm" id="listNameForm" class="text ui-widget-content ui-corner-all" />

                        <br />

                        <label for="isListHeader" class="lang lang_ACCOUNT_MAIN_CONTENT_TICK_IF_HEADER"></label>
                        <select name="listHeaderForm" id="listHeaderForm" class="text ui-widget-content ui-corner-all">
                            <option value="0" class="lang lang_ACCOUNT_MISC_NO"></option>                                
                            <option value="1" class="lang lang_ACCOUNT_MISC_YES"></option>                                
                        </select>


                            &nbsp;&nbsp;&nbsp;
                            <a id="whatsListHeaderHelp" class="helpLink lang lang_ACCOUNT_MAIN_CONTENT_WHATS_HEADER" href="#"></a>
                            <div id="whatsListHeaderHelpTooltip" class="tip">
                                <span class="lang lang_ACCOUNT_HINT_LIST_HEADER"></span>
                                <br /><br />
                                <img src="/app/desktop/img/header_example.gif" />                                
                            </div>
                </fieldset>
                </form>
            </div>


            <div id="dialogFormTask" class="dialogForm" title="">
                <p class="validateTips"></p>

                <form method="post">
                <fieldset>
                        <input type="hidden" name="operationTaskForm"  id="operationTaskForm" value="" />                     
                        <input type="hidden" name="taskIdForm"  id="taskIdForm" value="" />
                        <input type="hidden" name="aboveTaskIdForm"  id="aboveTaskIdForm" value="" />                         

                        <label for="name"><span class="lang lang_ACCOUNT_NEW_TASK_DESCRIPTION"></span></label>
                        <img class="star" src="/app/common/img/empty_star_micro.png" style="display: none" />
                        <input type="text" name="taskDescriptionForm" class="taskDescription text ui-widget-content ui-corner-all" />

                        <div class="taskOptionsWrapper"></div>
                </fieldset>
                </form>
            </div>    


            <div id="dialogFormTag" class="dialogForm" title="">
                <p class="validateTips"></p>

                <form method="post">
                <fieldset>
                        <input type="hidden" name="operationTagForm"  id="operationTagForm" value="" />                     
                        <input type="hidden" name="tagIdForm"  id="tagIdForm" value="" />                        

                        <label for="name"><span class="lang lang_ACCOUNT_TAGS_TAG_NAME"></span></label>
                        <input type="text" name="tagNameForm" id="tagNameForm" class="text ui-widget-content ui-corner-all" />
                </fieldset>
                </form>
            </div>

            <div id="panelContent" style="display: none">
                 <form name="addTask" class="addTask noPrint ui-corner-all" method="post">
                    <table class="addTaskControls">
                        <tr>
                            
                            <td style="width: 100%">
                                <table class="taskDescriptionBlock" style="width: 100%">
                                    <tr>
                                        <td><img style="margin-left: 5px" class="star" src="/app/common/img/empty_star_micro.png" />&nbsp;</td>
                                        <td style="width: 100%">
                                            <input  style="width: 98%;" type="text" class="taskDescription" name="taskDescription" value="" autocomplete="off" />
                                        </td>
                                        <td style="width: 100%">
                                            <div>&#171; <span class="lang lang_ACCOUNT_MAIN_CONTENT_ADD_TASK_HIT_ENTER"></span></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td><span class="submitTaskButtonWrapper"><input type="submit" name="submitTask" class="submitButton" value="Add"></input></span></td>
                        </tr>
                    </table>                         
                    <a href="#" class="taskOptionsLink showTaskOptionsLink"><span class="lang lang_ACCOUNT_MAIN_CONTENT_ADD_TASK_OPTIONS_LINK"></span></a>
                    <a href="#" class="taskOptionsLink hideTaskOptionsLink hidden"><span class="lang lang_ACCOUNT_MAIN_CONTENT_ADD_HIDE_TASK_OPTIONS_LINK"></span></a>
                    <a href="#" class="helpLink taskDescrShortcutsHelp" ><span class="lang lang_ACCOUNT_MAIN_CONTENT_ADD_TASK_TIPS"></span></a>

                    <div class="taskOptionsWrapper">

                    </div>
                 </form>

                 <div class="todo_hideableHint hideableHint hidden noPrint">
                     <a class="hideableHintClose" href=".#">&#215;</a>
                     <span class="lang lang_ACCOUNT_MAIN_CONTENT_TODO_WARNING1"></span>
                 </div>

                 <div class="inbox_hideableHint hideableHint hidden noPrint">
                     <a class="hideableHintClose" href=".#">&#215;</a>                     
                     <span class="lang lang_ACCOUNT_MAIN_CONTENT_INBOX_HINT"></span>
                 </div>

                <div class="taskFilters">
                    <form class="sortTasks noPrint">
                        <span class="lang lang_ACCOUNT_MAIN_CONTENT_SORT_TASKS_BY"></span>
                        &nbsp;
                        <select>
                            <option value="sortTasksByDragAndDropOrder" class="lang lang_ACCOUNT_MAIN_CONTENT_SORT_TASKS_BY_DRAG_ORDER"></option>
                            <option value="sortTasksByDueDate" class="lang lang_ACCOUNT_MAIN_CONTENT_SORT_TASKS_BY_DATE"></option>                
                        </select>
                    </form>

                     <form class="hideScheduledTasks noPrint">
                         <label><input type="checkbox" /> <span class="lang lang_ACCOUNT_MAIN_CONTENT_HIDE_SCHEDULED_TASKS"></span></label>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     </form>
                </div>

                <div class="calendarControls noPrint"></div>

                 <p class="noTasks noPrint lang lang_ACCOUNT_MAIN_CONTENT_NO_TASKS"></p>

                 <div class="tasksLoader noPrint" >&nbsp;&nbsp;</div>

                 <ul class="tasks">                 
                 </ul>

                 <div class="searchWarning"></div>

                <form name="addTaskBottom" class="addTaskBottom noPrint" method="post">
                    <table class="taskDescriptionBlock" style="width: 98%; margin-left: 5px; margin-top: 10px;">
                        <tr>
                            <td style="width: 100%">
                                <input  style="width: 98%;" type="text" class="addTaskDescriptionBottom" name="addTaskDescriptionBottom" value="" autocomplete="off" />
                            </td>
                            <td style="width: 100%">
                                <div>&#171; <span class="lang lang_ACCOUNT_MAIN_CONTENT_ADD_TASK_AT_THE_BOTTOM"></span></div>
                            </td>
                        </tr>
                    </table>                     
                </form>

                 <ul class="completedTasks noPrint">

                 </ul>

                 <div class="completed_hideableHint hideableHint hidden noPrint">
                     <a class="hideableHintClose" href=".#">&#215;</a>                     
                     <span class="lang lang_ACCOUNT_MAIN_CONTENT_COMPLETED_HINT"></span>
                 </div>         

                 <br /><br /><br /><br /><br /><br />
            </div>

             <div id="calendarControls" class="noPrint hidden">
                 <div class="calendarPrev">
                     <div class="calendarControl calPrevMonth">
                         <a href=".#"><span class="calendarControlArrowsPrev">&lt;&lt;&lt;</span> <span class="lang lang_ACCOUNT_MAIN_CONTENT_CAL_PREV_MONTH"></span></a>
                     </div>
                     <div class="calendarControl calPrevWeek">
                         <a href=".#"><span class="calendarControlArrowsPrev">&lt;</span> <span class="lang lang_ACCOUNT_MAIN_CONTENT_CAL_PREV_7_DAYS"></span></a>
                     </div>
                 </div>
                 <div class="calendarNext">
                    <div class="calendarControl calNextMonth">
                        <a href=".#"><span class="calendarControlArrowsNext">&gt;&gt;&gt;</span><span class="lang lang_ACCOUNT_MAIN_CONTENT_CAL_NEXT_MONTH"></span></a>
                    </div>
                    <div class="calendarControl calNextWeek">
                        <a href=".#"><span class="calendarControlArrowsNext">&gt;</span><span class="lang lang_ACCOUNT_MAIN_CONTENT_CAL_NEXT_7_DAYS"></span></a>
                    </div>
                 </div>
                 <div class="calendarJump">
                     <span class="lang lang_ACCOUNT_MAIN_CONTENT_CAL_JUMP_TO_DATE"></span>
                     <form style="margin: 0px; padding: 0px; margin-top: 3px;"><input type="text" class="calendarJumpDate" /></form>
                 </div>             
             </div>      

            <div id="whatsTaskHeaderHelpTooltip" class="tip">
                <span class="lang lang_ACCOUNT_HINT_TASK_HEADER"></span>
                <br /><br />
                <img src="/app/desktop/img/header_example.gif" />                                
            </div>

            <div id="dueDateHelpTooltip" class="tip">
                <span class="lang lang_ACCOUNT_HINT_DUE_DATE"></span>        
            </div>

            <div class="taskOptions noPrint">
                <table><tbody>
                    <tr>
                        <td class="taskOptionName lang lang_ACCOUNT_MAIN_CONTENT_TICK_IF_HEADER"></td>
                        <td>
                            <select name="taskOptionHeader" class="taskOptionHeader">
                                <option value="0" class="lang lang_ACCOUNT_MISC_NO"></option>                                
                                <option value="1" class="lang lang_ACCOUNT_MISC_YES"></option>                                 
                            </select>
                            &nbsp;&nbsp;
                            <a class="whatsTaskHeaderHelp helpLink lang lang_ACCOUNT_MAIN_CONTENT_WHATS_HEADER" href="#"></a>
                        </td>
                    </tr>

                    <tr class="notForHeader">
                        <td class="taskOptionName"><span class="lang lang_ACCOUNT_NEW_TASK_LIST"></span></td>
                        <td><select class="taskOptionList"></select>
                        </td>
                    </tr>

                    <tr class="notForHeader">
                        <td class="taskOptionName"><span class="lang lang_ACCOUNT_NEW_TASK_DUE_DATE"></span></td>
                        <td>
                            <input type="text" value="" name="taskOptionDueDate" class="taskOptionDueDate" />
                            &nbsp;
                            <a class="helpLink dueDateHelpLink lang lang_ACCOUNT_NEW_TASK_DUE_DATE_HINT_LINK" href="#"><span>
                        </td>
                    </tr>

                    <tr class="notForHeader">
                        <td class="taskOptionName"><span class="lang lang_ACCOUNT_NEW_TASK_DUE_TIME"></span></td>
                        <td>

                            <select class="taskOptionDueTimeHour" name="taskOptionDueTimeHour">
                                <option value=""></option>
                            </select>
                            &nbsp;:
                            <select class="taskOptionDueTimeMinute" name="taskOptionDueTimeMinute">
                                <option value=""></option>
                            </select>        
                        </td>
                    </tr>
                    <tr class="notForHeader">
                        <td class="taskOptionName"><span class="lang lang_ACCOUNT_NEW_TASK_REPETITION"></span></td>
                        <td>
                            <select name="taskOptionRepetitions" class="taskOptionRepetitions">
                            </select> 
                            <br />
                            <div class="taskOptionRepetitionParamsWrapper"></div>
                        </td>
                    </tr>
                    <tr class="notForHeader">
                        <td class="taskOptionName"><span class="lang lang_ACCOUNT_NEW_TASK_TAGS"></span></td>
                        <td>
                            <div class="taskOptionTags"></div>
                        </td>
                    </tr>
                    <tr class="notForHeader">
                        <td class="taskOptionName"><span class="lang lang_ACCOUNT_NEW_TASK_NOTE"></span></td>
                        <td><textarea class="taskOptionNote" name="taskOptionNote"></textarea></td>
                    </tr>
                </tbody></table>
                <a href="#" class="submitTask"><span class="lang lang_ACCOUNT_MISC_ADD"></span></a>
            </div>
        </div>
    </div>

    <!-- START: JS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
    <script src="/app/common/js/mobile.detection.js"></script> <!-- this has to be the first one -->
    <script src="/app/common/js/date-en-US.js"></script> <!-- used by PlancakeTask.js -->
    <script src="/app/desktop/js/jquery-ui.min.js"></script>
    <script src="/app/desktop/js/jquery.ui.touch-punch.js"></script>
    <script src="/app/common/js/json2.js"></script>
    <script src="/app/common/js/sprintf.js"></script>    
    <script src="/app/common/js/php.js"></script>
    <script src="/app/common/js/string.js"></script>    
    <script src="/app/common/js/array.js"></script>
    <script src="/app/common/js/jlinq.js"></script>
    <script src="/app/offline/js/jlinq.plancake.extensions.js"></script>  
    <script src="/js/offline/localDatastore.detection.js"></script>    
    <script src="/app/offline/js/localStorage.js"></script>    
    <script src="/app/offline/js/applicationCache.js"></script>
    <script src="/app/offline/js/plancake.localApiHelper.js"></script>    
    <script src="/app/offline/js/plancake.localApi.js"></script>
    <script src="/app/offline/js/plancake.sync.js"></script>
    <script src="/app/desktop/js/jquery.alerts.js"></script>
    <script src="/app/common/js/jquery.pngFix.min.js"></script>
    <script src="/app/common/js/jquery.cookie.js"></script>
    <script src="/app/common/js/jquery.livequery.min.js"></script>    
    <script src="/app/desktop/js/jquery.qtip.min.js"></script>         
    <script src="/app/common/js/jquery.blockUI.js"></script>
    <script src="/app/desktop/js/jquery.pulse.js"></script>         
    <script src="/app/common/js/jquery.tinysort.js"></script>      
    <script src="/app/common/js/jquery.plancake.js"></script>
    <script src="/app/common/js/plancake.utils.js"></script>
    <script src="/app/common/js/plancake.dateUtils.js"></script>
    <script src="/app/desktop/js/plancake.ajaxNotificationFunctions.js"></script>    
    <script src="/app/common/js/plancake.ajax.js"></script>    
    <script src="/app/desktop/js/plancake.misc.js"></script>
    <script src="/app/common/js/plancake.lang.js"></script>
    <script src="/app/desktop/js/plancake.overlayContent.js"></script>    
    <script src="/app/desktop/js/plancake.overlay.js"></script> <!-- this plugin is used by plancake.init.js -->
    <script src="/app/common/js/plancake.init.common.js"></script>
    <script src="/app/desktop/js/plancake.init.js"></script>
    <script src="/app/desktop/js/plancake.search.js"></script>    
    <script src="/app/common/js/plancake.lists.common.js"></script>
    <script src="/app/desktop/js/plancake.lists.js"></script>
    <script src="/app/common/js/plancake.tags.common.js"></script>
    <script src="/app/desktop/js/plancake.tags.js"></script>
    <script src="/app/desktop/js/plancake.todayTasksReordering.js"></script>    
    <script src="/app/common/js/plancake.taskRepetitionParam.js"></script>
    <script src="/app/common/js/plancake.tasks.common.js"></script>    
    <script src="/app/desktop/js/plancake.tasks.js"></script>
    <script src="/app/desktop/js/plancake.bottomPanel.js"></script>
    <script src="/app/desktop/js/plancake.feedbackBox.js"></script>     
    <script src="/app/common/js/plancake.layout.common.js"></script>
    <script src="/app/desktop/js/plancake.layout.js"></script>
    <script src="/app/desktop/js/plancake.social.js"></script>
    <script src="/app/common/js/plancake.counters.js"></script>
    
    <script src="/app/common/js/api-client/Utils.js"></script>
    <script src="/app/common/js/api-client/PlancakeList.js"></script>
    <script src="/app/common/js/api-client/PlancakeTag.js"></script>      
    <script src="/app/common/js/api-client/PlancakeTask.js"></script>    
    <script src="/app/common/js/api-client/PlancakeApiClient.js"></script>
    
    <script src="/app/desktop/js/plancake.populateContent.js"></script>    
    <script src="/app/desktop/js/plancake.print.js"></script> <!-- this must be the last one -->    
    <!-- END: JS --> <!-- this comment is very important for minification of assets and dymanic generation of cache manifest -->
    
</body>
</html>
