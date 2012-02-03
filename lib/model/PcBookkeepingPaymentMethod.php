<?php

require 'lib/model/om/BasePcBookkeepingPaymentMethod.php';


/**
 * Skeleton subclass for representing a row from the 'pc_bookkeeping_payment_method' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcBookkeepingPaymentMethod extends BasePcBookkeepingPaymentMethod {

    public function __toString()
    {
        return $this->getName();
    }    
    
} // PcBookkeepingPaymentMethod
