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

class PcImporter
{
    private $xml = null;

    /**
     *
     * @param PcUser $user
     */
    public function __construct(PcUser $user)
    {
        $this->user = $user;
    }

    
    public function import($xml)
    {
        $originalMaxExecutionTime = ini_get('max_execution_time');
        ini_set('max_execution_time', 120);

        proc_nice(1);

        $tagLocalIds = array();
        $listLocalIds = array();


        $newTagIds = array();
        $newListIds = array();
        $newTaskIds = array();
        $newNoteIds = array();


        $tags = $xml->plancake_tasks->tags->tag;

        foreach($tags as $tag)
        {
            $isNewTag = false;

            $tagId = ((int)($tag->id) > 0) ? $tag->id : null;
            $tagLocalId = (int)($tag->localId);
            $tagName = (string)($tag->name);
            $tagSortOrder = (int)($tag->sortOrder);

            $tagObj = null;
            if ($tagId && !in_array($tagId, $newTagIds)) // it would be wrong if we try to edit a newly created object during this import
            {
                $tagObj = PcUsersContextsPeer::retrieveByPK($tagId);
            }
            if ($tagObj)
            {
                if ($tagObj->getUserId() != $this->user->getId())
                {
                    die("Hacking attempt.");
                }
            }
            else
            {
                // tags are unique by name, thus
                // we check whether the tag is already in the instance
                // we are importing the dump to.
                $c = new Criteria();
                $c->add(PcUsersContextsPeer::CONTEXT, $tagName);
                $tagObj = PcUsersContextsPeer::doSelectOne($c);
                if (! is_object($tagObj))
                {
                    $tagObj = new PcUsersContexts();
                    $isNewTag = true;
                }
            }

            $tagObj->setUserId($this->user->getId())
                   ->setContext($tagName)
                   ->setSortOrder($tagSortOrder)
                   ->save();

            $tagLocalIds[$tagLocalId] = $tagObj->getId();

            if ($isNewTag)
            {
                $newTagIds[] = $tagObj->getId();
            }
        }

        $lists = $xml->plancake_tasks->lists->list;

        foreach($lists as $list)
        {
            $isNewList = false;

            $listId = ((int)($list->id) > 0) ? $list->id : null;
            $listLocalId = (int)($list->localId);
            $listName = (string)($list->name);
            $listSortOrder = (int)($list->sortOrder);
            $listIsInbox = ((int)($list->isInbox) == 1 ? true : false);
            $listIsTodo = ((int)($list->isTodo) == 1 ? true : false);
            $listIsHeader = ((int)($list->isHeader) == 1 ? true : false);

            $listObj = null;
            if ($listId && !in_array($listId, $newListIds)) // it would be wrong if we try to edit a newly created object during this import
            {
                $listObj = PcListPeer::retrieveByPK($listId);
            }
            if ($listObj)
            {
                if ($listObj->getCreatorId() != $this->user->getId())
                {
                    die("Hacking attempt.");
                }
            }
            else
            {
                if ($listIsInbox) // we don't want 2 inboxes
                {
                    $listObj = $this->user->getInbox();
                }
                else if ($listIsTodo) // we don't want 2 todo lists
                {
                    $listObj = $this->user->getTodo();
                }
                else
                {
                    $listObj = new PcList();
                    $isNewList = true;
                }
            }

            $listObj->setCreatorId($this->user->getId())
                    ->setTitle($listName)
                    ->setSortOrder($listSortOrder)
                    ->setIsInbox($listIsInbox)
                    ->setIsTodo($listIsTodo)
                    ->setIsHeader($listIsHeader)
                    ->save();

            $listLocalIds[$listLocalId] = $listObj->getId();

            if ($isNewList)
            {
                $newListIds[] = $listObj->getId();
            }
        }

        $tasks = $xml->plancake_tasks->tasks->task;

        foreach($tasks as $task)
        {
            $isNewTask = false;

            $taskId = ((int)($task->id) > 0) ? $task->id : 0;
            $taskListLocalId = (int)($task->listLocalId);
            $taskDescription = (string)($task->description);
            $taskSortOrder = (int)($task->sortOrder);
            $taskDueDate = (string)($task->dueDate);
            $taskDueTime = strlen($task->dueTime) > 0 ? (int)($task->dueTime) : '';
            $taskRepetitionId= (int)($task->repetitionId);
            $taskRepetitionParam= (int)($task->repetitionParam);
            $taskIsStarred = ((int)($task->isStarred) == 1 ? true : false);
            $taskIsCompleted = ((int)($task->isCompleted) == 1 ? true : false);
            $taskIsHeader = ((int)($task->isHeader) == 1 ? true : false);
            $taskIsFromSystem = ((int)($task->isFromSystem) == 1 ? true : false);
            $taskTagLocalIds = (string)($task->tagLocalIds);
            $taskNote = (string)($task->note);

            $taskListId =  $listLocalIds[$taskListLocalId];

            $taskTagIdsArray = array();
            $taskTagLocalIdsArray = PcUtils::explodeWithEmptyInputDetection(',', $taskTagLocalIds);

            foreach($taskTagLocalIdsArray as $id)
            {
                $taskTagIdsArray[] = $tagLocalIds[$id];
            }

            $taskTagIds = '';
            if (count($taskTagIdsArray))
            {
                $taskTagIds = implode(',', $taskTagIdsArray);
            }

            $taskFromDb = null;
            if ($taskId && !in_array($taskId, $newTaskIds)) // it would be wrong if we try to edit a newly created object during this import
            {
                $taskFromDb = PcTaskPeer::retrieveByPK($taskId);
            }
            if (! is_object($taskFromDb))
            {
                // if the task doesn't exist (even if the dump contains a taskId)
                // we want to add it.
                $taskId = 0;
                $isNewTask = true;
            }

            $newTask = PcTaskPeer::createOrEdit($taskDescription, $taskListId, $taskId, $taskTagIds,
                      $taskIsHeader, $taskNote, $taskDueDate, $taskDueTime, $taskIsStarred, $taskRepetitionId, $taskRepetitionParam,
                      0, '', 'd-m-Y', false);

            if ($taskIsCompleted)
            {
                $newTask->setIsCompleted(1);
                $newTask->setCompletedAt($task->completedAt);
                $newTask->save();
            }

            if ($isNewTask)
            {
                $newTaskIds[] = $newTask->getId();
            }

            if (! $taskId) // that was a new task
            {
                $newTask->deleteDirtyEntry();
            }
        }

        $notes = $xml->plancake_notes->notes->note;

        foreach($notes as $note)
        {
            $isNewNote = false;

            $noteId = ((int)($note->id) > 0) ? $note->id : null;
            $noteTitle = (string)($note->title);
            $noteContent = (string)($note->content);

            $noteObj = null;
            if ($noteId && !in_array($noteId, $newNoteIds)) // it would be wrong if we try to edit a newly created object during this import
            {
                $noteObj = PcNotePeer::retrieveByPK($noteId);
            }
            if ($noteObj)
            {
                if ($noteObj->getCreatorId() != $this->user->getId())
                {
                    die("Hacking attempt.");
                }
            }
            else
            {
                $noteObj = new PcNote();
                $isNewNote = true;
            }

            $noteObj->setCreatorId($this->user->getId())
                   ->setTitle($noteTitle)
                   ->setContent($noteContent)
                   ->save();

            if ($isNewNote)
            {
                $newNoteIds[] = $noteObj->getId();
            }
        }

        ini_set('max_execution_time', $originalMaxExecutionTime);
    }
}
