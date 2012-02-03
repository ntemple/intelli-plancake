<?php

/**
 * PcReview form base class.
 *
 * @method PcReview getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcReviewForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'contact_id' => new sfWidgetFormPropelChoice(array('model' => 'PcContact', 'add_empty' => false)),
      'link'       => new sfWidgetFormInputText(),
      'html'       => new sfWidgetFormInputText(),
      'language'   => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'contact_id' => new sfValidatorPropelChoice(array('model' => 'PcContact', 'column' => 'id')),
      'link'       => new sfValidatorString(array('max_length' => 255)),
      'html'       => new sfValidatorString(),
      'language'   => new sfValidatorString(array('max_length' => 2)),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_review[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcReview';
  }


}
