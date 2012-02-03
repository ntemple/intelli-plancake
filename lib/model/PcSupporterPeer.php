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

class PcSupporterPeer extends BasePcSupporterPeer
{
    /**
     * It handles the case in which a user that already used a free trial,
     * try to get another free trial (that is not allowed)
     *
     * It also set the pc_user.has_requested_free_trial field
     *
     * @param PcUser $user
     * @param PcSubscriptionType $subscriptionType
     * @param bool $isGift (=false)
     * @param bool $isAutomatic (=false)
     * @param string $paypalTransactionId (='')
     * @return bool - false if a user who requested a free trial tries to get it again, true otherwise
     */
    public static function createOrExtendSupporterAccount(PcUser $user, PcSubscriptionType $subscriptionType,
                                                          $isGift = false, $isAutomatic = false,
                                                          $paypalTransactionId = '')
    {
        if ($subscriptionType->getId() == PcSubscriptionTypePeer::FREE_TRIAL)
        {
            if ($user->getHasRequestedFreeTrial())
            {
                return false;
            }
            else
            {
               $user->setHasRequestedFreeTrial(1)
                    ->save();
            }
        }

        // 3 situations can happen:
        // 1) the user is not an supporter -> we add the record
        // 2) the user is still a supporter -> we extend the subscription from the last day of the current subscription
        // 3) the user used to be a supporter (the record is still in the table) but the subscription has expired -> we
        //    start a new subscription from today

        $startDate = null;
        $today = date("Y-m-d");

        $c = new Criteria();
        $c->add(PcSupporterPeer::USER_ID, $user->getId());
        $supporterAccount = PcSupporterPeer::doSelectOne($c);
        if (! $supporterAccount)
        {
            $supporterAccount = new PcSupporter();
            $supporterAccount->setUserId($user->getId());
            $startDate = $today;
        }
        else
        {
            $supporterAccountExpiryDate = $supporterAccount->getExpiryDate();
            if ($today > $supporterAccountExpiryDate )
            {
                $startDate = $today;
            }
            else
            {
                $startDate = $supporterAccountExpiryDate;
            }
        }

        $newExpiryDateTimestamp = $supporterAccount->getNewExpiryDateAfterSubscription($subscriptionType, $startDate);
        $supporterAccount->setExpiryDate(date("Y-m-d", $newExpiryDateTimestamp))
                         ->save();

        // recording the subscription
        $subscription = new PcSubscription();
        $subscription->setUserId($user->getId())
                     ->setSubscriptionTypeId($subscriptionType->getId())
                     ->setWasGift($isGift)
                     ->setWasAutomatic($isAutomatic)
                     ->setPaypalTransactionId($paypalTransactionId)
                     ->save();

        // sending email
        $email = $user->getEmail();
        $from = sfConfig::get('app_emailAddress_contact');
        $subject = sfConfig::get('app_subscriptionSuccess_emailSubject');
        $body = sfConfig::get('app_subscriptionSuccess_emailBody');
        $replyTo = sfConfig::get('app_emailAddress_director');
        PcUtils::sendEmail($email, $subject, $body, $from, $replyTo);

        // creating task in the Inbox
        $user->addToInbox(__('ACCOUNT_SUBSCRIPTION_INBOX_MESSAGE') . ' ' . $supporterAccount->getExpiryDate('j F Y') . '.');

        return true;
    }
}
