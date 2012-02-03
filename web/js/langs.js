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

var pc_activeTranslationTextarea = null;

$(document).ready(function() {
    $('form.translationForm').submit( function() {
       sendTranslation($(this), false);
       return false;
    });

    $('a.resetTranslation').click(function() {
        var form = $(this).parent().parent();
        form.find('textarea').val('');
        sendTranslation(form, true);
        setToBeCompleted(true, form);
        return false;
    });

    $('textarea').TextAreaExpander();

    $('textarea').focus(function() {
        pc_activeTranslationTextarea = $(this);
        
    });

    $('textarea').blur(function() {
        pc_activeTranslationTextarea = null;
    });

    $('textarea').keyup(function() {
        var charsLeft = parseInt($(this).parent().find('span.charsLeft').text());
        var maxLength = parseInt($(this).parent().find('span.maxLength').text());

        if (charsLeft >= 0)
        {
            $(this).val( $(this).val().substring(0, maxLength) );
            var charsLeftSpan = $(this).parent().find('span.charsLeft');
            charsLeftSpan.text(maxLength - $(this).val().length);
        }
    });
});

/**
 * @param JQuery form
 * @param bool reset
 */
function sendTranslation(form, reset)
{
      var url = '/' + pcLangsHomeUrl + '/strings/saveTranslation';

      var translation = form.find('textarea').val();
      var stringId = form.parent().parent().find('div.stringId').text();

      var data = 'stringId=' + stringId + '&translation=' + prepareForAjaxTransmission(translation);

      notifyAjaxStart(form);
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
          else if ( (typeof(dataFromServer) == 'string') && (dataFromServer.indexOf('OK') === -1) )
          {
            notifyAjaxError(dataFromServer);              
          }
          else
          {
                  notifyAjaxSuccess();
                  if (reset)
                  {
                    setToBeCompleted(true, form);
                  }
                  else
                  {
                    setToBeCompleted(false, form);
                  }
          }
          _afterAjaxRequest(form);
        },
        error: function(){
          notifyAjaxError('An error occurred');
          _afterAjaxRequest(form);
        }
      });
}

/**
 * @param JQuery form
 */
function notifyAjaxStart(form)
{
  form.find('img.sendingTranslation').show();
  form.block({
    message: 'Performing operation...',
    css: {border: '1px solid #ff9922', padding: '5px'},
    applyPlatformOpacityRules: false
  });
}

function notifyAjaxSuccess()
{
    $('div#successMessage').text("Operation completed successfully.");
    _showFeedback($('div#successMessage'));
}

/**
 * @param string errorMessage
 */
function notifyAjaxError(errorMessage)
{
    if (! errorMessage) {
        errorMessage = "generic error - maybe you are not logged in to Plancake";
    }
    $('div#errorMessage').text(errorMessage);
    _showFeedback($('div#errorMessage'));
}

/**
 * @param JQuery feedbackArea
 */
function _showFeedback(feedbackArea)
{
    feedbackArea.show();
    setTimeout( function() {
                feedbackArea.fadeOut(3000);
              }, 2000);
}

/**
 * @param JQuery form
 */
function _afterAjaxRequest(form)
{
    form.find('img.sendingTranslation').hide();
    form.unblock();
}

/**
 * @param bool toBeCompleted
 * @param JQuery form
 */
function setToBeCompleted(toBeCompleted, form)
{
    var li = form.parent().parent();
    if (toBeCompleted)
    {
        li.addClass('toBeTranslated');
    }
    else
    {
        li.removeClass('toBeTranslated');
    }
}