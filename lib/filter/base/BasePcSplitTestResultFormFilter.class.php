<?php

/**
 * PcSplitTestResult filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcSplitTestResultFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'number_of_tries'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'number_of_successes' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'number_of_tries'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'number_of_successes' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_split_test_result_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSplitTestResult';
  }

  public function getFields()
  {
    return array(
      'test_id'             => 'ForeignKey',
      'variant_id'          => 'Number',
      'number_of_tries'     => 'Number',
      'number_of_successes' => 'Number',
      'updated_at'          => 'Date',
    );
  }
}
