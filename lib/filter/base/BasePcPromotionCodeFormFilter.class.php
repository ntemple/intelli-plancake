<?php

/**
 * PcPromotionCode filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcPromotionCodeFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'discount_percentage'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'expiry_date'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'only_for_new_customers' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'uses_count'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_uses'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'note'                   => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'code'                   => new sfValidatorPass(array('required' => false)),
      'discount_percentage'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'expiry_date'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'only_for_new_customers' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'uses_count'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_uses'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'note'                   => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_promotion_code_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPromotionCode';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'code'                   => 'Text',
      'discount_percentage'    => 'Number',
      'expiry_date'            => 'Date',
      'only_for_new_customers' => 'Boolean',
      'uses_count'             => 'Number',
      'max_uses'               => 'Number',
      'note'                   => 'Text',
      'created_at'             => 'Date',
    );
  }
}
