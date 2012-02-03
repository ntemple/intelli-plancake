<?php

/**
 * PcGoogleCalendarEvent filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcGoogleCalendarEventFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'event_id'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'event_id'   => new sfValidatorPass(array('required' => false)),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_google_calendar_event_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcGoogleCalendarEvent';
  }

  public function getFields()
  {
    return array(
      'task_id'    => 'ForeignKey',
      'event_id'   => 'Text',
      'updated_at' => 'Date',
      'created_at' => 'Date',
    );
  }
}
