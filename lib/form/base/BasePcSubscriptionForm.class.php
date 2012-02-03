<?php

/**
 * PcSubscription form base class.
 *
 * @method PcSubscription getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcSubscriptionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'user_id'                 => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'subscription_type_id'    => new sfWidgetFormPropelChoice(array('model' => 'PcSubscriptionType', 'add_empty' => false)),
      'was_gift'                => new sfWidgetFormInputCheckbox(),
      'was_automatic'           => new sfWidgetFormInputCheckbox(),
      'paypal_transaction_id'   => new sfWidgetFormInputText(),
      'is_refunded_or_reversed' => new sfWidgetFormInputCheckbox(),
      'created_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'                 => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'subscription_type_id'    => new sfValidatorPropelChoice(array('model' => 'PcSubscriptionType', 'column' => 'id')),
      'was_gift'                => new sfValidatorBoolean(),
      'was_automatic'           => new sfValidatorBoolean(),
      'paypal_transaction_id'   => new sfValidatorString(array('max_length' => 64)),
      'is_refunded_or_reversed' => new sfValidatorBoolean(),
      'created_at'              => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_subscription[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSubscription';
  }


}
