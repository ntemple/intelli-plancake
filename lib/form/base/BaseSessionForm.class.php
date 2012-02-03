<?php

/**
 * Session form base class.
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSessionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'data' => new sfWidgetFormTextarea(),
      'time' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorPropelChoice(array('model' => 'Session', 'column' => 'id', 'required' => false)),
      'data' => new sfValidatorString(array('required' => false)),
      'time' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session';
  }


}
