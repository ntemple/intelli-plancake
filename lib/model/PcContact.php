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

require 'lib/model/om/BasePcContact.php';


/**
 * Skeleton subclass for representing a row from the 'pc_contact' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PcContact extends BasePcContact {

    /**
     *
     * @param array|null $tagIds 
     */
    public function updateTags($tagIds)
    {
        // first remove all the pre-existing tags
        $c = new Criteria();
        $c->add(PcContactsTagsPeer::CONTACT_ID, $this->getId());
        PcContactsTagsPeer::doDelete($c);

        if (is_array($tagIds))
        {
            foreach($tagIds as $tagId)
            {
                $entry = new PcContactsTags();
                $entry->setContactId($this->getId())
                      ->setPcUser(PcUserPeer::getLoggedInUser())
                      ->setTagId($tagId)
                      ->save();
            }
        }

        return $this;
    }

    public function getTagsString()
    {
        $c = new Criteria();
        $c->add(PcContactsTagsPeer::CONTACT_ID, $this->getId());
        $contactsTags = PcContactsTagsPeer::doSelect($c);

        $tagsString = '';

        foreach ($contactsTags as $contactTags)
        {
            $tag = PcContactTagPeer::retrieveByPK($contactTags->getTagId());
            $tagsString .= "@{$tag->getName()}, ";
        }

        return $tagsString;
    }

    /**
     *
     * @return array of PcContactNote
     */
    public function getNotes()
    {
        $c = new Criteria();
        $c->add(PcContactNotePeer::CONTACT_ID, $this->getId());
        $c->addDescendingOrderByColumn(PcContactNotePeer::CREATED_AT);
        return PcContactNotePeer::doSelect($c);
    }

    /**
     *
     * @param string $note
     */
    public function createNewNote($note)
    {
        $note = trim($note);

        if (strlen($note))
        {
            $noteObj = new PcContactNote();
            $noteObj->setContactId($this->getId())
                    ->setContent($note)
                    ->setPcUser(PcUserPeer::getLoggedInUser())
                    ->save();
        }
    }

    public function __toString()
    {
        $s = $this->getName();

        if (! $s)
        {
            $s = $this->getWebsite();
        }

        if (! $s)
        {
            $s = $this->getLink();
        }

        $s = $this->getId() . ' - ' . $s;

        return $s;
    }

} // PcContact
