<?php

/**
 * PcTrashbinList filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTrashbinListFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'creator_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'title'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order' => new sfWidgetFormFilterInput(),
      'is_header'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_inbox'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_todo'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'creator_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'title'      => new sfValidatorPass(array('required' => false)),
      'sort_order' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_header'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_inbox'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_todo'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_trashbin_list_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTrashbinList';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'creator_id' => 'Number',
      'title'      => 'Text',
      'sort_order' => 'Number',
      'is_header'  => 'Boolean',
      'is_inbox'   => 'Boolean',
      'is_todo'    => 'Boolean',
      'updated_at' => 'Date',
      'created_at' => 'Date',
      'deleted_at' => 'Number',
    );
  }
}
