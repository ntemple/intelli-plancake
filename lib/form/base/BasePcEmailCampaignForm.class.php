<?php

/**
 * PcEmailCampaign form base class.
 *
 * @method PcEmailCampaign getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcEmailCampaignForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'comment'         => new sfWidgetFormInputText(),
      'email_subject'   => new sfWidgetFormInputText(),
      'email_body'      => new sfWidgetFormInputText(),
      'sql_query'       => new sfWidgetFormInputText(),
      'email_addresses' => new sfWidgetFormInputText(),
      'sent_count'      => new sfWidgetFormInputText(),
      'open_count'      => new sfWidgetFormInputText(),
      'email_count'     => new sfWidgetFormInputText(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'comment'         => new sfValidatorString(array('max_length' => 255)),
      'email_subject'   => new sfValidatorString(array('max_length' => 255)),
      'email_body'      => new sfValidatorString(),
      'sql_query'       => new sfValidatorString(),
      'email_addresses' => new sfValidatorString(),
      'sent_count'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'open_count'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'email_count'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'updated_at'      => new sfValidatorDateTime(),
      'created_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_email_campaign[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcEmailCampaign';
  }


}
