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

var PLANCAKE = PLANCAKE || {};

PLANCAKE.overlayWrapper = null;
PLANCAKE.overlayPanel = null;
PLANCAKE.closeOverlayCallback = null;
PLANCAKE.overflowHidden = null;

PLANCAKE.showOverlay = function (content, closeOverlayCallback, overflowHidden) {
    if ( (overflowHidden === null) || (overflowHidden === undefined)) {
        PLANCAKE.overflowHidden = true;
    } else {
        PLANCAKE.overflowHidden = overflowHidden;
    }
    
    if ( (closeOverlayCallback !== null) && (closeOverlayCallback !== undefined) ) {
        PLANCAKE.closeOverlayCallback = closeOverlayCallback;
    }
    
    if ( !PLANCAKE.overlayWrapper ) PLANCAKE.appendOverlay(content);
    PLANCAKE.overlayWrapper.fadeIn(700);
    
    if (PLANCAKE.overflowHidden) {
        document.body.style.overflow = 'hidden';
    }
}

PLANCAKE.hideOverlay = function () {
    if (PLANCAKE.overlayWrapper)
    {
        PLANCAKE.overlayWrapper.fadeOut(500);
    }
    
    if (PLANCAKE.closeOverlayCallback) {
        PLANCAKE.closeOverlayCallback();
    }
    
    PLANCAKE.overlayWrapper = null;
    
    if (PLANCAKE.overflowHidden) {
        document.body.style.overflow = 'hidden';
    }
}

PLANCAKE.appendOverlay = function (content) {
    $('#overlay').remove();
    PLANCAKE.overlayWrapper = $('<div id="overlay" class="noPrint"></div>').appendTo( $('body') );
    
    PLANCAKE.overlayPanel = $('<div id="overlay-panel"></div>').appendTo( PLANCAKE.overlayWrapper );

    PLANCAKE.overlayPanel.html('<div id="overlay-close"></div>' + content);

    PLANCAKE.attachOverlayEvents();
}

PLANCAKE.attachOverlayEvents = function () {
    $('a.hide-overlay', PLANCAKE.overlayWrapper).click( function(e) {
        e.preventDefault();
        PLANCAKE.hideOverlay();
    });

    $('div#overlay-close').click( function(e) {
        e.preventDefault();
        PLANCAKE.hideOverlay();
    });
}

$(document).keydown(function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    
    if (code == 27) { // ESC
        PLANCAKE.hideOverlay();        
    }
});