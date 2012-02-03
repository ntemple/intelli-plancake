<?php

/**
 * PcPasswordResetToken filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcPasswordResetTokenFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'token'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'token'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_password_reset_token_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcPasswordResetToken';
  }

  public function getFields()
  {
    return array(
      'user_id' => 'ForeignKey',
      'token'   => 'Text',
    );
  }
}
