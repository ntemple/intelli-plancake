<?php

/**
 * PcSupporter form base class.
 *
 * @method PcSupporter getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcSupporterForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'              => new sfWidgetFormInputHidden(),
      'expiry_date'          => new sfWidgetFormDate(),
      'is_renewal_automatic' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'user_id'              => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id', 'required' => false)),
      'expiry_date'          => new sfValidatorDate(array('required' => false)),
      'is_renewal_automatic' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_supporter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSupporter';
  }


}
