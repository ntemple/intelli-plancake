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

        <?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_STEP4_SUCCESS') ?>

        <br /><br />

        <h3><?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_STEP4_USAGE_HEADER') ?></h3>

        <?php include_partial('templateParts/googleCalendarIntegrationUsage') ?>

        <br />

        <h3><?php echo __('ACCOUNT_SETTINGS_GCAL_INTEGRATION_STEP4_LIMITATIONS_HEADER') ?></h3>

        <?php include_partial('templateParts/googleCalendarIntegrationLimitations') ?>

        <br /><br/>
        <p>
            <a style="border: 0px" href="https://www.google.com/calendar/" target="_blank">
                <img style="border: 0px" title="" src="/images/google_calendar_button.png" title="" />
            </a>
        </p>
        
    </div>

</div>