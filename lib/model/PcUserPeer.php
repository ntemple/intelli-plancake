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

class PcUserPeer extends BasePcUserPeer
{
  static $loggedInUser;

  /**
   * Returns the user who is logged in
   * N.B.: if there isn't actually any user logged in, it redirects to login page
   * so you must not use it just to check whether the user is logged in or not.
   *
   * @return PcUser
   */
  public static function getLoggedInUser()
  {
    if (is_object(self::$loggedInUser)) return self::$loggedInUser;

    $userid = sfContext::getInstance()->getUser()->getAttribute('userid');
    if (!$userid) // user is not logged in
    {
      header('Location: /login');
    }
    self::$loggedInUser = PcUserPeer::retrieveByPk($userid);

    return self::$loggedInUser;
  }

  /**
   * Sets the logged in user
   *
   * @param PcUser $u - set the logged in User, if it is null, it detects the logged in user itself
   * @return PcUser
   */
  public static function setLoggedInUser(PcUser $u = null)
  {
    if (! $u)
    {
      $u = self::getLoggedInUser();
    }

    self::$loggedInUser = $u;
    return $u;
  }

 /**
  * Checks whether a user with the email address $email already exists
  *
  * @param string $email - the email address to check against
  * @return boolean
  */
  public static function emailExist($email)
  {
    $c = new Criteria();
    $c->add(PcUserPeer::EMAIL, $email, Criteria::EQUAL);
    $userToCheck = PcUserPeer::doSelectOne($c);
    return is_object($userToCheck);
  }

 /**
  * Checks whether a username already exists
  *
  * @param string $username - the username to check against
  * @return boolean
  */
  public static function usernameExist($username)
  {
    $c = new Criteria();
    $c->add(PcUserPeer::USERNAME, $username, Criteria::EQUAL);
    $userToCheck = PcUserPeer::doSelectOne($c);
    return is_object($userToCheck);
  }

 /**
  * Register a new user
  *
  * @param string $email - the email address
  * @param string $password - the plain password (no encryption)
  * @param string $lang - if it is null or empty, the language will be detected from the header of the request
  * @param string $preferredLang - this should be a 2-char abbreviation of the lang the user wants,
  *         among the ones in the main app.yml config file
  * @param string $tzLabel - a timezone label as in the PcTimezone db table
  * @param integer $dstOn (1 or 0) - whether or not the dst for the user is on
  * @param boolen $joinNewsletter(=false) - whether the user decided to join our newsletter
  * @param boolen $sendActivationEmail(=true) - whether to send the activation email  
  * @return boolean|PcUser false is a user with that email already exists, the PcUser object otherwise
  */
  public static function registerNewUser($email, $password, $lang, $preferredLang,
          $tzLabel, $dstOn, $joinNewsletter=false, $sendActivationEmail=true)
  {
    if (self::emailExist($email)) {
      return false;
    }

    $newUser = new PcUser();
    $newUser->setEmail($email);
    $newUser->setPassword($password);
    $newUser->setAwaitingActivation(1);
    if ($joinNewsletter)
    {
      $newUser->setNewsletter(1);
    }
    $newUser->save();

    // Dealing with timezone
    $newUser->setDstActive($dstOn);
    $c = new Criteria();
    $c->add(PcTimezonePeer::LABEL, $tzLabel, Criteria::EQUAL);
    $timezone = PcTimezonePeer::doSelectOne($c);

    if (! is_object($timezone)) // this shouldn't happen, but sometimes does (probably because of JS disabled)
    {
        // set to a default one
        $timezone = PcTimezonePeer::retrieveByPK(21);
    }

    $newUser->setTimezoneId($timezone->getId());

    // Dealing with formats
    // _ time format: the countries with the majority of our users are using the
    //   12H format, thus we can leave the default
    // _ for the date format we check whether they are in USA
    // _ for the first day of the week, we check whether they are in USA
    $dateFormatId = 3;
    $weekStart = 1; // from Monday
    $tzOffset = $timezone->getOffset();
    if ( ($tzOffset <= -300) && ($tzOffset >= -450)) // in USA or Canada
    {
      $dateFormatId = 4;
      $weekStart = 0; // from Sunday
    }
    $newUser->setDateFormat($dateFormatId);
    $newUser->setWeekStart($weekStart);


    if ( ($lang != null) && ($lang !== '') )
    {
        $newUser->setLanguage($lang);
    }
    else
    {
        $newUser->setLanguage(PcUtils::getVisitorAcceptLanguage());
    }

    $availableLangs = PcLanguagePeer::getAvailableLanguageAbbreviations();
    if (in_array($preferredLang, $availableLangs))
    {
        $newUser->setPreferredLanguage($preferredLang);
    }
    else
    {
        $newUser->setPreferredLanguage(SfConfig::get('app_site_defaultLang'));
    }

    $newUser->setIpAddress(PcUtils::getVisitorIPAddress());
    
    if ($sessionEntryPoint = sfContext::getInstance()->getUser()->getAttribute('session_entry_point')) {
        $newUser->setSessionEntryPoint($sessionEntryPoint);    
    }
    
    if ($sessionReferral = sfContext::getInstance()->getUser()->getAttribute('session_referral')) {
        $newUser->setSessionReferral($sessionReferral);    
    }
    
    $newUser->save();

    // Creating system lists
    $inboxList = new PcList();
    $inboxList->setIsInbox(1)->setTitle(__('ACCOUNT_LISTS_INBOX'))->setCreator($newUser)->save();
    $todoList = new PcList();
    $todoList->setIsTodo(1)->setTitle(__('ACCOUNT_LISTS_TODO'))->setCreator($newUser)->save();

    // Creating default contexts
    $context = new PcUsersContexts();
    $context->setPcUser($newUser)->setContext(__('ACCOUNT_TAGS_DEFAULT_HOME'))->save();
    $context = new PcUsersContexts();
    $context->setPcUser($newUser)->setContext(__('ACCOUNT_TAGS_DEFAULT_ERRANDS'))->save();
    $context = new PcUsersContexts();
    $context->setPcUser($newUser)->setContext(__('ACCOUNT_TAGS_DEFAULT_COMPUTER'))->save();

    // Creating some tasks for the inbox
    $newUser->addToInbox(__('ACCOUNT_MISC_WELCOME_TASK'));

    // creating Plancake email address
    $newUser->generateAndStorePlancakeEmailAddress();

    // I need to use a token for the activation of their account
    $token = '';
    $c = new Criteria();
    $c->add(PcActivationTokenPeer::USER_ID, $newUser->getId(), Criteria::EQUAL);
    $tokenEntry = PcActivationTokenPeer::doSelectOne($c);
    if (is_object($tokenEntry)) // there is already a token for this user
    {
      $token = $tokenEntry->getToken();
    }
    else // creating a new token
    {
      $secret = sfConfig::get('app_registration_secret');
      // token doesn't need to be 32-char long. It is better to keep it short
      // so there will be less chance the email client will break the link into 2 lines
      $token = substr(md5($newUser->getId() . $secret . time()), 0, 14);
      $tokenEntry = new PcActivationToken();
      $tokenEntry->setUserId($newUser->getId());
      $tokenEntry->setToken($token);
      $tokenEntry->save();
    }

    // now we can send the email
    if ($sendActivationEmail)
    {
	    $link = sfContext::getInstance()->getController()->genUrl('@activation?t=' . $token, true);
	    $from = sfConfig::get('app_emailAddress_contact');
	    $subject = 'Plancake - ' . __('WEBSITE_REGISTRATION_EMAIL_SUBJECT');
	    $body = sprintf(__('WEBSITE_REGISTRATION_EMAIL_BODY'), $link);
	    PcUtils::sendEmail($email, $subject, $body, $from);
    }

    $newUser->refreshLatestBlogAccess();

    sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent($newUser, 'user.sign_up', array(
      'user' => $newUser,
      'plainPassword' => $password
    )));

