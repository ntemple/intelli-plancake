<?php if($hasDiscountCodeBeenEntered && $isDiscountCodeValid): ?>
  <span style="text-decoration: line-through;"><?php echo $currencySign ?> <?php echo $oneYearSubscription->getItemPrice() ?></span> 
  &nbsp;<span class="pc_subscriptionSaving">-<?php echo $discount ?>%</span><br />
  <?php printf(__('ACCOUNT_SUBSCRIPTION_ONLY_X_PER_YEAR'), '<span class="pc_subscriptionSaving pc_subscriptionPrice">' . $currencySign . $oneYearDiscountedSubscription->getItemPrice() . '</span> ') ?><br />
  <?php include_partial('templateParts/paypalButton', array('buttonCode' => $oneYearDiscountedSubscription->getPaypalButtonCode())) ?>                  
<?php else: ?>
  <?php printf(__('ACCOUNT_SUBSCRIPTION_ONLY_X_PER_YEAR'), '<span class="pc_subscriptionSaving pc_subscriptionPrice">' . $currencySign . $oneYearSubscription->getItemPrice() . '</span> ') ?><br />
  <!-- (<span class="pc_subscriptionSaving"><?php echo __('ACCOUNT_SUBSCRIPTION_SAVE') ?> <?php echo $currencySign ?> <?php echo $yearlySaving ?></span>) <br /> -->
  <?php include_partial('templateParts/paypalButton', array('buttonCode' => $oneYearSubscription->getPaypalButtonCode())) ?>
<?php endif ?> 
  
<?php if($isSupporter): ?>
  <br />
  <br /> <?php echo __('ACCOUNT_SUBSCRIPTION_EXPIRES_ON') ?> <span class="important"><?php echo $niceExpiryDate ?></span>,
  <br /> <?php echo __('ACCOUNT_SUBSCRIPTION_EXTEND_IT_TILL') ?> <?php echo $niceExpiryDateOneYearExtended ?>
<?php endif ?>