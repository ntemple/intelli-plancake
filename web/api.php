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

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('api', 'prod', false);

if (sfConfig::get('app_site_maintenance')) {
    die("<html><head><title>PlanCake</title></head><body><h1>PlanCake.com</h1>Sorry, Plancake is under maintenance. We should be back in minutes, or even seconds.</body></html>");
}

if (! defined('PLANCAKE_PUBLIC_RELEASE'))
{
    $deployConfig = sfDeployConfig::getInstance();
    $prodUrl = $deployConfig->get('prod_url');
    if (strpos($_SERVER['SERVER_NAME'], $prodUrl) !== 0)
    {
      die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
    }
}

sfContext::createInstance($configuration)->dispatch();
