<?php

/**
 * PcTimezone filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTimezoneFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'label'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'offset'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'label'       => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'offset'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_timezone_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTimezone';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'label'       => 'Text',
      'description' => 'Text',
      'offset'      => 'Number',
    );
  }
}
