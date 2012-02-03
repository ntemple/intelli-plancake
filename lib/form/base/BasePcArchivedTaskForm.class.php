<?php

/**
 * PcArchivedTask form base class.
 *
 * @method PcArchivedTask getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcArchivedTaskForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'list_id'          => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormInputText(),
      'sort_order'       => new sfWidgetFormInputText(),
      'due_date'         => new sfWidgetFormDate(),
      'due_time'         => new sfWidgetFormInputText(),
      'repetition_id'    => new sfWidgetFormInputText(),
      'repetition_param' => new sfWidgetFormInputText(),
      'is_starred'       => new sfWidgetFormInputCheckbox(),
      'is_completed'     => new sfWidgetFormInputCheckbox(),
      'is_header'        => new sfWidgetFormInputCheckbox(),
      'is_from_system'   => new sfWidgetFormInputCheckbox(),
      'special_flag'     => new sfWidgetFormInputText(),
      'note'             => new sfWidgetFormInputText(),
      'contexts'         => new sfWidgetFormInputText(),
      'completed_at'     => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'list_id'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'description'      => new sfValidatorString(array('max_length' => 255)),
      'sort_order'       => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'due_date'         => new sfValidatorDate(array('required' => false)),
      'due_time'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'repetition_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'repetition_param' => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'is_starred'       => new sfValidatorBoolean(array('required' => false)),
      'is_completed'     => new sfValidatorBoolean(),
      'is_header'        => new sfValidatorBoolean(),
      'is_from_system'   => new sfValidatorBoolean(),
      'special_flag'     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'note'             => new sfValidatorString(array('required' => false)),
      'contexts'         => new sfValidatorString(array('max_length' => 31, 'required' => false)),
      'completed_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(),
      'created_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_archived_task[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcArchivedTask';
  }


}
