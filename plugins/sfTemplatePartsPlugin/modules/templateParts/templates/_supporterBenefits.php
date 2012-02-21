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

  <table id="supporterBenefits">
      <thead>
          <tr>
            <th width="33%"></th>
            <th width="33%"><span id="freeAccountHeader"><!-- <?php echo __('ACCOUNT_SUBSCRIPTION_FREE_ACCOUNT') ?>--> Free Edition</span></th>
            <th width="33%" class="supporter"><span id="premiumAccountHeader"><!-- <?php echo __('ACCOUNT_SUBSCRIPTION_SUPPORTER_ACCOUNT') ?> --> Premium Edition</span></th>
          </tr>
      </thead>
      <tbody>

        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MAX_TASKS') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MAX_TASKS_HELP') ?></span></p></td><td><?php echo sfConfig::get('app_site_maxTasksForNonSupporter') ?></td><td class="supporter"><?php echo __('ACCOUNT_SUBSCRIPTION_UNLIMITED') ?></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MAX_LISTS') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MAX_LISTS_HELP') ?></span></p></td><td><?php echo sfConfig::get('app_site_maxListsForNonSupporter') ?></td><td class="supporter"><?php echo __('ACCOUNT_SUBSCRIPTION_UNLIMITED') ?></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MAX_TAGS') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MAX_TAGS_HELP') ?></span></p></td><td><?php echo sfConfig::get('app_site_maxTagsForNonSupporter') ?></td><td class="supporter"><?php echo __('ACCOUNT_SUBSCRIPTION_UNLIMITED') ?></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_NOTES') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_NOTES_HELP') ?></span></p></td><td><?php echo sfConfig::get('app_site_maxNotesForNonSupporter') ?></td><td class="supporter"><?php echo __('ACCOUNT_SUBSCRIPTION_UNLIMITED') ?></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_COMPLETED') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_COMPLETED_HELP') ?></span></p></td><td><?php echo sfConfig::get('app_site_retentionTimeForCompletedTasksForNonSupporters') ?></td><td class="supporter"><?php echo sfConfig::get('app_site_retentionTimeForCompletedTasksForSupporters') ?></td></tr>
      
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_REPEATING_TASKS') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_REPEATING_TASKS_HELP') ?></span></p></td><td><img src="/images/tick.png" /></td><td class="supporter"><img src="/images/tick.png" /></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_EXPORT') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_EXPORT_HELP') ?></span></p></td><td><img src="/images/tick.png" /></td><td class="supporter"><img src="/images/tick.png" /></td></tr>        
        
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MOBILE_APP') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_MOBILE_APP_HELP') ?></span></p></td><td><img src="/images/tick.png" /></td><td class="supporter"><img src="/images/tick.png" /></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_OFFLINE_USE') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_OFFLINE_USE_HELP') ?></span></p></td><td><img src="/images/tick.png" /></td><td class="supporter"><img src="/images/tick.png" /></td></tr>        
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_GENERAL_FEATURES') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_GENERAL_FEATURES_HELP') ?></span></p></td><td><img src="/images/tick.png" /></td><td class="supporter"><img src="/images/tick.png" /></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_SECURITY') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_SECURITY_HELP') ?></span></p></td><td><img src="/images/tick.png" /></td><td class="supporter"><img src="/images/tick.png" /></td></tr>

        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_EXTRA_SECURITY') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_EXTRA_SECURITY_HELP') ?></span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_PRINT') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_PRINT_HELP') ?></span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_SEARCH') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_SEARCH_HELP') ?></span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_REMINDERS') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_REMINDERS_HELP') ?></span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>

        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_ADVERTS') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_ADVERTS_HELP') ?></span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>                
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_SUPPORT') ?><p><span><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_SUPPORT_HELP') ?></span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>        

        
        
        <tr><td class="nonCenteredContent" style="font-weight: bold">Ebook "Plancake and GTD: a practical guide to an easier life" (coming soon)<p><span>small ebook with screenshots and written in easy English</span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>        
        
        
        
        <tr><td class="nonCenteredContent"><a href=".#" name="pricesTop">&nbsp;</a><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_NO_CONTRACT') ?><p><span><br /></span></p></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>
        <tr><td class="nonCenteredContent"><?php echo __('ACCOUNT_SUBSCRIPTION_COMPARISON_WARRANTY') ?></td><td>&nbsp;</td><td class="supporter"><img src="/images/tick.png" /></td></tr>
       
      <!-- we don't close the table so that the caller can display prices -->
      <!-- </tbody> -->
  <!-- </table> -->
