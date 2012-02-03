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
 * context actions.
 *
 * @package    plancake
 * @subpackage context
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class contextActions extends PlancakeActions
{
  public function executeAddEdit(sfWebRequest $request)
  {
    $op = $request->getParameter('op');
    $contextId = $request->getParameter('id');
    $contextName = trim($request->getParameter('name'));
    $newContext = null;

    if ($contextName && (strpos($contextName, ' ') !== FALSE))
    {
      die("ERROR: " . __('ACCOUNT_ERROR_TAG_CANT_HAVE_SPACE'));
    }

    $existingContexts = PcUserPeer::getLoggedInUser()->getContextsArray(true);

    if (count($existingContexts))
    {
        if (in_array(strtolower($contextName), $existingContexts))
        {
            die("ERROR: " . __('ACCOUNT_ERROR_TAG_ALREADY_EXIST'));
        }
    }

    if ( ($op == 'delete') && $contextId)
    {
      $contextToDelete = PcUsersContextsPeer::retrieveByPk($contextId);
      PcUtils::checkLoggedInUserPermission(PcUserPeer::retrieveByPk($contextToDelete->getUserId()));
      $contextToDelete->delete();
    }
    else if ( ($op == 'edit') && $contextId && $contextName)
    {
      $contextToEdit = PcUsersContextsPeer::retrieveByPk($contextId);
      PcUtils::checkLoggedInUserPermission(PcUserPeer::retrieveByPk($contextToEdit->getUserId()));
      $contextToEdit->setContext($contextName)->save();

        // {{{
        // this lines to make sure the list details we sent back via AJAX
        // are the ones stored in the database
        $contextToEdit = PcUsersContextsPeer::retrieveByPk($contextId);
        // }}}

    }
    else if ( ($op == 'add') && $contextName)
    {
      // getting max sortOrder
      $c = new Criteria();
      $c->addDescendingOrderByColumn(PcUsersContextsPeer::SORT_ORDER);
      $maxSortOrder = PcUsersContextsPeer::doSelectOne($c)->getSortOrder();     
        
      $context = new PcUsersContexts();
      $context->setContext($contextName)
              ->setPcUser(PcUserPeer::getLoggedInUser())
              ->setSortOrder($maxSortOrder+1)
              ->save();

        // {{{
        // this lines to make sure the list details we sent back via AJAX
        // are the ones stored in the database
        $newContext = PcUsersContextsPeer::retrieveByPk($context->getId());
        // }}}
    }
    
    $tag = (isset($contextToEdit) && $contextToEdit) ? $contextToEdit : $newContext;

    if ($request->isXmlHttpRequest())
    {
      if ($tag)
      {
          $ret = array('id' => $tag->getId(),
                       'name' => $tag->getContext());        
          return $this->renderJson($ret);
      }
      else // in case of deletion
      {
          return $this->renderDefault();          
      }
    }    
  }
}
