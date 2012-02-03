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

    <h3><?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_HEADER') ?></h3>

    <p>
        <?php include_partial('templateParts/googleCalendarIntegrationIntro') ?>
    </p>

    <br />

    <p>
        <span class="pc_important">
            <?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_BETA_MSG') ?>
        </span>
    </p>

    <br />

    <p>
        <?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_STEP1') ?>
    </p>

    <p>
        <a class="btn" href="<?php echo url_for('googleCalendarIntegration/step2') ?>"><?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_START_BTN') ?> >>></a>
    </p>
    <br /><br />
</div>