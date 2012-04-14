<?php

/**
 * PcSplitTest form base class.
 *
 * @method PcSplitTest getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcSplitTestForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'name'                           => new sfWidgetFormInputText(),
      'number_of_variants'             => new sfWidgetFormInputText(),
      'variants_description'           => new sfWidgetFormInputText(),
      'comment'                        => new sfWidgetFormInputText(),
      'created_at'                     => new sfWidgetFormDateTime(),
      'pc_split_test_user_result_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcUser')),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                           => new sfValidatorString(array('max_length' => 128)),
      'number_of_variants'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'variants_description'           => new sfValidatorString(),
      'comment'                        => new sfValidatorString(),
      'created_at'                     => new sfValidatorDateTime(),
      'pc_split_test_user_result_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_split_test[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcSplitTest';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_split_test_user_result_list']))
    {
      $values = array();
      foreach ($this->object->getPcSplitTestUserResults() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('pc_split_test_user_result_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePcSplitTestUserResultList($con);
  }

  public function savePcSplitTestUserResultList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['pc_split_test_user_result_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PcSplitTestUserResultPeer::TEST_ID, $this->object->getPrimaryKey());
    PcSplitTestUserResultPeer::doDelete($c, $con);

    $values = $this->getValue('pc_split_test_user_result_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcSplitTestUserResult();
        $obj->setTestId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
