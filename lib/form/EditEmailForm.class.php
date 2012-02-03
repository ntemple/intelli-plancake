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

class EditEmailForm extends BaseForm
{
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', __('GENERAL_REQUIRED_FIELD_ERROR'));
    sfValidatorBase::setDefaultMessage('min_length', sprintf(__('GENERAL_FIELD_TOO_SHORT_ERROR'), '"%value%"' , '%min_length%'));

    $this->setWidgets(array(
      'email1'   => new sfWidgetFormInputText(),
      'email2'   => new sfWidgetFormInputText()
    ));
 
    $this->setValidators(array(
      'email1'   => new sfValidatorEmail(array(
		    'required' => true,
		    'max_length' => sfConfig::get('app_email_maxLength'),
		    'min_length' => sfConfig::get('app_email_minLength'),
		    ), 
		    array('invalid' => __('ACCOUNT_SETTINGS_INVALID_EMAIL_ERROR'))),
      'email2'   => new sfValidatorEmail(array(
		    'required' => true,
		    'max_length' => sfConfig::get('app_email_maxLength'),
		    'min_length' => sfConfig::get('app_email_minLength'),
		    ), 
		    array('invalid' => __('ACCOUNT_SETTINGS_INVALID_EMAIL_ERROR'))),
    ));

    $this->mergePostValidator(
      new sfValidatorSchemaCompare(
        'email1',  
        '==', 
        'email2',
        array(),
        array('invalid' => __('ACCOUNT_SETTINGS_EMAILS_DONT_MATCH_ERROR'))
        )
    );

    $this->widgetSchema->setLabels(array(
      'email1'   => __('ACCOUNT_SETTINGS_EMAIL'),
      'email2'   => __('ACCOUNT_SETTINGS_REPEAT_EMAIL')
    ));

    $this->widgetSchema->setNameFormat('email[%s]');
  }
}

?>
