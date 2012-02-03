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

<h3><?php echo __('WEBSITE_FORGOTTEN_PSW_RESET_HEADER') ?></h3>
<?php echo __('WEBSITE_FORGOTTEN_PSW_RESET_INTRO') ?>

<?php if ($sf_user->hasFlash('password_reset_wrong')): ?>
  <div class="pc_errorMessage" id="pc_wrongPasswordReset">
    <?php echo $sf_user->getFlash('password_reset_wrong') ?>
  </div>
<?php endif; ?>

<div id="pc_passwordResetForm">
  <form action="<?php echo url_for('customAuth/passwordReset') ?>" method="post">
    <table>
      <?php echo $form ?>
      <tr>
	<td colspan="2">
	  <input type="submit" value="Reset" />
	</td>
      </tr>
    </table>
  </form>
</div>