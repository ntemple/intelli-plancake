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

<?php slot('title', ucfirst(__('ACCOUNT_NOTES_NOTE')) . ': ' . $noteTitle) ?>

<div id="noteForm">
    <form id="saveNote" name="saveNote" action="<?php echo url_for('@note_save') ?>" >
        <span id="noteId" class="hidden"><?php echo $note->getId(); ?></span>

        <a id="noteSaveButton" class="btn"><?php echo __('ACCOUNT_MISC_SAVE') ?></a>

        <div id="noteAutoSave"><input type="checkbox" id="noteAutoSaveOption" checked="checked" /> <?php echo __('ACCOUNT_NOTES_AUTOSAVE') ?></div>

        <a href="<?php echo url_for('@notes') ?>"><img src="/images/logo2.png" style="float: left" /></a>
        
        <h1 id="noteTitle"><a href="#"><?php echo $noteTitle ?></a></h1>
        
        <div id="noteSeparator"></div>

        <textarea class="noteEditor" id="editor1" name="noteEditor"><?php echo $note->getContent(); ?></textarea>
    </form>

</div>
