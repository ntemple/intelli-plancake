<?php

/**
 * PcLanguage filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcLanguageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sort_order'          => new sfWidgetFormFilterInput(),
      'pc_translation_list' => new sfWidgetFormPropelChoice(array('model' => 'PcString', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                => new sfValidatorPass(array('required' => false)),
      'sort_order'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'pc_translation_list' => new sfValidatorPropelChoice(array('model' => 'PcString', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_language_filters[%s]');

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

    $criteria->addJoin(PcTranslationPeer::LANGUAGE_ID, PcLanguagePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcTranslationPeer::STRING_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcTranslationPeer::STRING_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcLanguage';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Text',
      'name'                => 'Text',
      'sort_order'          => 'Number',
      'pc_translation_list' => 'ManyKey',
    );
  }
}
