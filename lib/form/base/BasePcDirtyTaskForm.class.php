<?php

/**
 * PcDirtyTask form base class.
 *
 * @method PcDirtyTask getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcDirtyTaskForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id' => new sfWidgetFormInputHidden(),
      'task_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'task_id' => new sfValidatorPropelChoice(array('model' => 'PcTask', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_dirty_task[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcDirtyTask';
  }


}
