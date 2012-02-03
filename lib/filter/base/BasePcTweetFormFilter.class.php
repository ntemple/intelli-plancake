<?php

/**
 * PcTweet filter form base class.
 *
 * @package    plancake
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePcTweetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'content'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'author'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'link'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'language'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'content'    => new sfValidatorPass(array('required' => false)),
      'author'     => new sfValidatorPass(array('required' => false)),
      'link'       => new sfValidatorPass(array('required' => false)),
      'language'   => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pc_tweet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcTweet';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'content'    => 'Text',
      'author'     => 'Text',
      'link'       => 'Text',
      'language'   => 'Text',
      'created_at' => 'Date',
    );
  }
}
