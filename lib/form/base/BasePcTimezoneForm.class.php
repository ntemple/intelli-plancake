<?php

/**
 * PcTimezone form base class.
 *
 * @method PcTimezone getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTimezoneForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'label'       => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'offset'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'label'       => new sfValidatorString(array('max_length' => 8)),
      'description' => new sfValidatorString(array('max_length' => 127)),
      'offset'      => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcTimezone', 'column' => array('label')))
    );

    $this->widgetSchema->setNameFormat('pc_timezone[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTimezone';
  }


}
