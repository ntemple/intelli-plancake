<?php

/**
 * PcTestimonial form base class.
 *
 * @method PcTestimonial getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTestimonialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'user_id'      => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'job_position' => new sfWidgetFormInputText(),
      'company'      => new sfWidgetFormInputText(),
      'city'         => new sfWidgetFormInputText(),
      'country'      => new sfWidgetFormInputText(),
      'comment'      => new sfWidgetFormInputText(),
      'photo_link'   => new sfWidgetFormInputText(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'created_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getUserId()), 'empty_value' => $this->getObject()->getUserId(), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 256)),
      'job_position' => new sfValidatorString(array('max_length' => 256)),
      'company'      => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'city'         => new sfValidatorString(array('max_length' => 256)),
      'country'      => new sfValidatorString(array('max_length' => 256)),
      'comment'      => new sfValidatorString(),
      'photo_link'   => new sfValidatorString(array('max_length' => 256)),
      'updated_at'   => new sfValidatorDateTime(),
      'created_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_testimonial[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTestimonial';
  }


}
