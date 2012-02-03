<?php

/**
 * PcSubscriptionThankyouPageImpression form base class.
 *
 * @method PcSubscriptionThankyouPageImpression getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcSubscriptionThankyouPageImpressionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'user_id'   => new sfWidgetFormInputText(),
      'username'  => new sfWidgetFormInputText(),
      'email'     => new sfWidgetFormInputText(),
      'viewed_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'username'  => new sfValidatorString(array('max_length' => 25)),
      'email'     => new sfValidatorString(array('max_length' => 80)),
      'viewed_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_subscription_thankyou_page_impression[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSubscriptionThankyouPageImpression';
  }


}
