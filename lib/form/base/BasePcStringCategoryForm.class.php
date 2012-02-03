<?php

/**
 * PcStringCategory form base class.
 *
 * @method PcStringCategory getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcStringCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'note'       => new sfWidgetFormInputText(),
      'link'       => new sfWidgetFormInputText(),
      'in_account' => new sfWidgetFormInputCheckbox(),
      'in_misc'    => new sfWidgetFormInputCheckbox(),
      'sort_order' => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 64)),
      'note'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'link'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'in_account' => new sfValidatorBoolean(),
      'in_misc'    => new sfValidatorBoolean(),
      'sort_order' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_string_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcStringCategory';
  }


}
