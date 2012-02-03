<?php

/**
 * PcApiApp filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcApiAppFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'api_key'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'api_secret'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'is_limited'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'api_key'     => new sfValidatorPass(array('required' => false)),
      'api_secret'  => new sfValidatorPass(array('required' => false)),
      'user_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'is_limited'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'description' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_api_app_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcApiApp';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'api_key'     => 'Text',
      'api_secret'  => 'Text',
      'user_id'     => 'ForeignKey',
      'is_limited'  => 'Boolean',
      'description' => 'Text',
    );
  }
}
