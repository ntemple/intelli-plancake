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

class RegistrationForm extends BaseForm
{
  const TIMEZONE_DEFAULT_VALUE = '+13:00,0';  
    
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', __('GENERAL_REQUIRED_FIELD_ERROR'));
    sfValidatorBase::setDefaultMessage('min_length', sprintf(__('GENERAL_FIELD_TOO_SHORT_ERROR'), '"%value%"' , '%min_length%'));

    $items = PcTimezonePeer::doSelect(new Criteria());
    $tzs = array();

    foreach($items as $item)
    {
      $tzs[$item->getLabel()] = $item->getDescription();
    }

    $this->setWidgets(array(
      'email'   => new sfWidgetFormInputText(),
      'password1'   => new sfWidgetFormInputPassword(),
      'password2'   => new sfWidgetFormInputPassword(),
      'lang'   => new sfWidgetFormInputHidden(),
      'tz' => new sfWidgetFormInputHidden(array('default' => self::TIMEZONE_DEFAULT_VALUE)),
      'dst_on' => new sfWidgetFormInputHidden(array('default' => 0))
    ));
 
    $this->setValidators(array(
      'password1' => new sfValidatorString(array(
		    'max_length' => sfConfig::get('app_password_maxLength'),
		    'min_length' => sfConfig::get('app_password_minLength'),
		    )),
      'password2' => new sfValidatorString(array(
		    'max_length' => sfConfig::get('app_password_maxLength'),
		    'min_length' => sfConfig::get('app_password_minLength'),
		    )),
      'tz' => new sfValidatorString(),
      'lang' => new sfValidatorString(array('max_length' => 8, 'required' => false)),
      'dst_on' => new sfValidatorString(array(
		    'max_length' => 1
		    ))
    ));
    
    $emailDomainsBlacklistedInRegistration = sfConfig::get('app_site_emailDomainsBlacklistedInRegistration');
    foreach ($emailDomainsBlacklistedInRegistration as $k => $v) {
        $emailDomainsBlacklistedInRegistration[$k] = str_replace('.', '\.', $v);
    }
    $emailDomainsBlacklistedInRegistration = implode('|', $emailDomainsBlacklistedInRegistration);
    
    $this->validatorSchema['email'] = new sfValidatorAnd(array(
                        new sfValidatorEmail(array(
                        'required' => true,
                        'max_length' => sfConfig::get('app_email_maxLength'),
                        'min_length' => sfConfig::get('app_email_minLength')
                        )),
                        new sfValidatorRegex(
                            array('pattern' => '/@(' . $emailDomainsBlacklistedInRegistration . ')(\b|$)/si', 'must_match' => false), 
                            array('invalid' => 'Domain blocked - please use another email'
                            ))
                    ) ,
                    array() ,
                    array()
        );    

    $this->mergePostValidator(
      new sfValidatorSchemaCompare(
        'password1',  
        '==', 
        'password2',
        array(),
        array('invalid' => __('WEBSITE_REGISTRATION_PASSWORD_MISMATCH_ERROR') )
        )
    );
    
    $this->mergePostValidator(
      new sfValidatorDetectingSpammersOnRegistration(
        null,
        array(),
        array('invalid' => __('WEBSITE_REGISTRATION_PASSWORD_MISMATCH_ERROR') )
        )
    );    

    $this->widgetSchema->setLabels(array(
      'email'   => __('WEBSITE_REGISTRATION_EMAIL_ADDRESS_LABEL'),
      'password1'   => __('WEBSITE_REGISTRATION_CHOOSE_PASSWORD_LABEL'),
      'password2'   => __('WEBSITE_REGISTRATION_REPEAT_PASSWORD_LABEL')
    ));

    $this->widgetSchema->setNameFormat('registration[%s]');
   
    // {{{ START: anti-spam (see sfValidatorTimerAntiSpam class)
    $this->widgetSchema['asdf'] = new sfWidgetFormInputHidden(
      array(),
      array('value' => base64_encode(time()))
    );
    $this->validatorSchema['asdf'] = new sfValidatorTimerAntiSpam;    
    // }}} STOP: anti-spam
    
  }
}

?>
