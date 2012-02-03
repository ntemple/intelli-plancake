<?php

/**
 * PcPaypalProduct form base class.
 *
 * @method PcPaypalProduct getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcPaypalProductForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'item_number'          => new sfWidgetFormInputText(),
      'item_name'            => new sfWidgetFormInputText(),
      'item_price'           => new sfWidgetFormInputText(),
      'item_price_currency'  => new sfWidgetFormInputText(),
      'discount_percentage'  => new sfWidgetFormInputText(),
      'subscription_type_id' => new sfWidgetFormPropelChoice(array('model' => 'PcSubscriptionType', 'add_empty' => false)),
      'paypal_button_code'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'item_number'          => new sfValidatorString(array('max_length' => 32)),
      'item_name'            => new sfValidatorString(array('max_length' => 64)),
      'item_price'           => new sfValidatorString(array('max_length' => 16)),
      'item_price_currency'  => new sfValidatorString(array('max_length' => 5)),
      'discount_percentage'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'subscription_type_id' => new sfValidatorPropelChoice(array('model' => 'PcSubscriptionType', 'column' => 'id')),
      'paypal_button_code'   => new sfValidatorString(array('max_length' => 32)),
    ));

    $this->widgetSchema->setNameFormat('pc_paypal_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPaypalProduct';
  }


}
