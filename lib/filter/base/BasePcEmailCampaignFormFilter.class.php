<?php

/**
 * PcEmailCampaign filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcEmailCampaignFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'comment'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_subject'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_body'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sql_query'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_addresses' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sent_count'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'open_count'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email_count'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'comment'         => new sfValidatorPass(array('required' => false)),
      'email_subject'   => new sfValidatorPass(array('required' => false)),
      'email_body'      => new sfValidatorPass(array('required' => false)),
      'sql_query'       => new sfValidatorPass(array('required' => false)),
      'email_addresses' => new sfValidatorPass(array('required' => false)),
      'sent_count'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'open_count'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'email_count'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_email_campaign_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcEmailCampaign';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'comment'         => 'Text',
      'email_subject'   => 'Text',
      'email_body'      => 'Text',
      'sql_query'       => 'Text',
      'email_addresses' => 'Text',
      'sent_count'      => 'Number',
      'open_count'      => 'Number',
      'email_count'     => 'Number',
      'updated_at'      => 'Date',
      'created_at'      => 'Date',
    );
  }
}
