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
    <div id="pc_footer">
      <div id="pc_footerLinks">

          <ul>
              <?php if (! defined('PLANCAKE_PUBLIC_RELEASE')): ?>
                  <?php if (sfConfig::get('app_site_showLegal')): ?>
                  <li><p><?php echo __('WEBSITE_FOOTER_LEGAL_HEADER') ?></p>
                      <ul>
                          <li><a href='http://<?php echo $baseUrl . $cultureUrlPart ?>/plans'><?php echo __('WEBSITE_FOOTER_PLANS_LINK') ?></a></li>
                          <li><a href='http://<?php echo $baseUrl ?>/legal/tc'><?php echo __('WEBSITE_FOOTER_TERMS_LINK') ?></a></li>
                          <li><a href='http://<?php echo $baseUrl ?>/legal/privacy'><?php echo __('WEBSITE_FOOTER_PRIVACY_LINK') ?></a></li>
                      </ul>
                  </li>
                  <?php endif ?>
              <?php else: ?>
                  <li>&nbsp;</li>
              <?php endif ?>
              <li><p><?php echo __('WEBSITE_FOOTER_COMPANY_HEADER') ?></p>
                  <ul>
                      <li><a href='http://<?php echo $baseUrl . $cultureUrlPart ?>/team'><?php echo __('WEBSITE_FOOTER_MEET_THE_TEAM_LINK') ?></a></li>
                      <li><a href='http://<?php echo $baseUrl ?>/blog'><?php echo __('WEBSITE_HEADER_BLOG_LINK') ?></b></a> </li>
                      <li><a href='http://<?php echo $baseUrl . $cultureUrlPart ?>/press'><?php echo __('WEBSITE_FOOTER_PRESS_LINK') ?></a> </li>
                      <li><a href='http://<?php echo $baseUrl ?>/jobs'>Jobs</a></li>                     
                      <li><a href='http://<?php echo $baseUrl . $cultureUrlPart ?>/contact'><?php echo __('WEBSITE_FOOTER_CONTACT_US_LINK') ?></a></li>
                  </ul>
              </li>

              <li><p><?php echo __('WEBSITE_FOOTER_DEVELOPERS_HEADER') ?></p>
                  <ul>
                      <li><a href='http://<?php echo $baseUrl ?>/api-documentation'>API</a></li>
                      <li><a href='http://<?php echo $baseUrl . $cultureUrlPart ?>/open-source'><?php echo __('WEBSITE_FOOTER_OPEN_SOURCE_LINK') ?></a></li>
                  </ul>
              </li>

              <li><p><?php echo __('WEBSITE_FOOTER_SUPPORT_HEADER') ?></p>
                  <ul>
                      <li><a href='http://<?php echo $baseUrl . $cultureUrlPart ?>/services'><?php echo __('WEBSITE_HEADER_SERVICES_LINK') ?></a></li>                      
                      <!-- <li><a href='http://<?php echo $baseUrl ?>/forums'><?php echo __('WEBSITE_HEADER_FORUM_LINK') ?></a> </li> -->
                      <li><a href='http://<?php echo $baseUrl ?>/faq'>FAQ</a> </li>
                      <li><a href='http://<?php echo $baseUrl . $cultureUrlPart ?>/contact'><?php echo __('WEBSITE_FOOTER_CONTACT_US_LINK') ?></a></li>
                  </ul>
              </li>

              <li>
                  <br /><br />
                  <?php include_partial('templateParts/followUs') ?>
                  <br /><br /><br />
                  
                  <?php include_partial('social/mix2') ?>
                  
                  <br />
                  
                   <?php if (sfConfig::get('sf_app') != 'account'): ?>
                     <?php if (!defined('PLANCAKE_PUBLIC_RELEASE')): ?>
                        <?php include_component('lang', 'langSelection') ?>
                     <?php endif ?>
                  <?php endif ?>
                  <!-- <a href="http://www.plancake.com/donate"><img style="border: 0px;" src="/images/paypal_donation_button.png" /></a> -->
                  <br /><br />
                  <!-- <a target="_blank" href="http://team.plancake.com"><img style="border: 0px;" src="/images/plancake_team_banner.png" /></a> -->
                  
              </li>

          </ul>
            
      </div>

        <div style="clear: both" />
        
        <br /><br /><br />

        <div class="copyrightNote">
          Plancake.com is operated by <a class="companyFooterLink" target="_blank" rel="nofollow" href="http://www.danyukisoftware.com">Danyuki Software Ltd.</a> - registered in England and Wales with Company No. 07554549 <br />
          Registered Office: 6 Boundary Road, London, N22 6AD, UK. <br /><br />            
          Copyright &#169; 2009, 2010, 2011, 2012 Danyuki Software Limited. All right reserved.<br />
          &#34;Plancake&#34; and &#34;Plancake Team&#34; are trademarks of Daniele Occhipinti. <br />
          GTD and Getting Things Done are registered trademarks of the David Allen &amp; Co.
        </div>

    <?php if (defined('PLANCAKE_PUBLIC_RELEASE')): ?>
      <div id="selfHostedVersionNotice">
        This is a self-hosted version of Plancake. Don't forget you can also let the Plancake Team take care of updates and backups for you by creating a free account at <a href="http://www.plancake.com">plancake.com</a>.
      </div>
    <?php endif ?>

    </div>
        
    <br /><br />
