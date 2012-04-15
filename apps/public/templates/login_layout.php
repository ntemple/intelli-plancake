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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <?php include('_head.php'); ?>
  </head>
  <body id="pc_loginPage">
      
    <div id="pc_content">
      <?php echo $sf_content ?>
    </div>
<?php 
/*      
    <?php if( ($sf_params->get('module') == 'plans') && (PcUserPeer::getLoggedInUser()) ||
            ($sf_params->get('module') == 'registration') || 
            ($sf_params->get('module') == 'customAuth')): ?>
    
    <?php else :?>
        <?php include_component('templateParts', 'footer'); ?>
    <?php endif ?>
*/ ?>

    <?php include_javascripts() ?>  
    <?php if (sfConfig::get('app_ga_enabled')) include('_ga.php'); ?>

  </body>
</html>
