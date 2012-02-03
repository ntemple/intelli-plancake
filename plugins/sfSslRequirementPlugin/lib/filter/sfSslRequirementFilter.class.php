<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfSslRequirementFilter.class.php 16720 2009-03-29 20:43:55Z Kris.Wallsmith $
 */
class sfSslRequirementFilter extends sfFilter
{
  public function execute ($filterChain)
  {
    // execute only once and only if not using an environment that is disabled for SSL
    if ($this->isFirstCall() && !sfConfig::get('app_disable_sslfilter'))
    {
      // get the cool stuff
      $context = $this->getContext();
      $request = $context->getRequest();

      // only redirect HEAD and GET http(s) requests
      if (in_array($request->getMethod(), array(sfRequest::HEAD, sfRequest::GET)) && substr($request->getUri(), 0, 4) == 'http')
      {
        $controller = $context->getController();

        // get the current action instance
        $actionEntry    = $controller->getActionStack()->getLastEntry();
        $actionInstance = $actionEntry->getActionInstance();

        // request is SSL secured
        if ($request->isSecure())
        {
          // but SSL is not allowed
          if (!$actionInstance->sslAllowed() && $this->redirectToHttp() && !$this->isRedirectLoop())
          {
            $controller->redirect($actionInstance->getNonSslUrl());
            exit();
          }
        }
        // request is not SSL secured, but SSL is required
        elseif ($actionInstance->sslRequired() && $this->redirectToHttps() && !$this->isRedirectLoop())
        {
          $controller->redirect($actionInstance->getSslUrl());
          exit();
        }
      }
    }

    $filterChain->execute();
  }

  protected function redirectToHttps()
  {
    return true;
  }

  protected function redirectToHttp()
  {
    return true;
  }
  
  protected function isRedirectLoop()
  {
    $isLoop = false;
    
    $context = sfContext::getInstance();
    $user = $context->getUser();    
    
    $t = $user->getAttribute('pc_timestamp_for_secure_redirection_hack');
    if ($t && 
           ((time()-$t) < 4) ) {
        $isLoop = true;
    }
    
    $user->setAttribute('pc_timestamp_for_secure_redirection_hack', time());
    
    return $isLoop;
  }
}
