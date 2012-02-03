<?php

/**
 * PcFailedLogins form base class.
 *
 * @method PcFailedLogins getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcFailedLoginsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormInputHidden(),
      'times'      => new sfWidgetFormInputText(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'times'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_failed_logins[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcFailedLogins';
  }


}
