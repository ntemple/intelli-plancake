<?php

/**
 * PcStringCategory filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcStringCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'note'       => new sfWidgetFormFilterInput(),
      'link'       => new sfWidgetFormFilterInput(),
      'in_account' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'in_misc'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'sort_order' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'note'       => new sfValidatorPass(array('required' => false)),
      'link'       => new sfValidatorPass(array('required' => false)),
      'in_account' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'in_misc'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'sort_order' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_string_category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcStringCategory';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'note'       => 'Text',
      'link'       => 'Text',
      'in_account' => 'Boolean',
      'in_misc'    => 'Boolean',
      'sort_order' => 'Number',
      'created_at' => 'Date',
    );
  }
}