    return $newUser;
  }

 /**
  * Checks whether the authentication by a user is correct and returns the
  * correct PcUser object in the case of correct authentication
  *
  * @param string $email - the email address
  * @param string $password - the plain password (no encryption)
  * @return boolean|PcUser, false if the details are not correct, the correct PcUser otherwise
  */
  public static function isCorrectAuthentication($email, $password)
  {
    // query to retrieve the salt, if the user exists
    $c = new Criteria();
    $c->add(PcUserPeer::EMAIL, $email, Criteria::EQUAL);
    $user = PcUserPeer::doSelectOne($c);

    if (!is_object($user)) {// the email address doesn't exist
      return false;
    }

    $salt = $user->getSalt();
    $c = new Criteria();
    $c->add(PcUserPeer::EMAIL, $email, Criteria::EQUAL);
    $c->add(PcUserPeer::ENCRYPTED_PASSWORD, PcUtils::createEncryptedPassword($password, $salt), Criteria::EQUAL);
    $user = PcUserPeer::doSelectOne($c);

    return is_object($user) ? $user : false;
  }

 /**
  * @param string $email - the email address
  * @return boolean|PcUser, false if the email address is not found, the corresponding PcUser otherwise
  */
  public static function getUserByEmail($email)
  {
    $c = new Criteria;
    $c->add(PcUserPeer::EMAIL, $email, Criteria::EQUAL);
    $user = PcUserPeer::doSelectOne($c);
    return is_object($user) ? $user : false;
  }

 /**
  * Activates a user.
  * N.B.: here we don't check the token is valid. That must be already done 
  * Returns the user that has been activated
  *
  * @param PcActivationToken $token - the email address
  * @return PcUser
  */
  public static function activateUser(PcActivationToken $token)
  {
    $user = self::retrieveByPk($token->getUserId());
    $user->setAwaitingActivation(0);
    $user->save();
    $token->delete();
    return $user;
  }

  /**
   *
   * @param string $emailAddress
   */
  public static function retrieveByEmailAddress($emailAddress)
  {
    return self::getUserByEmail($emailAddress);
  }
}
