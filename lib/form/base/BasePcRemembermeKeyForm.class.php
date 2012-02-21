<?php

/**
 * PcRemembermeKey form base class.
 *
 * @method PcRemembermeKey getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcRemembermeKeyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'rememberme_key' => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'        => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'rememberme_key' => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcRemembermeKey', 'column' => array('rememberme_key')))
    );

    $this->widgetSchema->setNameFormat('pc_rememberme_key[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcRemembermeKey';
  }


}
