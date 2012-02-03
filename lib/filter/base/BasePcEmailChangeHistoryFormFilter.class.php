<?php

/**
 * PcEmailChangeHistory filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcEmailChangeHistoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'old_email'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'new_email'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'old_email'  => new sfValidatorPass(array('required' => false)),
      'new_email'  => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_email_change_history_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcEmailChangeHistory';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'user_id'    => 'ForeignKey',
      'old_email'  => 'Text',
      'new_email'  => 'Text',
      'created_at' => 'Date',
    );
  }
}
