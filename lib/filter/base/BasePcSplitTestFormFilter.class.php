<?php

/**
 * PcSplitTest filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcSplitTestFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'number_of_variants'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'variants_description'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pc_split_test_user_result_list' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                           => new sfValidatorPass(array('required' => false)),
      'number_of_variants'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'variants_description'           => new sfValidatorPass(array('required' => false)),
      'comment'                        => new sfValidatorPass(array('required' => false)),
      'created_at'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_split_test_user_result_list' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_split_test_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPcSplitTestUserResultListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PcSplitTestUserResultPeer::TEST_ID, PcSplitTestPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcSplitTestUserResultPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcSplitTestUserResultPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcSplitTest';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'name'                           => 'Text',
      'number_of_variants'             => 'Number',
      'variants_description'           => 'Text',
      'comment'                        => 'Text',
      'created_at'                     => 'Date',
      'pc_split_test_user_result_list' => 'ManyKey',
    );
  }
}
