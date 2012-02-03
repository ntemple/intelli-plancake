<?php

/**
 * PcDirtyTask filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcDirtyTaskFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('pc_dirty_task_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcDirtyTask';
  }

  public function getFields()
  {
    return array(
      'user_id' => 'ForeignKey',
      'task_id' => 'ForeignKey',
    );
  }
}
