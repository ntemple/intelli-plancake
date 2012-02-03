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
<?php slot('title', 'Settings > ' . __('ACCOUNT_SETTINGS_MANAGE_GCAL')) ?>

<div class="standardContent">

  <h2><?php echo ucfirst(__('ACCOUNT_HEADER_SETTINGS')) ?> > <?php echo __('ACCOUNT_SETTINGS_MANAGE_GCAL') ?></h2>

  <div class="settingWrapper">
      <p>
        <?php printf(__('ACCOUNT_SETTINGS_MANAGE_GCAL_DOC'), 'http://www.plancake.com/services/google-calendar-integration') ?>
      </p>

      <p>
      <br />

      <?php if(PcUserPeer::getLoggedInUser()->hasGoogleCalendarIntegrationActive()): ?>
          <?php __('ACCOUNT_SETTINGS_MANAGE_GCAL_EMAIL') ?> <br />
          <em><?php PcGoogleCalendarPeer::retrieveByUser(PcUserPeer::getLoggedInUser())->getEmailAddress() ?></em>
          <br />

          <a onclick="javascript:return confirm(<?php echo __('ACCOUNT_MISC_CONFIRM_MSG') ?>)"
             href="<?php echo url_for('settings/googleCalendarIntegration?deactivate=1') ?>">
              <?php echo __('ACCOUNT_SETTINGS_MANAGE_GCAL_DEACTIVATE') ?>
          </a>
      <?php else: ?>
          <?php echo __('ACCOUNT_SETTINGS_MANAGE_GCAL_NOT_IN_USE') ?> <br /><br />

          <a class="btn" href="<?php echo url_for('googleCalendarIntegration/step1') ?>"><?php echo __('ACCOUNT_SETTINGS_MANAGE_GCAL_ACTIVATE') ?></a>
      <?php endif ?>        
       
      </p>
  </div>
  
   <div style="margin-left: 30px;">
   <span class="pc_very_important"><?php echo __('ACCOUNT_SETTINGS_GCAL_SLOW_DOWN_WARNING') ?></span>
   </div>
  
  <br /><br />
  
  <p class="goBackToSettings">
      <a href="<?php echo url_for('settings/index') ?>"><<< <?php echo __('ACCOUNT_SETTINGS_GO_BACK') ?></a>
  </p>

</div>
