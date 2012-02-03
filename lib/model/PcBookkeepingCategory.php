<?php

require 'lib/model/om/BasePcBookkeepingCategory.php';


/**
 * Skeleton subclass for representing a row from the 'pc_bookkeeping_category' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcBookkeepingCategory extends BasePcBookkeepingCategory {
     
    const EXPENSE = 1;     
    const INCOME = 2;   
    
    public function __toString()
    {
        return $this->getName();
    }
} // PcBookkeepingCategory
