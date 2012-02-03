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

/**
 * PcContact form.
 *
 * @package    plancake
 * @subpackage form
 * @author     Your name here
 */
class PcContactForm extends BasePcContactForm
{
  private $langs = array('en' => 'en', 'it' => 'it');

  public function configure()
  {
      $tags = array();

      foreach (PcContactTagPeer::doSelect(new Criteria()) as $c)
      {
          $tags[$c->getId()] = $c->getName();
      }

      $this->setWidget('description', new sfWidgetFormTextarea());
      $this->setWidget('language', new sfWidgetFormChoice(array('choices' => $this->langs, 'expanded' => false)));
      $this->setWidget('pc_contacts_tags_list', new sfWidgetFormChoice(array('choices' => $tags, 'expanded' => true, 'multiple' => true)));

      $defaultLang = null;

      if (PcUserPeer::getLoggedInUser()->getEmail() == 'dan@plancake.com')
      {
        $defaultLang = 'en';
      }
      else
      {
        $defaultLang = 'it';
      }

      $this->setDefault('language', $defaultLang);

      unset($this['updated_at']);
      unset($this['created_at']);
      unset($this['creator_id']);
      unset($this['id']);

      $this->widgetSchema->setNameFormat('contact[%s]');
  }
}
