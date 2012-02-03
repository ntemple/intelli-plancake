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

<select name="dueTimeHour" class="dueTimeHour">
    <?php if(! PcUserPeer::getLoggedInUser()->getTimeFormat()): ?>
        <option value=""></option>
        <option value="0">12am</option>
        <option value="1">1am</option>
        <option value="2">2am</option>
        <option value="3">3am</option>
        <option value="4">4am</option>
        <option value="5">5am</option>
        <option value="6">6am</option>
        <option value="7">7am</option>
        <option value="8">8am</option>
        <option value="9">9am</option>
        <option value="10">10am</option>
        <option value="11">11am</option>
        <option value="12">12pm</option>
        <option value="13">1pm</option>
        <option value="14">2pm</option>
        <option value="15">3pm</option>
        <option value="16">4pm</option>
        <option value="17">5pm</option>
        <option value="18">6pm</option>
        <option value="19">7pm</option>
        <option value="20">8pm</option>
        <option value="21">9pm</option>
        <option value="22">10pm</option>
        <option value="23">11pm</option>
    <?php else: ?>
        <option value=""></option>
        <option value="0">00</option>
        <option value="1">01</option>
        <option value="2">02</option>
        <option value="3">03</option>
        <option value="4">04</option>
        <option value="5">05</option>
        <option value="6">06</option>
        <option value="7">07</option>
        <option value="8">08</option>
        <option value="9">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
    <?php endif ?>
</select>


<select name="dueTimeMinute" class="dueTimeMinute">
<option value=""></option>

<?php for($i=0; $i<=59; $i++): ?>
<option value="<?php echo $i ?>"><?php printf('%02d', $i) ?></option>
<?php endfor ?>

</select>