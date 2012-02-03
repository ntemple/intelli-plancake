<?php

/**
 * PcBlogCategory form base class.
 *
 * @method PcBlogCategory getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcBlogCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'name'                          => new sfWidgetFormInputText(),
      'slug'                          => new sfWidgetFormInputText(),
      'pc_blog_categories_posts_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'PcBlogPost')),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                          => new sfValidatorString(array('max_length' => 64)),
      'slug'                          => new sfValidatorString(array('max_length' => 255)),
      'pc_blog_categories_posts_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'PcBlogPost', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_blog_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBlogCategory';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['pc_blog_categories_posts_list']))
    {
      $values = array();
      foreach ($this->object->getPcBlogCategoriesPostss() as $obj)
      {
        $values[] = $obj->getPostId();
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
    $c->add(PcBlogCategoriesPostsPeer::CATEGORY_ID, $this->object->getPrimaryKey());
    PcBlogCategoriesPostsPeer::doDelete($c, $con);

    $values = $this->getValue('pc_blog_categories_posts_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new PcBlogCategoriesPosts();
        $obj->setCategoryId($this->object->getPrimaryKey());
        $obj->setPostId($value);
        $obj->save();
      }
    }
  }

}
