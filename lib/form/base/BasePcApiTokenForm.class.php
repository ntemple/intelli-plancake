<?php

/**
 * PcApiToken form base class.
 *
 * @method PcApiToken getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcApiTokenForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'token'            => new sfWidgetFormInputHidden(),
      'api_app_id'       => new sfWidgetFormPropelChoice(array('model' => 'PcApiApp', 'add_empty' => false)),
      'user_id'          => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'expiry_timestamp' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'token'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getToken()), 'empty_value' => $this->getObject()->getToken(), 'required' => false)),
      'api_app_id'       => new sfValidatorPropelChoice(array('model' => 'PcApiApp', 'column' => 'id')),
      'user_id'          => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'expiry_timestamp' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_api_token[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcApiToken';
  }


}
