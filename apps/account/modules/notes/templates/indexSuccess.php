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
?>

<?php slot('sel_notes', 'selected') ?>
<?php slot('title', 'Plancake ' . ucfirst(__('ACCOUNT_NOTES_NOTES'))) ?>

<div class="standardContent">

    <a href="<?php echo url_for('@note') ?>" id="newNoteButton" class="btn"><?php echo __('ACCOUNT_NOTES_NEW_NOTE_BTN') ?></a>

    <h2><?php echo ucfirst(__('ACCOUNT_NOTES_NOTES')) ?></h2>

    <br /><br />

    <p>
        <?php if($user->getNotesCount() == 0): ?>
            <?php printf(__('ACCOUNT_NOTES_NO_NOTES_YET'), url_for('@note')); ?>
        <?php else: ?>
            <ul id="notesList">
            <?php foreach($notes as $note): ?>
                <li>
                    <form action="<?php echo url_for('@note_delete') ?>" name="deleteNoteForm_<?php echo $note->getId() ?>">
                        <a class="deleteNote" id="note_<?php echo $note->getId() ?>">
                            <img style="border: 0px" src="/images/delete_icon.png">
                        </a>
                    </form>                    
                    
                    <a href="<?php echo url_for('@note?id=' . $note->getId()) ?>">
                        <?php echo $note->getTitle() ?>
                    </a>
                </li>
            <?php endforeach ?>
            </ul>
        <?php endif ?>
    </p>
</div>
