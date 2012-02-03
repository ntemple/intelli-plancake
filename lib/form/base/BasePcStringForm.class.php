<?php

/**
 * PcString form base class.
 *
 * @method PcString getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcStringForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'category_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcStringCategory', 'add_empty' => false)),
      'sort_order_in_category' => new sfWidgetFormInputText(),
      'max_length'             => new sfWidgetFormInputText(),
      'note'                   => new sfWidgetFormInputText(),
      'is_archived'            => new sfWidgetFormInputCheckbox(),
      'created_at'             => new sfWidgetFormDateTime(),
      'pc_translation_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcLanguage')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'category_id'            => new sfValidatorPropelChoice(array('model' => 'PcStringCategory', 'column' => 'id')),
      'sort_order_in_category' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'max_length'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'note'                   => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'is_archived'            => new sfValidatorBoolean(),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'pc_translation_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcLanguage', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_string[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcString';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_translation_list']))
    {
      $values = array();
      foreach ($this->object->getPcTranslations() as $obj)
      {
        $values[] = $obj->getLanguageId();
      }

      $this->setDefault('pc_translation_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePcTranslationList($con);
  }

  public function savePcTranslationList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['pc_translation_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PcTranslationPeer::STRING_ID, $this->object->getPrimaryKey());
    PcTranslationPeer::doDelete($c, $con);

    $values = $this->getValue('pc_translation_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcTranslation();
        $obj->setStringId($this->object->getPrimaryKey());
        $obj->setLanguageId($value);
        $obj->save();
      }
    }
  }

}
