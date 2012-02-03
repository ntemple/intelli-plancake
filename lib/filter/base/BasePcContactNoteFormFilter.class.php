<?php

/**
 * PcContactNote filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcContactNoteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'PcContact', 'add_empty' => true)),
      'content'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'creator_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'contact_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcContact', 'column' => 'id')),
      'content'    => new sfValidatorPass(array('required' => false)),
      'creator_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_contact_note_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContactNote';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'contact_id' => 'ForeignKey',
      'content'    => 'Text',
      'creator_id' => 'ForeignKey',
      'updated_at' => 'Date',
      'created_at' => 'Date',
    );
  }
}
