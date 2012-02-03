<?php

/**
 * PcTestimonial filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTestimonialFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'job_position' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'company'      => new sfWidgetFormFilterInput(),
      'city'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'country'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'photo_link'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'         => new sfValidatorPass(array('required' => false)),
      'job_position' => new sfValidatorPass(array('required' => false)),
      'company'      => new sfValidatorPass(array('required' => false)),
      'city'         => new sfValidatorPass(array('required' => false)),
      'country'      => new sfValidatorPass(array('required' => false)),
      'comment'      => new sfValidatorPass(array('required' => false)),
      'photo_link'   => new sfValidatorPass(array('required' => false)),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_testimonial_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTestimonial';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'user_id'      => 'Number',
      'name'         => 'Text',
      'job_position' => 'Text',
      'company'      => 'Text',
      'city'         => 'Text',
      'country'      => 'Text',
      'comment'      => 'Text',
      'photo_link'   => 'Text',
      'updated_at'   => 'Date',
      'created_at'   => 'Date',
    );
  }
}
