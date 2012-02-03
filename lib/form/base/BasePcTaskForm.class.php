<?php

/**
 * PcTask form base class.
 *
 * @method PcTask getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTaskForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'list_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcList', 'add_empty' => false)),
      'description'        => new sfWidgetFormInputText(),
      'sort_order'         => new sfWidgetFormInputText(),
      'due_date'           => new sfWidgetFormDate(),
      'due_time'           => new sfWidgetFormInputText(),
      'repetition_id'      => new sfWidgetFormPropelChoice(array('model' => 'PcRepetition', 'add_empty' => true)),
      'repetition_param'   => new sfWidgetFormInputText(),
      'is_starred'         => new sfWidgetFormInputCheckbox(),
      'is_completed'       => new sfWidgetFormInputCheckbox(),
      'is_header'          => new sfWidgetFormInputCheckbox(),
      'is_from_system'     => new sfWidgetFormInputCheckbox(),
      'special_flag'       => new sfWidgetFormInputText(),
      'note'               => new sfWidgetFormInputText(),
      'contexts'           => new sfWidgetFormInputText(),
      'contact_id'         => new sfWidgetFormInputText(),
      'completed_at'       => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'created_at'         => new sfWidgetFormDateTime(),
      'pc_dirty_task_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcUser')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'list_id'            => new sfValidatorPropelChoice(array('model' => 'PcList', 'column' => 'id')),
      'description'        => new sfValidatorString(array('max_length' => 255)),
      'sort_order'         => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'due_date'           => new sfValidatorDate(array('required' => false)),
      'due_time'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'repetition_id'      => new sfValidatorPropelChoice(array('model' => 'PcRepetition', 'column' => 'id', 'required' => false)),
      'repetition_param'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'is_starred'         => new sfValidatorBoolean(array('required' => false)),
      'is_completed'       => new sfValidatorBoolean(),
      'is_header'          => new sfValidatorBoolean(),
      'is_from_system'     => new sfValidatorBoolean(),
      'special_flag'       => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'note'               => new sfValidatorString(array('required' => false)),
      'contexts'           => new sfValidatorString(array('max_length' => 31, 'required' => false)),
      'contact_id'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'completed_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(),
      'created_at'         => new sfValidatorDateTime(),
      'pc_dirty_task_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_task[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTask';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_dirty_task_list']))
    {
      $values = array();
      foreach ($this->object->getPcDirtyTasks() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('pc_dirty_task_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePcDirtyTaskList($con);
  }

  public function savePcDirtyTaskList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['pc_dirty_task_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PcDirtyTaskPeer::TASK_ID, $this->object->getPrimaryKey());
    PcDirtyTaskPeer::doDelete($c, $con);

    $values = $this->getValue('pc_dirty_task_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcDirtyTask();
        $obj->setTaskId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
