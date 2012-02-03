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
 * @param mixed varToDebug
 * @param string comment
 */
__d = function(varToDebug, comment) {
    if ( (typeof console !== 'undefined') && (console !== null) ) {
        if ((comment !== null) && (comment !== undefined)) {
            console.log(comment);
        }
        console.log(varToDebug);
        console.log("////////////////////////////////////////");
    }
}

PLANCAKE.encodeEntities = function (s){
    if ((s ==! null) && (s !== undefined)) {
        return $("<div/>").text(s).html();
    } else {
        return s;
    }
}

PLANCAKE.dencodeEntities = function (s){
        return $("<div/>").html(s).text();
};

PLANCAKE.isIE6 = function() {
    return ($.browser.msie && parseInt($.browser.version, 10) === 6);
};

PLANCAKE.isIE7 = function () {
    return ($.browser.msie && parseInt($.browser.version, 10) === 7);
};

PLANCAKE.isIE = function () {
    return $.browser.msie;
};

PLANCAKE.isWebkit = function () {
    return $.browser.webkit;
};

/**
 * What you would expect with one exception:
 * "0" becomes false
 * 
 * @param mixed v
 * @return bool
 */
PLANCAKE.toBoolean = function (v) {
    if (v === "0") {
        v = 0;
    }
    return !!v;
};

/**
  * Flashes the background of a JQuery element.
  *
  * @param      JQuery element - the element to flash the background of
  */
PLANCAKE.flashBackground = function(element)
{
  element.addClass('highlighedBackground');
  setTimeout(function(){element.removeClass('highlighedBackground')}, 800);
};

/**
* Guarantees a text is not longer than $maxlength chars
* (if it is, it's shortened and appended three dots to it by default)
*
* @param string text - the text to adjust
* @param int - the maximum number of characters
* @param string filler - three dots by default
* @return string - the adjusted text
*/
PLANCAKE.getTeaser = function (text, maxlength, filler) {
    if ((filler === null) || (filler === undefined)) {
        filler = '...';
    }
  
    return (text.length > maxlength) ? (text.substring(0, (maxlength - filler.length)) + filler) : text;
};

/**
* Returns the ordinal number corresponding to the cardinal passed as input
* 
* @param integer cardinalNumber - number to convert
* @param boolean abbr(=true) - whether return just an abbreviation (e.g.: '1st' rather than 'first') 
* @return string
*/
PLANCAKE.getOrdinalFromCardinal = function (cardinalNumber, abbr) {
    if ( (abbr === null) || (abbr === undefined)) {
        abbr = true;
    }
    
    var ordinalNumbers = ['', 'first', 'second', 'third', 'forth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth', 'eleventh', 'twelfth', 'thirteenth', 'fourteenth', 'fifteenth', 'sixteenth', 'seventeenth', 'eighteenth', 'nineteenth', 'twentieth', 'twenty-first', 'twenty-second', 'twenty-third', 'twenty-fourth', 'twenty-fifth', 'twenty-sixth', 'twenty-seventh', 'twenty-eighth', 'twenty-ninth', 'thirtieth'];

    var ordinalNumbersAbbr = ['', '1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21st', '22nd', '23rd', '24th', '25th', '26th', '27th', '28th', '29th', '30th'];

    return abbr ? ordinalNumbersAbbr[cardinalNumber] : ordinalNumbers[cardinalNumber];
};

/*
 * @param string html
 */
PLANCAKE.stripHtmlTags = function(html) {
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent||tmp.innerText;
};

/*
 * @param string str
 * @return string
 */
PLANCAKE.nl2br = function(str) {
   return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br />' + '$2');
};

/*
 * @param string str
 * @return string
 */
PLANCAKE.br2nl = function(str) {
   return (str + '').replace('<br />', '\n');
};

PLANCAKE.is_numeric = function(v) {
    return (typeof(v) === 'number' || typeof(v) === 'string') && v !== '' && !isNaN(v);
}

/**
 * @param string text
 * @return string
 */
PLANCAKE.linkify = function(text)
{
  if ( (text === null) || (text === undefined)) {
      return '';
  }
  var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
  return text.replace(exp,"<a target='_blank' href='$1'>$1</a>");
}

PLANCAKE.reloadApp = function() {
    window.location.href = PLANCAKE.getAppUrl();
}

PLANCAKE.getAppUrl = function () {
    var url = '';
    if (PLANCAKE.env === PLANCAKE.PROD_ENV) {           
        url = PLANCAKE.PROD_URL + PLANCAKE.PROD_ACCOUNT_URL;
    } else if (PLANCAKE.env === PLANCAKE.STAGING_ENV) {
        url = PLANCAKE.STAGING_URL + PLANCAKE.STAGING_ACCOUNT_URL;        
    } else if (PLANCAKE.env === PLANCAKE.DEV_ENV) {
        url = PLANCAKE.DEV_URL + PLANCAKE.DEV_ACCOUNT_URL;        
    }
    return url;
}

/**
 * @param string urlQueryString - e.g.:  type=list&extraParam=3
 * @return associative array:
 */
PLANCAKE.getHashParams = function (urlQueryString) {
    var hashParams = {};
    var e,
        a = /\+/g,  // Regex for replacing addition symbol with a space
        r = /([^&;=]+)=?([^&;]*)/g,
        d = function (s) { return decodeURIComponent(s.replace(a, " ")); };

    while (e = r.exec(urlQueryString))
       hashParams[d(e[1])] = d(e[2]);

    return hashParams;
}

/**
 * THIS IS AN HACK!!!!
 *
 * We assumes that:
 * _ if the coordinates or the taps are the same, then it is firing twice (not completely reliable approach)
 * _ if the previous click was less than 3 secs ago, than it is the same click (not completely reliable approach)
 *
 * @param JQuery element
 * @param event
 * @return boolean - true if it seems the event has been firing multiple times
 */
PLANCAKE.isFiringMultipleTimes = function (element, event) {
    var isMultipleFiring = false;
    
    // first approach: coordinates
    var lastclickpoint = element.attr('data-clickpoint');
    var curclickpoint = event.pageX + 'x' + event.pageY;
    if (lastclickpoint == curclickpoint) {
      isMultipleFiring = true;  
    }    
    element.attr('data-clickpoint', curclickpoint);  
    
    // second approach: time
    var lastclicktime = element.attr('data-clicktime'); 
    if ( (time()-lastclicktime) < 3) {  // php.js
      isMultipleFiring = true;  
    }    
    element.attr('data-clicktime', time());  // php.js


    return isMultipleFiring;
}