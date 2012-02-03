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

    var feedbackBoxPromptMessage = "";
    var supportPhotoFilename = null;
    
    var boxExpanded = false;
    
    if (PLANCAKE.userSettings.lang == 'it') {
        supportPhotoFilename = $('#feedbackBox img').attr('src').replace('_en', '_it');
        $('#feedbackBox img').attr('src', supportPhotoFilename);
    }
    
    $('textarea#feedbackBoxMessage').addClass('lightColorText');

    $('textarea#feedbackBoxMessage').click(function() {
        if (!boxExpanded) {
            getFeedbackBoxReadyForInput();
        }
    });

    $('a#cancelFeedback').click(function() {
        resetFeedbackBox();
    });

    $('a#sendFeedback').click(function() {
        sendFeedback();
    })
    .button();
    
    $('a#closeFeedbackBox').click(function() {
        $('#feedbackBox').effect("transfer", {to: $('a#helpButton'), className: "ui-effects-feedbackBox-transfer"}, 1000);
        $('#feedbackBox').hide();
        resetFeedbackBox();
        $.cookie(PLANCAKE.COOKIE_NAME_FOR_FEEDBACK_BOX, '0', {expires: 70});
        $('#helpButton').pulse({
            opacity: [0.25, 1],
            backgroundColor: ['#fff', '#fef7ff']
        }, 1000, 2, 'linear', function(){
            // alert("I'm done pulsing!");    
        });
    });    

    feedbackBoxPromptMessage = $('textarea#feedbackBoxMessage').val();

    function getFeedbackBoxReadyForInput()
    {
        boxExpanded = true;
        var textarea = $('textarea#feedbackBoxMessage');
        textarea.val('');
        textarea.addClass('darkColorText');
        $('#feedbackBox').css('width', 405);        
        textarea.css('width', 400);
        textarea.css('height', 80);
        $('a#cancelFeedback').show();
    }

    function resetFeedbackBox()
    {
        var textarea = $('textarea#feedbackBoxMessage');
        // textarea.addClass('lightColorText');
        textarea.css('color', '#777'); // adding a class wasn't working!
        textarea.val(feedbackBoxPromptMessage);
        $('#feedbackBox').css('width', 235); 
        textarea.css('width', 230);
        textarea.css('height', 50);
        $('a#cancelFeedback').hide();
        boxExpanded = false;
    }

    function sendFeedback()
    {
        if (! boxExpanded) {
            alert(PLANCAKE.lang.ACCOUNT_FEEDBACK_BOX_ERROR_MSG);
        } else {       
            $('div#feedbackBox').block({
                message: PLANCAKE.lang.ACCOUNT_FEEDBACK_THANK_YOU,
                css: {border: '1px solid #ff9922', padding: '5px'},
                applyPlatformOpacityRules: false
            });

            var ajaxParams = 'message=' + PLANCAKE.prepareForAjaxTransmission($('textarea#feedbackBoxMessage').val());
            PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_SEND_FEEDBACK, 
                                     ajaxParams, '', function() {
                    setTimeout(function() {
                        $('div#feedbackBox').unblock();
                        resetFeedbackBox();
                        boxExpanded = false;
                    }, 3000);
            });
        }
    }
});