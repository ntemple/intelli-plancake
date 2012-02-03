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

class EditTimezoneForm extends BaseForm
{
  public function configure()
  {
    $items = PcTimezonePeer::doSelect(new Criteria());
    $tzs = array();

    foreach($items as $item)
    {
      $tzs[$item->getLabel()] = $item->getDescription();
    }

    $this->setWidgets(array(
      'tz' => new sfWidgetFormSelect(array('choices' => $tzs, 'default' => '00:00,0')),
      'dst_on' => new sfWidgetFormInputCheckbox(array('default' => 0))
    ));
 
    $this->setValidators(array(
      'tz' => new sfValidatorString(),
      'dst_on' => new sfValidatorString(array(
		    'required' => false,
		    'max_length' => 3
		    ))
    ));

    $this->widgetSchema->setLabels(array(
      'tz'   => __('ACCOUNT_SETTINGS_SELECT_TIMEZONE'),
      'dst_on' => __('ACCOUNT_SETTINGS_DAYLIGHT_SAVING_ACTIVE')
    ));

    $this->widgetSchema->setNameFormat('timezone[%s]');
  }
}

?>
