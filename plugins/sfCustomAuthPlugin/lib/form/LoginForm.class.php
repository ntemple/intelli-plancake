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

class LoginForm extends sfForm
{
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', __('GENERAL_REQUIRED_FIELD_ERROR'));
    sfValidatorBase::setDefaultMessage('min_length', sprintf(__('GENERAL_FIELD_TOO_SHORT_ERROR'), '"%value%"' , '%min_length%'));

    $this->setWidgets(array(
      'email'   => new sfWidgetFormInput(),
      'return-url'   => new sfWidgetFormInputHidden(),
      'password'   => new sfWidgetFormInputPassword(),
      'rememberme'   => new sfWidgetFormInputCheckbox(array())
    ));
 
    $this->setValidators(array(
      'email'   => new sfValidatorEmail(array(
		    'required' => true,
		    'max_length' => sfConfig::get('app_email_maxLength'),
		    'min_length' => sfConfig::get('app_email_minLength'),
		    ), 
		    array('invalid' => __('WEBSITE_LOGIN_EMAIL_ERROR'))),
      'password' => new sfValidatorString(array(
		    'max_length' => sfConfig::get('app_password_maxLength'),
		    'min_length' => sfConfig::get('app_password_minLength'),
		    )),
      'rememberme' => new sfValidatorBoolean(array('required' => false)),
      'return-url' => new sfValidatorString(array('required' => false))
    ));

    $this->widgetSchema->setLabels(array(
      'email'      => __('WEBSITE_LOGIN_EMAIL_LABEL'),
      'password'   => __('WEBSITE_LOGIN_PASSWORD_LABEL'),
      'rememberme'   => __('WEBSITE_LOGIN_REMEMBER_ME_LABEL')
    ));

    $this->widgetSchema->setNameFormat('login[%s]');
  }
}

?>
