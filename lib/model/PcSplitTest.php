<?php

require 'lib/model/om/BasePcSplitTest.php';


/**
 * Skeleton subclass for representing a row from the 'pc_split_test' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcSplitTest extends BasePcSplitTest {

    private $variantId;
    
    public function setVariant() {
        $variantId = mt_rand(1, $this->getNumberOfVariants());
        $this->variantId = $variantId;
        
        sfContext::getInstance()->getResponse()->setCookie(PcSplitTestPeer::SPLIT_TEST_COOKIE_PREFIX . $this->getId(), $variantId);
        
        $variantResult = PcSplitTestResultPeer::retrieveByPK($this->getId(), $variantId);
        if (! $variantResult) {
            $variantResult = new PcSplitTestResult();
            $variantResult->setTestId($this->getId())
                          ->setVariantId($variantId);
        }
        $variantResult->setNumberOfTries($variantResult->getNumberOfTries()+1)
                      ->save();        
        
        return $variantId;
    }
    
    /**
     *
     * @return int|null
     */
    public function getVariant() {
        
        if ($variantId = $this->variantId) {
            return $variantId;
        } 
        
        $cookieValue = sfContext::getInstance()->getRequest()->getCookie(PcSplitTestPeer::SPLIT_TEST_COOKIE_PREFIX . $this->getId());
        
        if (!$cookieValue) {
             return null;
        } else {
            return $cookieValue;
        }
    }
    
    public function saveSuccess() {
        $variantId = $this->getVariant();
        
        if ($variantId > 0) {
            $variantResult = PcSplitTestResultPeer::retrieveByPK($this->getId(), $variantId);
            if (! $variantResult) {
                $variantResult = new PcSplitTestResult();
                $variantResult->setTestId($this->getId())
                              ->setVariantId($variantId);
            }
            $variantResult->setNumberOfSuccesses($variantResult->getNumberOfSuccesses()+1)
                          ->save();
        }
    }
    
    public function saveUserSuccess() {
        $variantId = $this->getVariant();
        
        $user = PcUserPeer::getLoggedInUser();
        
        if ($user && ($variantId > 0)) {
            $variantUserResult = PcSplitTestUserResultPeer::retrieveByPK($user->getId(), $this->getId(), $variantId);
            if (! $variantUserResult) { // the result hasn't been recorded yet
                $variantUserResult = new PcSplitTestUserResult();
                $variantUserResult->setUserId($user->getId())
                                  ->setTestId($this->getId())
                                  ->setVariantId($variantId)
                                  ->save();
            }
        }        
    }
    
} // PcSplitTest
