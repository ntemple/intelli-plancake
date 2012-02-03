<?php

/**
 * PcTranslator filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTranslatorFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcLanguage', 'add_empty' => true)),
      'has_accepted_agreement' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'language_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcLanguage', 'column' => 'id')),
      'has_accepted_agreement' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_translator_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTranslator';
  }

  public function getFields()
  {
    return array(
      'user_id'                => 'Number',
      'language_id'            => 'ForeignKey',
      'has_accepted_agreement' => 'Boolean',
      'created_at'             => 'Date',
    );
  }
}
