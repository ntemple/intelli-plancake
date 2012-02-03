<?php

/**
 * PcApiApp form base class.
 *
 * @method PcApiApp getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcApiAppForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'api_key'     => new sfWidgetFormInputText(),
      'api_secret'  => new sfWidgetFormInputText(),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'is_limited'  => new sfWidgetFormInputCheckbox(),
      'description' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 64)),
      'api_key'     => new sfValidatorString(array('max_length' => 40)),
      'api_secret'  => new sfValidatorString(array('max_length' => 16)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'is_limited'  => new sfValidatorBoolean(array('required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcApiApp', 'column' => array('api_key')))
    );

    $this->widgetSchema->setNameFormat('pc_api_app[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcApiApp';
  }


}
