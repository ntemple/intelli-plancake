<?php

/**
 * PcString filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcStringFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcStringCategory', 'add_empty' => true)),
      'sort_order_in_category' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_length'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'note'                   => new sfWidgetFormFilterInput(),
      'is_archived'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'pc_translation_list'    => new sfWidgetFormPropelChoice(array('model' => 'PcLanguage', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'category_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcStringCategory', 'column' => 'id')),
      'sort_order_in_category' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_length'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'note'                   => new sfValidatorPass(array('required' => false)),
      'is_archived'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_translation_list'    => new sfValidatorPropelChoice(array('model' => 'PcLanguage', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_string_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPcTranslationListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PcTranslationPeer::STRING_ID, PcStringPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcTranslationPeer::LANGUAGE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcTranslationPeer::LANGUAGE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcString';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Text',
      'category_id'            => 'ForeignKey',
      'sort_order_in_category' => 'Number',
      'max_length'             => 'Number',
      'note'                   => 'Text',
      'is_archived'            => 'Boolean',
      'created_at'             => 'Date',
      'pc_translation_list'    => 'ManyKey',
    );
  }
}
