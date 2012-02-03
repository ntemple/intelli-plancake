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
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <title>
        <?php include_slot('title') ?>
    </title>
      
    <?php if(PcLanguagePeer::isUserPreferredLanguageRTL()): ?>
        <style>
        input, textarea {
            direction: rtl;
        }
        </style>
    <?php endif ?>         

    <?php include_component('misc', 'localizedStrings') ?>

    <meta property="og:title" content="Plancake - Free Task and List Manager & Personal Organizer" />
    <meta property="og:image" content="http://www.plancake.com/images/plancake_logo_v2.png" />
    <meta property="og:site_name" content="Plancake" />
    <meta property="og:type" content="company" />
    <meta property="og:url" content="http://www.plancake.com" />
    <meta property="fb:app_id" content="157356510972189" />

    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body id="module_<?php echo $sf_context->getModuleName() ?>">
      
    <div id="showHelp">
      <a id="showHelpClose" href="javascript: void(0)"><?php echo __('ACCOUNT_MISC_CLOSE') ?> [X]</a>
      <span></span>
    </div>      
      
    <div id="allPage">
      <div id="mainNavigation">
	<a class="noUnderline" href="<?php echo url_for('@homepage') ?>"><h1>Plancake</h1></a>       
        
        <!-- <span class="motto"><?php echo strtolower(__('GENERAL_SLOGAN')) ?></span> -->
        
        <?php if ($sf_request->getParameter('onRegistration') != '1'): ?>
            <a class="btn" id="backToTasksLink" href="<?php echo url_for('@homepage') ?>"><<< <?php echo __('ACCOUNT_LISTS_GO_BACK_TO_TASKS') ?></a>
        <?php endif ?>
      </div> 

      <div id="mainContent">
	<?php echo $sf_content ?>
      </div> <!-- id="mainContent" -->

      <?php if($sf_context->getModuleName() != 'subscribe'): ?>
        <?php // include_component('templateParts', 'footer'); ?>
      <?php else: ?>
      <?php endif ?>
      
        <br /><br /><br />      
      
    <?php include_javascripts() ?>

  </body>
</html>
