<?php

/**
 * PcApiToken filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcApiTokenFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'api_app_id'       => new sfWidgetFormPropelChoice(array('model' => 'PcApiApp', 'add_empty' => true)),
      'user_id'          => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'expiry_timestamp' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'api_app_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcApiApp', 'column' => 'id')),
      'user_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'expiry_timestamp' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_api_token_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcApiToken';
  }

  public function getFields()
  {
    return array(
      'token'            => 'Text',
      'api_app_id'       => 'ForeignKey',
      'user_id'          => 'ForeignKey',
      'expiry_timestamp' => 'Number',
    );
  }
}
