<?php

require 'lib/model/om/BasePcContactCompany.php';


/**
 * Skeleton subclass for representing a row from the 'pc_contact_company' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcContactCompany extends BasePcContactCompany {

    public function __toString() {
        return $this->getName();
    }
    
} // PcContactCompany
