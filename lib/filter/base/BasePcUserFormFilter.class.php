<?php

/**
 * PcUser filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'username'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'encrypted_password'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salt'                           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_format'                    => new sfWidgetFormFilterInput(),
      'time_format'                    => new sfWidgetFormFilterInput(),
      'timezone_id'                    => new sfWidgetFormPropelChoice(array('model' => 'PcTimezone', 'add_empty' => true)),
      'week_start'                     => new sfWidgetFormFilterInput(),
      'dst_active'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'awaiting_activation'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'newsletter'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'forum_id'                       => new sfWidgetFormFilterInput(),
      'last_login'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'language'                       => new sfWidgetFormFilterInput(),
      'preferred_language'             => new sfWidgetFormFilterInput(),
      'ip_address'                     => new sfWidgetFormFilterInput(),
      'has_desktop_app_been_loaded'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'has_requested_free_trial'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'avatar_random_suffix'           => new sfWidgetFormFilterInput(),
      'reminders_active'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'latest_blog_access'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'latest_backup_request'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'latest_import_request'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'latest_breaking_news_closed'    => new sfWidgetFormFilterInput(),
      'last_promotional_code_inserted' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'blocked'                        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'session_entry_point'            => new sfWidgetFormFilterInput(),
      'session_referral'               => new sfWidgetFormFilterInput(),
      'created_at'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'pc_dirty_task_list'             => new sfWidgetFormPropelChoice(array('model' => 'PcTask', 'add_empty' => true)),
      'pc_users_lists_list'            => new sfWidgetFormPropelChoice(array('model' => 'PcList', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'username'                       => new sfValidatorPass(array('required' => false)),
      'email'                          => new sfValidatorPass(array('required' => false)),
      'encrypted_password'             => new sfValidatorPass(array('required' => false)),
      'salt'                           => new sfValidatorPass(array('required' => false)),
      'date_format'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'time_format'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'timezone_id'                    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcTimezone', 'column' => 'id')),
      'week_start'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dst_active'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'awaiting_activation'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'newsletter'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'forum_id'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'last_login'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'language'                       => new sfValidatorPass(array('required' => false)),
      'preferred_language'             => new sfValidatorPass(array('required' => false)),
      'ip_address'                     => new sfValidatorPass(array('required' => false)),
      'has_desktop_app_been_loaded'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'has_requested_free_trial'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'avatar_random_suffix'           => new sfValidatorPass(array('required' => false)),
      'reminders_active'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'latest_blog_access'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'latest_backup_request'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'latest_import_request'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'latest_breaking_news_closed'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'last_promotional_code_inserted' => new sfValidatorPass(array('required' => false)),
      'blocked'                        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'session_entry_point'            => new sfValidatorPass(array('required' => false)),
      'session_referral'               => new sfValidatorPass(array('required' => false)),
      'created_at'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_dirty_task_list'             => new sfValidatorPropelChoice(array('model' => 'PcTask', 'required' => false)),
      'pc_users_lists_list'            => new sfValidatorPropelChoice(array('model' => 'PcList', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPcDirtyTaskListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PcDirtyTaskPeer::USER_ID, PcUserPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcDirtyTaskPeer::TASK_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcDirtyTaskPeer::TASK_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addPcUsersListsListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PcUsersListsPeer::USER_ID, PcUserPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcUsersListsPeer::LIST_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcUsersListsPeer::LIST_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcUser';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'username'                       => 'Text',
      'email'                          => 'Text',
      'encrypted_password'             => 'Text',
      'salt'                           => 'Text',
      'date_format'                    => 'Number',
      'time_format'                    => 'Number',
      'timezone_id'                    => 'ForeignKey',
      'week_start'                     => 'Number',
      'dst_active'                     => 'Boolean',
      'awaiting_activation'            => 'Boolean',
      'newsletter'                     => 'Boolean',
      'forum_id'                       => 'Number',
      'last_login'                     => 'Date',
      'language'                       => 'Text',
      'preferred_language'             => 'Text',
      'ip_address'                     => 'Text',
      'has_desktop_app_been_loaded'    => 'Boolean',
      'has_requested_free_trial'       => 'Boolean',
      'avatar_random_suffix'           => 'Text',
      'reminders_active'               => 'Boolean',
      'latest_blog_access'             => 'Date',
      'latest_backup_request'          => 'Date',
      'latest_import_request'          => 'Date',
      'latest_breaking_news_closed'    => 'Number',
      'last_promotional_code_inserted' => 'Text',
      'blocked'                        => 'Boolean',
      'session_entry_point'            => 'Text',
      'session_referral'               => 'Text',
      'created_at'                     => 'Date',
      'pc_dirty_task_list'             => 'ManyKey',
      'pc_users_lists_list'            => 'ManyKey',
    );
  }
}
