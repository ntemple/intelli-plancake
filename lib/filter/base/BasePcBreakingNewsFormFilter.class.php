<?php

/**
 * PcBreakingNews filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcBreakingNewsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'headline'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'link'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'headline'   => new sfValidatorPass(array('required' => false)),
      'link'       => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_breaking_news_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBreakingNews';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'headline'   => 'Text',
      'link'       => 'Text',
      'created_at' => 'Date',
    );
  }
}
