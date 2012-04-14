<?php

/**
 * PcUser form base class.
 *
 * @method PcUser getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'username'                       => new sfWidgetFormInputText(),
      'email'                          => new sfWidgetFormInputText(),
      'encrypted_password'             => new sfWidgetFormInputText(),
      'salt'                           => new sfWidgetFormInputText(),
      'date_format'                    => new sfWidgetFormInputText(),
      'time_format'                    => new sfWidgetFormInputText(),
      'timezone_id'                    => new sfWidgetFormPropelChoice(array('model' => 'PcTimezone', 'add_empty' => true)),
      'week_start'                     => new sfWidgetFormInputText(),
      'dst_active'                     => new sfWidgetFormInputCheckbox(),
      'awaiting_activation'            => new sfWidgetFormInputCheckbox(),
      'newsletter'                     => new sfWidgetFormInputCheckbox(),
      'forum_id'                       => new sfWidgetFormInputText(),
      'last_login'                     => new sfWidgetFormDateTime(),
      'language'                       => new sfWidgetFormInputText(),
      'preferred_language'             => new sfWidgetFormInputText(),
      'ip_address'                     => new sfWidgetFormInputText(),
      'has_desktop_app_been_loaded'    => new sfWidgetFormInputCheckbox(),
      'has_requested_free_trial'       => new sfWidgetFormInputCheckbox(),
      'avatar_random_suffix'           => new sfWidgetFormInputText(),
      'reminders_active'               => new sfWidgetFormInputCheckbox(),
      'latest_blog_access'             => new sfWidgetFormDateTime(),
      'latest_backup_request'          => new sfWidgetFormDateTime(),
      'latest_import_request'          => new sfWidgetFormDateTime(),
      'latest_breaking_news_closed'    => new sfWidgetFormInputText(),
      'last_promotional_code_inserted' => new sfWidgetFormInputText(),
      'blocked'                        => new sfWidgetFormInputCheckbox(),
      'session_entry_point'            => new sfWidgetFormInputText(),
      'session_referral'               => new sfWidgetFormInputText(),
      'created_at'                     => new sfWidgetFormDateTime(),
      'pc_users_lists_list'            => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcList')),
      'pc_dirty_task_list'             => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcTask')),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'username'                       => new sfValidatorString(array('max_length' => 25)),
      'email'                          => new sfValidatorString(array('max_length' => 80)),
      'encrypted_password'             => new sfValidatorString(array('max_length' => 40)),
      'salt'                           => new sfValidatorString(array('max_length' => 12)),
      'date_format'                    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'time_format'                    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'timezone_id'                    => new sfValidatorPropelChoice(array('model' => 'PcTimezone', 'column' => 'id', 'required' => false)),
      'week_start'                     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'dst_active'                     => new sfValidatorBoolean(array('required' => false)),
      'awaiting_activation'            => new sfValidatorBoolean(array('required' => false)),
      'newsletter'                     => new sfValidatorBoolean(array('required' => false)),
      'forum_id'                       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'last_login'                     => new sfValidatorDateTime(array('required' => false)),
      'language'                       => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'preferred_language'             => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'ip_address'                     => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'has_desktop_app_been_loaded'    => new sfValidatorBoolean(array('required' => false)),
      'has_requested_free_trial'       => new sfValidatorBoolean(array('required' => false)),
      'avatar_random_suffix'           => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'reminders_active'               => new sfValidatorBoolean(array('required' => false)),
      'latest_blog_access'             => new sfValidatorDateTime(array('required' => false)),
      'latest_backup_request'          => new sfValidatorDateTime(array('required' => false)),
      'latest_import_request'          => new sfValidatorDateTime(array('required' => false)),
      'latest_breaking_news_closed'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'last_promotional_code_inserted' => new sfValidatorString(array('max_length' => 25)),
      'blocked'                        => new sfValidatorBoolean(array('required' => false)),
      'session_entry_point'            => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'session_referral'               => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'created_at'                     => new sfValidatorDateTime(array('required' => false)),
      'pc_users_lists_list'            => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcList', 'required' => false)),
      'pc_dirty_task_list'             => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcTask', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcUser', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('pc_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcUser';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_users_lists_list']))
    {
      $values = array();
      foreach ($this->object->getPcUsersListss() as $obj)
      {
        $values[] = $obj->getListId();
      }

      $this->setDefault('pc_users_lists_list', $values);
    }

    if (isset($this->widgetSchema['pc_dirty_task_list']))
    {
      $values = array();
      foreach ($this->object->getPcDirtyTasks() as $obj)
      {
        $values[] = $obj->getTaskId();
      }

      $this->setDefault('pc_dirty_task_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePcUsersListsList($con);
    $this->savePcDirtyTaskList($con);
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
    $c->add(PcUsersListsPeer::USER_ID, $this->object->getPrimaryKey());
    PcUsersListsPeer::doDelete($c, $con);

    $values = $this->getValue('pc_users_lists_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcUsersLists();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setListId($value);
        $obj->save();
      }
    }
  }

  public function savePcDirtyTaskList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['pc_dirty_task_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PcDirtyTaskPeer::USER_ID, $this->object->getPrimaryKey());
    PcDirtyTaskPeer::doDelete($c, $con);

    $values = $this->getValue('pc_dirty_task_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcDirtyTask();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setTaskId($value);
        $obj->save();
      }
    }
  }

}
