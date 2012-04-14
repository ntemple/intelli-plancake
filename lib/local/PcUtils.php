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
 * Aggregates everything that depends on the date format.
 * It is a Singleton.
 * It works with the logged in user and with their preferences
 *
 */
class PcUtils
{
  /**
   *
   * @return string
   */
  public static function getCurrentURL()
  {
      return "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
  }

  /**
   * Generates a random string using only alphanumeric characters
   *
   * @param integer $length - the length of the random string
   * @return string
   */
  public static function generateRandomString($length = 8)
  {
    $ret = '';
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $charsNumber = strlen($chars);

    for($i=0; $i < $length; ++$i) {
      $ret .= substr($chars, mt_rand(0, $charsNumber-1), 1);
    }
    return $ret;
  }

  /**
   * Creates an encrypted password from a plain password and salt
   *
   * @param string $password
   * @param string $salt
   * @return string
   */
  public static function createEncryptedPassword($password, $salt)
  {
    return sha1($salt . sha1($password));
  }

  /**
   * Sends email
   * Uses the settings app_mailServer_* in the app.yml 
   *
   * @param string $to
   * @param string $subject
   * @param string $body
   * @param string $from
   * @param string $replyTo
   * @param string $attachmentFilePath
   */
  public static function sendEmail($to, $subject, $body, $from, $replyTo = '', $attachmentFilePath = '', $html = false)
  {
    if (! defined('PLANCAKE_PUBLIC_RELEASE'))
    {
        require_once sfConfig::get('sf_lib_dir').'/vendor/swift/lib/swift_init.php';

        $transport = Swift_SmtpTransport::newInstance(sfConfig::get("app_mailServer_host"), sfConfig::get("app_mailServer_port"), sfConfig::get("app_mailServer_encryption"))
              ->setUsername(sfConfig::get("app_mailServer_username"))
              ->setPassword(sfConfig::get("app_mailServer_password"));
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance()
              //Give the message a subject
              ->setSubject($subject)
              //Set the From address with an associative array
              ->setFrom($from)
              //Set the To addresses with an associative array
              ->setTo($to)
              //Give it a body
              ->setBody($body);
        
        if ($html) {
            $message->setContentType("text/html");
        }

        if ($replyTo != '')
        {
            $message->setReplyTo($replyTo);
        }

        if ($attachmentFilePath != '')
        {
            $attachment = Swift_Attachment::fromPath($attachmentFilePath);
            $message->attach($attachment);
        }

        $result = $mailer->send($message);
    }
    else
    {
        mail($to, $subject, $body);
    }
  }
  
  /**
   * Sends email
   * Uses the settings app_mailServer_* in the app.yml 
   *
   * @param string $to
   * @param string $subject
   * @param string $body
   * @param string $from
   * @param string $replyTo
   * @param string $attachmentFilePath
   */
  public static function sendNotificationToAdmin($subject, $body = '')
  {
      $to = sfConfig::get('app_site_adminUserEmails');
      $from = sfConfig::get('app_site_adminUserEmails');
      
      self::sendEmail($to, $subject, $body, $from);
  }  

  /**
   * Useful to generate the mainUrl of the site (i.e. www.plancake.com) from
   * an external application (i.e. www.plancake.com/forums)
   *
   * It uses the $_SERVER['HTTP_HOST'] variable
   *
   * @return string (i.e. www.plancake.com)
   */
  public static function mainUrlFromOtherApplication()
  {
    $thirdServerHttpHost = $_SERVER['HTTP_HOST']; // i.e.: forums.plancake.com
    // replacing forums.plancake.com with www.plancake.com
    $pattern = '/[^.]*\.([^\/]*)/'; 
    $replacement = 'www.$1';
    return preg_replace($pattern, $replacement, $thirdServerHttpHost);
  }

  /**
   * Checks the logged in user is the user $userToCheckAgainst (the legitimate user)
   *
   * @param PcUser $userToCheckAgainst
   * @return boolean
   */
  public static function checkLoggedInUserPermission(PcUser $userToCheckAgainst)
  {
    // we actually compare the ids to have a robust behaviour, safe from changes in PHP
    if (PcUserPeer::getLoggedInUser()->getId()!=$userToCheckAgainst->getId())
    {
      throw new sfException('User '.$userToCheckAgainst->getId().' trying to access a resource illegitimately');      
    }
  }

  /**
   * Guarantees a text is not longer than $maxlength chars
   * (if it is, it's shortened and appended three dots to it by default)
   *
   * @param string $text - the text to adjust
   * @param int - the maximum number of characters
   * @param string $filler - three dots by default
   * @return string - the adjusted text
   */
  public static function getTeaser($text, $maxlength, $filler = '...')
  {
    $params = func_get_args();
    return (strlen($text) > $maxlength) ? substr($text, 0, $maxlength-strlen($filler)).$filler : $text;
  }

