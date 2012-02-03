<?php

/**
 * PcCounter filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcCounterFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'  => new sfWidgetFormFilterInput(),
      'value' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'  => new sfValidatorPass(array('required' => false)),
      'value' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_counter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcCounter';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'name'  => 'Text',
      'value' => 'Number',
    );
  }
}
