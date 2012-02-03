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

class SubmitArticleForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'tc' => new sfWidgetFormInputCheckbox(),
      'file'    => new sfWidgetFormInputFile()
    ));
    $this->widgetSchema->setNameFormat('article[%s]');

    $this->setValidators(array(
      'file'    => new sfValidatorFile(array('required' => true)),
      'tc' => new sfValidatorString(array(
		    'required' => true,
		    'max_length' => 3
		    ))
    ));

    $validMimeTypes = array('text/plain', 'text/html', 'application/msword', 'application/vnd.oasis.opendocument.text');
    $this->validatorSchema['file']->setOption('mime_types', $validMimeTypes);

    $messages = array ('invalid' => 'Invalid file.',
                       'required' => 'Select a file to upload.',
                       'max_size' => 'The file can\'t be bigger than 20 MB',
                       'mime_types' => 'The file must be of TXT, HTML, ODT, DOC, DOCX format.' );
    $this->validatorSchema['file']->setMessages($messages);

    $this->widgetSchema->setLabels(array(
      'file'   => 'Article:',
      'tc' => 'Tick the box if you accept the terms above'
    ));

    $this->widgetSchema->setNameFormat('article[%s]');
  }
}