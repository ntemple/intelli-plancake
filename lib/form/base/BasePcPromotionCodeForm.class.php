<?php

/**
 * PcPromotionCode form base class.
 *
 * @method PcPromotionCode getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcPromotionCodeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'code'                   => new sfWidgetFormInputText(),
      'discount_percentage'    => new sfWidgetFormInputText(),
      'expiry_date'            => new sfWidgetFormDate(),
      'only_for_new_customers' => new sfWidgetFormInputCheckbox(),
      'uses_count'             => new sfWidgetFormInputText(),
      'max_uses'               => new sfWidgetFormInputText(),
      'note'                   => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'code'                   => new sfValidatorString(array('max_length' => 25)),
      'discount_percentage'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'expiry_date'            => new sfValidatorDate(),
      'only_for_new_customers' => new sfValidatorBoolean(),
      'uses_count'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'max_uses'               => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'note'                   => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_promotion_code[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPromotionCode';
  }


}
