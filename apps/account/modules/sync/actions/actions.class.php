<?php

/**
 * sync actions.
 *
 * @package    plancake
 * @subpackage sync
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class syncActions extends PlancakeActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeGetServerTime(sfWebRequest $request)
  {
    include_once(sfConfig::get('sf_root_dir') . '/apps/api/lib/PlancakeApiServer.class.php');
    
    $serverTime = PlancakeApiServer::getServerTime(array('api_ver' => sfConfig::get('app_api_version')));
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderJson($serverTime);
    }       
  }
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeSync(sfWebRequest $request)
  {
    include_once(sfConfig::get('sf_root_dir') . '/apps/api/lib/PlancakeApiServer.class.php');
    
    parse_str(urldecode($request->getContent()), $requestParams);
    
    $tasks = (isset($requestParams['tasks']) && is_array($requestParams['tasks'])) ? 
                        $requestParams['tasks'] : array();
    
    $changes = PlancakeApiServer::sync(array(
        'from_ts' => $requestParams['from_ts'],
        'tasks' => $tasks,
        'camel_case_keys' => 1,
        'api_ver' => sfConfig::get('app_api_version')
    ));
    
    if ($request->isXmlHttpRequest())
    {
      return $this->renderJson($changes);
    }       
  }  
}
