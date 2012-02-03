<?php

/**
 * PcContactCompany filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcContactCompanyFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(),
      'email'      => new sfWidgetFormFilterInput(),
      'website'    => new sfWidgetFormFilterInput(),
      'address'    => new sfWidgetFormFilterInput(),
      'note'       => new sfWidgetFormFilterInput(),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'email'      => new sfValidatorPass(array('required' => false)),
      'website'    => new sfValidatorPass(array('required' => false)),
      'address'    => new sfValidatorPass(array('required' => false)),
      'note'       => new sfValidatorPass(array('required' => false)),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_contact_company_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContactCompany';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'email'      => 'Text',
      'website'    => 'Text',
      'address'    => 'Text',
      'note'       => 'Text',
      'updated_at' => 'Date',
      'created_at' => 'Date',
    );
  }
}
