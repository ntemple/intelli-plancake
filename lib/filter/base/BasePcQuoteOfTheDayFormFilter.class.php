<?php

/**
 * PcQuoteOfTheDay filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcQuoteOfTheDayFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'quote'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'quote_in_italian'        => new sfWidgetFormFilterInput(),
      'quote_author'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'quote_author_in_italian' => new sfWidgetFormFilterInput(),
      'is_tip'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'shown_on'                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'quote'                   => new sfValidatorPass(array('required' => false)),
      'quote_in_italian'        => new sfValidatorPass(array('required' => false)),
      'quote_author'            => new sfValidatorPass(array('required' => false)),
      'quote_author_in_italian' => new sfValidatorPass(array('required' => false)),
      'is_tip'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'shown_on'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('pc_quote_of_the_day_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcQuoteOfTheDay';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'quote'                   => 'Text',
      'quote_in_italian'        => 'Text',
      'quote_author'            => 'Text',
      'quote_author_in_italian' => 'Text',
      'is_tip'                  => 'Boolean',
      'shown_on'                => 'Number',
    );
  }
}
