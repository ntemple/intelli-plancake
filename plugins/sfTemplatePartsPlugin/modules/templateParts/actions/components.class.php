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

class templatePartsComponents extends sfComponents
{
  // This component is flexible: it detects whether the user is on the forums
  // (i.e.: www.plancake.com/forums). If they are, it adjusts the links in order to have
  // www.plancake.com/login rather than www.plancake.com/forums/login
  public function executeHeader()
  {
    $links = array();
    $controller = sfContext::getInstance()->getController();
    
    $cultureUrlPart = '';
    
    if ($this->getUser()->getCulture() != SfConfig::get('app_site_defaultLang'))
    {
        $cultureUrlPart = 'localized_';
    }

    $links['login'] = $controller->genUrl('@login'); // we don't include cultural Part otherwise the offline support won't work
    // $links['login'] = $controller->genUrl('@' . $cultureUrlPart . 'login');
    $links['registration'] = $controller->genUrl('@' . $cultureUrlPart . 'registration');
    $links['homepage'] = $controller->genUrl('@' . $cultureUrlPart . 'homepage');
    $links['services'] = $controller->genUrl('@' . $cultureUrlPart . 'services');
    $links['contact'] = $controller->genUrl('@' . $cultureUrlPart . 'contact');

    $links['roadmap'] = $controller->genUrl('@roadmap');
    $links['blog'] = $controller->genUrl('@blog_index');

    if (defined('FORUM_ROOT')) // we are on the forum
    {
      foreach($links as $k => $v)
      {
	$links[$k] = substr($v, 7);  // removing the leading '/forums'
      }
    }

    $this->links = $links;
  }

  // This component creates the HTML tag for the public CSS
  // This works well for the integration of the forum (www.plancake.com/forums)
  public function executeCss()
  {
    // this retrieves the filename of the latest public CSS file
    $publicCssFilename = shell_exec('ls -1 -tr '.sfConfig::get('sf_web_dir').'/css/all_public*');
    $publicCssFilename = trim(basename($publicCssFilename));

    $mainHttpHost = PcUtils::mainUrlFromOtherApplication();
    $this->publicCssUrl = 'http://' . $mainHttpHost . '/css/' . $publicCssFilename;
  }

  // It takes the moduleName where it sits as parameter
  public function executeBottomMenu()
  {
    $this->isUserLoggedIn = $this->getUser()->isAuthenticated();
    $this->cultureUrlPart = '';
    if ($this->getUser()->getCulture() != SfConfig::get('app_site_defaultLang'))
    {
        $this->cultureUrlPart = 'localized_';
    }
  }

  public function executeBlogCategoriesSidebar()
  {
    $this->categories = PcBlogCategoryPeer::getUsedCategories();
  }

  public function executeBlogSubscribeSidebar()
  {
    $this->categories = PcBlogCategoryPeer::getUsedCategories();
  }

  public function executeFooter()
  {
      $this->baseUrl = sfConfig::get('app_site_url') . 
              ((sfConfig::get('sf_environment') == 'prod') ? '' : '/') .
              sfConfig::get('app_publicApp_frontController');
      if (defined('PLANCAKE_PUBLIC_RELEASE'))
      {
        $this->baseUrl = 'http://www.plancake.com';
      }
      $userCulture = $this->getUser()->getCulture();

        $this->cultureUrlPart = '';
        if ($userCulture != SfConfig::get('app_site_defaultLang'))
        {
            $this->cultureUrlPart = '/' . $userCulture;
        }
  }

