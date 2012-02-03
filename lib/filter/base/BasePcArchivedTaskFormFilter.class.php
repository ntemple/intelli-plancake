<?php

/**
 * PcArchivedTask filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcArchivedTaskFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order'       => new sfWidgetFormFilterInput(),
      'due_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'due_time'         => new sfWidgetFormFilterInput(),
      'repetition_id'    => new sfWidgetFormFilterInput(),
      'repetition_param' => new sfWidgetFormFilterInput(),
      'is_starred'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_completed'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_header'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_from_system'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'special_flag'     => new sfWidgetFormFilterInput(),
      'note'             => new sfWidgetFormFilterInput(),
      'contexts'         => new sfWidgetFormFilterInput(),
      'completed_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'list_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'description'      => new sfValidatorPass(array('required' => false)),
      'sort_order'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'due_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'due_time'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'repetition_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'repetition_param' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_starred'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_completed'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_header'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_from_system'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'special_flag'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'note'             => new sfValidatorPass(array('required' => false)),
      'contexts'         => new sfValidatorPass(array('required' => false)),
      'completed_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_archived_task_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcArchivedTask';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'list_id'          => 'Number',
      'description'      => 'Text',
      'sort_order'       => 'Number',
      'due_date'         => 'Date',
      'due_time'         => 'Number',
      'repetition_id'    => 'Number',
      'repetition_param' => 'Number',
      'is_starred'       => 'Boolean',
      'is_completed'     => 'Boolean',
      'is_header'        => 'Boolean',
      'is_from_system'   => 'Boolean',
      'special_flag'     => 'Number',
      'note'             => 'Text',
      'contexts'         => 'Text',
      'completed_at'     => 'Date',
      'updated_at'       => 'Date',
      'created_at'       => 'Date',
    );
  }
}
