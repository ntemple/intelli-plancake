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
 * homepage actions.
 *
 * @package    sf_sandbox
 * @subpackage homepage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class homepageActions extends sfActions
{
 public function preExecute()
 {
    if (defined('PLANCAKE_PUBLIC_RELEASE') && (PLANCAKE_PUBLIC_RELEASE == 1)  )
    {
        $this->forward('customAuth', 'login');
    }
 }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $lang = PcLanguagePeer::getUserPreferredLanguage()->getId();
    
    if (! $lang)
    {
        $lang = SfConfig::get('app_site_defaultLang');
    }
    
    $this->lang = $lang;

    $this->baseUrl = sfConfig::get('app_site_url') . 
          ((sfConfig::get('sf_environment') == 'prod') ? '' : '/') .
          sfConfig::get('app_publicApp_frontController');
    if (defined('PLANCAKE_PUBLIC_RELEASE'))
    {
        $this->baseUrl = 'http://www.plancake.com';
    }
    $userCulture = $this->getUser()->getCulture();

    $this->cultureUrlPart = '';
    if ($userCulture != SfConfig::get('app_site_defaultLang'))
    {
        $this->cultureUrlPart = '/' . $userCulture;
    }


    
    // this is a "backdoor" to avoid redirection: just append ?redirect=no to the URL
    if ($request->getParameter('redirect') == 'no')
    {
        return;
    }

    // if the user is authenticated, they will be redirected
    // to their account
    if ($this->getUser()->isAuthenticated())
    {
      $this->redirect('/' . sfConfig::get('app_accountApp_frontController'));
    }
  }
}
