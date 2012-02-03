<?php

/**
 * PcTrashbinList form base class.
 *
 * @method PcTrashbinList getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTrashbinListForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'creator_id' => new sfWidgetFormInputText(),
      'title'      => new sfWidgetFormInputText(),
      'sort_order' => new sfWidgetFormInputText(),
      'is_header'  => new sfWidgetFormInputCheckbox(),
      'is_inbox'   => new sfWidgetFormInputCheckbox(),
      'is_todo'    => new sfWidgetFormInputCheckbox(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
      'deleted_at' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'creator_id' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'title'      => new sfValidatorString(array('max_length' => 255)),
      'sort_order' => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'is_header'  => new sfValidatorBoolean(array('required' => false)),
      'is_inbox'   => new sfValidatorBoolean(),
      'is_todo'    => new sfValidatorBoolean(),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted_at' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_trashbin_list[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTrashbinList';
  }


}
