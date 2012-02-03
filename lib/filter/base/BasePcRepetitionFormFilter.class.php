<?php

/**
 * PcRepetition filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcRepetitionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'human_expression'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'computer_expression'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'initial_computer_expression' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'special'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'needs_param'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_param_cardinal'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'min_param'                   => new sfWidgetFormFilterInput(),
      'max_param'                   => new sfWidgetFormFilterInput(),
      'sort_order'                  => new sfWidgetFormFilterInput(),
      'has_divider_below'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ical_rrule'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'updated_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'human_expression'            => new sfValidatorPass(array('required' => false)),
      'computer_expression'         => new sfValidatorPass(array('required' => false)),
      'initial_computer_expression' => new sfValidatorPass(array('required' => false)),
      'special'                     => new sfValidatorPass(array('required' => false)),
      'needs_param'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_param_cardinal'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'min_param'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_param'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sort_order'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'has_divider_below'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ical_rrule'                  => new sfValidatorPass(array('required' => false)),
      'updated_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_repetition_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcRepetition';
  }

  public function getFields()
  {
    return array(
      'id'                          => 'Number',
      'human_expression'            => 'Text',
      'computer_expression'         => 'Text',
      'initial_computer_expression' => 'Text',
      'special'                     => 'Text',
      'needs_param'                 => 'Boolean',
      'is_param_cardinal'           => 'Boolean',
      'min_param'                   => 'Number',
      'max_param'                   => 'Number',
      'sort_order'                  => 'Number',
      'has_divider_below'           => 'Boolean',
      'ical_rrule'                  => 'Text',
      'updated_at'                  => 'Date',
      'created_at'                  => 'Date',
    );
  }
}
