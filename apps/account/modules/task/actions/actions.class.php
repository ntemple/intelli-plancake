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

class taskActions extends PlancakeActions
{
  /**
  * It is used for both editing and adding
  */
  public function executeAdd(sfWebRequest $request)
  {       
    $description = $request->getParameter('content');
    $listId = $request->getParameter('listId');
    $taskId = $request->getParameter('taskId');
    // the contexts coming from the client have a trailing slash
    $contexts = $request->getParameter('contexts');
    $isHeader = $request->getParameter('isHeader') == 1 ? 1 : 0;
    $note = $request->getParameter('note');
    $dueDate = $request->getParameter('dueDate');
    $dueTime = $request->getParameter('dueTime');
    $isStarred = $request->getParameter('isStarred') == 1 ? 1 : 0;
    $repetitionId = $request->getParameter('repetitionId');
    $repetitionParam = $request->getParameter('repetitionParam');
    $taskAboveId = (int)$request->getParameter('taskAboveId');
    
    $task = PcTaskPeer::createOrEdit($description, $listId, $taskId, $contexts, $isHeader,
            $note, $dueDate, $dueTime, $isStarred,
            $repetitionId, $repetitionParam, $taskAboveId, 'ajax', 'Y-m-d');

    if ($request->isXmlHttpRequest())
    {       
      return $this->renderJson($task->toArray());
    }
  }
  
  /*
   * NLT called when an action is linked to a project 
   */ 
 
  public function executeLink(sfWebRequest $request)
  {
  	$taskId = $request->getParameter('taskId');
  	$targetId = $request->getParameter('targetId');
  	
  	
  	// The task is now a *act, ensure tagged
  	// the project is now a *prj, ensure tagged
  	// tag noth with the *targetId tag
  	$actTag = PcTasksContextsPeer::lookupTag('*act');
  	$prjTag = PcTasksContextsPeer::lookupTag('*prj');
  	$linkTag = PcTasksContextsPeer::lookupTag('*' . $targetId);
  	
  	// NLT @todo make sure that the user ids match. Working on tags.
  	
  	$task = PcTaskPeer::retrieveByPK($taskId);
  	PcUtils::checkLoggedInUserPermission($task->getList()->getCreator());
  	
  	$target = PcTaskPeer::retrieveByPK($targetId);
  	PcUtils::checkLoggedInUserPermission($target->getList()->getCreator());
  	
  	$task->addContexts(array($actTag->getId(), $linkTag->getId()));
  	$task->save();
  	
  	$target->addContexts(array($prjTag->getId(), $linkTag->getId()));
  	$target->save();
  
    file_put_contents('/tmp/il.log', "link $taskId -> $targetId\n", FILE_APPEND);
    file_put_contents('/tmp/il.log', print_r($task, true), FILE_APPEND);
    file_put_contents('/tmp/il.log', print_r($target, true), FILE_APPEND);
    return $this->renderDefault();
  }

  // called when an action is made complete
  public function executeComplete(sfWebRequest $request)
  {
    $taskId = (int)$request->getParameter('taskId');
    $task = PcTaskPeer::retrieveByPk($taskId);

    if (!is_object($task))
    {
        die("ERROR: " . __('ACCOUNT_ERROR_ERROR_OCCURRED_PLEASE_RETRY'));
    }

    PcUtils::checkLoggedInUserPermission($task->getList()->getCreator());

    $task->markComplete();

    if ($task->getRepetitionId())
    {
      // I need to insert the next occurrence in the list
      return $this->renderJson($task->toArray());
    }
    return $this->renderDefault();
  }

  public function executeStarTaskToggle(sfWebRequest $request)
  {
    $taskId = $request->getParameter('taskId');
    $task = PcTaskPeer::retrieveByPk($taskId);

    PcUtils::checkLoggedInUserPermission($task->getList()->getCreator());

    $isStarred = $task->isStarred();

    if ($isStarred)
    {
        $task->setStarred(false);
    }
    else
    {
        $task->setStarred(true);
    }
    $task->save();

    return $this->renderText((int)!$isStarred);

  }

  // called when a task is made incomplete
  public function executeIncomplete(sfWebRequest $request)
  {
    $taskId = (int)$request->getParameter('taskId');
    $task = PcTaskPeer::retrieveByPk($taskId);

    PcUtils::checkLoggedInUserPermission($task->getList()->getCreator());

    $task->markIncomplete();

    return $this->renderDefault();
  }

