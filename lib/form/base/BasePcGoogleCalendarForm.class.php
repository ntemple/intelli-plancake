<?php

/**
 * PcGoogleCalendar form base class.
 *
 * @method PcGoogleCalendar getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcGoogleCalendarForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'user_id'                     => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'calendar_url'                => new sfWidgetFormInputText(),
      'session_token'               => new sfWidgetFormInputText(),
      'email_address'               => new sfWidgetFormInputText(),
      'is_active'                   => new sfWidgetFormInputCheckbox(),
      'is_syncing'                  => new sfWidgetFormInputCheckbox(),
      'latest_sync_start_timestamp' => new sfWidgetFormInputText(),
      'latest_sync_end_timestamp'   => new sfWidgetFormInputText(),
      'updated_at'                  => new sfWidgetFormDateTime(),
      'created_at'                  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'                     => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'calendar_url'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'session_token'               => new sfValidatorString(array('max_length' => 64)),
      'email_address'               => new sfValidatorString(array('max_length' => 123)),
      'is_active'                   => new sfValidatorBoolean(array('required' => false)),
      'is_syncing'                  => new sfValidatorBoolean(array('required' => false)),
      'latest_sync_start_timestamp' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'latest_sync_end_timestamp'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'updated_at'                  => new sfValidatorDateTime(array('required' => false)),
      'created_at'                  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_google_calendar[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcGoogleCalendar';
  }


}
