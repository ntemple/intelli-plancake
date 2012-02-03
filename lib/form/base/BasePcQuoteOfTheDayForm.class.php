<?php

/**
 * PcQuoteOfTheDay form base class.
 *
 * @method PcQuoteOfTheDay getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcQuoteOfTheDayForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'quote'                   => new sfWidgetFormInputText(),
      'quote_in_italian'        => new sfWidgetFormInputText(),
      'quote_author'            => new sfWidgetFormInputText(),
      'quote_author_in_italian' => new sfWidgetFormInputText(),
      'is_tip'                  => new sfWidgetFormInputCheckbox(),
      'shown_on'                => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'quote'                   => new sfValidatorString(array('max_length' => 512)),
      'quote_in_italian'        => new sfValidatorString(array('max_length' => 512, 'required' => false)),
      'quote_author'            => new sfValidatorString(array('max_length' => 64)),
      'quote_author_in_italian' => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'is_tip'                  => new sfValidatorBoolean(array('required' => false)),
      'shown_on'                => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_quote_of_the_day[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcQuoteOfTheDay';
  }


}
