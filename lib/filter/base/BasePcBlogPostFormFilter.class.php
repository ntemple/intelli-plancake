<?php

/**
 * PcBlogPost filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcBlogPostFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'                       => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'title'                         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'                          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'content'                       => new sfWidgetFormFilterInput(),
      'italian_url'                   => new sfWidgetFormFilterInput(),
      'is_reviewed'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_published'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'published_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'pc_blog_categories_posts_list' => new sfWidgetFormPropelChoice(array('model' => 'PcBlogCategory', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'user_id'                       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'title'                         => new sfValidatorPass(array('required' => false)),
      'slug'                          => new sfValidatorPass(array('required' => false)),
      'content'                       => new sfValidatorPass(array('required' => false)),
      'italian_url'                   => new sfValidatorPass(array('required' => false)),
      'is_reviewed'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_published'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'published_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'pc_blog_categories_posts_list' => new sfValidatorPropelChoice(array('model' => 'PcBlogCategory', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_blog_post_filters[%s]');

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

    $criteria->addJoin(PcBlogCategoriesPostsPeer::POST_ID, PcBlogPostPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(PcBlogCategoriesPostsPeer::CATEGORY_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(PcBlogCategoriesPostsPeer::CATEGORY_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'PcBlogPost';
  }

  public function getFields()
  {
    return array(
      'id'                            => 'Number',
      'user_id'                       => 'ForeignKey',
      'title'                         => 'Text',
      'slug'                          => 'Text',
      'content'                       => 'Text',
      'italian_url'                   => 'Text',
      'is_reviewed'                   => 'Boolean',
      'is_published'                  => 'Boolean',
      'published_at'                  => 'Date',
      'created_at'                    => 'Date',
      'pc_blog_categories_posts_list' => 'ManyKey',
    );
  }
}
