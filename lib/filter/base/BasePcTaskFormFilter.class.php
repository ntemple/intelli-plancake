<?php

/**
 * PcTask filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTaskFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcList', 'add_empty' => true)),
      'description'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order'         => new sfWidgetFormFilterInput(),
      'due_date'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'due_time'           => new sfWidgetFormFilterInput(),
      'repetition_id'      => new sfWidgetFormPropelChoice(array('model' => 'PcRepetition', 'add_empty' => true)),
      'repetition_param'   => new sfWidgetFormFilterInput(),
      'is_starred'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_completed'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_header'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_from_system'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'special_flag'       => new sfWidgetFormFilterInput(),
      'note'               => new sfWidgetFormFilterInput(),
      'contexts'           => new sfWidgetFormFilterInput(),
      'contact_id'         => new sfWidgetFormFilterInput(),
      'completed_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pc_dirty_task_list' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'list_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcList', 'column' => 'id')),
      'description'        => new sfValidatorPass(array('required' => false)),
      'sort_order'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'due_date'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'due_time'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'repetition_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcRepetition', 'column' => 'id')),
      'repetition_param'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_starred'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_completed'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_header'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_from_system'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'special_flag'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'note'               => new sfValidatorPass(array('required' => false)),
      'contexts'           => new sfValidatorPass(array('required' => false)),
      'contact_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'completed_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_dirty_task_list' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_task_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPcDirtyTaskListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PcDirtyTaskPeer::TASK_ID, PcTaskPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcDirtyTaskPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcDirtyTaskPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcTask';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'list_id'            => 'ForeignKey',
      'description'        => 'Text',
      'sort_order'         => 'Number',
      'due_date'           => 'Date',
      'due_time'           => 'Number',
      'repetition_id'      => 'ForeignKey',
      'repetition_param'   => 'Number',
      'is_starred'         => 'Boolean',
      'is_completed'       => 'Boolean',
      'is_header'          => 'Boolean',
      'is_from_system'     => 'Boolean',
      'special_flag'       => 'Number',
      'note'               => 'Text',
      'contexts'           => 'Text',
      'contact_id'         => 'Number',
      'completed_at'       => 'Date',
      'updated_at'         => 'Date',
      'created_at'         => 'Date',
      'pc_dirty_task_list' => 'ManyKey',
    );
  }
}
