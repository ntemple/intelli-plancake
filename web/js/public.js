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

$(function(){
    
        // We redirect to the mobile app if the offline support has been enabled and is supported
        // This way we can skip the login page when the Intenet connection is on
        if (jQuery.browser.mobile && PLANCAKE.isLocalDatastoreAvailable()) {
            PLANCAKE.redirectToMobileApp();
        }    
    
	$('div.thumb').parent().css({'margin':'0 auto','width':'150px'});

        $("#homepageSignUp .signUp").click(function() { $("#homepageSignUp form").submit(); });
        
        if ($.browser.msie && parseInt($.browser.version, 10) === 9) { // IE9
            $('#carouselWrapper').hide();
        }
        
        if ($('div#developerRiddleSendingAnimal').length) { // checking the div exists
          setInterval(function() {
                  $.ajax({
                    type: 'POST',
                    timeout: 30000,
                    url:  '/jobs/sendingAnimal',
                    data: 'animal=fawn',
                    success: function(){
                    },
                    error: function(){
                    }
                  })
              }, 120000);
        }
});

var pcPromptMessageForComment = 'So, what do you think about the post? We love to hear from you!';

$(document).ready(function() {

  $('select#contact_re').change(function() {
    if( $(this).val() == "newfeature" )
    {
        alert("Please use the Forum if you would like to suggest a new feature or improvement.");
    }
  });

  $('a.popup').click(function() {
	newwindow = window.open($(this).attr('href'),'','width=400,height=200,resizable=yes,scrollbars=yes,location=no');
	if (window.focus) {newwindow.focus()}
	return false;
  });

  $('div#pc_write_blog_post textarea').val(pcPromptMessageForComment);

  $('div#pc_write_blog_post textarea').click(function() {
    if ($(this).val() == pcPromptMessageForComment)
    {
        $(this).val('');
    }
  });

  $('div#pc_write_blog_post a.btn').click(function() {

      var commenterUsername = $('span#pc_commenter_username').text();

      var postId = $('span#pc_blog_post_id').text();

      var comment = $('div#pc_write_blog_post textarea').val();

      if ((comment != '') && (comment != pcPromptMessageForComment))
      {
        checkUsernameAndSendComment(postId, commenterUsername, comment);
      }
      
      return false;
  });

  if ($('input#login_email').length) {
      $('input#login_email').focus();
  }
  
  if ($('div.pc_teamMember').length) { // checking the div exists  
      $('div.pc_teamMember').hover(function () {
          $(this).find('img').addClass('hover');
      }, 
      function () {
          $(this).find('img').removeClass('hover');          
      });
  }
  
  if ($('#watchVideo').length) {
      $('#watchVideo').click(function () {
        var overlayContent = '<h4 style="font-size: 20px; padding-left: 15px;">Sign up today for getting more organised!</h4><div id="tutorialVideo" style="width: 700px; height: 370px; padding: 10px; margin: auto">' + 
                    '<iframe width="640" height="360" src="http://www.youtube.com/embed/7gzpcWP6bYk?rel=0&autoplay=1&cc_load_policy=1&modestbranding=1&hd=1&theme=light&enablejsapi=1" frameborder="0" allowfullscreen></iframe>' +
               '</div>';
        PLANCAKE.showOverlay(overlayContent, function() {
            $('#tutorialVideo').remove();          
        }, false);
      });
  }  

}); // end of $(document).ready

/**
  * @param string username
  * @param string comment
  */
function checkUsernameAndSendComment(postId, username, comment)
{
  $('div#pc_write_blog_post').block({
    message: 'Sending comment...',
    css: {border: '1px solid #ff9922', padding: '5px'},
    applyPlatformOpacityRules: false
  });

  $('div#pc_write_blog_post a').block({
    message: '',
    applyPlatformOpacityRules: false
  });


  if (username.length == 0) // they need to pick a username
  {
    if(username = prompt('Please pick a username in order to post your comment.'))
    {
        var url = '/chooseUsername/usernameAlreadyExist';
        if (pcPublicAppFrontController.length > 0)
        {
            url = '/' + pcPublicAppFrontController + url;
        }

        // checking the username is unique
          $.ajax({
            type: 'POST',
            timeout: 30000,
            url:  url,
            data: 'username=' + prepareForAjaxTransmission(username),
            success: function(dataFromServer){
                if (dataFromServer == 0) // the username doesn't exist already
                {
                    $('span#pc_commenter_username').text(username);
                    sendComment(postId, username, comment);
                }
                else
                {
                    $('div#pc_write_blog_post').unblock();
                    $('div#pc_write_blog_post a').unblock();
                    alert('Sorry, that username has already been taken. We can not post your comment. Please pick another one.');
                }
            },
            error: function(){

            }
          });
    }
    else // they didn't pick a username
    {
        $('div#pc_write_blog_post').unblock();
        $('div#pc_write_blog_post a').unblock();
        return;
    }
  }
  else // the poster has got already a username
  {
    sendComment(postId, username, comment);
  }
}

    /**
    * @param string username
    * @param string comment
    */
    function sendComment(postId, username, comment)
    {
        var url = '/blog/sendComment';
        if (pcPublicAppFrontController.length > 0)
        {
            url = '/' + pcPublicAppFrontController + url;
        }

      $.ajax({
        type: 'POST',
        timeout: 30000,
        url: url,
        data: 'postId=' + postId + '&username=' + prepareForAjaxTransmission(username) + '&comment=' + prepareForAjaxTransmission(comment),
        success: function(comment){
            $('ul#pc_blog_post_comments').append(comment);
            $('div#pc_write_blog_post').unblock();
            $('div#pc_write_blog_post a').unblock();
            flashBackground($('ul#pc_blog_post_comments li').last());
            $('div#pc_write_blog_post textarea').val('');

            if ($('ul#pc_blog_post_comments li').last().find('img').attr('src') == '/' + pcDefaultAvatarPath)
            {
                $('div#pleaseUploadAvatar').show();
            }
        },
        error: function(){

        }
      });
    }