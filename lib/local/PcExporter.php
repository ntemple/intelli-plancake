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

class PcExporter
{
    private $user = 0;

    /**
     *
     * @param PcUser $user
     */
    public function __construct(PcUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return string (XML format)
     */
    public function getXmlString()
    {
        $dump = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";

        $dump .= '<backup version="1" title="Plancake backup" link="http://www.plancake.com">' . "\n";
        $dump .= "\t<plancake_tasks>\n";

        // This Ids are to make the dump more portable:
        // tasks will be related to tags and lists via these "virtual" ids
        $tagLocalIds = array();
        $listLocalIds = array();

        $c = new Criteria();
        $c->add(PcUsersContextsPeer::USER_ID, $this->user->getId(), Criteria::EQUAL);
        $c->addDescendingOrderByColumn(PcUsersContextsPeer::SORT_ORDER);
        $c->addDescendingOrderByColumn(PcUsersContextsPeer::ID);
        $tags = PcUsersContextsPeer::doSelect($c);
        $dump .= "\t\t<tags>\n";
        $localId = 1;
        foreach($tags as $tag)
        {
            $dump .= "\t\t\t<tag>\n";
            $dump .= "\t\t\t\t<localId>{$localId}</localId>\n";
            $dump .= "\t\t\t\t<id>{$tag->getId()}</id>\n";
            $dump .= "\t\t\t\t<name><![CDATA[{$tag->getContext()}]]></name>\n";
            $dump .= "\t\t\t\t<sortOrder>{$tag->getSortOrder()}</sortOrder>\n";
            $dump .= "\t\t\t\t<updatedAt>{$tag->getUpdatedAt()}</updatedAt>\n";
            $dump .= "\t\t\t\t<createdAt>{$tag->getCreatedAt()}</createdAt>\n";
            $dump .= "\t\t\t</tag>\n";

            $tagLocalIds[$tag->getId()] = $localId;

            $localId++;
        }
        $dump .= "\t\t</tags>\n\n";


        $c = new Criteria();
        $c->add(PcListPeer::CREATOR_ID, $this->user->getId(), Criteria::EQUAL);
        $c->addDescendingOrderByColumn(PcListPeer::SORT_ORDER);
        $c->addDescendingOrderByColumn(PcListPeer::ID);
        $lists = PcListPeer::doSelect($c);
        $dump .= "\t\t<lists>\n";
        $localId = 1;
        foreach($lists as $list)
        {
            $listIsInbox = $list->getIsInbox() ? 1 : 0;
            $listIsTodo = $list->getIsTodo() ? 1 : 0;
            $listIsHeader = $list->getIsHeader() ? 1 : 0;

            $dump .= "\t\t\t<list>\n";
            $dump .= "\t\t\t\t<localId>{$localId}</localId>\n";
            $dump .= "\t\t\t\t<id>{$list->getId()}</id>\n";
            $dump .= "\t\t\t\t<name><![CDATA[{$list->getTitle()}]]></name>\n";
            $dump .= "\t\t\t\t<sortOrder>{$list->getSortOrder()}</sortOrder>\n";
            $dump .= "\t\t\t\t<isInbox>{$listIsInbox}</isInbox>\n";
            $dump .= "\t\t\t\t<isTodo>{$listIsTodo}</isTodo>\n";
            $dump .= "\t\t\t\t<isHeader>{$listIsHeader}</isHeader>\n";
            $dump .= "\t\t\t\t<updatedAt>{$list->getUpdatedAt()}</updatedAt>\n";
            $dump .= "\t\t\t\t<createdAt>{$list->getCreatedAt()}</createdAt>\n";
            $dump .= "\t\t\t</list>\n";

            $listLocalIds[$list->getId()] = $localId;

            $localId++;
        }
        $dump .= "\t\t</lists>\n";




        $tasks = $this->user->getTasksByMultipleCriteria();

        $c = new Criteria();
        $c->addJoin(PcTaskPeer::LIST_ID, PcListPeer::ID, Criteria::INNER_JOIN);
        $c->add(PcListPeer::CREATOR_ID, $this->user->getId());
        $c->addDescendingOrderByColumn(PcTaskPeer::LIST_ID);
        $c->addAscendingOrderByColumn(PcTaskPeer::SORT_ORDER);
        $c->addAscendingOrderByColumn(PcTaskPeer::ID);
        $tasks = PcTaskPeer::doSelect($c);

        $dump .= "\t\t<tasks>\n";
        $localId = 1;
        foreach($tasks as $task)
        {
            $taskIsStarred = $task->getIsStarred() ? 1 : 0;
            $taskIsCompleted = $task->getIsCompleted() ? 1 : 0;
            $taskIsHeader = $task->getIsHeader() ? 1 : 0;
            $taskIsFromSystem = $task->getIsFromSystem() ? 1 : 0;

            $taskListId = $task->getListId();
            $taskListLocalId = $listLocalIds[$task->getListId()];
            
            $taskTagIds = $task->getContexts(); // comma separated list of tagIds
            $taskTagIdsArray = PcUtils::explodeWithEmptyInputDetection(',', $taskTagIds);
            $taskTagLocalIdsArray = array();
            foreach($taskTagIdsArray as $id)
            {
                $taskTagLocalIdsArray[] = $tagLocalIds[$id];
            }
            $taskTagLocalIds = implode(',', $taskTagLocalIdsArray);


            $dump .= "\t\t\t<task>\n";

            $dump .= "\t\t\t\t<id>{$task->getId()}</id>\n";
            $dump .= "\t\t\t\t<localId>{$localId}</localId>\n";
            $dump .= "\t\t\t\t<listName><![CDATA[{$task->getList()->getTitle()}]]></listName>\n";
            $dump .= "\t\t\t\t<listLocalId>{$taskListLocalId}</listLocalId>\n";
            $dump .= "\t\t\t\t<description><![CDATA[{$task->getDescription()}]]></description>\n";
            $dump .= "\t\t\t\t<sortOrder>{$list->getSortOrder()}</sortOrder>\n";

            $dump .= "\t\t\t\t<dueDate>{$task->getDueDate()}</dueDate>\n";
            $dump .= "\t\t\t\t<dueTime>{$task->getDueTime()}</dueTime>\n";
            $dump .= "\t\t\t\t<repetitionId>{$task->getRepetitionId()}</repetitionId>\n";
            $dump .= "\t\t\t\t<repetitionParam>{$task->getRepetitionParam()}</repetitionParam>\n";

            $dump .= "\t\t\t\t<isStarred>{$taskIsStarred}</isStarred>\n";
            $dump .= "\t\t\t\t<isCompleted>{$taskIsCompleted}</isCompleted>\n";
            $dump .= "\t\t\t\t<isHeader>{$taskIsHeader}</isHeader>\n";
            $dump .= "\t\t\t\t<isFromSystem>{$taskIsFromSystem}</isFromSystem>\n";
            $dump .= "\t\t\t\t<tagLocalIds>{$taskTagLocalIds}</tagLocalIds>\n";
            $dump .= "\t\t\t\t<note><![CDATA[{$task->getNote()}]]></note>\n";
            $dump .= "\t\t\t\t<completedAt>{$task->getCompletedAt()}</completedAt>\n";

            $dump .= "\t\t\t\t<updatedAt>{$task->getUpdatedAt()}</updatedAt>\n";
            $dump .= "\t\t\t\t<createdAt>{$task->getCreatedAt()}</createdAt>\n";

            $dump .= "\t\t\t</task>\n";
            $localId++;
        }
        $dump .= "\t\t</tasks>\n";



        $dump .= "\t</plancake_tasks>\n";

        $dump .= "\t<plancake_notes>\n";
            $c = new Criteria();
            $c->add(PcNotePeer::CREATOR_ID, $this->user->getId(), Criteria::EQUAL);
            $c->addDescendingOrderByColumn(PcNotePeer::ID);
            $notes = PcNotePeer::doSelect($c);
            $dump .= "\t\t<notes>\n";
            $localId = 1;
            foreach($notes as $note)
            {
                $dump .= "\t\t\t<note>\n";
                $dump .= "\t\t\t\t<localId>{$localId}</localId>\n";
                $dump .= "\t\t\t\t<id>{$note->getId()}</id>\n";
                $dump .= "\t\t\t\t<title><![CDATA[{$note->getTitle()}]]></title>\n";
                $dump .= "\t\t\t\t<content><![CDATA[{$note->getContent()}]]></content>\n";
                $dump .= "\t\t\t\t<updatedAt>{$note->getUpdatedAt()}</updatedAt>\n";
                $dump .= "\t\t\t\t<createdAt>{$note->getCreatedAt()}</createdAt>\n";
                $dump .= "\t\t\t</note>\n";
                $localId++;
            }
            $dump .= "\t\t</notes>\n";
        $dump .= "\t</plancake_notes>";

        $dump .= "\n" . '</backup>';

        return $dump;
    }
}
