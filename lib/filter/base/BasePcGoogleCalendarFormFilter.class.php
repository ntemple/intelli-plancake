<?php

/**
 * PcGoogleCalendar filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcGoogleCalendarFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                     => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'calendar_url'                => new sfWidgetFormFilterInput(),
      'session_token'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_address'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_syncing'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'latest_sync_start_timestamp' => new sfWidgetFormFilterInput(),
      'latest_sync_end_timestamp'   => new sfWidgetFormFilterInput(),
      'updated_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'user_id'                     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'calendar_url'                => new sfValidatorPass(array('required' => false)),
      'session_token'               => new sfValidatorPass(array('required' => false)),
      'email_address'               => new sfValidatorPass(array('required' => false)),
      'is_active'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_syncing'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'latest_sync_start_timestamp' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'latest_sync_end_timestamp'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_google_calendar_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcGoogleCalendar';
  }

  public function getFields()
  {
    return array(
      'id'                          => 'Number',
      'user_id'                     => 'ForeignKey',
      'calendar_url'                => 'Text',
      'session_token'               => 'Text',
      'email_address'               => 'Text',
      'is_active'                   => 'Boolean',
      'is_syncing'                  => 'Boolean',
      'latest_sync_start_timestamp' => 'Number',
      'latest_sync_end_timestamp'   => 'Number',
      'updated_at'                  => 'Date',
      'created_at'                  => 'Date',
    );
  }
}
