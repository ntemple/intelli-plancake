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
<?php slot('title', 'Settings > ' . __('ACCOUNT_SETTINGS_CHANGE_EMAIL')) ?>

<div class="standardContent">

  <h2><?php echo ucfirst(__('ACCOUNT_HEADER_SETTINGS')) ?> > <?php echo __('ACCOUNT_SETTINGS_CHANGE_EMAIL') ?></h2>
  
  <div class="settingWrapper">
      <?php if ($sf_user->hasFlash('email_wrong')): ?>
        <div class="pc_errorMessage">
          <?php echo $sf_user->getFlash('email_wrong') ?>
        </div>
      <?php endif; ?>

      <p>
      <?php printf( __('ACCOUNT_SETTINGS_YOUR_EMAIL_ADDRESS'), $user->getEmail() ) ?>
      </p>

      <p>
          <?php echo __('ACCOUNT_SETTINGS_EMAIL_ADDRESS_NOTICE') ?>
      </p>

      <form action="<?php echo url_for('settings/email') ?>" method="post">
        <table>
          <?php echo $form ?>
          <tr>
            <td colspan="2">
              <input type="submit" value="<?php echo __('ACCOUNT_MISC_SAVE') ?>" />
            </td>
          </tr>
        </table>
      </form>
  </div>
      
      <p class="goBackToSettings">
          <a href="<?php echo url_for('settings/index') ?>"><<< <?php echo __('ACCOUNT_SETTINGS_GO_BACK') ?></a>
      </p>
  </div>
</div>
