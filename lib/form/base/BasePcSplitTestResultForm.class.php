<?php

/**
 * PcSplitTestResult form base class.
 *
 * @method PcSplitTestResult getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcSplitTestResultForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'test_id'             => new sfWidgetFormInputHidden(),
      'variant_id'          => new sfWidgetFormInputHidden(),
      'number_of_tries'     => new sfWidgetFormInputText(),
      'number_of_successes' => new sfWidgetFormInputText(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'test_id'             => new sfValidatorPropelChoice(array('model' => 'PcSplitTest', 'column' => 'id', 'required' => false)),
      'variant_id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getVariantId()), 'empty_value' => $this->getObject()->getVariantId(), 'required' => false)),
      'number_of_tries'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'number_of_successes' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_split_test_result[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSplitTestResult';
  }


}
