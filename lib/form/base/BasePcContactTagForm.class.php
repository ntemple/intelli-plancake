<?php

/**
 * PcContactTag form base class.
 *
 * @method PcContactTag getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcContactTagForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'name'                  => new sfWidgetFormInputText(),
      'creator_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_at'            => new sfWidgetFormDateTime(),
      'pc_contacts_tags_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcContact')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 255)),
      'creator_id'            => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'updated_at'            => new sfValidatorDateTime(),
      'created_at'            => new sfValidatorDateTime(),
      'pc_contacts_tags_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcContact', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_contact_tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContactTag';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_contacts_tags_list']))
    {
      $values = array();
      foreach ($this->object->getPcContactsTagss() as $obj)
      {
        $values[] = $obj->getContactId();
      }

      $this->setDefault('pc_contacts_tags_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePcContactsTagsList($con);
  }

  public function savePcContactsTagsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['pc_contacts_tags_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PcContactsTagsPeer::TAG_ID, $this->object->getPrimaryKey());
    PcContactsTagsPeer::doDelete($c, $con);

    $values = $this->getValue('pc_contacts_tags_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcContactsTags();
        $obj->setTagId($this->object->getPrimaryKey());
        $obj->setContactId($value);
        $obj->save();
      }
    }
  }

}
