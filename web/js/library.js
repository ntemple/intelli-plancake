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

function ucfirst (str) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: ucfirst('kevin van zonneveld');
    // *     returns 1: 'Kevin van zonneveld'
 
    str += '';
    var f = str.charAt(0).toUpperCase();
    return f + str.substr(1);
}

function appendToUrl(url, param, value)
{
    var paramAndValue = param + '=' + value;

    return url + (url.indexOf('?') != -1 ? ("&" + paramAndValue) : ("?" + paramAndValue));
}

/**
  *
  */
function prepareForAjaxTransmission(text)
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

String.prototype.format = function() {
    var formatted = this;
    for (var i = 0; i < arguments.length; i++) {
        var regexp = new RegExp('\\{'+i+'\\}', 'gi');
        formatted = formatted.replace(regexp, arguments[i]);
    }
    return formatted;
};

/**
 * @param string text
 * @return string
 */
function linkify(text)
{
  var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
  return text.replace(exp,"<a href='$1'>$1</a>");
}