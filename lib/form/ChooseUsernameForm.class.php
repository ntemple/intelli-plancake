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

class ChooseUsernameForm extends BaseForm
{
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', __('GENERAL_REQUIRED_FIELD_ERROR'));
    sfValidatorBase::setDefaultMessage('min_length', sprintf(__('GENERAL_FIELD_TOO_SHORT_ERROR'), '"%value%"' , '%min_length%'));

    $this->setWidgets(array(
      'username'   => new sfWidgetFormInputText(),
      'return-url'   => new sfWidgetFormInputHidden()
    ));
 
    $this->setValidators(array(
      'username'   => new sfValidatorString(array(
		    'required' => true,
		    'max_length' => sfConfig::get('app_username_maxLength'),
		    'min_length' => sfConfig::get('app_username_minLength'),
		    )),
      'return-url' => new sfValidatorString(array('required' => false))
    ));

    $this->widgetSchema->setLabels(array(
      'username'      => __('WEBSITE_FORUM_USERNAME_USERNAME_LABEL')
    ));

    $this->widgetSchema->setNameFormat('chooseUsername[%s]');
  }
}

?>
