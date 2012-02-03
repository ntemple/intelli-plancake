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

class DeleteAccountForm extends BaseForm
{
  private $reasons = array();

  public function configure()
  {
    $this->initRes();

    $reasons = $this->reasons;

    $this->setWidgets(array(
      'reason' => new sfWidgetFormChoice(array('choices' => $reasons, 'expanded' => true)),
      'info' => new sfWidgetFormTextarea(),
    ));
 
    $this->setValidators(array(
      'reason'   => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'info' => new sfValidatorString(array('max_length' => 1024, 'required' => false))
    ));

    $this->widgetSchema->setLabels(array(
      'reason'    => __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_REASON_LABEL'),
      'info'    => __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_HOW_TO_IMPROVE')
    ));

    $this->widgetSchema->setNameFormat('deleteAccount[%s]');
  }

  public function getReasons()
  {
      $this->initRes();
      
      return $this->reasons;
  }

  private function initRes()
  {
      $reasons = $this->reasons;
      $reasons['workflow_problem'] = __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_REASON1');
      $reasons['other_product'] = __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_REASON2');
      // $reasons['lack_of_features'] = __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_REASON3');
      $reasons['too_expensive'] = __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_REASON6');
      $reasons['other'] = __('ACCOUNT_SETTINGS_DELETE_ACCOUNT_REASON4');

      $this->reasons = $reasons;
  }
}

?>
