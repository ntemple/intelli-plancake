<?php

require 'lib/model/om/BasePcBookkeepingType.php';


/**
 * Skeleton subclass for representing a row from the 'pc_bookkeeping_type' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcBookkeepingType extends BasePcBookkeepingType {

    public function __toString()
    {
        return $this->getName();
    }
    
} // PcBookkeepingType
