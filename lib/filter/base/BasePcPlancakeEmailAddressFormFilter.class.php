<?php

/**
 * PcPlancakeEmailAddress filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcPlancakeEmailAddressFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'email'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_plancake_email_address_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPlancakeEmailAddress';
  }

  public function getFields()
  {
    return array(
      'user_id' => 'ForeignKey',
      'email'   => 'Text',
    );
  }
}
