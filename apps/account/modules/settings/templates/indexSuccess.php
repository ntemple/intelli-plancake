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

<?php slot('sel_settings', 'selected') ?>
<?php slot('title', 'Plancake ' . __('ACCOUNT_HEADER_SETTINGS') ) ?>

<div class="standardContent">

  <?php if ($sf_user->hasFlash('settingSuccess')): ?>
    <div class="pc_confirmationMessage">
      <?php echo $sf_user->getFlash('settingSuccess') ?>
    </div>
    <p>&nbsp;</p>
  <?php endif; ?>
    
  <h2><?php echo __('ACCOUNT_SETTINGS_ACCOUNT_INFO_HEADER') ?></h2>
  <ul class="niceMenu">
      <li><?php echo __('ACCOUNT_SETTINGS_ACCOUNT_TYPE') ?>
          <?php if(PcUserPeer::getLoggedInUser()->isSupporter()): ?>
              <span class="pc_important"><?php echo __('ACCOUNT_SETTINGS_SUPPORTER_ACCOUNT_TYPE') ?></span> &nbsp;
              
                <?php if(PcUserPeer::getLoggedInUser()->isSubscriptionGoingToExpireSoon()): ?>
                    <span class="pc_errorMessage">(<?php echo __('ACCOUNT_SETTINGS_SUBSCRIPTION_EXPIRY_DATE') ?> <?php echo $niceExpiryDate ?>)</span>
                    <a href="<?php echo url_for('@subscribe') ?>"><?php echo __('ACCOUNT_SETTINGS_EXTEND_SUBSCRIPTION') ?></a>
                <?php else: ?>
                    (<?php echo __('ACCOUNT_SETTINGS_SUBSCRIPTION_EXPIRY_DATE') ?> <?php echo $niceExpiryDate ?>)
                <?php endif ?>
          <?php else: ?>
              <span class="pc_important"><?php echo __('ACCOUNT_SETTINGS_FREE_ACCOUNT_TYPE') ?></span> &nbsp;
              <a href="<?php echo url_for('@subscribe') ?>"><?php echo __('ACCOUNT_SETTINGS_UPGRADE_NOW') ?></a>
          <?php endif ?>
      </li>
      <li><?php echo __('ACCOUNT_SETTINGS_FORUM_USERNAME') ?>
        <?php if($user->getUsername()): ?>
          <em><?php echo $user->getUsername() ?></em>
        <?php else: ?>
          <em><?php echo __('ACCOUNT_SETTINGS_FORUM_USERNAME_NOT_SET') ?></em>
        <?php endif ?>
      </li>
      <li><?php echo __('ACCOUNT_SETTINGS_PLANCAKE_EMAIL_ADDRESS') ?> <em><?php echo $user->getPlancakeEmailAddress() ?></em> &nbsp;<a href="http://www.plancake.com/about/emailToInbox" class="help" ><?php echo __('ACCOUNT_SETTINGS_PLANCAKE_EMAIL_ADDRESS_WHATS_FOR') ?></a></li>
      <li><b>User key</b>:
          <?php if(PcUserPeer::getLoggedInUser()->getKey()): ?>
            <em><?php echo PcUserPeer::getLoggedInUser()->getKey(); ?></em>
          <?php else: ?>
            <a href="<?php echo url_for('settings/generateUserKey') ?>"><?php echo __('ACCOUNT_SETTINGS_GENERATE_USER_KEY') ?></a>
          <?php endif ?>
      </li>
  </ul>    
  
  <br />

  <h2><?php echo ucfirst(__('ACCOUNT_HEADER_SETTINGS')) ?></h2> 
  
  <ul class="niceMenu">
      <li><a href="<?php echo url_for('settings/date') ?>"><?php echo __('ACCOUNT_SETTINGS_CHANGE_DATE_FORMAT') ?></a></li>
      <li><a href="<?php echo url_for('settings/time') ?>"><?php echo __('ACCOUNT_SETTINGS_CHANGE_TIME_FORMAT') ?></a></li>
      <li><a href="<?php echo url_for('settings/timezone') ?>"><?php echo __('ACCOUNT_SETTINGS_CHANGE_TIMEZONE') ?></a></li>
      <li><a href="<?php echo url_for('settings/startWeek') ?>"><?php echo __('ACCOUNT_SETTINGS_CHOOSE_FIRST_DOW') ?></a></li>

      <li class="addDivider"><a href="<?php echo url_for('settings/lang') ?>"><?php echo __('ACCOUNT_SETTINGS_CHANGE_LANG') ?></a></li>

      <?php if (! defined('PLANCAKE_PUBLIC_RELEASE')): ?>
	     <li class="addDivider"><a href="<?php echo url_for('settings/avatar') ?>"><?php echo __('ACCOUNT_SETTINGS_MANAGE_AVATAR') ?></a></li>
      <?php endif ?>

      <li><a href="<?php echo url_for('settings/password') ?>"><?php echo __('ACCOUNT_SETTINGS_CHANGE_PASSWORD') ?></a></li>
      <li><a href="<?php echo url_for('settings/email') ?>"><?php echo __('ACCOUNT_SETTINGS_CHANGE_EMAIL') ?></a></li>

      <li class="addDivider"><a href="<?php echo url_for('settings/googleCalendarIntegration') ?>"><?php echo __('ACCOUNT_SETTINGS_MANAGE_GCAL') ?></a></li>
      <li><a href="<?php echo url_for('settings/emailReminders') ?>"><?php echo __('ACCOUNT_SETTINGS_EMAIL_REMINDERS') ?></a></li>
      <li><a href="<?php echo url_for('settings/export') ?>"><?php echo __('ACCOUNT_SETTINGS_EXPORT') ?></a></li>
      <li><a href="<?php echo url_for('settings/import') ?>"><?php echo __('ACCOUNT_SETTINGS_IMPORT') ?></a></li>

      <li class="addDivider"><a href="<?php echo url_for('settings/deleteAccount') ?>"><?php echo __('ACCOUNT_SETTINGS_DELETE_ACCOUNT') ?></a></li>
  </ul>

  <p>&nbsp;</p>

  <?php if($hasApiDetails): ?>
      <h2><?php echo __('ACCOUNT_SETTINGS_API_HEADER') ?></h2>
      <ul class="niceMenu">
        <li><?php echo __('ACCOUNT_SETTINGS_API_KEY') ?> <em><?php echo $apiDetails->getApiKey() ?></em></li>
        <li>API Secret: <em><?php echo $apiDetails->getApiSecret() ?></em></li>
      </ul>

    <p>&nbsp;</p>
  <?php endif ?>


  <?php include_component('adv', 'advAccountSettings') ?>

</div>
