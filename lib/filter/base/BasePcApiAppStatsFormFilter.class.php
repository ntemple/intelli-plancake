<?php

/**
 * PcApiAppStats filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcApiAppStatsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'api_app_id'                   => new sfWidgetFormPropelChoice(array('model' => 'PcApiApp', 'add_empty' => true)),
      'number_of_requests'           => new sfWidgetFormFilterInput(),
      'bandwidth'                    => new sfWidgetFormFilterInput(),
      'today'                        => new sfWidgetFormFilterInput(),
      'number_of_requests_today'     => new sfWidgetFormFilterInput(),
      'bandwidth_today'              => new sfWidgetFormFilterInput(),
      'last_hour'                    => new sfWidgetFormFilterInput(),
      'number_of_requests_last_hour' => new sfWidgetFormFilterInput(),
      'bandwidth_last_hour'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'api_app_id'                   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcApiApp', 'column' => 'id')),
      'number_of_requests'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bandwidth'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'today'                        => new sfValidatorPass(array('required' => false)),
      'number_of_requests_today'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bandwidth_today'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'last_hour'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'number_of_requests_last_hour' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bandwidth_last_hour'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_api_app_stats_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcApiAppStats';
  }

  public function getFields()
  {
    return array(
      'id'                           => 'Number',
      'api_app_id'                   => 'ForeignKey',
      'number_of_requests'           => 'Number',
      'bandwidth'                    => 'Number',
      'today'                        => 'Text',
      'number_of_requests_today'     => 'Number',
      'bandwidth_today'              => 'Number',
      'last_hour'                    => 'Number',
      'number_of_requests_last_hour' => 'Number',
      'bandwidth_last_hour'          => 'Number',
    );
  }
}
