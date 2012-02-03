<?php 

/**
 * See: http://vvv.tobiassjosten.net/symfony/stopping-spam-with-symfony-forms
 * 
The idea is that automated bots are efficient for spammers because they are fast. 
They load an HTML page and submit a form in it faster than any human could. And that is how we can catch them.

You start by adding a new element to your form.

$this->widgetSchema['asdf'] = new sfWidgetFormInputHidden(
  array(),
  array('value' => base64_encode(time()))
);
$this->validatorSchema['asdf'] = new sfValidatorTimer;

It defaults to always have the current time as its value. 
It does not matter if this time differs from the client because all validation will take place on the server.

I also obfuscated the element by naming it asdf and base64 encoding its value – 
 * two more easy steps that could help throw off the lesser bots.
This checks to see if the given time, which defaulted to currently, is more than seven seconds ago and less than a day ago. 
If that is not the case, or if the value has been tampered with, it throws an error. 
This will again reset the value to the current time and you must wait another seven seconds before posting.
 * 
 */

class sfValidatorTimerAntiSpam extends sfValidatorSchema
{
  const MIN_TIME_SECS = 5;
  const MAX_TIME_SECS = 86400; // a day
    
  protected function configure($options = array(), $messages = array())
  {
  }
 
    protected function doClean($value)
    {
      $time = base64_decode($value);

      if (!$time)
      {
        throw new sfValidatorError($this, 'tampered');
      }

      if (!is_numeric($time))
      {
        throw new sfValidatorError($this, 'nan');
      }

      $timeAgo = time() - $time;

      if ($timeAgo > self::MAX_TIME_SECS)
      {
        throw new sfValidatorError($this, "max_time (you shouldn't submit after " . self::MAX_TIME_SECS .  " secs from when the form loaded)");
      }

      if ($timeAgo < self::MIN_TIME_SECS)
      {
        throw new sfValidatorError($this, "min_time (you shouldn't submit before " . self::MIN_TIME_SECS .  " secs from when the form loaded)");
      }

      return time();
    }
}