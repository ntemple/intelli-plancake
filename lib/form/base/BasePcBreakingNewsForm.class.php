<?php

/**
 * PcBreakingNews form base class.
 *
 * @method PcBreakingNews getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcBreakingNewsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'headline'   => new sfWidgetFormInputText(),
      'link'       => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'headline'   => new sfValidatorString(array('max_length' => 256)),
      'link'       => new sfValidatorString(array('max_length' => 256)),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_breaking_news[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBreakingNews';
  }


}
