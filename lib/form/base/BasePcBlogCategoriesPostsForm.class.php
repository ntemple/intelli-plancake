<?php

/**
 * PcBlogCategoriesPosts form base class.
 *
 * @method PcBlogCategoriesPosts getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcBlogCategoriesPostsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'post_id'     => new sfWidgetFormInputHidden(),
      'category_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'post_id'     => new sfValidatorPropelChoice(array('model' => 'PcBlogPost', 'column' => 'id', 'required' => false)),
      'category_id' => new sfValidatorPropelChoice(array('model' => 'PcBlogCategory', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_blog_categories_posts[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBlogCategoriesPosts';
  }


}
