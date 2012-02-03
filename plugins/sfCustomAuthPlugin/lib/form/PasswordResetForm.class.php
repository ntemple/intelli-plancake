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

class PasswordResetForm extends sfForm
{
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', __('GENERAL_REQUIRED_FIELD_ERROR'));
    sfValidatorBase::setDefaultMessage('min_length', sprintf(__('GENERAL_FIELD_TOO_SHORT_ERROR'), '"%value%"' , '%min_length%'));

    $this->setWidgets(array(
      'password1'   => new sfWidgetFormInputPassword(),
      'password2'   => new sfWidgetFormInputPassword(),
      't'   => new sfWidgetFormInputHidden(),
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
      't' => new sfValidatorString()
    ));

    $this->mergePostValidator(
      new sfValidatorSchemaCompare(
        'password1',  
        '==', 
        'password2',
        array(),
        array('invalid' => __('WEBSITE_FORGOTTEN_PSW_RESET_PASSWORD_ERROR'))
        )
    );

    $this->widgetSchema->setLabels(array(
      'password1'   => __('WEBSITE_FORGOTTEN_PSW_RESET_PASSWORD_LABEL'),
      'password2'   => __('WEBSITE_FORGOTTEN_PSW_RESET_REPEAT_PASSWORD_LABEL')
    ));

    $this->widgetSchema->setNameFormat('passwordReset[%s]');
  }
}

?>
