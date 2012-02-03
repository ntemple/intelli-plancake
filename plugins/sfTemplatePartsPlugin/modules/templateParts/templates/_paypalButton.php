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
<?php if(PcUserPeer::getLoggedInUser()): ?>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="margin-top: 5px;">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="custom" value="<?php echo PcUserPeer::getLoggedInUser()->getEmail() ?>">
<input type="hidden" name="hosted_button_id" value="<?php echo $buttonCode ?>">
<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>

<?php endif ?>
