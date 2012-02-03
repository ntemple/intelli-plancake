<div id="subscriptionPage">

    <h2><?php echo __('WEBSITE_FOOTER_PLANS_LINK') ?></h2>
    
    <div>
        <?php include_component('templateParts', 'subscriptionContent') ?>

        <br /><br />

        <?php if ( PcUserPeer::getLoggedInUser() ): ?>

        <?php else: ?>
            <?php include_component('templateParts', 'bottomMenu', array('moduleName' => 'about')) ?>
        <?php endif ?>                         
        
    </div>
    <div class="pc_sidebar">
    </div>
    
    
    
</div>
