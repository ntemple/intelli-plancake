<?php

/**
 * PcFailedLogins filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcFailedLoginsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'times'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'times'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_failed_logins_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcFailedLogins';
  }

  public function getFields()
  {
    return array(
      'user_id'    => 'ForeignKey',
      'times'      => 'Number',
      'updated_at' => 'Date',
    );
  }
}
