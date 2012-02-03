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

class EditPasswordForm extends BaseForm
{
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', __('GENERAL_REQUIRED_FIELD_ERROR'));
    sfValidatorBase::setDefaultMessage('min_length', sprintf(__('GENERAL_FIELD_TOO_SHORT_ERROR'), '"%value%"' , '%min_length%'));

    $this->setWidgets(array(
      'password1'   => new sfWidgetFormInputPassword(),
      'password2'   => new sfWidgetFormInputPassword()
    ));
 
    $this->setValidators(array(
      'password1' => new sfValidatorString(array(
		    'max_length' => sfConfig::get('app_password_maxLength'),
		    'min_length' => sfConfig::get('app_password_minLength'),
		    )),
      'password2' => new sfValidatorString(array(
		    'max_length' => sfConfig::get('app_password_maxLength'),
		    'min_length' => sfConfig::get('app_password_minLength'),
		    ))
    ));

    $this->mergePostValidator(
      new sfValidatorSchemaCompare(
        'password1',  
        '==', 
        'password2',
        array(),
        array('invalid' => __('ACCOUNT_SETTINGS_PASSWORDS_DONT_MATCH_ERROR'))
        )
    );

    $this->widgetSchema->setLabels(array(

      'password1'   => __('ACCOUNT_SETTINGS_PASSWORD'),
      'password2'   => __('ACCOUNT_SETTINGS_REPEAT_PASSWORD')
    ));

    $this->widgetSchema->setNameFormat('password[%s]');
  }
}

?>
