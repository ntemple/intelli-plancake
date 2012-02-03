<?php

/**
 * PcHideableHintsSetting filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcHideableHintsSettingFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'inbox'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'todo'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'completed'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'quote'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'inbox'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'todo'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'completed'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'quote'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_hideable_hints_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcHideableHintsSetting';
  }

  public function getFields()
  {
    return array(
      'id'         => 'ForeignKey',
      'inbox'      => 'Boolean',
      'todo'       => 'Boolean',
      'completed'  => 'Boolean',
      'quote'      => 'Boolean',
      'updated_at' => 'Date',
      'created_at' => 'Date',
    );
  }
}
