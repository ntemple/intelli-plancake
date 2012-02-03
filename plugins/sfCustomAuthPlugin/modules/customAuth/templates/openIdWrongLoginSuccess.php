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

<?php slot('title', 'Plancake') ?>

<div class="pc_leftColumn">

  <?php echo __('WEBSITE_GOOGLE_ACCOUNT_DONT_EXIST_ERROR1') ?>

  <?php printf(__('WEBSITE_GOOGLE_ACCOUNT_DONT_EXIST_ERROR2'), url_for('@registration?input_email=' . $inputEmail),
                                                                $inputEmail,
                                                                url_for('@login'),
                                                                $inputEmail) ?>

</div>
<div class="pc_sidebar">
<?php if (!defined('PLANCAKE_PUBLIC_RELEASE')): ?>
    <?php include_partial('templateParts/featuresSidebar') ?>
<?php endif ?>
</div>
