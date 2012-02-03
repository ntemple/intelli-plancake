<?php

/**
 * PcPlancakeEmailAddress form base class.
 *
 * @method PcPlancakeEmailAddress getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcPlancakeEmailAddressForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id' => new sfWidgetFormInputHidden(),
      'email'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'user_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'email'   => new sfValidatorString(array('max_length' => 63)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcPlancakeEmailAddress', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('pc_plancake_email_address[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPlancakeEmailAddress';
  }


}
