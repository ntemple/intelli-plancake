<div id="homepageSplash">
    <div>
        <h1><?php echo __('WEBSITE_HOMEPAGE_MAIN_COPY') ?></h1>

        <ul id="stepsForPlancake">
            <li id="stepCapture">
                <div class="stepHeader"><?php echo __('WEBSITE_HOMEPAGE_STEP1_TITLE') ?></div>
                <p><?php echo __('WEBSITE_HOMEPAGE_STEP1_BODY') ?></p>
            </li>
            <li id="stepAccess">
                <div class="stepHeader"><?php echo __('WEBSITE_HOMEPAGE_STEP2_TITLE') ?></div>
                <p><?php echo __('WEBSITE_HOMEPAGE_STEP2_BODY') ?></p>
            </li>
            <li id="stepRelax">
                <div class="stepHeader"><?php echo __('WEBSITE_HOMEPAGE_STEP3_TITLE') ?></div>
                <p><?php echo __('WEBSITE_HOMEPAGE_STEP3_BODY') ?></p>
            </li>
        </ul>

        <div style="clear: both"></div>

        <div id="mainSignupButtonWrapper">
            <div>
                <?php echo include_partial('templateParts/signupButton') ?>
            </div>
        </div>
        <div style="clear: both"></div>
        
        <div id="platformsWrapper">
            &nbsp;
        </div>
        
        <div id="watchVideo">
            <img  alt="Plancake Video Tutorial" src="/images/watch_video_tutorial.png" />
            <div><?php echo __('WEBSITE_HOMEPAGE_PLAY_VIDEO') ?></div>
        </div>
    </div>
</div>