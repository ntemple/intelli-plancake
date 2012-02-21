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

<?php if (! defined('PLANCAKE_PUBLIC_RELEASE')): ?>
<div class="" style="width: 400px; clear: both; margin-bottom: 25px; position: relative;">

    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'7ab9e98e-4f84-433c-b8f1-2bfef6b2ba24'});</script>

    <span class="st_email"></span><span class="st_gbuzz"></span><span class="st_sharethis"></span>

    <div style="position: absolute; display: block; top: 0px; left: 90px; width: 100px;">
        <a href="http://twitter.com/share" class="twitter-share-button" data-count="none" data-via="plancakeGTD" url="http://www.plancake.com" text="Tweet this!">Tweet</a>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>

    <div style="position: absolute; left: 155px; top: 0px; width: 100px;">
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like width="225"></fb:like>
    </div>
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
<?php endif ?>