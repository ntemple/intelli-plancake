<?php

/**
 * PcApiAppStats form base class.
 *
 * @method PcApiAppStats getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcApiAppStatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'api_app_id'                   => new sfWidgetFormPropelChoice(array('model' => 'PcApiApp', 'add_empty' => true)),
      'number_of_requests'           => new sfWidgetFormInputText(),
      'bandwidth'                    => new sfWidgetFormInputText(),
      'today'                        => new sfWidgetFormInputText(),
      'number_of_requests_today'     => new sfWidgetFormInputText(),
      'bandwidth_today'              => new sfWidgetFormInputText(),
      'last_hour'                    => new sfWidgetFormInputText(),
      'number_of_requests_last_hour' => new sfWidgetFormInputText(),
      'bandwidth_last_hour'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'api_app_id'                   => new sfValidatorPropelChoice(array('model' => 'PcApiApp', 'column' => 'id', 'required' => false)),
      'number_of_requests'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'bandwidth'                    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'today'                        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'number_of_requests_today'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'bandwidth_today'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'last_hour'                    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'number_of_requests_last_hour' => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'bandwidth_last_hour'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_api_app_stats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcApiAppStats';
  }


}
