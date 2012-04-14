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
 * user actions.
 *
 * @package    plancake
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class userActions extends PlancakeActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  // From AJAX
  public function executeSendFeedback(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();

    $message = $request->getParameter('message');
    $to = sfConfig::get('app_emailAddress_contact');
    $subject = "Submitted feedback";

    if (PcLanguagePeer::getUserPreferredLanguage()->getId() == 'it')
    {
        $subject= 'Richiesta da box';
    }

    // we need to add a 'random' code otherwise GMail groups all of them together
    $subject .= ' ' . date('YmdHis');

    $message = $message . "\n ----- \n" . $_SERVER['HTTP_USER_AGENT'];
    
    PcUtils::sendEmail($to,
                       $subject,
                       $message,
                       $to,
                       PcUserPeer::getLoggedInUser()->getEmail());

    return $this->renderDefault();
  }
  
  // From AJAX
  public function executeLogError(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();

    $error = $request->getParameter('error');
    $to = sfConfig::get('app_emailAddress_support');
    $subject = "Javascript Remote Problem";

    // we need to add a 'random' code otherwise GMail groups all of them together
    $subject .= ' ' . date('YmdHis');

    $error = $error . "\n\nUserId:" . PcUserPeer::getLoggedInUser()->getId() . "\n ----- \n" . $_SERVER['HTTP_USER_AGENT'];
    
    PcUtils::sendEmail($to,
                       $subject,
                       $error,
                       $to,
                       PcUserPeer::getLoggedInUser()->getEmail());  
    
    return $this->renderDefault();
  }  
  
  // From AJAX
  public function executeHideBreakingNews(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();

    $newsId = $request->getParameter('newsId');
    
    if ($newsId) {
        $user->setLatestBreakingNewsClosed($newsId)
             ->save();
    }
    
    return $this->renderDefault();    
  }
  
  
  // From AJAX
  public function executeHideHint(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
    $userId = $user->getId();

    $hintId = $request->getParameter('hintId');
    
    if ($hintId) {
        $setting = PcHideableHintsSettingPeer::retrieveByPK($userId);
        
        if (! is_object($setting)) {
            $setting = new PcHideableHintsSetting();
            $setting->setId($userId);
        }
        
        switch($hintId) {
            case PcHideableHintsSettingPeer::INBOX_HINT :
                $setting->setInbox(1);
                break;
            case PcHideableHintsSettingPeer::TODO_HINT :
                $setting->setTodo(1);
                break;
            case PcHideableHintsSettingPeer::COMPLETED_HINT :
                $setting->setCompleted(1);
                break;
            case PcHideableHintsSettingPeer::QUOTE_HINT :
                $setting->setQuote(1);
                break;            
        }
        
        
        $setting->save();
    }
    
    return $this->renderDefault();    
  }  

  public function executeSubmitArticle(sfWebRequest $request)
  {
    $this->form = new SubmitArticleForm();

    $user = PcUserPeer::getLoggedInUser();

    $this->submitted = false;

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('article'), $request->getFiles('article'));
      if ($this->form->isValid())
      {
          $file = $this->form->getValue('file');

          $extension = $file->getExtension($file->getOriginalExtension());

          $fileFullPath = '/tmp/article_' . time('Y-m-d-H-i-s') . $extension;

          try
          {
              $file->save($fileFullPath);

              PcUtils::sendEmail(sfConfig::get('app_site_adminUserEmails'),
                                 'New article',
                                 'New article',
                                 sfConfig::get('app_site_adminUserEmails'),
                                 $user->getEmail(),
                                 $fileFullPath);
          }
          catch (Exception $e)
          {
             unlink($fileFullPath);
             throw $e;
          }

          unlink($fileFullPath);

          $this->submitted = true;
      }
    }
  }
}
