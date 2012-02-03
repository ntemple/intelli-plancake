<?php

/**
 * PcContact filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcContactFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                  => new sfWidgetFormFilterInput(),
      'description'           => new sfWidgetFormFilterInput(),
      'position'              => new sfWidgetFormFilterInput(),
      'email'                 => new sfWidgetFormFilterInput(),
      'phone'                 => new sfWidgetFormFilterInput(),
      'website'               => new sfWidgetFormFilterInput(),
      'link'                  => new sfWidgetFormFilterInput(),
      'twitter'               => new sfWidgetFormFilterInput(),
      'language'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'company_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcContactCompany', 'add_empty' => true)),
      'creator_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'pc_contacts_tags_list' => new sfWidgetFormPropelChoice(array('model' => 'PcContactTag', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                  => new sfValidatorPass(array('required' => false)),
      'description'           => new sfValidatorPass(array('required' => false)),
      'position'              => new sfValidatorPass(array('required' => false)),
      'email'                 => new sfValidatorPass(array('required' => false)),
      'phone'                 => new sfValidatorPass(array('required' => false)),
      'website'               => new sfValidatorPass(array('required' => false)),
      'link'                  => new sfValidatorPass(array('required' => false)),
      'twitter'               => new sfValidatorPass(array('required' => false)),
      'language'              => new sfValidatorPass(array('required' => false)),
      'company_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcContactCompany', 'column' => 'id')),
      'creator_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_contacts_tags_list' => new sfValidatorPropelChoice(array('model' => 'PcContactTag', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_contact_filters[%s]');

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

    $criteria->addJoin(PcContactsTagsPeer::CONTACT_ID, PcContactPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcContactsTagsPeer::TAG_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcContactsTagsPeer::TAG_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcContact';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'name'                  => 'Text',
      'description'           => 'Text',
      'position'              => 'Text',
      'email'                 => 'Text',
      'phone'                 => 'Text',
      'website'               => 'Text',
      'link'                  => 'Text',
      'twitter'               => 'Text',
      'language'              => 'Text',
      'company_id'            => 'ForeignKey',
      'creator_id'            => 'ForeignKey',
      'updated_at'            => 'Date',
      'created_at'            => 'Date',
      'pc_contacts_tags_list' => 'ManyKey',
    );
  }
}
