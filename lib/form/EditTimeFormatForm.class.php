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

class EditTimeFormatForm extends BaseForm
{
  public function configure()
  {
    // these values are defined in the comment to the 'time_format' field of the user table
    $formats = PcCommonData::getTimeFormats();

    $this->setWidgets(array(
      'format' => new sfWidgetFormSelect(array('choices' => $formats))
    ));
 
    $this->setValidators(array(
      'format'   => new sfValidatorInteger(array('min' => 0, 'max' => 1))
    ));

    $this->widgetSchema->setLabels(array(
      'format'   => __('ACCOUNT_SETTINGS_CHANGE_TIME_FORMAT_LABEL')
    ));

    $this->widgetSchema->setNameFormat('timeFormat[%s]');
  }
}

?>
