/*!************************************************************************************
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

$(function()
{
	var config = {
		toolbar:
		[
                    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],
                    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
                    ['Link','Unlink','Image','Table','HorizontalRule','SpecialChar', '-', 'Source'],
                    ['Maximize', 'Maximize', 'Maximize', 'Maximize', 'Maximize', 'Maximize'],
                    '/',
                    ['Bold','Italic','Underline','Strike','-'],
                    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                    ['Format','Font','FontSize'],
                    ['TextColor','BGColor']
		],
                height: "400px"
	};
        
        if ($('textarea').css('direction') == 'rtl') {
            config.contentsLangDirection = 'rtl';
        }
        
	// Initialize the editor.
	// Callback function can be passed and executed after full instance creation.
	$('.noteEditor').ckeditor(config);
});


$(document).ready(function() {
  $('a#noteSaveButton').click(function() {
    saveNote();
  });

  $('h1 > a').click(function() {
    if(title = prompt(pc_lang_enter_note_title, getNoteTitle()))
    {
        $('h1#noteTitle a').html(title);
        saveNote();
        $(document).attr('title', pc_lang_note + ': ' + getNoteTitle());
    }
  });

  startAutoSaveNote();
}); // end of $(document).ready

/**
  *
  * @param JQuery taskObject - the <a> link for saving
  */
function saveNote()
{
    maxTitleLength = 128;
    maxContentLength = 50000;

    noteId = getNoteId();
    noteTitle = getNoteTitle();
    noteContent = getNoteContent();
    formObject = $('form#saveNote');

    if(noteTitle.length >=  maxTitleLength)
    {
        alert(sprintf(pc_lang_error_note_title_too_long, maxTitleLength));
    }
    else if(noteContent.length >=  maxContentLength)
    {
        alert(sprintf(pc_lang_error_note_content_too_long, maxContentLength));        
    }
    else
    {
        sendAjaxRequest(formObject.attr('action'),
                        "noteId=" +  noteId +
                                "&noteTitle=" +  prepareForAjaxTransmission(noteTitle) +
                                "&noteContent=" +  prepareForAjaxTransmission(noteContent),
                        pc_lang_success_note_saved,
                        function(savedNoteId) {
                          $('span#noteId').html(savedNoteId);
                          return false;
                        },
                        null);
    }
    
    return false;
}

function autoSaveNote()
{
    if($('#noteAutoSaveOption').is(':checked'))
    {
        saveNote();
    }
}

function startAutoSaveNote()
{
    setInterval('autoSaveNote()', 120000); // every 2 mins
}

function getNoteTitle()
{
    return $('h1#noteTitle a').html();
}

function getNoteId()
{
    return $('span#noteId').html();
}

function getNoteContent()
{
    return $('textarea.noteEditor').val();
}