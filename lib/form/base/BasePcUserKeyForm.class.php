<?php

/**
 * PcUserKey form base class.
 *
 * @method PcUserKey getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcUserKeyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id' => new sfWidgetFormInputHidden(),
      'key'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'user_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'key'     => new sfValidatorString(array('max_length' => 32)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcUserKey', 'column' => array('key')))
    );

    $this->widgetSchema->setNameFormat('pc_user_key[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcUserKey';
  }


}
