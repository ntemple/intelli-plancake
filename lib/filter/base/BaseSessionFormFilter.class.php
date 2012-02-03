<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Session filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseSessionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'data' => new sfWidgetFormFilterInput(),
      'time' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'data' => new sfValidatorPass(array('required' => false)),
      'time' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('session_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Text',
      'data' => 'Text',
      'time' => 'Number',
    );
  }
}
