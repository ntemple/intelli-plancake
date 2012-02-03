<?php

/**
 * PcBookkeepingEntry form base class.
 *
 * @method PcBookkeepingEntry getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcBookkeepingEntryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'type_id'             => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingType', 'add_empty' => false)),
      'contact_id'          => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingContact', 'add_empty' => true)),
      'amount'              => new sfWidgetFormInputText(),
      'description'         => new sfWidgetFormInputText(),
      'date'                => new sfWidgetFormDate(),
      'vat'                 => new sfWidgetFormInputText(),
      'category_id'         => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingCategory', 'add_empty' => false)),
      'payment_method_id'   => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingPaymentMethod', 'add_empty' => false)),
      'ref_number'          => new sfWidgetFormInputText(),
      'needs_clarification' => new sfWidgetFormInputCheckbox(),
      'question'            => new sfWidgetFormInputText(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'created_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'type_id'             => new sfValidatorPropelChoice(array('model' => 'PcBookkeepingType', 'column' => 'id')),
      'contact_id'          => new sfValidatorPropelChoice(array('model' => 'PcBookkeepingContact', 'column' => 'id', 'required' => false)),
      'amount'              => new sfValidatorNumber(),
      'description'         => new sfValidatorString(array('max_length' => 255)),
      'date'                => new sfValidatorDate(),
      'vat'                 => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'category_id'         => new sfValidatorPropelChoice(array('model' => 'PcBookkeepingCategory', 'column' => 'id')),
      'payment_method_id'   => new sfValidatorPropelChoice(array('model' => 'PcBookkeepingPaymentMethod', 'column' => 'id')),
      'ref_number'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'needs_clarification' => new sfValidatorBoolean(),
      'question'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_at'          => new sfValidatorDateTime(),
      'created_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_bookkeeping_entry[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBookkeepingEntry';
  }


}
