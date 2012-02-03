<?php

require 'lib/model/om/BasePcHideableHintsSettingPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'pc_hideable_hints_setting' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcHideableHintsSettingPeer extends BasePcHideableHintsSettingPeer {
    
    const INBOX_HINT = 'inbox';
    const TODO_HINT = 'todo';
    const COMPLETED_HINT = 'completed';
    const QUOTE_HINT = 'quote';    
} // PcHideableHintsSettingPeer
