<?php

/**
 * PcBlogCategoriesPosts filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcBlogCategoriesPostsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('pc_blog_categories_posts_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBlogCategoriesPosts';
  }

  public function getFields()
  {
    return array(
      'post_id'     => 'ForeignKey',
      'category_id' => 'ForeignKey',
    );
  }
}
