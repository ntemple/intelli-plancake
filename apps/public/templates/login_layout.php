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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>

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
    <meta property="og:site_name" content="Plancake" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $sf_request->getUri(); ?>" />
    <meta property="fb:app_id" content="157356510972189" />

    <title>      
        <?php if (!include_slot('title')): ?>
            <?php echo 'Plancake - ' . __('WEBSITE_GENERAL_PRODUCT_SHORT_DESCRIPTION') ?>
        <?php endif ?>
    </title>
<?php endif ?>
    
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa"></link>    

    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body id="pc_loginPage">

      
    <div id="pc_content">
      <?php echo $sf_content ?>
    </div>
      
    <?php if( ($sf_params->get('module') == 'plans') && (PcUserPeer::getLoggedInUser()) ||
            ($sf_params->get('module') == 'registration') || 
            ($sf_params->get('module') == 'customAuth')): ?>
    
    <?php else :?>
        <?php include_component('templateParts', 'footer'); ?>
    <?php endif ?>

    <?php include_javascripts() ?>  
      
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-20928065-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>

  </body>
</html>
