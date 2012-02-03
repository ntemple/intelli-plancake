<?php

/**
 * PcBlogComment form base class.
 *
 * @method PcBlogComment getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcBlogCommentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'post_id'    => new sfWidgetFormPropelChoice(array('model' => 'PcBlogPost', 'add_empty' => false)),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'content'    => new sfWidgetFormInputText(),
      'updated_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'post_id'    => new sfValidatorPropelChoice(array('model' => 'PcBlogPost', 'column' => 'id')),
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'content'    => new sfValidatorString(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_blog_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBlogComment';
  }


}
