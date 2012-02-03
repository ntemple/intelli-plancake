<?php

/**
 * PcTasksContexts form base class.
 *
 * @method PcTasksContexts getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTasksContextsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'task_id'           => new sfWidgetFormPropelChoice(array('model' => 'PcTask', 'add_empty' => false)),
      'users_contexts_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUsersContexts', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'task_id'           => new sfValidatorPropelChoice(array('model' => 'PcTask', 'column' => 'id')),
      'users_contexts_id' => new sfValidatorPropelChoice(array('model' => 'PcUsersContexts', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('pc_tasks_contexts[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTasksContexts';
  }


}
