<?php

/**
 * submitTestimonial actions.
 *
 * @package    plancake
 * @subpackage submitTestimonial
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class submitTestimonialActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new PcTestimonialForm();
    
    $this->showFeedback = false;
    
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('testimonial'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('testimonial');
        $this->showFeedback = true;
        PcUtils::sendNotificationToAdmin("New testimonial");
        $this->form->save();
      }
    }
    
  }
}
