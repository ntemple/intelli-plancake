  <?php include_partial('templateParts/supporterBenefits') ?>
        <tr><td class="nonCenteredContent"></td>
            <td>
                <?php if ($isOnRegistration): ?>
                    free <br />
                    <a href="/<?php echo sfConfig::get('app_accountApp_frontController') ?>"><img src="/images/free_sign_in_btn.gif"></a>
                <?php endif ?>
            </td>
            <td class="supporter">
              <div id="supporterPrices">      
                  <div class="payment paymentInUSD">
                      <?php include_partial('templateParts/subscriptionCurrencyBuyNow', 
                              array('hasDiscountCodeBeenEntered' => $hasDiscountCodeBeenEntered,
                                    'isDiscountCodeValid' => $isDiscountCodeValid,
                                    'discount' => $discount,
                                    'currencySign' => '$',
                                    'oneYearSubscription' => $oneYearUsdSubscription,
                                    'oneYearDiscountedSubscription' => $oneYearUsdDiscountedSubscription,
                                    'yearlySaving' => $yearlyUsdSaving,
                                    'isSupporter' => $isSupporter,
                                    'niceExpiryDate' => $niceExpiryDate,
                                    'niceExpiryDateOneYearExtended' => $niceExpiryDateOneYearExtended                              
                                  )) ?>                    
                  </div>
                  <div class="payment paymentInGBP">
                      <?php include_partial('templateParts/subscriptionCurrencyBuyNow', 
                              array('hasDiscountCodeBeenEntered' => $hasDiscountCodeBeenEntered,
                                    'isDiscountCodeValid' => $isDiscountCodeValid,
                                    'discount' => $discount,                              
                                    'currencySign' => '£',
                                    'oneYearSubscription' => $oneYearGbpSubscription,
                                    'oneYearDiscountedSubscription' => $oneYearGbpDiscountedSubscription,
                                    'yearlySaving' => $yearlyGbpSaving,
                                    'isSupporter' => $isSupporter,
                                    'niceExpiryDate' => $niceExpiryDate,
                                    'niceExpiryDateOneYearExtended' => $niceExpiryDateOneYearExtended                              
                                  )) ?>                                            
                  </div>
                  <div class="payment paymentInEUR">
                      <?php include_partial('templateParts/subscriptionCurrencyBuyNow', 
                              array('hasDiscountCodeBeenEntered' => $hasDiscountCodeBeenEntered,
                                    'isDiscountCodeValid' => $isDiscountCodeValid,
                                    'discount' => $discount,                              
                                    'currencySign' => '&euro;',
                                    'oneYearSubscription' => $oneYearEurSubscription,
                                    'oneYearDiscountedSubscription' => $oneYearEurDiscountedSubscription,
                                    'yearlySaving' => $yearlyEurSaving,
                                    'isSupporter' => $isSupporter,
                                    'niceExpiryDate' => $niceExpiryDate,
                                    'niceExpiryDateOneYearExtended' => $niceExpiryDateOneYearExtended                              
                                  )) ?>     
                  </div>
                  <div class="payment paymentInJPY">
                      <?php include_partial('templateParts/subscriptionCurrencyBuyNow', 
                              array('hasDiscountCodeBeenEntered' => $hasDiscountCodeBeenEntered,
                                    'isDiscountCodeValid' => $isDiscountCodeValid,
                                    'discount' => $discount,                              
                                    'currencySign' => '&#165;',
                                    'oneYearSubscription' => $oneYearJpySubscription,
                                    'oneYearDiscountedSubscription' => $oneYearJpyDiscountedSubscription,
                                    'yearlySaving' => $yearlyJpySaving,
                                    'isSupporter' => $isSupporter,
                                    'niceExpiryDate' => $niceExpiryDate,
                                    'niceExpiryDateOneYearExtended' => $niceExpiryDateOneYearExtended                              
                                  )) ?>                       
                  </div>              
              </div>                
        </td></tr>        
      </tbody>
  </table>

  
<?php if (PcUserPeer::getLoggedInUser()) : ?>
    <div id="marketingCopy">
        <div>
            <?php echo __('ACCOUNT_SUBSCRIPTION_MARKETING_COPY') ?>
        </div>
    </div>
