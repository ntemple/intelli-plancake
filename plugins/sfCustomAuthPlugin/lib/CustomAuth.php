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

class CustomAuth
{
  /**
   * Logins the user (performing the brute force attack check)
   * 
   * @param myUser $userSf
   * @param PcUser $userApp - the user trying to login
   * @param boolean $rememberme - whether the user wanted to remember the login
   * @param boolean $remembermeCookieAlreadySet - in this case, if even
   *    $rememberme is true, the cookie is not set because it is already available
   * @return boolean - false if the account is blocked because of a brute
   *         force attack detection
   */
  public static function login(myUser $userSf, PcUser $userApp, $rememberme=false, $remembermeCookieAlreadySet=false)
  {
    // Check whether the account must be block because of a
    // brute force attack detection
    $c = new Criteria;
    $c->addJoin(PcUserPeer::ID, PcFailedLoginsPeer::USER_ID, Criteria::INNER_JOIN);
    $c->add(PcUserPeer::ID, $userApp->getId(), Criteria::EQUAL);
    $row = PcFailedLoginsPeer::doSelectOne($c);
    if ($row) // something went wrong
    {
      $maxAttempts = sfConfig::get('app_bruteForceLockout_loginAttemptThreshold');
      $currentAttempts = $row->getTimes();

      $timeout = sfConfig::get('app_bruteForceLockout_lockoutDuration');
      $secondsElapsedFromLastAttempt = time() - strtotime($row->getUpdatedAt());

      if ($secondsElapsedFromLastAttempt > $timeout) // timeout expired
      {
	// reset the 'failed logins' situation for the user
	$row->delete();
      }
      else
      {
	if($currentAttempts >= $maxAttempts)
	{
	  PcWatchdog::alert('Brute force attack attempt', 'For the userid '. $row->getUserId());
	  return false;
	}
      }
    }

    $userApp->setLanguage(PcUtils::getVisitorAcceptLanguage());
    $userApp->setIpAddress(PcUtils::getVisitorIPAddress());
    $userApp->save();

    $userSf->setAuthenticated(true);
    $userSf->setAttribute('userid', $userApp->getId());

    if ($userApp->isAdmin())
    {
        $userSf->addCredential('admin');
    }

    if ($userApp->isStaffMember())
    {
        $userSf->addCredential('staffMember');
    }

    if ($userApp->isContractor())
    {
        $userSf->addCredential('contractor');
    }
    
    if ($userApp->isEditor())
    {
        $userSf->addCredential('editor');
    }    
    
    if ($userApp->isTranslator())
    {
        $userSf->addCredential('translator');
    }

    if ($rememberme && !$remembermeCookieAlreadySet)
    {
      self::setRememberMeCookie($userSf, $userApp);	    
    }
    else if (!$rememberme)
    {
      // the user may login a second time (while still logged in because of forum integration problems), without 
      // ticking the rememberme checkbox
      self::resetRememberMeCookie();	    
    }
    else
    {
        // if $rememberme and $remembermeCookieAlreadySet
        // are both true we don't need to do anything
    }
    sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('CustomAuthLogin', 'custom_auth.login', array(
      'user' => $userApp,
      'rememberme' => $rememberme
    )));
    return true;
  }

  /**
   * Logouts the user
   * 
   * @param      myUser $userSf
   */
  public static function logout(myUser $userSf)
  {
    $user = PcUserPeer::retrieveByPk($userSf->getAttribute('userid'));
    $userSf->setAuthenticated(false);
    $userSf->setAttribute('userid', 0);
    $userSf->clearCredentials();

    // {{{ this should not be necessary...but just in case
    unset($_SESSION["symfony/user/sfUser/credentials"]);
    unset($_SESSION["symfony/user/sfUser/authenticated"]);
    // }}}

    self::resetRememberMeCookie();
    sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('customAuthLogout', 'custom_auth.logout', array(
      'user' => $user
    )));
  }

  /**
   * In the case of wrong authentication, check whether
   * a brute force attack is ongoing 
   * 
   * @param string $email - the email address of the user who
   *        tried to login and failed
   */
  public static function checkAgainstBruteForceAttack($email)
  {
    $c = new Criteria;
    $c->add(PcUserPeer::EMAIL, $email, Criteria::EQUAL);
    $userToCheck = PcUserPeer::doSelectOne($c);

    $c = new Criteria;
    $c->addJoin(PcUserPeer::ID, PcFailedLoginsPeer::USER_ID);
    $c->add(PcUserPeer::ID, $userToCheck->getId(), Criteria::EQUAL);
    $row = PcFailedLoginsPeer::doSelectOne($c);
    if ($row) // there is a row for the user
    {
      $maxAttempts = sfConfig::get('app_bruteForceLockout_loginAttemptThreshold');
      $currentAttempts = $row->getTimes();

      $timeout = sfConfig::get('app_bruteForceLockout_lockoutDuration');
      $secondsElapsedFromLastAttempt = time() - strtotime($row->getUpdatedAt());

      if ($secondsElapsedFromLastAttempt > $timeout) // timeout expired
      {
	// reset the 'failed logins' situation for the user
	$row->delete();
      }
      else
      {
	if($currentAttempts >= $maxAttempts)
	{
	  return true;
	}
	else
	{
	  $row->setTimes($row->getTimes() + 1);
	  $row->save();
	}
      }

    }
    else // there is not a row yet for the user
    {
      // insert a new row for the user
      $failedLogins = new PcFailedLogins();
      $failedLogins->setUser($userToCheck);
      $failedLogins->setTimes(1);
      $failedLogins->save();
    }
    return false;
  }

  /**
   * Sets the 'remember me' cookie and stores the hash in the db.
   *
   * @param myUser $userSf
   * @param PcUser $userApp - the user trying to login
   */
  private static function setRememberMeCookie(myUser $userSf, PcUser $userApp)
  {
    $secret = sfConfig::get('app_rememberMe_secret');
    $timeout = sfConfig::get('app_rememberMe_timeout');
    $cookieName = sfConfig::get('app_rememberMe_cookieName');
    $userId = $userSf->getAttribute('userid');
    if (! is_int($userId))
    {
      throw new sfException('Couldn\'t set the rememberme cookie properly - userId invalid.');
    }
    $now = time();

    $cookieValue = md5($userApp->getId() . $secret . $now);
    
    $rememberMeEntry = new PcRemembermeKey();
    $rememberMeEntry->setUserId($userApp->getId())
                    ->setRemembermeKey($cookieValue)
                    ->save();
    
    $sfContext = sfContext::getInstance();
    $sfContext->getResponse()->setCookie($cookieName, $cookieValue, $now+$timeout);
  }

  /**
   * Resets the 'remember me' cookie.
   *
   * @param myUser $userSf
   */
  private static function resetRememberMeCookie()
  {
    $cookieName = sfConfig::get('app_rememberMe_cookieName');
    $cookieValue = '';

    $sfContext = sfContext::getInstance();
    $sfContext->getResponse()->setCookie($cookieName, $cookieValue, time());
  }

  /**
   * Checks whether the user has got a valid 'remember me' session.
   *
   * @return boolean|integer the userid if the 'remember me' session is existing and
   *         valid, false otherwise
   */
  public static function isRememberMeCookieValid()
  {
    $cookieName = sfConfig::get('app_rememberMe_cookieName');
    $sfContext = sfContext::getInstance();

    $cookieContent = $sfContext->getRequest()->getCookie($cookieName);
    if ($cookieContent) // the cookie is set
    {
      $c = new Criteria();	
      $c->add(PcRemembermeKeyPeer::REMEMBERME_KEY, $cookieContent, Criteria::EQUAL);
      $rememberMeEntry = PcRemembermeKeyPeer::doSelectOne($c);

      if ( is_object($rememberMeEntry) )
      {
        return (int)$rememberMeEntry->getUserId();
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }

 /**
  * Sends an email to reset the password.
  * At this point we should be already sure the email address is valid
  *
  * @param string $email - the email address
  */
  public static function sendPasswordForgotten($email)
  {
    $requestingUser = PcUserPeer::getUserByEmail($email);

    if (!is_object($requestingUser))
    {
      throw new Exception('Couldn\'t send the password forgotten email. Problems while creating the user object.');
    }

    // I need to use a token
    $token = '';
    $c = new Criteria();
    $c->add(PcPasswordResetTokenPeer::USER_ID, $requestingUser->getId(), Criteria::EQUAL);
    $tokenEntry = PcPasswordResetTokenPeer::doSelectOne($c);
    if (is_object($tokenEntry)) // there is already a token for this user
    {
      $token = $tokenEntry->getToken();
    }
    else // creating a new token
    {
      $secret = sfConfig::get('app_forgottenPassword_secret');
      // token doesn't need to be 32-char long. It is better to keep it short
      // so there will be less chance the email client will break the link into 2 lines
      $token = substr(md5($requestingUser->getId() . $secret . time()), 0, 14);
      $tokenEntry = new PcPasswordResetToken();
      $tokenEntry->setUserId($requestingUser->getId());
      $tokenEntry->setToken($token);
      $tokenEntry->save();
    }

    // now we can send the email

    $link = sfContext::getInstance()->getController()->genUrl('@password-reset?t=' . $token, true);
    $from = sfConfig::get('app_emailAddress_contact');
    $subject = __('WEBSITE_FORGOTTEN_PSW_EMAIL_SUBJECT');
    $body = sprintf(__('WEBSITE_FORGOTTEN_PSW_EMAIL_BODY'), $link);
    PcUtils::sendEmail($email, $subject, $body, $from);
  }

 /**
  * Takes care after the user resets their password succcessfully
  *
  * @param string $token
  * @param string $password - the new password to set (plain password)
  * @return PcUser - the user who has reset their own password
  */
  public static function resetPassword($token, $password)
  {
    $c = new Criteria();
    $c->add(PcPasswordResetTokenPeer::TOKEN, $token, Criteria::EQUAL);
    $tokenEntry = PcPasswordResetTokenPeer::doSelectOne($c);

    $userId = $tokenEntry->getUserId();
    $tokenEntry->delete();
    $sfContext = sfContext::getInstance();
    $user = PcUserPeer::retrieveByPk($userId);
    $user->setPassword($password);
    $user->save();
    self::login($sfContext->getUser(), $user);
    sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetPassword', 'user.set_password', array(
      'user' => $user,
      'plainPassword' => $password
    )));
    return $user;
  }
}