  /**
   * Returns the visitor IP
   * 
   * @return string
   */
  public static function getVisitorIPAddress()
  {
    return (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : ( isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '' );
  }

  /**
   * Returns the visitor IP
   * 
   * @return string
   */
  public static function getVisitorAcceptLanguage()
  {
    return $_SERVER["HTTP_ACCEPT_LANGUAGE"];
  }

/*
  public static function getGMTNow()
  {
    return (int)gmdate('U', time());
  }
*/

  /**
   * Returns the ordinal number corresponding to the cardinal passed as input
   * 
   * @param integer $cardinalNumber - number to convert
   * @param boolean $abbr(=true) - whether return just an abbreviation (e.g.: '1st' rather than 'first') 
   * @return string
   */
  public static function getOrdinalFromCardinal($cardinalNumber, $abbr = true)
  {
    $ordinalNumbers = array('', 'first', 'second', 'third', 'forth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth', 'eleventh', 'twelfth', 'thirteenth', 'fourteenth', 'fifteenth', 'sixteenth', 'seventeenth', 'eighteenth', 'nineteenth', 'twentieth', 'twenty-first', 'twenty-second', 'twenty-third', 'twenty-fourth', 'twenty-fifth', 'twenty-sixth', 'twenty-seventh', 'twenty-eighth', 'twenty-ninth', 'thirtieth');

    $ordinalNumbersAbbr = array('', '1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21st', '22nd', '23rd', '24th', '25th', '26th', '27th', '28th', '29th', '30th');

    return $abbr ? $ordinalNumbersAbbr[$cardinalNumber] : $ordinalNumbers[$cardinalNumber];
  }

  /*
   * Returns the url (relative to the Plancake's webroot) of the downloadable package of plancake 
   * 
   * @param string $versionToForce (='')
   * @return string
   */
  public static function getPlancakeDownloadFilename()
  {
  	return 'plancake.zip';
  }


  /*
   * Returns a nice datetime expression
   * N.B.: the reference is the current GMT timestamp
   *
   * @param int $unixTimestamp
   * @return string
   */
  public static function getHumanFriendlyTimeElapsedFromNow($unixTimestamp)
  {
    $gmdTimestampNow = gmdate('U');

    $minutesElapsed = floor (($gmdTimestampNow - $unixTimestamp) / 60);

    if ($minutesElapsed < 10)
        return sprintf(__('WEBSITE_HOMEPAGE_FRESHNESS_MINUTES_AGO'), $minutesElapsed . '');

    if ( ($minutesElapsed >= 10) && ($minutesElapsed < 60))
        return sprintf(__('WEBSITE_HOMEPAGE_FRESHNESS_MINUTES_AGO'), (floor($minutesElapsed/10)*10) . '');

    if ( ($minutesElapsed >= 60) && ($minutesElapsed < 1320))
        return sprintf(__('WEBSITE_HOMEPAGE_FRESHNESS_HOURS_AGO'), floor($minutesElapsed/60) . '');

    if ($minutesElapsed > 1320)
        return sprintf(__('WEBSITE_HOMEPAGE_FRESHNESS_DAYS_AGO'), floor($minutesElapsed/1320) . '');

  }

  /**
   * Inserts the update message into the inbox of each user
   *
   * @param string $description
   * @param string $url
   */
  public static function broadcastUpdate($description, $url)
  {
    $taskContent = "$description - " . __('ACCOUNT_MISC_READ_MORE_ON_OUR_BLOG') . " $url.";

    foreach(PcListPeer::getAllInboxes() as $inbox)
    {
        $task = new PcTask();
        $task->setDescription($taskContent)
             ->setListId($inbox->getId())
             ->setIsFromSystem(1)
             ->save();
    }
  }

  /**
   *
   * @param string $text
   * @param boolean $inNewWindow
   * @return string
   */
  public static function linkify($text, $inNewWindow=true)
  {
    $inNewWindowString = $inNewWindow ? 'target=\"_blank\"' : '';

    // the first attempt is to catch http://........
    $firstAttemptRet = preg_replace("![[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]!","<a $inNewWindowString href=\"\\0\">\\0</a>", $text, -1, $numberOfReplacements);

    if ($numberOfReplacements > 0)
    {
        return $firstAttemptRet;
    }
    else // this second attempt is to catch something like staging.plancake.com (without leading http://)
    {
        return preg_replace("![^<>[:space:]]+\.[^<>[:space:].]+\.[^<>[:space:]]+!","<a $inNewWindowString href=\"http://\\0\">\\0</a>", $text);
    }
  }

  /**
   * This is the backend for the PcValue table
   *
   * If the key doesn't exist it will be created
   *
   * It may return:
   * _ the value for the key, if the key exists
   * _ $defaultValue if the key doesn't exist and $defaultValue!=''
   * _ an empty string if the $key doesn't exist and $defaultValue is not passed
   *
   * @param string $key
   * @param string $defaultValue (='')
   * @return string
   */
  public static function getValue($key, $defaultValue='')
  {
    $c = new Criteria();
    $c->add(PcValuePeer::NAME, $key);
    $value = PcValuePeer::doSelectOne($c);

    if (!is_object($value))
    {
        // inserting the new value
        $newValue = new PcValue();
        $newValue->setName($key)->save();
    }

    return is_object($value) ? $value->getValue() : $defaultValue;
  }

  /**
   * This is the backend for the PcValue table
   * 
   * If the key doesn't exist it will be created
   *
   * @param string $key
   * @param string $value
   */
  public static function setValue($key, $value)
  {
    $c = new Criteria();
    $c->add(PcValuePeer::NAME, $key);
    $valueObject = PcValuePeer::doSelectOne($c);

    if (is_object($valueObject)) // the $key exists
    {
        $valueObject->setValue($value);
        $valueObject->save();
    }
    else
    {
        $valueObject = new PcValue();
        $valueObject->setName($key)
              ->setValue($value)
              ->save();
    }
  }

  /**
   * This is an alternative to file_get_contents.
   * It is better because it doesn't require a particular PHP configuration
   * that allows file_get_contents to request resources over the Internet.
   * It is worse because it is Linux-specific
   *
   * @param string $url
   * @param boolean $returnOnlyLastLine (=false)
   * @return string
   */
  public static function getFileContentOverInternet($url, $returnOnlyLastLine=false)
  {
    $url = trim($url);
    $wgetCommand = "wget --quiet --output-document=- '$url'";
    return $returnOnlyLastLine ? exec($wgetCommand) : shell_exec($wgetCommand);
  }

    /**
     * @return string - a 32-character hash
     */
  public static function generate32CharacterRandomHash()
  {
    return self::generateRandomString(32);
  }

    /**
     * @return string - a 40-character hash
     */
  public static function generate40CharacterRandomHash()
  {
    $result = "";
    $charPool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for($p = 0; $p<32; $p++)
        $result .= $charPool[mt_rand(0,strlen($charPool)-1)];
    return sha1($result);
  }

  /**
   * Unlike explode(), it returns an empty array if $string is empty
   *
   * @param string $delimiter
   * @param string $string
   * @param int $limit
   * @return array
   */
  public static function explodeWithEmptyInputDetection($delimiter, $string, $limit = null)
  {
    if (strlen($string) == 0)
    {
        return array();
    }

    if ($limit !== null)
    {
        return explode($delimiter, $string, $limit);
    }
    else
    {
        return explode($delimiter, $string);
    }

  }

  /**
   *
   * @param string $text
   * @return string
   */
  public static function slugify($text)
  {
    $text = preg_replace('/[^a-zA-Z0-9 ]/', '', $text);
    return strtolower(preg_replace('/ /', '-', $text));
  }

  /**
   * It makes sure the slug is unique
   *
   * @param string $text
   * @param string fieldName (in this form: pc_blog_post.CONTENT)
   * @return string
   */
  public static function slugifyWithUniqueness($text, $fieldName)
  {
    $i = 0;
    do
    {
        $slug = self::slugify($text);

        if ($i > 0)
        {
            $slug = $slug . '-' . $i;
        }

        // check whether the slug is unique
        $c = new Criteria();
        $c->add($fieldName, $slug);
        $slugs = PcBlogPostPeer::doSelect($c);
        $i++;
    } while(count($slugs) > 0);

    return $slug;
  }

  public static function getMysqlTimestamp($unixTimestamp)
  {
      return date('Y-m-d H:i:s', $unixTimestamp);
  }

  /**
   *
   * @param string $weekdayAbbreviation - i.e.: sun, mon
   * @return string - i.e. Sunday, Monday
   */
  public static function fromAbbreviationToWeekday($weekdayAbbreviation)
  {
    $weekdayAbbreviation =  strtolower($weekdayAbbreviation);

    $weekdaysArray = array('sun' => __('ACCOUNT_DOW_SUNDAY'),
                           'mon' => __('ACCOUNT_DOW_MONDAY'),
                           'tue' => __('ACCOUNT_DOW_TUESDAY'),
                           'wed' => __('ACCOUNT_DOW_WEDNESDAY'),
                           'thu' => __('ACCOUNT_DOW_THURSDAY'),
                           'fri' => __('ACCOUNT_DOW_FRIDAY'),
                           'sat' => __('ACCOUNT_DOW_SATURDAY'));

    return $weekdaysArray[$weekdayAbbreviation];
  }

  /**
   * 1 -> Mon
   *
   * @param int $index  (1-7)
   * @return string
   */
  public static function fromIndexToWeekday($index)
  {
    $weekdaysArray = array(7 => __('ACCOUNT_DOW_SUN'),
                           1 => __('ACCOUNT_DOW_MON'),
                           2 => __('ACCOUNT_DOW_TUE'),
                           3 => __('ACCOUNT_DOW_WED'),
                           4 => __('ACCOUNT_DOW_THU'),
                           5 => __('ACCOUNT_DOW_FRI'),
                           6 => __('ACCOUNT_DOW_SAT'));

    return $weekdaysArray[$index];
  }

  /**
   * 1 -> Jan
   *
   * @param int $index  (1-12)
   * @return string
   */
  public static function fromIndexToMonth($index)
  {
    $monthsArray = array(1 => __('ACCOUNT_MONTH_JAN'),
                         2 => __('ACCOUNT_MONTH_FEB'),
                         3 => __('ACCOUNT_MONTH_MAR'),
                         4 => __('ACCOUNT_MONTH_APR'),
                         5 => __('ACCOUNT_MONTH_MAY'),
                         6 => __('ACCOUNT_MONTH_JUN'),
                         7 => __('ACCOUNT_MONTH_JUL'),
                         8 => __('ACCOUNT_MONTH_AUG'),
                         9 => __('ACCOUNT_MONTH_SEP'),
                         10 => __('ACCOUNT_MONTH_OCT'),
                         11 => __('ACCOUNT_MONTH_NOV'),
                         12 => __('ACCOUNT_MONTH_DEC'));

    return $monthsArray[$index];
  }

  /**
   *
   * @param string $weekdayAbbreviation - i.e.: sun, mon
   * @return string - i.e. Sunday, Monday
   */
  public static function fromAbbreviationToIcalAbbreviation($weekdayAbbreviation)
  {
    $weekdayAbbreviation =  strtolower($weekdayAbbreviation);

    $weekdaysArray = array('sun' => 'SU',
                           'mon' => 'MO',
                           'tue' => 'TU',
                           'wed' => 'WE',
                           'thu' => 'TH',
                           'fri' => 'FR',
                           'sat' => 'SA');

    return $weekdaysArray[$weekdayAbbreviation];
  }

  /**
   * @param myUser $user
   * @param sfAction $action
   */
  public static function redirectLoggedInUser(myUser $user, sfAction $action)
  {
    // not redirecting if the user is a member of the staff or a translator as
    // they may need to debug something
    $loggedInUser = PcUserPeer::getLoggedInUser();
    if ($loggedInUser)
    {
        if ($loggedInUser->isStaffMember() || $loggedInUser->isTranslator())
        {
            return;
        }
    }

    if ($loggedInUser && $user->isAuthenticated())
    {
        self::redirectToApp($action);
    }
  }
  
  public static function redirectToApp($action)
  {
    $urlForRedirect  = 'http://' .  sfConfig::get('app_site_url') . '/' . sfConfig::get('app_accountApp_frontController');              
    if (PcUtils::isMobileBrowser())
    {
        // we force https with mobile app so that
        // the cache manifest can have this entry:
        // https://www.plancake.com/account.php/mobile
        // and it is going to work for any user, not just Premium ones        
      $urlForRedirect = 'https://' .  sfConfig::get('app_site_url') . '/' . sfConfig::get('app_accountApp_frontController') . '/mobile';
    }               
    $action->redirect($urlForRedirect);
  }

  /**
   * We escape the ' character in the return of the function and remove newlines
   *
   * @param string $stringId
   * @return string
   */
  public static function makeLangStringAvailableToJs($stringId)
  {
    return str_replace(array("\r", "\r\n", "\n"), '', str_replace("'", "\'", __($stringId)));
  }

  /**
   *
   * @param string $url
   * @return string
   */
  public static function prependHttpToUrl($url)
  {
    if (!preg_match("/^(http|https):/", $url)) {
       $url = 'http://'.$url;
    }
    return $url;
  }
  
  /**
   * Based on the code prodived by http://detectmobilebrowsers.com/ for detecting mobile browsers
   * 
   * @return boolean
   */
  public static function isMobileBrowser()
  {
      $useragent=$_SERVER['HTTP_USER_AGENT'];
      if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
          return true;
      } else {
          return false;
      }
  }
  
  // from: http://stackoverflow.com/questions/1289061/best-way-to-use-php-to-encrypt-and-decrypt
  public static function encryptString($s)
  {
      $key = sfConfig::get('app_site_encryptionKey');
      return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $s, MCRYPT_MODE_CBC, md5(md5($key))));
  }
  
  // from: http://stackoverflow.com/questions/1289061/best-way-to-use-php-to-encrypt-and-decrypt
  public static function decryptString($s)
  {
      $key = sfConfig::get('app_site_encryptionKey');     
      return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($s), MCRYPT_MODE_CBC, md5(md5($key)));      
  }
  
}
