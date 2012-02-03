<?php

/**
 * PcContact form base class.
 *
 * @method PcContact getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcContactForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'name'                  => new sfWidgetFormInputText(),
      'description'           => new sfWidgetFormInputText(),
      'position'              => new sfWidgetFormInputText(),
      'email'                 => new sfWidgetFormInputText(),
      'phone'                 => new sfWidgetFormInputText(),
      'website'               => new sfWidgetFormInputText(),
      'link'                  => new sfWidgetFormInputText(),
      'twitter'               => new sfWidgetFormInputText(),
      'language'              => new sfWidgetFormInputText(),
      'company_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcContactCompany', 'add_empty' => true)),
      'creator_id'            => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_at'            => new sfWidgetFormDateTime(),
      'pc_contacts_tags_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcContactTag')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'           => new sfValidatorString(array('required' => false)),
      'position'              => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'email'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone'                 => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'website'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter'               => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'language'              => new sfValidatorString(array('max_length' => 2)),
      'company_id'            => new sfValidatorPropelChoice(array('model' => 'PcContactCompany', 'column' => 'id', 'required' => false)),
      'creator_id'            => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'updated_at'            => new sfValidatorDateTime(),
      'created_at'            => new sfValidatorDateTime(),
      'pc_contacts_tags_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcContactTag', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContact';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_contacts_tags_list']))
    {
      $values = array();
      foreach ($this->object->getPcContactsTagss() as $obj)
      {
        $values[] = $obj->getTagId();
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
    $c->add(PcContactsTagsPeer::CONTACT_ID, $this->object->getPrimaryKey());
    PcContactsTagsPeer::doDelete($c, $con);

    $values = $this->getValue('pc_contacts_tags_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcContactsTags();
        $obj->setContactId($this->object->getPrimaryKey());
        $obj->setTagId($value);
        $obj->save();
      }
    }
  }

}
