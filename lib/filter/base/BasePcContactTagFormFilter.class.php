<?php

/**
 * PcContactTag filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcContactTagFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'creator_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pc_contacts_tags_list' => new sfWidgetFormPropelChoice(array('model' => 'PcContact', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                  => new sfValidatorPass(array('required' => false)),
      'creator_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_contacts_tags_list' => new sfValidatorPropelChoice(array('model' => 'PcContact', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_contact_tag_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPcContactsTagsListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PcContactsTagsPeer::TAG_ID, PcContactTagPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcContactsTagsPeer::CONTACT_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcContactsTagsPeer::CONTACT_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcContactTag';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'name'                  => 'Text',
      'creator_id'            => 'ForeignKey',
      'updated_at'            => 'Date',
      'created_at'            => 'Date',
      'pc_contacts_tags_list' => 'ManyKey',
    );
  }
}
