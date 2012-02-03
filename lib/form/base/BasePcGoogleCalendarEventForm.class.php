<?php

/**
 * PcGoogleCalendarEvent form base class.
 *
 * @method PcGoogleCalendarEvent getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcGoogleCalendarEventForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'task_id'    => new sfWidgetFormInputHidden(),
      'event_id'   => new sfWidgetFormInputText(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'task_id'    => new sfValidatorPropelChoice(array('model' => 'PcTask', 'column' => 'id', 'required' => false)),
      'event_id'   => new sfValidatorString(array('max_length' => 32)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_google_calendar_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcGoogleCalendarEvent';
  }


}