<?php endif ?>



    <div id="currencySelector">
        <?php echo __('ACCOUNT_SUBSCRIPTION_CHOOSE_CURRENCY') ?>: <br />
        <ul>
            <li id="currencyUSD" class="selected">&#36;</li>
            <li id="currencyGBP">&pound;</li>
            <li id="currencyEUR">&euro;</li>
            <li id="currencyJPY">&#165;</li>            
        </ul>
    </div>   
  
    <div style="clear: right;">&nbsp;</div>
    
    <?php if( $promotionErrorCode > 0 ): ?>
        <div id="discountCodeError">
            <?php if( $promotionErrorCode === PcPromotionCodePeer::PROMOTION_CODE_ERROR_INVALID_CODE ): ?>
                    <?php echo __('ACCOUNT_PROMOTION_CODE_ERROR_INVALID_CODE') ?>
            <?php elseif( $promotionErrorCode === PcPromotionCodePeer::PROMOTION_CODE_ERROR_EXPIRED_CODE ): ?>
                    <?php echo __('ACCOUNT_PROMOTION_CODE_ERROR_EXPIRED_CODE') ?>
            <?php elseif( $promotionErrorCode === PcPromotionCodePeer::PROMOTION_CODE_ERROR_MAX_USES_REACHED ): ?>
                    <?php echo __('ACCOUNT_PROMOTION_CODE_ERROR_MAX_USES_REACHED') ?>
            <?php elseif( $promotionErrorCode === PcPromotionCodePeer::PROMOTION_CODE_ERROR_ONLY_FOR_NEW_CUSTOMERS ): ?>
                    <?php echo __('ACCOUNT_PROMOTION_CODE_ERROR_ONLY_FOR_NEW_CUSTOMERS') ?>
            <?php endif ?>
        </div>
    <?php endif ?>


    
    

    

    
    <div id="discountCode">
        <?php echo __('ACCOUNT_SUBSCRIPTION_DISCOUNT_CODE') ?>
        <form method="post" action="<?php if ($sf_params->get('module') == "subscribe") echo url_for('@subscribe'); ?><?php if ($isOnRegistration) { echo '?onRegistration=1'; } ?>#pricesTop">
            <input id="codeForDiscount" name="codeForDiscount" type="text" />
            <input type="submit" value="<?php echo __('ACCOUNT_SUBSCRIPTION_UPDATE_PRICES') ?>" />
        </form>
    </div>

    <div class="clearfix">&nbsp;</div>  
    
    <?php if (!PcUserPeer::getLoggedInUser()) : ?>
        <div style="margin: auto; clear: both; width: 100%; position: relative; text-align: center; margin-top: 30px; margin-bottom: 30px;">
            <div>
                <?php echo include_partial('templateParts/signupButton') ?>
            </div>
            <br />
            <?php echo __('ACCOUNT_PROMOTION_NEED_TO_SIGN_UP') ?>
        </div>
    <?php endif ?>
  <br />


  <div id="payWithConfodence">
      <ul class="tickList" style="width: 615px;">
          <li><?php echo __('ACCOUNT_SUBSCRIPTION_BENEFIT1') ?></li>
          <li><?php echo __('ACCOUNT_SUBSCRIPTION_BENEFIT6') ?></li>
          <li><?php echo __('ACCOUNT_SUBSCRIPTION_BENEFIT7') ?></li>          
          <li><?php echo __('ACCOUNT_SUBSCRIPTION_BENEFIT2') ?></li>
          <li><?php echo __('ACCOUNT_SUBSCRIPTION_BENEFIT3') ?></li>
          <!-- <li><?php echo __('ACCOUNT_SUBSCRIPTION_BENEFIT4') ?></li> -->
          <li><?php echo __('ACCOUNT_SUBSCRIPTION_BENEFIT5') ?></li>
      </ul>
  </div>

  <div id="paymentViaBankTransfer">
    <?php printf(__('ACCOUNT_SUBSCRIPTION_PAYMENT_VIA_BANK'), '/contact?re=general') ?> 
  </div>
  <div id="discountForCharities">
    <?php echo __('ACCOUNT_SUBSCRIPTION_DISCOUNT_FOR_CHARITIES') ?> 
  </div>
  <div id="discountForStudents">
    <?php printf(__('ACCOUNT_SUBSCRIPTION_DISCOUNT_FOR_STUDENTS'), '/contact?re=general') ?>     
  </div>
  
<?php if(PcUserPeer::getLoggedInUser() && (PcUserPeer::getLoggedInUser()->isAdmin())): ?>
  <br /><br /><br />
  payment test: <?php include_partial('templateParts/paypalButton', array('buttonCode' => $testSubscription->getPaypalButtonCode())) ?>
  </tr>
<?php endif ?>   
  