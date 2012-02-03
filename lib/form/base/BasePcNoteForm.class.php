<?php

/**
 * PcNote form base class.
 *
 * @method PcNote getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcNoteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'creator_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'title'      => new sfWidgetFormInputText(),
      'content'    => new sfWidgetFormInputText(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'creator_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'title'      => new sfValidatorString(array('max_length' => 127)),
      'content'    => new sfValidatorString(),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_note[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcNote';
  }


}
