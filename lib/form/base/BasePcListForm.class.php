<?php

/**
 * PcList form base class.
 *
 * @method PcList getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcListForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'creator_id'          => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'title'               => new sfWidgetFormInputText(),
      'sort_order'          => new sfWidgetFormInputText(),
      'is_header'           => new sfWidgetFormInputCheckbox(),
      'is_inbox'            => new sfWidgetFormInputCheckbox(),
      'is_todo'             => new sfWidgetFormInputCheckbox(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'created_at'          => new sfWidgetFormDateTime(),
      'pc_users_lists_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcUser')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'creator_id'          => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'title'               => new sfValidatorString(array('max_length' => 255)),
      'sort_order'          => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'is_header'           => new sfValidatorBoolean(),
      'is_inbox'            => new sfValidatorBoolean(),
      'is_todo'             => new sfValidatorBoolean(),
      'updated_at'          => new sfValidatorDateTime(),
      'created_at'          => new sfValidatorDateTime(),
      'pc_users_lists_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_list[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcList';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_users_lists_list']))
    {
      $values = array();
      foreach ($this->object->getPcUsersListss() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('pc_users_lists_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePcUsersListsList($con);
  }

  public function savePcUsersListsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['pc_users_lists_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PcUsersListsPeer::LIST_ID, $this->object->getPrimaryKey());
    PcUsersListsPeer::doDelete($c, $con);

    $values = $this->getValue('pc_users_lists_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcUsersLists();
        $obj->setListId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
