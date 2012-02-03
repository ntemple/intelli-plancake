<?php

/**
 * PcSubscriptionType form base class.
 *
 * @method PcSubscriptionType getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcSubscriptionTypeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'name'                       => new sfWidgetFormInputText(),
      'expiration_time_expression' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 32)),
      'expiration_time_expression' => new sfValidatorString(array('max_length' => 32)),
    ));

    $this->widgetSchema->setNameFormat('pc_subscription_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSubscriptionType';
  }


}
