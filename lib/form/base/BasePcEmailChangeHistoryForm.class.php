<?php

/**
 * PcEmailChangeHistory form base class.
 *
 * @method PcEmailChangeHistory getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcEmailChangeHistoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormInputHidden(),
      'old_email'  => new sfWidgetFormInputText(),
      'new_email'  => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'old_email'  => new sfValidatorString(array('max_length' => 80)),
      'new_email'  => new sfValidatorString(array('max_length' => 80)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_email_change_history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcEmailChangeHistory';
  }


}
