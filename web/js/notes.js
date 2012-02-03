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

$(document).ready(function() {
  $('a.deleteNote').click(function() {
    deleteNoteCallback($(this));
  });

  $('ul#notesList > li').mouseover(function() {
    $(this).find('a.deleteNote').show();
  });

  $('ul#notesList > li').mouseout(function() {
    $(this).find('a.deleteNote').hide();
  });
}); // end of $(document).ready

/**
  *
  * @param JQuery taskObject - the <a> link for deletion
  */
function deleteNoteCallback(linkObject)
{
  if (confirm(pc_lang_confirm_msg))
  {
    noteObject = linkObject.parent().parent();
    formObject = linkObject.parent();

    sendAjaxRequest(formObject.attr('action'),
		    "noteLabel=" +  linkObject.attr('id'),
		    pc_lang_success_note_deleted,
		    function() {
		      noteObject.hide('slow');
		      noteObject.remove();
                      return false;
		    },
		    null);
    return false;
  }
}