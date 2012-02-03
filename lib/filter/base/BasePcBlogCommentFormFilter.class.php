<?php

/**
 * PcBlogComment filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcBlogCommentFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'post_id'    => new sfWidgetFormPropelChoice(array('model' => 'PcBlogPost', 'add_empty' => true)),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => true)),
      'content'    => new sfWidgetFormFilterInput(),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'post_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcBlogPost', 'column' => 'id')),
      'user_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'PcUser', 'column' => 'id')),
      'content'    => new sfValidatorPass(array('required' => false)),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_blog_comment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcBlogComment';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'post_id'    => 'ForeignKey',
      'user_id'    => 'ForeignKey',
      'content'    => 'Text',
      'updated_at' => 'Date',
      'created_at' => 'Date',
    );
  }
}
