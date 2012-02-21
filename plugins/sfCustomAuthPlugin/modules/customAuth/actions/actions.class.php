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

/**
 * login actions.
 *
 * @package    sf_sandbox
 * @subpackage login
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class customAuthActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeLogin(sfWebRequest $request)
  {      
    // In theory, an authenticated user shouldn't request this action.
    // But there could be a problem with the forum integration: a user could be logged in
    // on Plancake but logged out on the forum so it is better to be easy and don't
    // uncomment the following
    PcUtils::redirectLoggedInUser($this->getUser(), $this);

    $this->form = new LoginForm(array('return-url' => $request->getParameter('return-url')));

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('login'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('login');
	if ($user = PcUserPeer::isCorrectAuthentication($fields['email'], $fields['password'])) 
	{
	  // WOW : correct authentication...
	  // ...but we still need to check whether the user is awaiting activation
	  if ($user->getAwaitingActivation())
	  {
	    PcWatchdog::alert('Still awaiting activation', 'For the user ' . $user->getId());
	    $this->forward('customAuth', 'stillAwaitingActivation');
	  }
          
          if ($user->getBlocked()) 
          {
              $this->forward('customAuth', 'accountBlocked');
          }
          
	  $loginSuccess = CustomAuth::login($this->getUser(), $user, isset($fields['rememberme']));
	  if ($loginSuccess)
	  {
	    if (isset($fields['return-url']) && (strlen($fields['return-url']) > 0) )
	    {
	      $this->redirect($fields['return-url']);
	    }
	    else // an return url hasn't been set in the form
	    {
                PcUtils::redirectToApp($this);
	    }
	  }
	  else // the user is still locked out because of a brute force attack was detected
 	  {
	    $this->getUser()->setFlash('login_wrong_auth', __('WEBSITE_LOGIN_ACCOUNT_LOCKED_ERROR'));
	  }
	}
	else // wrong authentication
	{
	  $registrationLink = sfContext::getInstance()->getController()->genUrl('@registration');
	  $passwordForgottenLink = sfContext::getInstance()->getController()->genUrl('@forgotten-password');
	  
	  if (! PcUserPeer::emailExist($fields['email']))
	  {
	      $this->getUser()->setFlash('login_wrong_auth', sprintf(__('WEBSITE_LOGIN_EMAIL_NOT_REGISTERED_ERROR'), $registrationLink));
	  }
	  else
	  {
	    if ($isAttack = CustomAuth::checkAgainstBruteForceAttack($fields['email']))
	    {
	      $this->getUser()->setFlash('login_wrong_auth', __('WEBSITE_LOGIN_ACCOUNT_LOCKED_ERROR'));
	    }
	    else
	    {
	      $this->getUser()->setFlash('login_wrong_auth', sprintf(__('WEBSITE_LOGIN_DETAILS_ERROR'), $passwordForgottenLink));
	    }
	  }
	}
      }
    }
  }

  public function executeLogout(sfWebRequest $request)
  {
    CustomAuth::logout($this->getUser());
    $this->redirect(sfContext::getInstance()->getController()->genUrl('@homepage'));
    return sfView::NONE;
  }

  public function executeForgottenPassword(sfWebRequest $request)
  {
    // if the user is authenticated, they shouldn't get here
    PcUtils::redirectLoggedInUser($this->getUser(), $this);

    $this->form = new PasswordForgottenForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('passwordForgotten'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('passwordForgotten');
	$email = $fields['email'];

	if (PcUserPeer::emailExist($email))
	{
	  CustomAuth::sendPasswordForgotten($email);
	  $this->redirect('customAuth/passwordForgottenThankYou');
	}
	else // the email address doesn't actually exist
	{
	  $registrationLink = sfContext::getInstance()->getController()->genUrl('@registration');
	  $forgottenPasswordLink = sfContext::getInstance()->getController()->genUrl('@forgotten-password');

	  // the requested email doesn't exist!
	  $this->getUser()->setFlash('password_forgotten_wrong', sprintf(__('WEBSITE_FORGOTTEN_PSW_EMAIL_ADDRESS_NOT_REGISTERED_ERROR'), $forgottenPasswordLink, $registrationLink));
	}
      }
    }
  }

  public function executePasswordForgottenThankYou(sfWebRequest $request)
  {
  }

  public function executePasswordReset(sfWebRequest $request)
  {
    $token = '';

    if ($request->getParameter('t'))
    {
        $token = $request->getParameter('t');
    }
    else
    {
        $param = $request->getParameter('passwordReset');
        $token = $param['t'];
    }

    $token = trim($token);

    // if the user is authenticated, they shouldn't get here
    PcUtils::redirectLoggedInUser($this->getUser(), $this);

    // Check the token is valid
    $c = new Criteria();
    $c->add(PcPasswordResetTokenPeer::TOKEN, $token, Criteria::EQUAL);
    $entry = PcPasswordResetTokenPeer::doSelectOne($c);
    if (!is_object($entry))
    {
      // the token is not valid
      PcWatchdog::alert('Invalid Password Reset Token', 'This is the token '. $token);      
      $this->forward('customAuth', 'passwordResetInvalidToken');
    }

    $this->form = new PasswordResetForm(array('t' => $token));

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('passwordReset'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('passwordReset');
	$user = CustomAuth::resetPassword($token, $fields['password1']);
	$this->redirect('/' . sfConfig::get('app_accountApp_frontController'));
      }
    }
  }

  public function executePasswordResetInvalidToken(sfWebRequest $request)
  {
  }

  public function executeStillAwaitingActivation(sfWebRequest $request)
  { 
  }

  public function executeOpenIdWrongLogin(sfWebRequest $request)
  {
      $this->inputEmail = $request->getParameter('input_email');
  }
  
  public function executeAccountBlocked(sfWebRequest $request)
  {
      return $this->renderText('This account is blocked. Please <a href="/contact">contact us</a> to unblock it.');
  }
}
