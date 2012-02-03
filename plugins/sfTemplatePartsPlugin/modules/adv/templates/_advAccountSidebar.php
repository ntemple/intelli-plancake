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

<div class="rightColumnModule">

    <div style="margin-top: 20px; padding: 5px; padding-left: 15px; border: 1px solid #ccc; position: relative">

      <a href="<?php echo url_for('@subscribe') ?>"
         style="display: block; position: absolute; height: 20px; top: -15px; right: 0px; color: #fff; background-color: #0085ef; font-weight: bold; padding: 1px 5px;">
          <?php echo __('ACCOUNT_MISC_REMOVE_THIS_AD') ?>
      </a>

      <div class="googleAd">
          <?php include_partial('adv/googleAdsenseSmallSquare') ?>
      </div>
    </div>
</div>