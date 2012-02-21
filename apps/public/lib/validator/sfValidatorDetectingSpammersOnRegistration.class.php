<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorSchemaCompare compares several values from an array.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorSchemaCompare.class.php 21908 2009-09-11 12:06:21Z fabien $
 */
class sfValidatorDetectingSpammersOnRegistration extends sfValidatorSchema
{
  /**
   * @see sfValidatorBase
   */
  protected function doClean($values)
  {

    $errorSchema = new sfValidatorErrorSchema($this);
    $errorSchemaLocal = new sfValidatorErrorSchema($this);      
      
    // We use this variable to check if 3 conditions happen altogether.
    // We could have used a big 'if' statement but we thought this was clearer.
    // Each condition can be legittimate, but all of them at the same time is a bit dodgy
    $spamScore = 0;
    
    if ($values['tz'] == RegistrationForm::TIMEZONE_DEFAULT_VALUE) { // a bit unusual they are in our default timezone
                                                                     // (check what the default timezone is).
                                                                     // Or maybe their JS is off? ;-)
        $spamScore++;
    }
      
    $emailParts = explode('@', $values['email']);
    $emailDomain = $emailParts[1];
    
    if (strlen($emailDomain) < 8) { // spammers' domains tend to be very short
        $spamScore++;
    }
      
    $context = sfContext::getInstance();
    $user = $context->getUser();
    
    $userEntryPoint = $user->getAttribute(PcCaptureReferralAndEntryPoint::ENTRY_POINT_SESSION_KEY);
    
    if ( strpos($userEntryPoint, '/registration') !== FALSE) { // strange the first page they landed was the registration one
        $spamScore++;
    }
    
    if ($spamScore == 3) {
        // we should actually use a global error for this but our registration form template doesn't manage that
        $errorSchemaLocal->addError(new sfValidatorError($this, "The system thinks you are a spammer. If that is wrong, we are sorry and please contact us to fix the problem."), 'email');
    }

    // throws the error for the main form
    if (count($errorSchemaLocal))
    {
      throw new sfValidatorErrorSchema($this, $errorSchemaLocal);
    }
    if (count($errorSchema))
    {
      throw new sfValidatorErrorSchema($this, $errorSchema);
    }    
    
    return $values;
  }
}
