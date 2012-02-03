<?php

/**
 * PcActivationToken form base class.
 *
 * @method PcActivationToken getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcActivationTokenForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id' => new sfWidgetFormInputHidden(),
      'token'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'user_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'token'   => new sfValidatorString(array('max_length' => 16)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcActivationToken', 'column' => array('token')))
    );

    $this->widgetSchema->setNameFormat('pc_activation_token[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcActivationToken';
  }


}
