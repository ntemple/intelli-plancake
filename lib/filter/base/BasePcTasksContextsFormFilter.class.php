<?php

/**
 * PcTasksContexts filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTasksContextsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'task_id'           => new sfWidgetFormPropelChoice(array('model' => 'PcTask', 'add_empty' => true)),
      'users_contexts_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUsersContexts', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'task_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcTask', 'column' => 'id')),
      'users_contexts_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUsersContexts', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('pc_tasks_contexts_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTasksContexts';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'task_id'           => 'ForeignKey',
      'users_contexts_id' => 'ForeignKey',
    );
  }
}
