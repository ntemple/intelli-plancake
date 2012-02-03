<?php

/**
 * PcUpdate form base class.
 *
 * @method PcUpdate getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcUpdateForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'signature'   => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'url'         => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'signature'   => new sfValidatorString(array('max_length' => 32)),
      'description' => new sfValidatorString(array('max_length' => 512)),
      'url'         => new sfValidatorString(array('max_length' => 128)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcUpdate', 'column' => array('signature')))
    );

    $this->widgetSchema->setNameFormat('pc_update[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcUpdate';
  }


}
