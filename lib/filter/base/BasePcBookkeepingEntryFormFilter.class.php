<?php

/**
 * PcBookkeepingEntry filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcBookkeepingEntryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_id'             => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingType', 'add_empty' => true)),
      'contact_id'          => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingContact', 'add_empty' => true)),
      'amount'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'vat'                 => new sfWidgetFormFilterInput(),
      'category_id'         => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingCategory', 'add_empty' => true)),
      'payment_method_id'   => new sfWidgetFormPropelChoice(array('model' => 'PcBookkeepingPaymentMethod', 'add_empty' => true)),
      'ref_number'          => new sfWidgetFormFilterInput(),
      'needs_clarification' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'question'            => new sfWidgetFormFilterInput(),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'type_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcBookkeepingType', 'column' => 'id')),
      'contact_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcBookkeepingContact', 'column' => 'id')),
      'amount'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'description'         => new sfValidatorPass(array('required' => false)),
      'date'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'vat'                 => new sfValidatorPass(array('required' => false)),
      'category_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcBookkeepingCategory', 'column' => 'id')),
      'payment_method_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcBookkeepingPaymentMethod', 'column' => 'id')),
      'ref_number'          => new sfValidatorPass(array('required' => false)),
      'needs_clarification' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'question'            => new sfValidatorPass(array('required' => false)),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_bookkeeping_entry_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBookkeepingEntry';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'type_id'             => 'ForeignKey',
      'contact_id'          => 'ForeignKey',
      'amount'              => 'Number',
      'description'         => 'Text',
      'date'                => 'Date',
      'vat'                 => 'Text',
      'category_id'         => 'ForeignKey',
      'payment_method_id'   => 'ForeignKey',
      'ref_number'          => 'Text',
      'needs_clarification' => 'Boolean',
      'question'            => 'Text',
      'updated_at'          => 'Date',
      'created_at'          => 'Date',
    );
  }
}
