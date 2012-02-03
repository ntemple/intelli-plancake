<?php

/**
 * PcHideableHintsSetting form base class.
 *
 * @method PcHideableHintsSetting getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcHideableHintsSettingForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'inbox'      => new sfWidgetFormInputCheckbox(),
      'todo'       => new sfWidgetFormInputCheckbox(),
      'completed'  => new sfWidgetFormInputCheckbox(),
      'quote'      => new sfWidgetFormInputCheckbox(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'inbox'      => new sfValidatorBoolean(),
      'todo'       => new sfValidatorBoolean(),
      'completed'  => new sfValidatorBoolean(),
      'quote'      => new sfValidatorBoolean(),
      'updated_at' => new sfValidatorDateTime(),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_hideable_hints_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcHideableHintsSetting';
  }


}
