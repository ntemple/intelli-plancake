<?php

/**
 * PcTranslator form base class.
 *
 * @method PcTranslator getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTranslatorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                => new sfWidgetFormInputHidden(),
      'language_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcLanguage', 'add_empty' => false)),
      'has_accepted_agreement' => new sfWidgetFormInputCheckbox(),
      'created_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getUserId()), 'empty_value' => $this->getObject()->getUserId(), 'required' => false)),
      'language_id'            => new sfValidatorPropelChoice(array('model' => 'PcLanguage', 'column' => 'id')),
      'has_accepted_agreement' => new sfValidatorBoolean(),
      'created_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_translator[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTranslator';
  }


}
