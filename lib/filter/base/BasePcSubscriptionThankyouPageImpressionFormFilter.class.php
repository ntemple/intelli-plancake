<?php

/**
 * PcSubscriptionThankyouPageImpression filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcSubscriptionThankyouPageImpressionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'   => new sfWidgetFormFilterInput(),
      'username'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'viewed_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'username'  => new sfValidatorPass(array('required' => false)),
      'email'     => new sfValidatorPass(array('required' => false)),
      'viewed_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_subscription_thankyou_page_impression_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSubscriptionThankyouPageImpression';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'user_id'   => 'Number',
      'username'  => 'Text',
      'email'     => 'Text',
      'viewed_at' => 'Date',
    );
  }
}
