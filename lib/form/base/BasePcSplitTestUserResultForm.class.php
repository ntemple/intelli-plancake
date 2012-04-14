<?php

/**
 * PcSplitTestUserResult form base class.
 *
 * @method PcSplitTestUserResult getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcSplitTestUserResultForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormInputHidden(),
      'test_id'    => new sfWidgetFormInputHidden(),
      'variant_id' => new sfWidgetFormInputHidden(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'test_id'    => new sfValidatorPropelChoice(array('model' => 'PcSplitTest', 'column' => 'id', 'required' => false)),
      'variant_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getVariantId()), 'empty_value' => $this->getObject()->getVariantId(), 'required' => false)),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_split_test_user_result[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSplitTestUserResult';
  }


}
