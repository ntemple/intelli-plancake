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

<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
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