<?php

/**
 * PcBlogCategory filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcBlogCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pc_blog_categories_posts_list' => new sfWidgetFormPropelChoice(array('model' => 'PcBlogPost', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'                          => new sfValidatorPass(array('required' => false)),
      'slug'                          => new sfValidatorPass(array('required' => false)),
      'pc_blog_categories_posts_list' => new sfValidatorPropelChoice(array('model' => 'PcBlogPost', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_blog_category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPcBlogCategoriesPostsListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(PcBlogCategoriesPostsPeer::CATEGORY_ID, PcBlogCategoryPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcBlogCategoriesPostsPeer::POST_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcBlogCategoriesPostsPeer::POST_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcBlogCategory';
  }

  public function getFields()
  {
    return array(
      'id'                            => 'Number',
      'name'                          => 'Text',
      'slug'                          => 'Text',
      'pc_blog_categories_posts_list' => 'ManyKey',
    );
  }
}
