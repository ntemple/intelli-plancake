<?php

/**
 * PcContactsTags filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcContactsTagsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'creator_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'creator_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_contacts_tags_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContactsTags';
  }

  public function getFields()
  {
    return array(
      'contact_id' => 'ForeignKey',
      'tag_id'     => 'ForeignKey',
      'creator_id' => 'ForeignKey',
      'created_at' => 'Date',
    );
  }
}
