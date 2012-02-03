<?php

/**
 * PcTranslation form base class.
 *
 * @method PcTranslation getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTranslationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_id' => new sfWidgetFormInputHidden(),
      'string_id'   => new sfWidgetFormInputHidden(),
      'string'      => new sfWidgetFormInputText(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'language_id' => new sfValidatorPropelChoice(array('model' => 'PcLanguage', 'column' => 'id', 'required' => false)),
      'string_id'   => new sfValidatorPropelChoice(array('model' => 'PcString', 'column' => 'id', 'required' => false)),
      'string'      => new sfValidatorString(),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_translation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTranslation';
  }


}
