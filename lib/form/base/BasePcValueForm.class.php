<?php

/**
 * PcValue form base class.
 *
 * @method PcValue getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcValueForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'  => new sfWidgetFormInputHidden(),
      'value' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'name'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getName()), 'empty_value' => $this->getObject()->getName(), 'required' => false)),
      'value' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_value[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcValue';
  }


}
