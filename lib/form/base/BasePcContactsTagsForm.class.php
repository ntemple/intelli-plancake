<?php

/**
 * PcContactsTags form base class.
 *
 * @method PcContactsTags getObject() Returns the current form's model object
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePcContactsTagsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'contact_id' => new sfWidgetFormInputHidden(),
      'tag_id'     => new sfWidgetFormInputHidden(),
      'creator_id' => new sfWidgetFormPropelChoice(array('model' => 'PcUser', 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'contact_id' => new sfValidatorPropelChoice(array('model' => 'PcContact', 'column' => 'id', 'required' => false)),
      'tag_id'     => new sfValidatorPropelChoice(array('model' => 'PcContactTag', 'column' => 'id', 'required' => false)),
      'creator_id' => new sfValidatorPropelChoice(array('model' => 'PcUser', 'column' => 'id')),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pc_contacts_tags[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcContactsTags';
  }


}
