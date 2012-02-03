<?php

/**
 * PcRepetition form base class.
 *
 * @method PcRepetition getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcRepetitionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'human_expression'            => new sfWidgetFormInputText(),
      'computer_expression'         => new sfWidgetFormInputText(),
      'initial_computer_expression' => new sfWidgetFormInputText(),
      'special'                     => new sfWidgetFormInputText(),
      'needs_param'                 => new sfWidgetFormInputCheckbox(),
      'is_param_cardinal'           => new sfWidgetFormInputCheckbox(),
      'min_param'                   => new sfWidgetFormInputText(),
      'max_param'                   => new sfWidgetFormInputText(),
      'sort_order'                  => new sfWidgetFormInputText(),
      'has_divider_below'           => new sfWidgetFormInputCheckbox(),
      'ical_rrule'                  => new sfWidgetFormInputText(),
      'updated_at'                  => new sfWidgetFormDateTime(),
      'created_at'                  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'human_expression'            => new sfValidatorString(array('max_length' => 63)),
      'computer_expression'         => new sfValidatorString(array('max_length' => 63)),
      'initial_computer_expression' => new sfValidatorString(array('max_length' => 63)),
      'special'                     => new sfValidatorString(array('max_length' => 16)),
      'needs_param'                 => new sfValidatorBoolean(array('required' => false)),
      'is_param_cardinal'           => new sfValidatorBoolean(array('required' => false)),
      'min_param'                   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'max_param'                   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'sort_order'                  => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'has_divider_below'           => new sfValidatorBoolean(array('required' => false)),
      'ical_rrule'                  => new sfValidatorString(array('max_length' => 63)),
      'updated_at'                  => new sfValidatorDateTime(array('required' => false)),
      'created_at'                  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcRepetition', 'column' => array('human_expression')))
    );

    $this->widgetSchema->setNameFormat('pc_repetition[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcRepetition';
  }


}
