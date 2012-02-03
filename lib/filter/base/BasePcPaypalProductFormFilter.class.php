<?php

/**
 * PcPaypalProduct filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcPaypalProductFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'item_number'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'item_name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'item_price'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'item_price_currency'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'discount_percentage'  => new sfWidgetFormFilterInput(),
      'subscription_type_id' => new sfWidgetFormPropelChoice(array('model' => 'PcSubscriptionType', 'add_empty' => true)),
      'paypal_button_code'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'item_number'          => new sfValidatorPass(array('required' => false)),
      'item_name'            => new sfValidatorPass(array('required' => false)),
      'item_price'           => new sfValidatorPass(array('required' => false)),
      'item_price_currency'  => new sfValidatorPass(array('required' => false)),
      'discount_percentage'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'subscription_type_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcSubscriptionType', 'column' => 'id')),
      'paypal_button_code'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_paypal_product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPaypalProduct';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'item_number'          => 'Text',
      'item_name'            => 'Text',
      'item_price'           => 'Text',
      'item_price_currency'  => 'Text',
      'discount_percentage'  => 'Number',
      'subscription_type_id' => 'ForeignKey',
      'paypal_button_code'   => 'Text',
    );
  }
}
