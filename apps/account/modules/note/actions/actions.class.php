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
 * note actions.
 *
 * @package    plancake
 * @subpackage note
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class noteActions extends sfActions
{
    const NEW_MODE = 0;
    const EDIT_MODE = 1;

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $noteId = $request->getParameter('id', 0);
    $user = PcUserPeer::getLoggedInUser();

    $mode = self::NEW_MODE;
    $note = null;
    $noteTitle = "";

    if ($noteId > 0)
    {
        $mode = self::EDIT_MODE;
        $note = PcNotePeer::retrieveByPK($noteId);
        PcUtils::checkLoggedInUserPermission($note->getCreator());
        $noteTitle = $note->getTitle();
    }
    else
    {
        if ( (!$user->isSupporter()) && ($user->getNotesCount() > sfConfig::get('app_site_maxNotesForNonSupporter')) )
        {
            $this->redirect('@subscribe?feature=notes');
        }

        $note = new PcNote();
        $noteTitle = __('ACCOUNT_NOTES_UNTITLED_NOTE');
    }

    $this->note = $note;
    $this->noteTitle = $noteTitle;
  }

  /**
  * It is used for both editing and adding
  */
  public function executeSave(sfWebRequest $request)
  {
    $noteId = $request->getParameter('noteId');
    $noteTitle = $request->getParameter('noteTitle');
    $noteContent = $request->getParameter('noteContent');

    $noteId = (int)$noteId;

    $note = null;
    if ($noteId > 0)
    {
        $mode = self::EDIT_MODE;
        $note = PcNotePeer::retrieveByPK($noteId);
        PcUtils::checkLoggedInUserPermission($note->getCreator());
    }
    else
    {
        $note = new PcNote();
    }
    
    $note->setCreatorId(PcUserPeer::getLoggedInUser()->getId())
         ->setTitle($noteTitle)
         ->setContent($noteContent)
         ->save();

    if ($request->isXmlHttpRequest())
    {
        return $this->renderText($note->getId());
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    $noteLabel = $request->getParameter('noteLabel');

    $noteLabelInfo = explode('_', $noteLabel);
    $note = PcNotePeer::retrieveByPk($noteLabelInfo[1]);
    PcUtils::checkLoggedInUserPermission($note->getCreator());
    $note->delete();

    if ($request->isXmlHttpRequest())
    {
        return sfView::NONE;
    }
  }
}