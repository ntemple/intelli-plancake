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
    <div id="pc_socialWidgets">
        <ul>
                <li>Spread the love</li>
                <li>
                <script type="text/javascript" charset="utf-8">
                tweetmeme_source = 'plancake';
                tweetmeme_url = '<?php echo PcUtils::getCurrentURL() ?>';
                </script>
                <script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
                </li>

                <li>

                      <a name="fb_share" type="box_count" href="http://www.facebook.com/sharer.php?u=<?php echo PcUtils::getCurrentURL() ?>">Share</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>


                </li>
        </ul>
    </div>
<?php endif ?>
