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

class listActions extends PlancakeActions
{
  public function executeAdd(sfWebRequest $request)
  {
    $isHeader = $request->getParameter('isHeader') == 1 ? 1 : 0;

    $list = new PcList();
    $list->setTitle($request->getParameter('listTitle'));
    $list->setCreatorId($this->getUser()->getAttribute('userid'));
    $list->setIsHeader($isHeader);
    $user = $list->getCreator();
    if( ! $request->getParameter('beforeListId'))
    {
      // getting max sortOrder
      $c = new Criteria();
      $c->addDescendingOrderByColumn(PcListPeer::SORT_ORDER);
      $maxSortOrder = PcListPeer::doSelectOne($c)->getSortOrder();
      
      $list->setSortOrder($maxSortOrder+1);
    }
    else
    {
      $beforeListId = $request->getParameter('beforeListId');
      // I need to insert the new list after the list whose id is beforeListId
      $allLists = $list->getCreator()->getLists();
      // the lists are returned with sortOrder ascending order
      // and the lists are displayed with the smaller sortOrder on top
      $incrementSortOrder = false;
      if (is_array($allLists)) {
          foreach($allLists as $oneOfTheOtherLists)
          {
                  $delta = 1;
                  if ($oneOfTheOtherLists->getId() == $beforeListId)
                  {
                    $list->setSortOrder($oneOfTheOtherLists->getSortOrder() +1);
                    $incrementSortOrder = true;
                  }
                  if ($incrementSortOrder) 
                  {
                      $oneOfTheOtherLists->setSortOrder($oneOfTheOtherLists->getSortOrder() +1)
                                         ->save();                      
                  }
          }
      }
    }

    $list->save();
    $user->save();

    // {{{
    // this lines to make sure the list details we sent back via AJAX
    // are the ones stored in the database
    $list = PcListPeer::retrieveByPK($list->getId());
    // }}}

    if ($request->isXmlHttpRequest())
    {
      $ret = array('id' => $list->getId(),
                   'name' => $list->getTitle(),
                   'isHeader' => (int)$list->isHeader());        
      return $this->renderJson($ret);
    }
    return $this->renderDefault();
  }

  public function executeEdit(sfWebRequest $request)
  {
    $allowedOps = array('delete', 'edit', 'add');
    $op = $request->getParameter('op');
    if ( !in_array($op, $allowedOps) )
    {
      return false;
    }
    if ($op == 'add')
    {
      return $this->executeAdd($request);
    }

    $listId = $request->getParameter('listId');

    $list = PcListPeer::retrieveByPk($listId);



    if ($list && ($op == 'delete')) // you may try and delete a list already deleted
    {
        $creator = $list->getCreator();
        PcUtils::checkLoggedInUserPermission($creator);        
      if ($list->isSystem())
      {
        die("ERROR: " . __('ACCOUNT_ERROR_CANT_EDIT_SYSTEM_LIST'));
      }
      $list->delete();

      return $this->renderDefault();
    }    

    if ($op == 'edit')
    {
        $creator = $list->getCreator();
        PcUtils::checkLoggedInUserPermission($creator);        
        
      if ($list->isInbox())
      {
        die("ERROR: " . __('ACCOUNT_ERROR_CANT_EDIT_SYSTEM_LIST'));
      }
      $newTitle = $request->getParameter('listTitle');
      
      $isHeader = $request->getParameter('isHeader') ? $request->getParameter('isHeader') : 0;
      $isHeader = (bool)$isHeader;
      
      $list->setTitle($newTitle);
      $list->setIsHeader($isHeader);
      $list->save();
      $ret = array('id' => $list->getId(),
                   'name' => $list->getTitle(),
                   'isHeader' => (int)$list->isHeader());        
      return $this->renderJson($ret);
    }

    return $this->renderDefault();
  }
}
