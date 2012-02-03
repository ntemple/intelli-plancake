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

class UploadAvatarForm extends BaseForm
{
  public function configure()
  {
    sfValidatorBase::setDefaultMessage('required', __('GENERAL_REQUIRED_FIELD_ERROR'));
    sfValidatorBase::setDefaultMessage('min_length', sprintf(__('GENERAL_FIELD_TOO_SHORT_ERROR'), '"%value%"' , '%min_length%'));

    $this->setWidgets(array(
      'file'    => new sfWidgetFormInputFile()
    ));
    $this->widgetSchema->setNameFormat('avatar[%s]');

    $this->setValidators(array(
      'file'    => new sfValidatorFile()
    ));

    $validMimeTypes = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');
    $this->validatorSchema['file']->setOption('mime_types', $validMimeTypes);
    $this->validatorSchema['file']->setOption('max_size', sfConfig::get('app_avatar_maxSize'));

    $messages = array ('invalid' => 'Invalid file.',
                       'required' => 'Select a file to upload.',
                       'max_size' => 'The file can\'t be bigger than ' . sfConfig::get('app_avatar_maxSize') / 1000000 . 'MB',
                       'mime_types' => 'The file must be of JPEG, PNG , GIF format.' );
    $this->validatorSchema['file']->setMessages($messages);
  }
}