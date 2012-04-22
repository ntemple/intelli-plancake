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

var PLANCAKE = PLANCAKE || {};

PLANCAKE.initTags = function(tags) {
    var i = 0;
    var tagsCounter = tags.length;
    var tag;

    for (i; i<tagsCounter; i++) {
        tag = tags[i];
        PLANCAKE.addTag(tag);   
    }
    
    if (!PLANCAKE.userSettings.isPremium) {
        if (PLANCAKE.tags.length > PLANCAKE.config.maxTagsForFreeAccount) {            
            $('ul#tags li:gt(' + (parseInt(PLANCAKE.config.maxTagsForFreeAccount)-1) + ')').block({
                message: '',
                applyPlatformOpacityRules: false
            })
            .addClass('exceedingAllowance');               
            $('#maxTagsAllowanceAlert').html(sprintf(PLANCAKE.lang.ACCOUNT_ERROR_MAX_TAGS_FOR_FREE_ACCOUNTS, 
                PLANCAKE.config.maxTagsForFreeAccount, PLANCAKE.BASE_URL + '/upgrade')).show();
        }
    }
    
    if (PLANCAKE.isMobile) { // without this, the styling of the tags screen on reloading would be broken
        $('#tags-screen').page();
        $('ul#tags').listview();    
        $('ul#tags').listview('refresh');
    }    
};

/**
 * @param PLANCAKE.Tag tag
 */
PLANCAKE.getHtmlTagObj = function(tag) {
    var htmlForTag = $("<li id='tag_" + tag.id + "'>" +
            '<span class="name">' + PLANCAKE.encodeEntities(tag.name) + '</span>' +
            "</li>");

    if (! PLANCAKE.isMobile) {
        htmlForTag.prepend('<a href="#" class="editTag tagAction">' + PLANCAKE.lang.ACCOUNT_MISC_EDIT + '</a>');
    } else {
        htmlForTag.find('span.name').wrap('<a href="#tasks-screen?type=tag&id=' + tag.id + '" />');
    }

    return htmlForTag;    
}

/**
 * @param PLANCAKE.Tag tag
 * @param bool highlight (=false) 
 */
PLANCAKE.addTag = function (tag, highlight) {
    if ( (highlight === null) || (highlight === undefined) ) {
        highlight = false;
    }  
    
    /**
     * @param PLANCAKE.Tag tag
     */
    function addTagToLayout(tag) {
        var htmlForTag =  PLANCAKE.getHtmlTagObj(tag);

        $("ul#tags").append(htmlForTag);
        if (highlight) {
            $('form#hackToScrollToBottomTag input').focus();
            PLANCAKE.flashBackground(htmlForTag);
        }    
    }
    
    
    if (tag.id) {
        addTagToLayout(tag);    
    } else {
        var ajaxParams = 'op=add&name=' + 
            PLANCAKE.prepareForAjaxTransmission(tag.name);

        PLANCAKE.sendAjaxRequest(PLANCAKE.AJAX_URL_MANAGE_TAGS, 
                                 ajaxParams, PLANCAKE.lang.ACCOUNT_SUCCESS_TAG_ADDED, function(tagFromServer) {

            addTagToLayout(tagFromServer);
        });
    }    
};