  public function executeEdit(sfWebRequest $request)
  {
    $allowedOps = array('delete', 'edit');
    $op = $request->getParameter('op');
    if ( !in_array($op, $allowedOps) )
    {
      return false;
    }

    $taskId = (int)$request->getParameter('taskId');
    $task = PcTaskPeer::retrieveByPk($taskId);

    if (!is_object($task))
    {
        die("ERROR: " . __('ACCOUNT_ERROR_ERROR_OCCURRED_PLEASE_RETRY'));
    }

    PcUtils::checkLoggedInUserPermission($task->getList()->getCreator());

    if ($op == "delete")
    {
      $task->delete();
      return $this->renderDefault();
    }

    if ($op == "edit")
    {
      // the 'add' action will manage also the edit action
      return $this->executeAdd($request);
    }

    return sfView::NONE;
  }

  public function executeGetRepetitionParamSelectTag(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $value = $request->getParameter('value');

    if (! $id)
    {
      return $this->renderText('');
    }

    $summary = '';
    $tag = '';
    if($repetition = PcRepetitionPeer::retrieveByPk($id))
    {
      if ($repetition->needsParam())
      {
        if($repetition->getSpecial() == 'selected_wkdays') // repetition on different weekdays
        {
            $weekdaysSelected = DateFormat::fromIntegerToWeekdaysSetForRepetition($value);
            $selectedSun = ($weekdaysSelected['sun']) ? "checked='checked'" : '';
            $selectedMon = ($weekdaysSelected['mon']) ? "checked='checked'" : '';
            $selectedTue = ($weekdaysSelected['tue']) ? "checked='checked'" : '';
            $selectedWed = ($weekdaysSelected['wed']) ? "checked='checked'" : '';
            $selectedThu = ($weekdaysSelected['thu']) ? "checked='checked'" : '';
            $selectedFri = ($weekdaysSelected['fri']) ? "checked='checked'" : '';
            $selectedSat = ($weekdaysSelected['sat']) ? "checked='checked'" : '';

            $tag = "";
            if (PcUserPeer::getLoggedInUser()->getWeekStart() == 0)
            {
                $tag .= "<input type='checkbox' id='wdfr_sun' name='weekdaysForRepetition' value='sun' $selectedSun ><label for='wdfr_sun'>" . __('ACCOUNT_DOW_SUN') . "</label>";
            }
            $tag .= "<input type='checkbox' id='wdfr_mon' name='weekdaysForRepetition' value='mon' $selectedMon /><label for='wdfr_mon'>" . __('ACCOUNT_DOW_MON') . "</label>";
            $tag .= "<input type='checkbox' id='wdfr_tue' name='weekdaysForRepetition' value='tue' $selectedTue /><label for='wdfr_tue'>" . __('ACCOUNT_DOW_TUE') . "</label>";
            $tag .= "<input type='checkbox' id='wdfr_wed' name='weekdaysForRepetition' value='wed' $selectedWed /><label for='wdfr_wed'>" . __('ACCOUNT_DOW_WED') . "</label>";
            $tag .= "<input type='checkbox' id='wdfr_thu' name='weekdaysForRepetition' value='thu' $selectedThu /><label for='wdfr_thu'>" . __('ACCOUNT_DOW_THU') . "</label>";
            $tag .= "<input type='checkbox' id='wdfr_fri' name='weekdaysForRepetition' value='fri' $selectedFri /><label for='wdfr_fri'>" . __('ACCOUNT_DOW_FRI') . "</label>";
            $tag .= "<input type='checkbox' id='wdfr_sat' name='weekdaysForRepetition' value='sat' $selectedSat /><label for='wdfr_sat'>" . __('ACCOUNT_DOW_SAT') . "</label>";
            if (PcUserPeer::getLoggedInUser()->getWeekStart() == 1)
            {
                $tag .= "<input type='checkbox' id='wdfr_sun' name='weekdaysForRepetition' value='sun' $selectedSun ><label for='wdfr_sun'>" . __('ACCOUNT_DOW_SUN') . "</label>";
            }
            $summary = $tag;
        }
        else // normal case
        {
            $min = $repetition->getMinParam();
            $max = $repetition->getMaxParam();
            $tag = "<select name=\"repetitionParam\">";

            for ($i = $min; $i <= $max; $i++)
            {
              $selected = ($value==$i) ? 'selected="selected"' : '';

              $label = $repetition->isParamCardinal() ? $i : PcUtils::getOrdinalFromCardinal($i);
              $tag .= "<option value=\"$i\" $selected>$label</option>";
            }

            $tag .= "</select>";
            $summary = str_replace(__('ACCOUNT_TASK_REPETITION_SELECT_LATER'), $tag, $repetition->getLocalizedHumanExpression());
        }
      }
    }
    return $this->renderText($summary);
  }
}
