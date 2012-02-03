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
 * Acts as a bridge from Plancake to the PunBB forum
 * Reacts to 4 events: new user registration, login, logout, resetPassword
 *
 */
class ForumBridge
{
  /**
   * It is bound to the registration.new_sign_up event
   *
   * @param sfEvent $event
   */
  public static function registrationEventCallback(sfEvent $event)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $username = ''; // in the Plancake registration, the user is not asked for a username
    $now = time();
    $ip = $_SERVER['REMOTE_ADDR'];
    $user = $event['user'];

    $encryptedPassword = $user->getEncryptedPassword();
    $salt = $user->getSalt();
    $email = $user->getEmail();

    // Creating a new record in the Forum User table
    $query = "INSERT INTO `".$forumTablesPrefix."users` (`group_id`, `username`, `password`, `salt`, `email`, `title`, `realname`, `url`, `jabber`, `icq`, `msn`, `aim`, `yahoo`, `location`, `signature`, `disp_topics`, `disp_posts`, `email_setting`, `notify_with_post`, `auto_notify`, `show_smilies`, `show_img`, `show_img_sig`, `show_avatars`, `show_sig`, `access_keys`, `timezone`, `dst`, `time_format`, `date_format`, `language`, `style`, `num_posts`, `last_post`, `last_search`, `last_email_sent`, `registered`, `registration_ip`, `last_visit`, `admin_note`, `activate_string`, `activate_key`) VALUES
    (3, :username, :encryptedPassword, :salt, :email, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 'English', 'Oxygen', 2, 1252691164, NULL, NULL, :now, :ip, :now, NULL, NULL, NULL)";
    $statement = $connection->prepare($query);
    $statement->execute(array(':username' => $username, 
			      ':encryptedPassword' => $encryptedPassword,
			      ':salt' => $salt,
			      ':email' => $email,
			      ':now' => $now,
			      ':ip' => $ip));
  
    // Linking the 2 user tables (Plancake and forum)
    $query = "SELECT LAST_INSERT_ID() as forum_id";
    $statement = $connection->prepare($query);
    $statement->execute();
    $resultset= $statement->fetch();
    $forum_id = (int)$resultset['forum_id'];
    $user->setForumId($forum_id);
    $user->save();

