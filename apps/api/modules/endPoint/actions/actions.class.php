<?php
/*************************************************************************************
* ===================================================================================*
* Software by: Danyuki Software Limited                                              *
* This file is part of Plancake.                                                     *
*                                                                                    *
* Copyright 2009-2010-2011-2012 by:     Danyuki Software Limited                          *
* Support, News, Updates at:  http://www.plancake.com                                *
* Licensed under the AGPL version 3 license.                                         *                                                       *
* Danyuki Software Limited is registered in England and Wales (Company No. 07554549) *
**************************************************************************************
* Plancake is distributed in the hope that it will be useful,                        *
* but WITHOUT ANY WARRANTY; without even the implied warranty of                     *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                      *
* GNU Affero General Public License for more details.                                *
*                                                                                    *
* You should have received a copy of the GNU Affero General Public License           *
* along with this program.  If not, see <http://www.gnu.org/licenses/>.              *
*                                                                                    *
**************************************************************************************/

/**
 * endPoint actions.
 *
 * @package    plancake
 * @subpackage endPoint
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class endPointActions extends sfActions
{

  /**
   * @var string 
   */
  private $methodName;

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    // for performance reasons, we insert this configuration inside the method itself
    $methods = array('getToken', 'getServerTime', 'getUserSettings',
                     'getLists', 'getDeletedLists',
                     'getTags', 'getDeletedTags',
                     'getRepetitions', 'getRepetitionOptions', // these two are alias
                     'getTasks', 'getDeletedTasks', 'completeTask', 'uncompleteTask', 'deleteTask',
                                 'addTask', 'editTask', 'setTaskNote',
                     'sync', 'whatHasChanged');

    // token, sig, api_ver are required for each method
    $extraRequiredParamsMap = array('getToken' => array('api_key'),
                'getServerTime' => array(),
                'getUserSettings' => array(),
                'getLists' => array(),
                'getDeletedLists' => array('from_ts', 'to_ts'),
                'getTags' => array(),
                'getDeletedTags' => array('from_ts', 'to_ts'),
                'getRepetitions' => array(),
                'getRepetitionOptions' => array(),
                'getTasks' => array(),
                'getDeletedTasks' => array('from_ts', 'to_ts'),
                'completeTask' => array('task_id'),
                'uncompleteTask' => array('task_id'),
                'addTask' => array('descr'),
                'editTask' => array('task_id'),
                'setTaskNote' => array('task_id', 'note'),
                'deleteTask' => array('task_id'),
                'sync' => array('local_changes'),        
                'whatHasChanged' => array('from_ts', 'to_ts'));

    $optionalParamsMap = array('getToken' => array('user_key', 'user_email', 'user_pwd', 'extra_info'),
                'getServerTime' => array(),
                'getUserSettings' => array(),
                'getLists' => array('from_ts', 'to_ts'),
                'getDeletedLists' => array(),
                'getTags' => array('from_ts', 'to_ts'),
                'getDeletedTags' => array(),
                'getRepetitions' => array('from_ts', 'to_ts'),
                'getRepetitionOptions' => array('from_ts', 'to_ts'),
                'getTasks' => array('from_ts', 'to_ts', 'task_id', 'list_id', 'tag_id', 'completed', 'only_with_due_date', 'only_without_due_date', 'only_due_today_or_tomorrow', 'only_starred', 'by_date', 'search_query'),
                'getDeletedTasks' => array(),
                'completeTask' => array('baseline_due_date'),
                'uncompleteTask' => array(),
                'addTask' => array('list_id', 'is_header', 'due_date', 'due_time', 'is_starred', 'repetition_id', 'repetition_param', 'repetition_ical_rrule', 'note', 'tag_ids'),
                'editTask' => array('list_id', 'descr', 'is_header', 'due_date', 'due_time', 'is_starred', 'repetition_id', 'repetition_param', 'repetition_ical_rrule', 'note', 'tag_ids'),
                'setTaskNote' => array(),
                'deleteTask' => array(),
                'sync' => array(),
                'whatHasChanged' => array());

    $methodName = $request->getParameter('method_name');
    $token = $request->getParameter('token');
    $sig = $request->getParameter('sig');
    $apiVersion = $request->getParameter('api_ver');

    if (!in_array($methodName, $methods))
    {
        return $this->returnError(PlancakeApiServer::INVALID_METHOD_ERROR);
    }
    $this->methodName = $methodName;

    if ($token === null)
    {
        return $this->returnError(PlancakeApiServer::MISSING_TOKEN_ERROR);
    }

    if (!$sig)
    {
        return $this->returnError(PlancakeApiServer::MISSING_SIGNATURE_ERROR);
    }

    if (!$apiVersion)
    {
        return $this->returnError(PlancakeApiServer::MISSING_API_VERSION);
    }

    $params = array();
    $params['token'] = $token;
    $params['sig'] = $sig;
    $params['api_ver'] = $apiVersion;

    $extraRequiredParams = $extraRequiredParamsMap[$methodName];

    foreach ($extraRequiredParams as $extraRequiredParam)
    {
        $paramValue = $request->getParameter($extraRequiredParam);

        if ($paramValue !== null)
        {
            $params[$extraRequiredParam] = $paramValue;
        }
        else
        {
            return $this->returnError(PlancakeApiServer::MISSING_PARAMETER_ERROR);
        }
    }

    if (! $this->isTokenValid($token))
    {
        return $this->returnError(PlancakeApiServer::INVALID_TOKEN_ERROR);
    }

    $apiKey = isset($params['api_key']) ? $params['api_key'] : null;

    $apiApp = $this->getApiApp($params['token'], $apiKey);

    if ($apiApp === null)
    {
        return $this->returnError(PlancakeApiServer::INVALID_API_KEY_OR_TOKEN_ERROR);
    }

    if ($apiApp->isLimited())
    {
        if ($apiApp->hasReachedLimits())
        {
            return $this->returnError(PlancakeApiServer::RATE_LIMIT_REACHED);
        }
    }

    $apiSecret = $apiApp->getApiSecret();

    // loading optional params
    $optionalParams = $optionalParamsMap[$methodName];
    foreach ($optionalParams as $optionalParam)
    {
        $paramValue = $request->getParameter($optionalParam);

        if ($paramValue !== null)
        {
            $params[$optionalParam] = $paramValue;
        }
    }

    // if from_ts is specified, also to_ts
    if( (isset($params['from_ts']) && !isset($params['to_ts'])) ||
        (isset($params['to_ts']) && !isset($params['from_ts'])) ||
        (isset($params['from_ts']) && isset($params['from_ts']) && !(((int)($params['from_ts']))>0) ) ||
        (isset($params['from_ts']) && isset($params['from_ts']) && !(((int)($params['to_ts']))>0) )  )
    {
        return $this->returnError(PlancakeApiServer::MISSING_FROMTS_OR_TOTS_PARAMETER_ERROR);
    }

    if (! (strlen($apiSecret) > 0) )
    {
        return $this->returnError(PlancakeApiServer::INVALID_API_KEY_ERROR);
    }

    if (! $this->isSignatureValid($params, $apiSecret))
    {
        return $this->returnError(PlancakeApiServer::INVALID_SIGNATURE_ERROR);
    }

    $user = null;

    if ( strlen($token) > 0 )
    {
        $userId = PcApiTokenPeer::retrieveByPK($token)->getUserId();
        $user = PcUserPeer::retrieveByPK($userId);
        PcUserPeer::setLoggedInUser($user);
        $user->refreshLastLogin()->save();
    }

    unset($params['token']);
    unset($params['sig']);

    $response = call_user_func(array('PlancakeApiServer', $methodName), $params);

    $jsonResponse = json_encode($response);

    $apiApp->recordStats(strlen($jsonResponse));

    if ($user && $user->hasGoogleCalendarIntegrationActive())
    {
        $gcalRecord = PcGoogleCalendarPeer::retrieveByUser($user);
        if ( $gcalRecord &&
             ((time() - $gcalRecord->getLatestSyncEndTimestamp()) > sfConfig::get('app_api_googleCalendarSyncMinInterval')) )
        {
            $gcal = new GoogleCalendarInterface($user);
            $gcal->init();
            $gcal->syncPlancake();
        }
    }
        
    if ($callback = $request->getParameter('callback')) // JSONP request
    {
        $this->getResponse()->setContentType('text/javascript'); 
        $response = $callback . '(' . $jsonResponse . ')';
    }
    else
    {
        $this->getResponse()->setContentType('application/json');
        $response = $jsonResponse;        
    }
    
    return $this->renderText($response);
  }

  /**
   *
   * @param int $errorCode
   */
  public function returnError($errorCode)
  {
    $this->getResponse()->setContentType('application/json');
    $jsonResponse = json_encode(array('error' => $errorCode));
    
    if ($callback = $this->getRequest()->getParameter('callback')) // JSONP request
    {
        $this->getResponse()->setContentType('text/javascript'); 
        $response = $callback . '(' . $jsonResponse . ')';
    }
    else
    {
        $this->getResponse()->setContentType('application/json');
        $response = $jsonResponse;        
    }
    
    return $this->renderText($response);
  }

  /**
   * If $apiKey is not null, it has the priority over getting the api secret
   * from the token
   *
   * @param string $token - must be a valid token
   * @param string $apiKey (=null)
   * @return null|PcApiApp - null is the API key does not exist
   */
  private function getApiApp($token, $apiKey=null)
  {
    if (null !== $apiKey)
    {
        $apiAppEntry = PcApiAppPeer::retrieveByApiKey($apiKey);
        if (null === $apiAppEntry)
        {
            return null;
        }
        return $apiAppEntry;
    }

    $c = new Criteria();
    $c->addJoin(PcApiAppPeer::ID, PcApiTokenPeer::API_APP_ID);
    $c->add(PcApiTokenPeer::TOKEN, $token);
    $apiAppEntry = PcApiAppPeer::doSelectOne($c);

    if (!is_object($apiAppEntry))
    {
        return null;
    }

    return $apiAppEntry;
  }

  /**
   *
   * @param array $params (including the signature with key 'sig')
   * @param string $apiSecret
   * @return boolean - whether the signature is valid or not
   */
  private function isSignatureValid(array $params, $apiSecret)
  {
    $methodName = $this->methodName;
    $signature = $params['sig'];

    if (!$signature)
    {
        return $this->returnError(PlancakeApiServer::UNKNOWN_ERROR);
    }

    unset($params['sig']);

    ksort($params);

    $str = $methodName;
    foreach($params as $k => $v)
    {
        $str .= $k . $v;
    }

    $str .= $apiSecret;

    return md5($str) == $signature;
  }

  /**
   *
   * @param string $token
   * @return boolean - whether the token is valid or not
   */
  private function isTokenValid($token)
  {
      if ($this->methodName == 'getToken')
      {
          return true;
      }

      $c = new Criteria();
      $c->add(PcApiTokenPeer::TOKEN, $token);
      $apiTokenEntry = PcApiTokenPeer::doSelectOne($c);

      if (!is_object($apiTokenEntry))
      {
          return false;
      }

      if ( ($apiTokenEntry->getExpiryTimestamp() < time()) || ($apiTokenEntry == null) || ($apiTokenEntry->getUserId() <= 0))
      {
          return false;
      }

      return true;
  }
}
