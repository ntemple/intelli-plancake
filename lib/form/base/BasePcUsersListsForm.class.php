<?php

/**
 * PcUsersLists form base class.
 *
 * @method PcUsersLists getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcUsersListsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id' => new sfWidgetFormInputHidden(),
      'list_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'list_id' => new sfValidatorPropelChoice(array('model' => 'PcList', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_users_lists[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcUsersLists';
  }


}
