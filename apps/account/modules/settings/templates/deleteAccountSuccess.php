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
<?php slot('title', 'Settings > ' . __('ACCOUNT_SETTINGS_DELETE_ACCOUNT')) ?>

<div class="standardContent">

  <h2><?php echo ucfirst(__('ACCOUNT_HEADER_SETTINGS')) ?> > <?php echo __('ACCOUNT_SETTINGS_DELETE_ACCOUNT') ?></h2>

  <div class="settingWrapper">
      <p><?php echo __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_WARNING') ?></p>
      <p><?php echo __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_INTRO') ?></p>


      <form id="deleteAccountForm" action="<?php echo url_for('settings/deleteAccount') ?>" method="post">
        <table>
          <?php echo $form ?>
          <tr>
            <td colspan="2">
              <br /><br /><br />
              <?php echo __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_LOGGED_OUT') ?><br />
              <input type="submit" value="<?php echo  __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_BTN') ?>" />
            </td>
          </tr>
        </table>
      </form>
  </div>
  
  <p class="goBackToSettings">
      <a href="<?php echo url_for('settings/index') ?>"><<< <?php echo __('ACCOUNT_SETTINGS_GO_BACK') ?></a>
  </p>  

</div>
