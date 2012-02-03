<?php

/**
 * PcTestimonial form.
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
class PcTestimonialForm extends BasePcTestimonialForm
{
  public function configure()
  {
    parent::configure();
    
    $this->setWidget('comment', new sfWidgetFormTextarea());

    $this->setValidator('user_id', new sfValidatorInteger());
    $this->setDefault('user_id', PcUserPeer::getLoggedInUser()->getId());
    
    $this->widgetSchema->setLabels(array(
      'name'    =>  "Your full name *",
      'job_position'    => "Your profession or your position in the company *",
      'company'      => "The company you work for (if applicable)",
      'city'   => 'Your city *',
      'country'   => 'Your country *',
      'comment' => 'Your testimonial *',
      'photo_link' => 'Link to your picture, from your website, LinkedIn, Twitter, ... *'
    ));

    
    $this->widgetSchema->setNameFormat('testimonial[%s]');
    
    unset($this['created_at'], $this['updated_at']);
  }
}
