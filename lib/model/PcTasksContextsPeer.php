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

class PcTasksContextsPeer extends BasePcTasksContextsPeer
{
	// Looks up a tag, and if it does not exist, creates it
	// NLT
	public static function lookupTag($contextName) {
		
		$loggedInUser = PcUserPeer::getLoggedInUser();
        $user_id = $loggedInUser->getId();
		
		$c = new Criteria();
		$c->add(PcUsersContextsPeer::CONTEXT, strtolower($contextName));
		$c->add(PcUsersContextsPeer::USER_ID, $user_id);
		$context = PcUsersContextsPeer::doSelectOne($c);
 
		if (!$context) {
			$c = new Criteria();
			$c->addDescendingOrderByColumn(PcUsersContextsPeer::SORT_ORDER);
			$maxSortOrder = PcUsersContextsPeer::doSelectOne($c)->getSortOrder();

			$context = new PcUsersContexts();
			$context->setContext($contextName)
			->setPcUser(PcUserPeer::getLoggedInUser())
			->setSortOrder($maxSortOrder+1)
			->save();

			// {{{
			// this lines to make sure the list details we sent back via AJAX
			// are the ones stored in the database
			$context = PcUsersContextsPeer::retrieveByPk($context->getId());
			// }}}
			 
		}
		
		return $context;
	}
}
