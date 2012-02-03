<?php

/**
 * PcTrashbinUsersContexts filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTrashbinUsersContextsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'context'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'deleted_at' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'context'    => new sfValidatorPass(array('required' => false)),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'deleted_at' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_trashbin_users_contexts_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTrashbinUsersContexts';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'user_id'    => 'Number',
      'context'    => 'Text',
      'updated_at' => 'Date',
      'created_at' => 'Date',
      'deleted_at' => 'Number',
    );
  }
}
