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

    <ul class="pc_langSelection" id="prefLang">
            <li>
                    <img src="/images/flags/small/<?php echo $preferredLanguage->getId() ?>.png" />
                    &nbsp;<?php echo $preferredLanguage->getName() ?>
                </li>
    </ul>

    <ul class="pc_langSelection" id="allLangs">
        <?php $i = 1 ?>
        <?php foreach($languages as $l): ?>
        <li class="<?php if($i == 1) echo 'selected' ?> <?php if($i == $langCount) echo 'last' ?>">
                <img src="/images/flags/small/<?php echo $l->getId() ?>.png" />
                &nbsp;<?php echo $l->getName() ?>
                <span class="langAbbreviation" style="display: none"><?php echo $l->getId() ?></span>
        </li>
            <?php $i++; ?>
        <?php endforeach ?>

    </ul>