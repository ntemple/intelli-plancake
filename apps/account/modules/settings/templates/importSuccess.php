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
<?php slot('title', 'Settings > ' . __('ACCOUNT_SETTINGS_IMPORT')) ?>

<div class="standardContent">

  <h2><?php echo ucfirst(__('ACCOUNT_HEADER_SETTINGS')) ?> > <?php echo __('ACCOUNT_SETTINGS_IMPORT') ?></h2>

  <div class="settingWrapper">
        <?php if($submitted): ?>
            <div class="pc_confirmationMessage">
                <?php echo __('ACCOUNT_SETTINGS_IMPORT_SUCCESS') ?>
            </div>
        <?php endif ?>

        <?php if($xmlError): ?>
            <div class="pc_errorMessage">
                <?php echo __('ACCOUNT_SETTINGS_IMPORT_XML_ERROR') ?>
            </div>
        <?php endif ?>

      <p>
          <?php echo __('ACCOUNT_SETTINGS_IMPORT_INTRO') ?>
      </p>

      <div id="importFile">
          <form enctype="multipart/form-data" action="<?php echo url_for('settings/import') ?>" method="post" >
            <p>
              <table>
                <?php echo $form ?>
              </table>
            </p>

            <p>
            <input type="submit" name="upload" id="importFileButton" value="<?php echo __('ACCOUNT_SETTINGS_UPLOAD_FILE') ?>" />
            </p>
          </form>
      </div>
  </div>

  <p class="goBackToSettings">
      <a href="<?php echo url_for('settings/index') ?>"><<< <?php echo __('ACCOUNT_SETTINGS_GO_BACK') ?></a>
  </p>

</div>
