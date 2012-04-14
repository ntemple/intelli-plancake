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

<?php slot(
  'title',
  'Plancake - ' . __('WEBSITE_GENERAL_PRODUCT_SHORT_DESCRIPTION'));
?>

<?php slot('sel_homepage', 'selected') ?>
<?php slot('og_title', __('WEBSITE_HOMEPAGE_META_OG_TITLE')) ?>
<?php slot('og_description', __('WEBSITE_HOMEPAGE_SECONDARY_COPY')) ?>

<div id="whatsPlancakeColumn">
    <span id="homepageMarketingTitles" style="margin-top: 0px"><?php echo __('WEBSITE_HOMEPAGE_WHOS_PLANCAKE_FOR_HEADER') ?></span>
    <ul id="whyUs" style="line-height: 140%">
        <?php echo __('WEBSITE_HOMEPAGE_WHOS_PLANCAKE_FOR_BODY') ?>
    </ul>

    <span id="homepageMarketingTitles"><?php echo __('WEBSITE_HOMEPAGE_WHATS_PLANCAKE_HEADER') ?></span>

    <ul style="line-height: 140%">

      <li id="homepageGTDpar">
        <h2 style="margin-top: 0px; margin-bottom: 5px;">GTD (Getting Things Done)<sup class="pc_small">TM</sup></h2>
        <p>
        <?php printf(__('WEBSITE_SERVICES_HOME_GTD_BODY'), 'http://www.davidco.com/about-gtd'); ?>
        </p>
      </li>          
        
      <li>
        <h2 style="margin-top: 0px; margin-bottom: 5px;"><?php echo __('WEBSITE_SERVICES_HOME_PLANCAKE_TASKS_TITLE') ?></h2>
        <p>
        <?php echo __('WEBSITE_SERVICES_HOME_PLANCAKE_TASKS_BODY') ?>
            <a href="<?php echo 'http://' . $baseUrl . $cultureUrlPart . '/services' ?>"><?php echo __('WEBSITE_SERVICES_HOME_PLANCAKE_TASKS_LINK') ?></a>
        </p>
      </li>
   
<!--      
      <li>
        <h2><?php echo __('WEBSITE_SERVICES_HOME_PLANCAKE_NOTES_TITLE') ?></h2>
        <p>
        <?php echo __('WEBSITE_SERVICES_HOME_PLANCAKE_NOTES_BODY') ?>
        </p>
      </li>
-->

    </ul>
    
    <span id="homepageMarketingTitles"><?php echo __('WEBSITE_HOMEPAGE_WHY_US_HEADER') ?></span>
    <ul id="whyUs" style="line-height: 140%">
        <?php printf(__('WEBSITE_HOMEPAGE_WHY_US_BODY'), "split view",
               'http://' . $baseUrl . $cultureUrlPart . '/plans') ?>
    </ul>

    
</div>

<div id="homepageTestimonials" style="line-height: 140%">

    <ul>
      <li id="homepageTestimonial1">
          <span class="testimonialComment">
              <?php echo __('WEBSITE_HOMEPAGE_TESTIMONIAL1') ?>
          </span>
          <br />
          <span class="testimonialAuthor">Philip Warner, <?php echo __('WEBSITE_HOMEPAGE_TESTIMONIAL1_AUTHOR_INFO') ?></span>
      </li>  

      <li id="homepageTestimonial2">
          <span class="testimonialComment">
              <?php echo __('WEBSITE_HOMEPAGE_TESTIMONIAL2') ?>
          </span>
          <br />
          <span class="testimonialAuthor">Pawel Konieczny, <?php echo __('WEBSITE_HOMEPAGE_TESTIMONIAL2_AUTHOR_INFO') ?></span>
      </li> 

      <li id="homepageTestimonial3">
          <span class="testimonialComment">
              <?php echo __('WEBSITE_HOMEPAGE_TESTIMONIAL3') ?>
          </span>
          <br />
          <span class="testimonialAuthor">Florence Iwuoha, <?php echo __('WEBSITE_HOMEPAGE_TESTIMONIAL3_AUTHOR_INFO') ?></span>
      </li> 
      
    </ul>
</div>

<div id="homepageBadges">
    <img src="/images/shell_award.jpg" />
    <div><?php echo __('WEBSITE_HOMEPAGE_AS_FEATURED_IN') ?></div>
    <img src="/images/reviewers_logos.png" />
</div>

<div id="homepageActionLinks">
    <?php printf(__('WEBSITE_HOMEPAGE_IMPORTANT_ACTION_LINKS'), 
            'http://' . $baseUrl . $cultureUrlPart . '/plans', 
            'http://' . $baseUrl . $cultureUrlPart . '/services', 
            url_for('@registration')) ?>
</div>