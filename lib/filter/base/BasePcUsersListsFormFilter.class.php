<?php

/**
 * PcUsersLists filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcUsersListsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('pc_users_lists_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcUsersLists';
  }

  public function getFields()
  {
    return array(
      'user_id' => 'ForeignKey',
      'list_id' => 'ForeignKey',
    );
  }
}
