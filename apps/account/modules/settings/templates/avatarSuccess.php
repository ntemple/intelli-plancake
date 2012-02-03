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
<?php slot('title', 'Settings > ' . __('ACCOUNT_SETTINGS_MANAGE_AVATAR')) ?>

<div class="standardContent">

  <h2><?php echo ucfirst(__('ACCOUNT_HEADER_SETTINGS')) ?> > <?php echo __('ACCOUNT_SETTINGS_MANAGE_AVATAR') ?></h2>

  <div class="settingWrapper">
      <p>
      <?php if($hasAvatar): ?>
           <?php echo __('ACCOUNT_SETTINGS_CURRENT_AVATAR') ?>   <br />
           <img src="<?php echo $avatarUrl ?>" />
      <?php endif ?>
      </p>

      <?php if(! $isUploaded): ?>
          <p>
              <h4><?php echo __('ACCOUNT_SETTINGS_UPLOAD_AVATAR_HEADER') ?></h4>
              <b><?php printf(__('ACCOUNT_SETTINGS_AVATAR_INSTRUCTIONS'), sfConfig::get('app_avatar_width'), sfConfig::get('app_avatar_height')) ?></b>
              <form enctype="multipart/form-data" action="<?php echo url_for('settings/avatar') ?>" method="post" >
                <p>
                  <?php echo $form ?>
                </p>

                <p>
                <input type="submit" name="upload" value="<?php echo __('ACCOUNT_SETTINGS_UPLOAD_FILE') ?>" />
                </p>
              </form>
          </p>
      <?php else: ?>
          <a href="<?php echo url_for('settings/avatar') ?>"><?php echo __('ACCOUNT_SETTINGS_CHANGE_AVATAR_LINK') ?></a>
      <?php endif ?>
  </div>

  <p class="goBackToSettings">
      <a href="<?php echo url_for('settings/index') ?>"><<< <?php echo __('ACCOUNT_SETTINGS_GO_BACK') ?></a>
  </p>

</div>
