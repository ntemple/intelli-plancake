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

    <div id="pc_header">
      <div id="pc_innerHeader">
	<?php if ($sf_context->getModuleName() != 'registration'): ?>
          
          <div id="headerLoginSignupArea">
              <?php if (! $sf_user->isAuthenticated()): ?>
                <a href="/openIdEndpoints/googleSendLogin.php" id="pc_googleAccountLoginButton" class="googleAccountLink"><?php echo __('WEBSITE_HEADER_SIGN_IN_WITH_GOOGLE') ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="<?php echo $links['registration'] ?>" id="pc_registerButton" class="orangeBtn"><?php echo __('GENERAL_CREATE_ACCOUNT') ?></a>
                &nbsp;&nbsp;&nbsp;
                <a href="<?php echo $links['login'] ?>" id="pc_loginButton" class="blueBtn"><?php echo __('GENERAL_LOGIN') ?></a>
              <?php else: ?>
                <a href="/<?php echo sfConfig::get('app_accountApp_frontController') ?>" id="pc_myAccountButton" class="orangeBtn"><?php echo __('GENERAL_MY_ACCOUNT') ?></a>
              <?php endif ?>
          </div>
	<?php endif ?>
            <?php if (!defined('PLANCAKE_PUBLIC_RELEASE')): ?>
          
                <!-- The homepage and the Services main page already have an H1 in the content -->
                <?php if (($sf_context->getModuleName() == 'homepage') || 
                          ( ($sf_context->getModuleName() == 'about') && ($sf_params->get('action') == 'index') )): ?>
                    <a id="pc_logo" href="<?php echo $links['homepage'] ?>">Plancake</a>
                <?php else: ?>
                    <h1><a id="pc_logo" href="<?php echo $links['homepage'] ?>">Plancake</a></h1>
                <?php endif ?>
                    
            <?php endif ?>

        <?php if (!defined('PLANCAKE_PUBLIC_RELEASE')): ?>
            <?php if ($sf_context->getModuleName() != 'registration'): ?>
              <div id="pc_headerLinks">
                  <?php if ($sf_user->isAuthenticated()): ?>
                    <!-- <a href="<?php echo $links['homepage'] ?>" class="pc_headerButton <?php include_slot('sel_homepage') ?>"><?php echo __('WEBSITE_HEADER_HOME_LINK') ?></a> -->

                    <!-- <a href="<?php echo $links['services'] ?>" class="pc_headerButton <?php include_slot('sel_services') ?>"><?php echo __('WEBSITE_HEADER_SERVICES_LINK') ?></a> -->
                  <?php endif ?>
                    <!-- <a href="<?php echo $links['roadmap'] ?>" class="pc_headerLink <?php include_slot('sel_roadmap') ?>">Roadmap</a> -->


                <?php if ($sf_user->isAuthenticated()): ?>
                    <!-- <a href="<?php echo $links['blog'] ?>" class="pc_headerButton <?php include_slot('sel_blog') ?>"><?php echo __('WEBSITE_HEADER_BLOG_LINK') ?></a> -->
                    <?php if (PLANCAKE_FORUM_ENABLED): ?>
                      <!-- <a href="/forums/index.php" class="pc_headerButton <?php include_slot('sel_forum') ?>"><?php echo __('WEBSITE_HEADER_FORUM_LINK') ?></a> -->
                    <?php endif ?>
                    <!-- <a href="<?php echo $links['contact'] ?>" class="pc_headerLink <?php include_slot('sel_contact') ?>"><?php echo __('WEBSITE_HEADER_CONTACT_US_LINK') ?></a> -->
                <?php endif ?>

              </div>
            <?php endif ?>
        <?php endif ?>
                
      </div>
    </div>