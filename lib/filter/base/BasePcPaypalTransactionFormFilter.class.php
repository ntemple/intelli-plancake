<?php

/**
 * PcPaypalTransaction filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcPaypalTransactionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'item_number'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'item_name'             => new sfWidgetFormFilterInput(),
      'custom_field'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'payment_status'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'payment_amount'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'payment_currency'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'transaction_id'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'parent_transaction_id' => new sfWidgetFormFilterInput(),
      'receiver_email'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'residence_country'     => new sfWidgetFormFilterInput(),
      'payer_email'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'payment_date'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'error'                 => new sfWidgetFormFilterInput(),
      'raw_data'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'item_number'           => new sfValidatorPass(array('required' => false)),
      'item_name'             => new sfValidatorPass(array('required' => false)),
      'custom_field'          => new sfValidatorPass(array('required' => false)),
      'payment_status'        => new sfValidatorPass(array('required' => false)),
      'payment_amount'        => new sfValidatorPass(array('required' => false)),
      'payment_currency'      => new sfValidatorPass(array('required' => false)),
      'transaction_id'        => new sfValidatorPass(array('required' => false)),
      'parent_transaction_id' => new sfValidatorPass(array('required' => false)),
      'receiver_email'        => new sfValidatorPass(array('required' => false)),
      'residence_country'     => new sfValidatorPass(array('required' => false)),
      'payer_email'           => new sfValidatorPass(array('required' => false)),
      'payment_date'          => new sfValidatorPass(array('required' => false)),
      'error'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'raw_data'              => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_paypal_transaction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPaypalTransaction';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'item_number'           => 'Text',
      'item_name'             => 'Text',
      'custom_field'          => 'Text',
      'payment_status'        => 'Text',
      'payment_amount'        => 'Text',
      'payment_currency'      => 'Text',
      'transaction_id'        => 'Text',
      'parent_transaction_id' => 'Text',
      'receiver_email'        => 'Text',
      'residence_country'     => 'Text',
      'payer_email'           => 'Text',
      'payment_date'          => 'Text',
      'error'                 => 'Number',
      'raw_data'              => 'Text',
      'created_at'            => 'Date',
    );
  }
}
