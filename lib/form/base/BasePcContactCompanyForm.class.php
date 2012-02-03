<?php

/**
 * PcContactCompany form base class.
 *
 * @method PcContactCompany getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcContactCompanyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'email'      => new sfWidgetFormInputText(),
      'website'    => new sfWidgetFormInputText(),
      'address'    => new sfWidgetFormInputText(),
      'note'       => new sfWidgetFormInputText(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'note'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'updated_at' => new sfValidatorDateTime(),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_contact_company[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContactCompany';
  }


}
