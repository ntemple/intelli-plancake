<?php

/**
 * PcContactNote form base class.
 *
 * @method PcContactNote getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcContactNoteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'PcContact', 'add_empty' => false)),
      'content'    => new sfWidgetFormInputText(),
      'creator_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'contact_id' => new sfValidatorPropelChoice(array('model' => 'PcContact', 'column' => 'id')),
      'content'    => new sfValidatorString(),
      'creator_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'updated_at' => new sfValidatorDateTime(),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_contact_note[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContactNote';
  }


}