    self::setTimezone($user);
    self::setDst($user);
    self::setDateFormat($user);
  }

  /**
   * It is bound to the custom_auth.login event
   *
   * @param sfEvent $event
   */
  public static function loginEventCallback(sfEvent $event)
  {
    $user = $event['user'];
    $rememberme = $event['rememberme'];

    $forum_config['o_timeout_visit'] = sfConfig::get('app_forum_timeoutVisit');
    $cookie_name = sfConfig::get('app_forum_cookieName');
    $user_id = $user->getForumId();
    $form_password_hash = $user->getEncryptedPassword();
    $salt = $user->getSalt();

    // we log the user in always with rememberme to avoid the annoying forum 'visit timeout'.
    // There is a piece of code in common.php that checks whether the user is logged out on Plancake. If it is,
    // we log the user out from the forum as well.
    $expire = time() + 1209600; // rememberme timeout
    $forum_hash = sha1($salt.sha1($expire)); // this would be the work of the forum_hash function
    setcookie($cookie_name, base64_encode($user_id.'|'.$form_password_hash.'|'.$expire.'|'.sha1($salt.$form_password_hash.$forum_hash)), $expire, '/');
  }

  /**
   * It is bound to the custom_auth.logout event
   *
   * @param sfEvent $event
   */
  public static function logoutEventCallback(sfEvent $event)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $user = $event['user'];
    
    if ($user)
    {
        $userId = $user->getForumId();

        $query = sprintf("DELETE FROM ".$forumTablesPrefix."online WHERE user_id=%d", (int)$userId);
        $statement = $connection->prepare($query);
        $statement->execute();
        $query = sprintf("UPDATE ".$forumTablesPrefix."users SET last_visit=%d WHERE id=%d", time(), (int)$userId);
        $statement = $connection->prepare($query);
        $statement->execute();
    }

    self::deleteSessionCookie();
    setcookie(sfConfig::get('app_forum_cookieName').'_track', '', time()-5);
  }

  public static function deleteSessionCookie()
  {
    setcookie(sfConfig::get('app_forum_cookieName'), '', time()-5);
  }

  /**
   * It is bound to the custom_auth.reset_password event
   *
   * @param sfEvent $event
   */
  public static function setPasswordEventCallback(sfEvent $event)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $user = $event['user'];
    $userId = $user->getForumId();
    $query = sprintf("UPDATE ".$forumTablesPrefix."users SET password=:encryptedPassword, salt=:salt WHERE id=%d", (int)$userId);
    $statement = $connection->prepare($query);
    $statement->execute(array('encryptedPassword' => $user->getEncryptedPassword(),
			      'salt' => $user->getSalt()));
  }

  /**
   * It is bound to the user.set_username event
   *
   * @param sfEvent $event
   */
  public static function setUsernameEventCallback(sfEvent $event)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $user = $event['user'];
    $userId = $user->getForumId();
    $query = sprintf("UPDATE ".$forumTablesPrefix."users SET username=:username WHERE id=%d", (int)$userId);
    $statement = $connection->prepare($query);
    $statement->execute(array('username' => $user->getUsername()));
  }

  /**
   * It is bound to the user.set_email event
   *
   * @param sfEvent $event
   */
  public static function setEmailEventCallback(sfEvent $event)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $user = $event['user'];
    $userId = $user->getForumId();
    $query = sprintf("UPDATE ".$forumTablesPrefix."users SET email=:email WHERE id=%d", (int)$userId);
    $statement = $connection->prepare($query);
    $statement->execute(array('email' => $user->getEmail()));
  }

  /**
   * It is bound to the user.set_timezone event
   *
   * @param sfEvent $event
   */
  public static function setTimezoneEventCallback(sfEvent $event)
  {
    self::setTimezone($event['user']);
  }

  /**
   * It is bound to the user.set_dst event
   *
   * @param sfEvent $event
   */
  public static function setDstEventCallback(sfEvent $event)
  {
    self::setDst($event['user']);
  }


  /**
   * It is bound to the user.set_date_format event
   *
   * @param sfEvent $event
   */
  public static function setDateFormatEventCallback(sfEvent $event)
  {
    self::setDateFormat($event['user']);
  }

  /**
   * Sets the timezone
   *
   * @param PcUser $user
   */
  private static function setTimezone(PcUser $user)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $userId = $user->getForumId();

    $timezone = PcTimezonePeer::retrieveByPk($user->getTimezoneId());
    $timezone = $timezone->getOffset() / 60; // in the forum the timezone is in hours, not in minutes

    $query = sprintf("UPDATE ".$forumTablesPrefix."users SET timezone=:timezone WHERE id=%d", (int)$userId);
    $statement = $connection->prepare($query);
    $statement->execute(array('timezone' => $timezone));
  }

  /**
   * Sets the DST
   *
   * @param PcUser $user
   */
  private static function setDst(PcUser $user)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $userId = $user->getForumId();
    $query = sprintf("UPDATE ".$forumTablesPrefix."users SET dst=:dst WHERE id=%d", (int)$userId);
    $statement = $connection->prepare($query);
    $statement->execute(array('dst' => $user->getDstActive()));
  }

  /**
   * Sets the date format
   *
   * @param PcUser $user
   */
  private static function setDateFormat(PcUser $user)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $userId = $user->getForumId();

    $query = sprintf("UPDATE ".$forumTablesPrefix."users SET date_format=%d WHERE id=%d", (int)$user->getDateFormat(true), (int)$userId);
    $statement = $connection->prepare($query);
    $statement->execute();
  }
}
