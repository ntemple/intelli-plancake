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

class ContactForm extends BaseForm
{
  private $reChoices = array();

  private $langChoices = array('en' => 'English <img src="/images/flags/United-States-Flag-16.png" />',
		     'it' => 'Italian <img src="/images/flags/Italy-Flag-16.png" /> (puoi compilare il modulo in Italiano)');

  private function initRes()
  {
      $reChoices = $this->reChoices;
      $reChoices[''] = '';
      $reChoices['problem'] = __('WEBSITE_CONTACT_US_PROBLEM_REASON');
      $reChoices['activationemail'] = __('WEBSITE_CONTACT_US_ACTIVATION_REASON');
      $reChoices['bug'] = __('WEBSITE_CONTACT_US_BUG_REASON');
      $reChoices['newfeature'] = __('WEBSITE_CONTACT_US_NEWFEATURE_REASON');
      $reChoices['contribute'] = __('WEBSITE_CONTACT_US_CONTRIBUTE_REASON');
      $reChoices['workwithyou'] = __('WEBSITE_CONTACT_US_WORKWITHYOU_REASON');
      $reChoices['support'] = __('WEBSITE_CONTACT_US_SUPPORT_REASON');
      $reChoices['business'] = __('WEBSITE_CONTACT_US_BUSINESS_REASON');
      $reChoices['explanation'] = __('WEBSITE_CONTACT_US_EXPLANATION_REASON');
      $reChoices['press'] = __('WEBSITE_CONTACT_US_PRESS_REASON');
      $reChoices['article'] = __('WEBSITE_CONTACT_US_ARTICLE_REASON');
      $reChoices['general'] = __('WEBSITE_CONTACT_US_GENERAL_REASON');

      $this->reChoices = $reChoices;
  }

  public function configure()
  {
    $this->initRes();

    $reChoices = $this->reChoices;
    $langChoices = $this->langChoices;

    $this->setWidgets(array(
      'lang' => new sfWidgetFormChoice(array('choices' => $langChoices, 'expanded' => true, 'renderer_class' => 'sfWidgetFormSelectRadioHtmlLabels')),
      'name' => new sfWidgetFormInputText(),
      'email'   => new sfWidgetFormInputText(),
      're' => new sfWidgetFormSelect(array('choices' => $reChoices)),
      'message' => new sfWidgetFormTextarea(),
    ));
 
    $this->setValidators(array(
      'lang'   => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'name'   => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'email'   => new sfValidatorEmail(array('required' => true), 
	    array('invalid' => 'Please enter a valid email address')),
      're'   => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'message' => new sfValidatorString(array('max_length' => 1024)),
    ));

    $this->widgetSchema->setLabels(array(
      'lang'    => __('WEBSITE_CONTACT_US_LANGUAGE_LABEL'),
      'name'    => __('WEBSITE_CONTACT_US_NAME_LABEL'),
      'email'      => '* ' . __('WEBSITE_CONTACT_US_EMAIL_LABEL'),
      're'   => __('WEBSITE_CONTACT_US_REGARDING_LABEL'),
      'message'   => '* ' . __('WEBSITE_CONTACT_US_MESSAGE_LABEL'),
    ));

    $this->widgetSchema->setNameFormat('contact[%s]');
  }

  public function getReChoices()
  {
      $this->initRes();
      return $this->reChoices;
  }
}

?>
