<?php

/**
 * PcList filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcListFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'creator_id'          => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'title'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order'          => new sfWidgetFormFilterInput(),
      'is_header'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_inbox'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_todo'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pc_users_lists_list' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'creator_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'title'               => new sfValidatorPass(array('required' => false)),
      'sort_order'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_header'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_inbox'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_todo'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_users_lists_list' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_list_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(PcUsersListsPeer::LIST_ID, PcListPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcUsersListsPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcUsersListsPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcList';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'creator_id'          => 'ForeignKey',
      'title'               => 'Text',
      'sort_order'          => 'Number',
      'is_header'           => 'Boolean',
      'is_inbox'            => 'Boolean',
      'is_todo'             => 'Boolean',
      'updated_at'          => 'Date',
      'created_at'          => 'Date',
      'pc_users_lists_list' => 'ManyKey',
    );
  }
}
