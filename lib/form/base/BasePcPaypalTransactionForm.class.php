<?php

/**
 * PcPaypalTransaction form base class.
 *
 * @method PcPaypalTransaction getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcPaypalTransactionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'item_number'           => new sfWidgetFormInputText(),
      'item_name'             => new sfWidgetFormInputText(),
      'custom_field'          => new sfWidgetFormInputText(),
      'payment_status'        => new sfWidgetFormInputText(),
      'payment_amount'        => new sfWidgetFormInputText(),
      'payment_currency'      => new sfWidgetFormInputText(),
      'transaction_id'        => new sfWidgetFormInputText(),
      'parent_transaction_id' => new sfWidgetFormInputText(),
      'receiver_email'        => new sfWidgetFormInputText(),
      'residence_country'     => new sfWidgetFormInputText(),
      'payer_email'           => new sfWidgetFormInputText(),
      'payment_date'          => new sfWidgetFormInputText(),
      'error'                 => new sfWidgetFormInputText(),
      'raw_data'              => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'item_number'           => new sfValidatorString(array('max_length' => 32)),
      'item_name'             => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'custom_field'          => new sfValidatorString(array('max_length' => 127)),
      'payment_status'        => new sfValidatorString(array('max_length' => 32)),
      'payment_amount'        => new sfValidatorString(array('max_length' => 16)),
      'payment_currency'      => new sfValidatorString(array('max_length' => 5)),
      'transaction_id'        => new sfValidatorString(array('max_length' => 64)),
      'parent_transaction_id' => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'receiver_email'        => new sfValidatorString(array('max_length' => 127)),
      'residence_country'     => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'payer_email'           => new sfValidatorString(array('max_length' => 127)),
      'payment_date'          => new sfValidatorString(array('max_length' => 32)),
      'error'                 => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'raw_data'              => new sfValidatorString(),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_paypal_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPaypalTransaction';
  }


}
