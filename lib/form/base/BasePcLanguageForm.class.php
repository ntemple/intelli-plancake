<?php

/**
 * PcLanguage form base class.
 *
 * @method PcLanguage getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcLanguageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'sort_order'          => new sfWidgetFormInputText(),
      'pc_translation_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcString')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 32)),
      'sort_order'          => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'pc_translation_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcString', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'PcLanguage', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('pc_language[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcLanguage';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_translation_list']))
    {
      $values = array();
      foreach ($this->object->getPcTranslations() as $obj)
      {
        $values[] = $obj->getStringId();
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
    $c->add(PcTranslationPeer::LANGUAGE_ID, $this->object->getPrimaryKey());
    PcTranslationPeer::doDelete($c, $con);

    $values = $this->getValue('pc_translation_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcTranslation();
        $obj->setLanguageId($this->object->getPrimaryKey());
        $obj->setStringId($value);
        $obj->save();
      }
    }
  }

}
