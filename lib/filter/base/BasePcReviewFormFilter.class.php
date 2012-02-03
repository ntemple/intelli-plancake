<?php

/**
 * PcReview filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcReviewFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'PcContact', 'add_empty' => true)),
      'link'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'html'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'language'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'contact_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcContact', 'column' => 'id')),
      'link'       => new sfValidatorPass(array('required' => false)),
      'html'       => new sfValidatorPass(array('required' => false)),
      'language'   => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_review_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcReview';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'contact_id' => 'ForeignKey',
      'link'       => 'Text',
      'html'       => 'Text',
      'language'   => 'Text',
      'created_at' => 'Date',
    );
  }
}
