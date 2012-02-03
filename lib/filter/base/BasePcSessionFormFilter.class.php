<?php

/**
 * PcSession filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcSessionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'data' => new sfWidgetFormFilterInput(),
      'time' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'data' => new sfValidatorPass(array('required' => false)),
      'time' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_session_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSession';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Text',
      'data' => 'Text',
      'time' => 'Number',
    );
  }
}
