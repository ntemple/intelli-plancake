<?php

/**
 * PcTrashbinUsersContexts form base class.
 *
 * @method PcTrashbinUsersContexts getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcTrashbinUsersContextsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormInputText(),
      'context'    => new sfWidgetFormInputText(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
      'deleted_at' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'context'    => new sfValidatorString(array('max_length' => 31)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'deleted_at' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_trashbin_users_contexts[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTrashbinUsersContexts';
  }


}
