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

PLANCAKE.isMobile = false;
PLANCAKE.isOfflineEnabled = false;

PLANCAKE.COOKIE_NAME_FOR_FEEDBACK_BOX = 'feedbackBox';
PLANCAKE.COOKIE_NAME_FOR_PANEL2_VISIBLE = 'panel2Visible';
PLANCAKE.COOKIE_NAME_SPLIT_VIEW_HINT_SHOWN = 'splitViewHintShown';
PLANCAKE.BASE_URL = /https?:\/\/*\/.*\.php/i.exec(document.URL)[0]; // i.e.: http://www.plancake.com/account.php

PLANCAKE.ENTER_KEY_CODE = 13;
PLANCAKE.PRINT_URL_STRING = '#print';

PLANCAKE.PROD_ENV = 'prod';
PLANCAKE.DEV_ENV = 'dev';
PLANCAKE.STAGING_ENV = 'staging';

PLANCAKE.PROD_URL = 'http://www.plancake.com';
PLANCAKE.DEV_URL = 'http://www.plancake';
PLANCAKE.STAGING_URL = 'http://staging.plancake.com';

PLANCAKE.PROD_ACCOUNT_URL = '/account.php';
PLANCAKE.DEV_ACCOUNT_URL = '/account_dev.php';
PLANCAKE.STAGING_ACCOUNT_URL = '/account_staging.php';

PLANCAKE.env = null;

PLANCAKE.taskDropped = false; // to tell the difference between when tasks are sorted or dropped to lists/tags
PLANCAKE.listIdForTaskDropped = 0;
PLANCAKE.tagIdForTaskDropped = 0;

PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_INIT_DATA, 
                         '', '', function (startupData) {
    PLANCAKE.initPopulateStartupVariables(startupData);
    if (typeof PLANCAKE.supportsHtml5Storage == "function") {   // needed for the open source package that doesn't include offline
       if (PLANCAKE.isOfflineEnabled || PLANCAKE.supportsHtml5Storage()) {
            localStorage.setItem(PLANCAKE.LOCAL_STORAGE_KEY_STARTUP_DATA, JSON.stringify(startupData));
       }
    }    
    $.holdReady(false);
});

// this detects the enviroment
(function () {
    PLANCAKE.env = PLANCAKE.PROD_ENV;
    if (document.URL.indexOf(PLANCAKE.DEV_ACCOUNT_URL) !== -1) {
        PLANCAKE.env = PLANCAKE.DEV_ENV;
    } else if (document.URL.indexOf(PLANCAKE.STAGING_ACCOUNT_URL) !== -1) {
        PLANCAKE.env = PLANCAKE.STAGING_ENV;    
    }
})();


$(document).ready(function () {

    function adjustmentsForSmallScreens() {  // e.g.: 1024x768
        var windowWidth = $(window).width();
        
        if (! (windowWidth > 0)) { // we couldn't retrieve the window width
            return;
        }
        
        if (windowWidth < 1050 ) {
            $('.bottomPanelFiller').hide();
        }
    }
    adjustmentsForSmallScreens();
    
    
    if (PLANCAKE.isIE6()) {
        alert(PLANCAKE.lang.ACCOUNT_ERROR_UPGRADE_YOUR_BROWSER);
        // $('body').html('').hide();    
    }
    
    var importantAlertsToShowOnStartup = false;
    
    var lists = null;
    var tags = null;
    
    // the links in the app suit the prod environment (they are relatives) - changing 
    // now the links according to the environment
    (function () {
        if (PLANCAKE.env !== PLANCAKE.PROD_ENV) {            
            var url = PLANCAKE.DEV_URL;
            var urlAccount = PLANCAKE.DEV_ACCOUNT_URL;            
            if (PLANCAKE.env === PLANCAKE.STAGING_ENV) {
                url = PLANCAKE.STAGING_URL;                
                urlAccount = PLANCAKE.STAGING_ACCOUNT_URL;
            }
            
            $('a.inboundLink').each(function(){
                this.href = this.href.replace(PLANCAKE.PROD_ACCOUNT_URL, urlAccount);
            });        
        }
    })();
/*
    if (PLANCAKE.userSettings.isPremium) {
        $('a').each(function(){
            this.href = this.href.replace('http://', 'https://');
        });
    }
  */  
    $('.calendarControls').html($('#calendarControls').show());   
    $('.panelContent').html($('#panelContent').show());  
    
    function initFeedbackBox () {
        var cookieContent = $.cookie(PLANCAKE.COOKIE_NAME_FOR_FEEDBACK_BOX);
        
        if (cookieContent && (cookieContent === '0')) {
            $('#feedbackBox').hide();
        }
    }

    function hideAds () {
        $('#mainAd').hide();
        $('#teamBanner').hide();
        $('#donateButton').hide();
        $('#upgradeButton').hide();
        $('#socialWidgets').hide();
    }
    
    function prepPublicRelease() {
        $('#feedbackBox').hide();
        $('#helpButton').hide();
    }
    
    function prepQuoteOfTheDay() {
        if (!importantAlertsToShowOnStartup) {
            if(PLANCAKE.data['quoteContent'] && PLANCAKE.data['quoteContent'].length) {
                PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_quoteOfTheDay());
            }
        }
    }
    
    function prepBreakingNews() {
        var breakingNewsId = PLANCAKE.data.breakingNewsId;
        var breakingNewsHeadline = PLANCAKE.data.breakingNewsHeadline;
        
        if (PLANCAKE.data.breakingNewsLink.length) {
            breakingNewsHeadline += ' <a target="_blank" href="' + PLANCAKE.data.breakingNewsLink + '">' +
                PLANCAKE.lang.ACCOUNT_MISC_READ_MORE_ON_OUR_BLOG + '</a>';
        }
        
        if (breakingNewsHeadline.length) {
            $('#breakingNewsId').text(breakingNewsId);            
            $('#breakingNewsHeadline').html(breakingNewsHeadline);
            $('#breakingNews').show();             
        }
    }
    
    function prepHideableHints() {
        if (PLANCAKE.hideableHintsSetting.inbox) {
            $('.inbox_hideableHint').remove();
        }
        if (PLANCAKE.hideableHintsSetting.todo) {
            $('.todo_hideableHint').remove();
        }
        if (PLANCAKE.hideableHintsSetting.completed) {
            $('.completed_hideableHint').remove();
        }
        delete(PLANCAKE.hideableHintsSetting);
    }
    
    PLANCAKE.initPopulateLayout();        
        
    initFeedbackBox();
    
    prepBreakingNews();
    
    prepHideableHints();
    
    if (PLANCAKE.userSettings.isPremium) {
        hideAds();
    } 
    
    if (PLANCAKE.data.isPublicRelease) {
        prepPublicRelease();
    }
    

    
    /// {{{ START: overlay on startup
    if (PLANCAKE.data.showExpiringSubscriptionAlert) {
        importantAlertsToShowOnStartup = true;
        PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_expiringMembership());
    }
    
    if (PLANCAKE.data.isSubscriptionExpired) {
        importantAlertsToShowOnStartup = true;        
        PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_expiredMembership());
    }
    if (PLANCAKE.data.isFirstDesktopLogin) {
        importantAlertsToShowOnStartup = true;        
        PLANCAKE.showOverlay(PLANCAKE.getOverlayContent_videoTutorial(), function() {
            $('#tutorialVideo').remove();
        });
    }

    prepQuoteOfTheDay();    
    /// }}} END: overlay on startup        
    
    
    // in the markup that div is hidden to let the layout adjust itself without the user noticing that
    $('#hiddenDuringInitialLoading').show();
    $('.loadingElements').remove();
    
    if ( PLANCAKE.supportsHtml5Storage() && PLANCAKE.isLocalDatastoreAvailable() ) {
        $('#linkToMobileApp').show();
    } else {
        $('#linkToMobileApp').hide();
    }
    
    
});
