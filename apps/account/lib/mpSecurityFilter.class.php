<?php

class mpSecurityFilter extends sfBasicSecurityFilter
{
  /**
   * Forwards the current request to the login action.
   *
   * @throws sfStopException
   */
  protected function forwardToLoginAction()
  {
    $actionStack = $this->context->getActionStack();
    $action      = $actionStack->getFirstEntry()->getActionInstance();

    if($action->getRequest()->isXmlHttpRequest())
    {
      $action->getResponse()->setContent(''); // when the AJAX response is empty,
                                              // JS clientside forces logout
      $action->getResponse()->send();
    }
    else
    {
      $this->context->getController()->forward(sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
    }

    throw new sfStopException();
  }
}