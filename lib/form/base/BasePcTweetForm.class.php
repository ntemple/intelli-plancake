<?php

/**
 * PcTweet form base class.
 *
 * @method PcTweet getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTweetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'content'    => new sfWidgetFormInputText(),
      'author'     => new sfWidgetFormInputText(),
      'link'       => new sfWidgetFormInputText(),
      'language'   => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'content'    => new sfValidatorString(array('max_length' => 256)),
      'author'     => new sfValidatorString(array('max_length' => 128)),
      'link'       => new sfValidatorString(array('max_length' => 255)),
      'language'   => new sfValidatorString(array('max_length' => 2)),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_tweet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTweet';
  }


}
