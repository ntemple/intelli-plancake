<?php

/**
 * PcBookkeepingEntry form.
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
class PcBookkeepingEntryForm extends BasePcBookkeepingEntryForm
{
  public function configure()
  {
      $this->setWidget('description', new sfWidgetFormTextarea());
      $this->setWidget('date', new sfWidgetFormJQueryDate());      
      
      unset($this['updated_at'], $this['created_at']);       
  }
}
