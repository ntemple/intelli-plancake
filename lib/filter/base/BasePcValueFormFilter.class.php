<?php

/**
 * PcValue filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcValueFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'value' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'value' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_value_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcValue';
  }

  public function getFields()
  {
    return array(
      'name'  => 'Text',
      'value' => 'Text',
    );
  }
}
