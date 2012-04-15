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
    <title>      
        <?php  if (!include_slot('title')): ?>
            <?php echo sfConfig::get('app_site_name') . ' - ' . __('WEBSITE_GENERAL_PRODUCT_SHORT_DESCRIPTION') ?>
        <?php  endif ?>

    </title>

<?php if (!defined('PLANCAKE_PUBLIC_RELEASE')): ?>
    <?php include_http_metas() ?>
    <meta name="description" content="<?php echo __('WEBSITE_GENERAL_PRODUCT_LONG_DESCRIPTION') ?>" />
    <?php include_metas() ?>

    <?php if (has_slot('og_title')): ?>
      <meta property="og:title" content="<?php include_slot('og_title') ?>" />
    <?php else: ?>
      <meta property="og:title" content="<?php echo __('WEBSITE_HOMEPAGE_META_OG_TITLE') ?>" />
    <?php endif; ?>

    <?php if (has_slot('og_description')): ?>
      <meta property="og:description" content="<?php include_slot('og_description') ?>" />
    <?php else: ?>
      <meta property="og:description" content="<?php echo __('WEBSITE_HOMEPAGE_SECONDARY_COPY') ?>" />
    <?php endif; ?>

    <meta property="og:image" content="http://www.plancake.com/images/plancake_logo_square.png" />
    <meta property="og:site_name" content="<?php echo sfConfig::get('app_site_name') ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $sf_request->getUri(); ?>" />
    <meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_appid') ?>" />
<?php endif ?>

    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa"></link>    
    <link rel="shortcut icon" href="/favicon.ico" />
