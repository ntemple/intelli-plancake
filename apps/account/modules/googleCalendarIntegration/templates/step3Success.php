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

<div class="standardContent">

    <div class="gcalIntegrationStep">
        <h3><?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_HEADER') ?></h3>

        <?php if($calendarAlreadyExist): ?>
            <?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_STEP3_ERROR') ?>
        <?php else: ?>
            <?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_STEP3_SUCCESS') ?>
            <p>
            <a id="gcalActivationFinalStep" href="/integrations/google_calendar_init_import.php" class="btn"><?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_START_FINAL_STEP_BTN') ?></a>
            </p>
            <div id="gcalActivationFinalStepPleaseWait" style="display: none">
                <img src="/images/ajax_loader_small_orange.gif" /> <br />
                <?php echo __('ACCOUNT_MISC_PLEASE_WAIT') ?>
            </div>
            <br /><br />
        <?php endif ?>
    </div>
</div>