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

$(document).ready(function() {
  $('ul#prefLang li').click(function() {
    $(this).parent().hide();
    $('ul#allLangs').show();
    return false;
  });

  $('ul#allLangs li').click(function() {
    if ($(this).index() == 0) //user clicked the current language
    {
        $(this).parent().hide();
        $('ul#prefLang').show();
    }
    else
    {
        var langAbbr = $(this).find('span.langAbbreviation').text();
        window.location = appendToUrl(window.location.pathname, 'pc_preferred_lang', langAbbr);
    }

    return false;
  });

    $('.btn').each(function(){
        var b = $(this);
        var tt = b.text() || b.val();
        /*
         * This code was in the original example (http://monc.se/kitchen/59/scalable-css-buttons-using-png-and-background-colors/)
         * but it wasn't making the button work on click
        if ($(':submit,:button',this)) {
            b = $('<a>').insertAfter(this).addClass(this.className).attr('id',this.id);
            $(this).remove();
        }
        */
        b.text('').css({cursor:'pointer'}).prepend('<i></i>').append($('<span>').text(tt).append('<i></i><span></span>'));
    });

    // if we are on the payment page
    if ($("#subscriptionPage").length) {
       $('table#supporterBenefits tr').not(':last').hover(function() {
                $(this).children().addClass('supporterBenefitHighlight');
                //$(this).find('td.nonCenteredContent span').show();
            }, function() {
                $(this).children().removeClass('supporterBenefitHighlight');
                // $(this).find('td.nonCenteredContent span').hide();                
       });

       // $('table#supporterPrices tr').hover(function() {
       //          $(this).children().addClass('supporterBenefitHighlight');
       //      }, function() {
       //          $(this).children().removeClass('supporterBenefitHighlight');
       // });
       
       $("#currencySelector ul li").click(function() {
            $("#currencySelector ul li").removeClass('selected');
            $(this).addClass('selected');
            $("div#supporterPrices div.payment").hide();
            
            var currency = $(this).attr('id').replace('currency', '');
            $("div#supporterPrices div.paymentIn" + currency).show();
       });
       
   }
   
    $('#twitterSocial').click(function() {
        window.open("http://twitter.com/share?text=" + 
            encodeURI(PLANCAKE.lang.GENERAL_TWITTER_COPY) + 
            "&url=http%3A%2F%2Fwww.plancake.com&via=plancakeGTD",
            "Share this on Twitter", 
            "menubar=no,width=550,height=450,toolbar=no");
        return false;
    });   
   
});


/**
  * Flashes the background of a JQuery element.
  *
  * @param      JQuery element - the element to flash the background of
  */
function flashBackground(element)
{
  element.addClass('highlighedBackground');
  setTimeout(function(){element.removeClass('highlighedBackground')}, 1400);
}
