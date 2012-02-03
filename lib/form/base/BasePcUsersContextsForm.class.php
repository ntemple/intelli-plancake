<?php

/**
 * PcUsersContexts form base class.
 *
 * @method PcUsersContexts getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcUsersContextsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'context'    => new sfWidgetFormInputText(),
      'sort_order' => new sfWidgetFormInputText(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'context'    => new sfValidatorString(array('max_length' => 31)),
      'sort_order' => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'updated_at' => new sfValidatorDateTime(),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_users_contexts[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcUsersContexts';
  }


}
