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

<div class="pc_sidebarBlock" id="pc_blogSubscribeSidebar">
<h4>Subscribe to our blog</h4>

<ul>
    <li><img src="/images/feed_icon_small.gif" />&nbsp;<a href="<?php echo url_for('@blog_rss') ?>">All categories</a></li>
<?php foreach($categories as $category): ?>
    <li><img src="/images/feed_icon_small.gif" />&nbsp;<a href="<?php echo url_for('blog_rss_category', $category) ?>">
        <?php echo $category->getName() ?>
        </a>
    </li>
<?php endforeach ?>
</ul>

</div>
