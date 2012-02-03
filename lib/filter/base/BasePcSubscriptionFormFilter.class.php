<?php

/**
 * PcSubscription filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcSubscriptionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                 => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'subscription_type_id'    => new sfWidgetFormPropelChoice(array('model' => 'PcSubscriptionType', 'add_empty' => true)),
      'was_gift'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'was_automatic'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'paypal_transaction_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_refunded_or_reversed' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'user_id'                 => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'subscription_type_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcSubscriptionType', 'column' => 'id')),
      'was_gift'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'was_automatic'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'paypal_transaction_id'   => new sfValidatorPass(array('required' => false)),
      'is_refunded_or_reversed' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_subscription_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSubscription';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'user_id'                 => 'ForeignKey',
      'subscription_type_id'    => 'ForeignKey',
      'was_gift'                => 'Boolean',
      'was_automatic'           => 'Boolean',
      'paypal_transaction_id'   => 'Text',
      'is_refunded_or_reversed' => 'Boolean',
      'created_at'              => 'Date',
    );
  }
}
