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
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_javascripts() ?>
    <?php    include_stylesheets() ?>
    <style>
        ul#navigation li
        {
            list-style: none;
            float: right;
            border-right: 1px solid black;
            padding-left: 10px;
            padding-right: 10px;
            font-size: 14px;
        }

        ul#navigation li a
        {
            text-decoration: none;
        }

        h2
        {
            clear: both;
        }
    </style>
    
  </head>
  <body>
      <ul id="navigation" style="">
          <li><p><a href="http://<?php echo sfConfig::get('app_site_url') ?>/<?php echo sfConfig::get('app_accountApp_frontController') ?>">Go to account</a></p></li>
          <li><?php echo link_to('Contacts', 'booksContact/index') ?></li>
          <li><?php echo link_to('Books', 'books/index?sort=date&sort_type=desc') ?></li>        
          <li><?php echo link_to('Home', 'dashboard/index') ?></li>  
      </ul>

    <?php echo $sf_content ?>



  </body>
</html>
