<?php

/**
 * PcSubscriptionType filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcSubscriptionTypeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'expiration_time_expression' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'                       => new sfValidatorPass(array('required' => false)),
      'expiration_time_expression' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_subscription_type_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSubscriptionType';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'name'                       => 'Text',
      'expiration_time_expression' => 'Text',
    );
  }
}
