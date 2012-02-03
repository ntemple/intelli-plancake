<?php

/**
 * PcBlogPost form base class.
 *
 * @method PcBlogPost getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcBlogPostForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'user_id'                       => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'title'                         => new sfWidgetFormInputText(),
      'slug'                          => new sfWidgetFormInputText(),
      'content'                       => new sfWidgetFormInputText(),
      'italian_url'                   => new sfWidgetFormInputText(),
      'is_reviewed'                   => new sfWidgetFormInputCheckbox(),
      'is_published'                  => new sfWidgetFormInputCheckbox(),
      'published_at'                  => new sfWidgetFormDateTime(),
      'created_at'                    => new sfWidgetFormDateTime(),
      'pc_blog_categories_posts_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcBlogCategory')),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'                       => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'title'                         => new sfValidatorString(array('max_length' => 255)),
      'slug'                          => new sfValidatorString(array('max_length' => 255)),
      'content'                       => new sfValidatorString(array('required' => false)),
      'italian_url'                   => new sfValidatorString(array('required' => false)),
      'is_reviewed'                   => new sfValidatorBoolean(array('required' => false)),
      'is_published'                  => new sfValidatorBoolean(array('required' => false)),
      'published_at'                  => new sfValidatorDateTime(array('required' => false)),
      'created_at'                    => new sfValidatorDateTime(array('required' => false)),
      'pc_blog_categories_posts_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcBlogCategory', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_blog_post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBlogPost';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_blog_categories_posts_list']))
    {
      $values = array();
      foreach ($this->object->getPcBlogCategoriesPostss() as $obj)
      {
        $values[] = $obj->getCategoryId();
      }

      $this->setDefault('pc_blog_categories_posts_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePcBlogCategoriesPostsList($con);
  }

  public function savePcBlogCategoriesPostsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['pc_blog_categories_posts_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(PcBlogCategoriesPostsPeer::POST_ID, $this->object->getPrimaryKey());
    PcBlogCategoriesPostsPeer::doDelete($c, $con);

    $values = $this->getValue('pc_blog_categories_posts_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcBlogCategoriesPosts();
        $obj->setPostId($this->object->getPrimaryKey());
        $obj->setCategoryId($value);
        $obj->save();
      }
    }
  }

}
