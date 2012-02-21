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

<?php slot('title', 'Plancake - ' . __('WEBSITE_GENERAL_PRODUCT_SHORT_DESCRIPTION')) ?>


<div id="pc_loginBox">
    
  <a id="homeLinkForLoginBox" href="http://www.plancake.com"><img src="/app/desktop/img/logo2.png" /></a>
    
  <div id="pc_googleAccountLinkLogin">
    <a href="/openIdEndpoints/googleSendLogin.php" class="googleAccountLink"><?php echo __('WEBSITE_LOGIN_WITH_GOOGLE_ACCOUNT') ?></a>
  </div>    
  
    
    <h2><?php echo __('WEBSITE_LOGIN_HEADER') ?></h2>

    
  <?php if (!defined('PLANCAKE_PUBLIC_RELEASE')): ?>
    <div id="pc_notRegisteredYet">
        <?php printf(__('WEBSITE_LOGIN_NOT_REGISTERED_YET'), '/registration') ?>
    </div>
  <?php endif ?>      

  <?php if ($sf_user->hasFlash('login_wrong_auth')): ?>
    <div class="pc_errorMessage" id="pc_wrongAuthentication">
      <?php echo $sf_user->getFlash('login_wrong_auth') ?>
    </div>
  <?php endif; ?>

 
   
  <div id="pc_loginForm">
    <form action="<?php echo url_for('@login') ?>" method="post">
        
        <p>        
          <?php echo $form['email']->renderLabel() ?>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email']->render() ?>
        </p>

        <p>
          <?php echo $form['password']->renderLabel() ?>
          <?php echo $form['password']->renderError() ?>
          <?php echo $form['password']->render() ?>   
        </p>

        <p>
          <?php echo $form['rememberme']->renderLabel() ?>
          <?php echo $form['rememberme']->renderError() ?>
          <?php echo $form['rememberme']->render() ?>       
          <?php echo $form['return-url']->render() ?>           
        </p>     

        <br />

        <p>
            <a href="<?php echo url_for('@forgotten-password') ?>" style="display: block; float: right;"><?php echo __('WEBSITE_LOGIN_FORGOTTEN_PASSWORD') ?></a>
            <input type="submit" class="pc_beautifiedSubmitButton" value="<?php echo __('WEBSITE_LOGIN_SUBMIT') ?>" />
        </p>


    </form>
  </div>
</div>

<br /><br /><br /><br /><br />