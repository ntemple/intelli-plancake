<?php

/**
 * PcNote filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcNoteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'creator_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'title'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'creator_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'title'      => new sfValidatorPass(array('required' => false)),
      'content'    => new sfValidatorPass(array('required' => false)),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_note_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcNote';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'creator_id' => 'ForeignKey',
      'title'      => 'Text',
      'content'    => 'Text',
      'updated_at' => 'Date',
      'created_at' => 'Date',
    );
  }
}