  public function executeSubscriptionContent() 
  {
      $inputDiscountCode = trim($this->getContext()->getRequest()->getParameter('codeForDiscount'));
      $discount = PcPromotionCodePeer::getDiscountByCode($inputDiscountCode, $promotionErrorCode);

      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'USD');
      $this->oneYearUsdSubscription = PcPaypalProductPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'GBP');
      $this->oneYearGbpSubscription = PcPaypalProductPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'EUR');
      $this->oneYearEurSubscription = PcPaypalProductPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'JPY');
      $this->oneYearJpySubscription = PcPaypalProductPeer::doSelectOne($c);
      
      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 2);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'USD');
      $this->threeMonthUsdSubscription = PcPaypalProductPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 2);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'GBP');
      $this->threeMonthGbpSubscription = PcPaypalProductPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 2);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'EUR');
      $this->threeMonthEurSubscription = PcPaypalProductPeer::doSelectOne($c);

      $c = new Criteria();
      $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 2);
      $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'JPY');
      $this->threeMonthJpySubscription = PcPaypalProductPeer::doSelectOne($c);
      
      $c = new Criteria();
      $c->add(PcPaypalProductPeer::ID, 7);
      $this->testSubscription = PcPaypalProductPeer::doSelectOne($c);

      $this->yearlyUsdSaving = ($this->threeMonthUsdSubscription->getItemPrice() * 4) - $this->oneYearUsdSubscription->getItemPrice();
      $this->yearlyGbpSaving = ($this->threeMonthGbpSubscription->getItemPrice() * 4) - $this->oneYearGbpSubscription->getItemPrice();
      $this->yearlyEurSaving = ($this->threeMonthEurSubscription->getItemPrice() * 4) - $this->oneYearEurSubscription->getItemPrice();
      $this->yearlyJpySaving = ($this->threeMonthJpySubscription->getItemPrice() * 4) - $this->oneYearJpySubscription->getItemPrice();
      
      $this->niceExpiryDate = '';
      $this->niceExpiryDateThreeMonthExtended = '';
      $this->niceExpiryDateOneYearExtended = '';
      
      $this->oneYearUsdDiscountedSubscription = null;
      $this->oneYearGbpDiscountedSubscription = null;
      $this->oneYearEurDiscountedSubscription = null;
      $this->oneYearJpyDiscountedSubscription = null;
      
      $loggedInUser = PcUserPeer::getLoggedInUser();
      
      $this->promotionErrorCode = $promotionErrorCode;
      $this->discount = $discount;
      $this->hasDiscountCodeBeenEntered = false;
      if ($inputDiscountCode)
      {
        $this->hasDiscountCodeBeenEntered = true;    
      }
      $this->isDiscountCodeValid = false;
      if ($discount > 0)
      {
        $this->isDiscountCodeValid = true; 
        
        if ($loggedInUser) {
            $loggedInUser->setLastPromotionalCodeInserted($inputDiscountCode)->save();
        }
        
        $c = new Criteria();
        $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
        $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'USD');
        $c->add(PcPaypalProductPeer::DISCOUNT_PERCENTAGE, $discount);
        $this->oneYearUsdDiscountedSubscription = PcPaypalProductPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
        $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'GBP');
        $c->add(PcPaypalProductPeer::DISCOUNT_PERCENTAGE, $discount);        
        $this->oneYearGbpDiscountedSubscription = PcPaypalProductPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
        $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'EUR');
        $c->add(PcPaypalProductPeer::DISCOUNT_PERCENTAGE, $discount);        
        $this->oneYearEurDiscountedSubscription = PcPaypalProductPeer::doSelectOne($c);

        $c = new Criteria();
        $c->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, 3);
        $c->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, 'JPY');
        $c->add(PcPaypalProductPeer::DISCOUNT_PERCENTAGE, $discount);        
        $this->oneYearJpyDiscountedSubscription = PcPaypalProductPeer::doSelectOne($c);
      }

      $this->isSupporter = false;

      if($loggedInUser)
      {
        $this->isSupporter = $loggedInUser->isSupporter();
        $supporterAccount = PcSupporterPeer::retrieveByPK($loggedInUser->getId());

	if ($this->isSupporter)
        {
		$this->niceExpiryDate = $supporterAccount->getExpiryDate('j') . ' ' .
		        PcUtils::fromIndexToMonth($supporterAccount->getExpiryDate('n')) . ' ' .
		        $supporterAccount->getExpiryDate('Y');

		$newExpiryTimestamp = $supporterAccount->getNewExpiryDateAfterSubscription(PcSubscriptionTypePeer::retrieveByPK(2), $supporterAccount->getExpiryDate('Y-m-d'));
		$this->niceExpiryDateThreeMonthExtended =
		     date('j', $newExpiryTimestamp) . ' ' .
		        PcUtils::fromIndexToMonth(date('n', $newExpiryTimestamp)) . ' ' .
		        date('Y', $newExpiryTimestamp);

		$newExpiryTimestamp = $supporterAccount->getNewExpiryDateAfterSubscription(PcSubscriptionTypePeer::retrieveByPK(3), $supporterAccount->getExpiryDate('Y-m-d'));
		$this->niceExpiryDateOneYearExtended =
		     date('j', $newExpiryTimestamp) . ' ' .
		        PcUtils::fromIndexToMonth(date('n', $newExpiryTimestamp)) . ' ' .
		        date('Y', $newExpiryTimestamp);
	}
      }

	$userCulture = $this->getUser()->getCulture();

	$this->cultureUrlPart = '';
	if ($userCulture != SfConfig::get('app_site_defaultLang'))
	{
	    $this->cultureUrlPart = '/' . $userCulture;
	}
        
        $this->isOnRegistration = ($this->getContext()->getRequest()->getParameter('onRegistration') == '1');

    /*
    if ($this->promoCode = $request->getParameter('promoCode'))
    {
        $this->hasPromoCodeBeenSubmitted = true;

        $promoCodeEntry = PcPromotionCodePeer::getValidPromoCodeEntry($this->promoCode);

        if (is_object($promoCodeEntry))
        {
            $this->isPromoCodeValid = true;
            $buttonCode = $promoCodeEntry->getPaypalButtonCode();
            $this->price *= 1 - ($promoCodeEntry->getDiscountPercentage() / 100);
        }
    }
     */	
  } 

}
