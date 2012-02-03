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
 * settings actions.
 *
 * @package    plancake
 * @subpackage settings
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class settingsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();

    $this->hasApiDetails = false;

    if (is_object($apiDetails = PcApiAppPeer::retrieveByUserId($user->getId())))
    {
        $this->hasApiDetails = true;
        $this->apiDetails = $apiDetails;
    }

    $this->user = $user;

    $this->niceExpiryDate = '';
    if($user->isSupporter())
    {
        $supporter = PcSupporterPeer::retrieveByPK($user->getId());
        $this->niceExpiryDate = $supporter->getExpiryDate('j') . ' ' .
                PcUtils::fromIndexToMonth($supporter->getExpiryDate('n')) . ' ' .
                $supporter->getExpiryDate('Y');
    }
  }

  public function executePassword(sfWebRequest $request)
  {
    $this->form = new EditPasswordForm();
    $fields = array();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('password'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('password');
	$user = PcUserPeer::getLoggedInUser();
	$user->setPassword($fields['password1']);
	$user->save();
	sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetPassword', 'user.set_password', array(
	  'user' => $user,
	  'plainPassword' => $fields['password1']
	)));
	$this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_PASSWORD_RESET_SUCCESS'));
	$this->forward('settings', 'index');
      }
    }
  }

  public function executeEmail(sfWebRequest $request)
  {
    $this->user = PcUserPeer::getLoggedInUser();
    $this->form = new EditEmailForm();
    $fields = array();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('email'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('email');

	if (PcUserPeer::emailExist($fields['email1']))
	{
	  $loginLink = sfContext::getInstance()->getController()->genUrl('@login');
	  $forgottenPasswordLink = sfContext::getInstance()->getController()->genUrl('@forgotten-password');
	  $this->getUser()->setFlash('email_wrong', __('ACCOUNT_SETTINGS_EMAIL_EXISTS_ERROR'));
	}
	else // everything is OK
	{
	  $user = PcUserPeer::getLoggedInUser();

	  // logging this change
	  $emailChange = new PcEmailChangeHistory();
	  $emailChange->setUserId($user->getId());
	  $emailChange->setOldEmail($user->getEmail());
	  $emailChange->setNewEmail($fields['email1']);
	  $emailChange->save();

	  $user->setEmail($fields['email1']);
	  $user->save();
	  sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetEmail', 'user.set_email', array(
	    'user' => $user
	  )));
	  $this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_EMAIL_RESET_SUCCESS'));
	  $this->forward('settings', 'index');
	}
      }
    }
  }

  public function executeDate(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
    $this->form = new EditDateFormatForm(array('format' => $user->getDateFormat(true)));
    $fields = array();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('dateFormat'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('dateFormat');

	$user->setDateFormat($fields['format']);
	$user->save();

	sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetDateFormat', 'user.set_date_format', array(
	  'user' => $user
	)));
	$this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_DATE_FORMAT_SUCCESS'));
	$this->forward('settings', 'index');
      }
    }
    $this->user = $user;
  }


  public function executeTime(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
    $this->form = new EditTimeFormatForm(array('format' => $user->getTimeFormat()));
    $fields = array();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('timeFormat'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('timeFormat');

	$user->setTimeFormat($fields['format']);
	$user->save();

	sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetTimeFormat', 'user.set_time_format', array(
	  'user' => $user
	)));
	$this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_TIME_FORMAT_SUCCESS'));
	$this->forward('settings', 'index');
      }
    }
    $this->user = $user;
  }


  public function executeStartWeek(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
    $this->form = new EditStartWeekForm(array('format' => $user->getWeekStart()));
    $fields = array();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('startWeekFormat'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('startWeekFormat');

	$user->setWeekStart($fields['format']);
	$user->save();

	sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userStartWeek', 'user.set_start_week', array(
	  'user' => $user
	)));
	$this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_FIRST_DOW_SUCCESS'));
	$this->forward('settings', 'index');
      }
    }
    $this->user = $user;
  }

  public function executeEmailReminders(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
    $this->form = new EditEmailRemindersForm(array('emailRemindersEnabled' => $user->getRemindersActive()));
    $fields = array();
    if ($request->isMethod('post'))
    {
      if (!$user->isSupporter())
      {
          $this->redirect('@subscribe?feature=reminders');
      }
        
      $this->form->bind($request->getParameter('emailReminders'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('emailReminders');

	$user->setRemindersActive($fields['emailRemindersEnabled']);
	$user->save();

	$this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_EMAIL_REMINDERS_SUCCESS'));
	$this->forward('settings', 'index');
      }
    }
    $this->user = $user;
  }  
  

  public function executeTimezone(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
// die($user->getTimezoneLabel());
    $this->form = new EditTimezoneForm(array('tz' => $user->getTimezoneLabel(), 'dst_on' => $user->getDstActive()));
    $fields = array();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('timezone'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('timezone');

	$c = new Criteria();
	$c->add(PcTimezonePeer::LABEL, $fields['tz'], Criteria::EQUAL);
	$timezone = PcTimezonePeer::doSelectOne($c);

	$user->setTimezoneId($timezone->getId());
	if (isset($fields['dst_on']) && $fields['dst_on'])
	{
	  $user->setDstActive($fields['dst_on']);
	}
	else
	{
	  $user->setDstActive(false);
	}
	$user->save();

	sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetTimezone', 'user.set_timezone', array(
	  'user' => $user
	)));
	sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetDst', 'user.set_dst', array(
	  'user' => $user
	)));

	$this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_TIMEZONE_SUCCESS'));
	$this->forward('settings', 'index');
      }
    }
    $this->user = $user;
  }

  public function executeAvatar(sfWebRequest $request)
  {
    $this->form = new UploadAvatarForm();

    $user = PcUserPeer::getLoggedInUser();

    $this->isUploaded = false;

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('avatar'), $request->getFiles('avatar'));
      if ($this->form->isValid())
      {
          $file = $this->form->getValue('file');
          
          $extension = $file->getExtension($file->getOriginalExtension());
          $filenameWithNoRandomNorExtension = $user->getForumId() . '_';

          if ($file->getSize() > sfConfig::get('app_avatar_maxSize'))
          {
              die(__('ACCOUNT_SETTINGS_AVATAR_TOO_BIG'));
          }

          $random = PcUtils::generate32CharacterRandomHash();

          // see generate_avatar_markup PunBB function

          $fileFullPathWithNoRandomNorExtension = sfConfig::get('sf_web_dir').'/'.
                                          sfConfig::get('app_avatar_relativeRoot').'/'.
                                          $filenameWithNoRandomNorExtension;

          $fileFullPath = $fileFullPathWithNoRandomNorExtension . $random . $extension;
          $fileFullPathWildcard = $fileFullPathWithNoRandomNorExtension . '*.*';

          // {{{ deleting pre-existing files
          $filesToDelete = glob($fileFullPathWildcard);
          foreach($filesToDelete as $fileToDelete)
          {
              unlink($fileToDelete);
          }
          /// }}}
          
          $file->save($fileFullPath);
          $user->setAvatarRandomSuffix($random)->save();

          // resizing
          $image = new SimpleImage();

          $image_info = getimagesize($fileFullPath);
          $image->load($fileFullPath);
          $image->resize(sfConfig::get('app_avatar_width'), sfConfig::get('app_avatar_height'));
          $image->save($fileFullPath, $image_info[2], 96);

          $this->isUploaded = true;
      }
    }

    $this->hasAvatar = $user->hasAvatar();
    $this->avatarUrl = $user->getAvatarUrl();
  }

  public function executeDeleteAccount(sfWebRequest $request)
  {
    $user = PcUserPeer::getLoggedInUser();
    $this->form = new DeleteAccountForm();
    $reasons = $this->form->getReasons();

    $fields = array();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('deleteAccount'));

      if ($this->form->isValid())
      {
	$fields = $request->getParameter('deleteAccount');

        $message = $reasons[$fields['reason']] . "\n XX \n" . $fields['info'];
        $to = sfConfig::get('app_emailAddress_contact');

        // we need to add a 'random' code otherwise GMail groups all of them together
        $subject = 'Account deletion ' . date('YmdHis');
	PcUtils::sendEmail($to,
			   $subject,
			   $message,
			   $to,
                           PcUserPeer::getLoggedInUser()->getEmail());

        $emailAddressForDeletedAccounts = 'deleted_' . PcUtils::generateRandomString(32) . '@plancake.com';
        $user->setEmail($emailAddressForDeletedAccounts)
             ->save();

        sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent('userSetEmail', 'user.set_email', array(
            'user' => $user
        )));

        CustomAuth::logout($this->getUser());
        $this->redirect(sfContext::getInstance()->getController()->genUrl('@homepage'));
      }
    }
    $this->user = $user;
  }


  public function executeGoogleCalendarIntegration(sfWebRequest $request)
  {
    $deactivate = $request->getParameter('deactivate', 0);
    if ($deactivate)
    {
        PcGoogleCalendarPeer::retrieveByUser(PcUserPeer::getLoggedInUser())->setIsActive(false)->save();
    }
  }

  public function executeLang(sfWebRequest $request)
  {

  }

  public function executeExport(sfWebRequest $request)
  {

  }


  public function executeImport(sfWebRequest $request)
  {
    $this->form = new ImportForm();

    $user = PcUserPeer::getLoggedInUser();

    if (! defined('PLANCAKE_PUBLIC_RELEASE'))
    {
        // checking whether the previous import was earlier than 24Hrs ago
        // We limit this operation bacause is very computation-expensive
        if ($previousImportTimestamp = $user->getLatestImportRequest('U'))
        {
            if ( (time() - $previousImportTimestamp) < 86400)  // the latest import was less than 24Hrs ago
            {
                $this->forward('settings', 'importNotAvailableYet');
            }
        }
    }

    $this->submitted = false;
    $this->xmlError = false;

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('import'), $request->getFiles('import'));
      if ($this->form->isValid())
      {
          $file = $this->form->getValue('file');

          $extension = $file->getExtension($file->getOriginalExtension());

          $fileFullPath = '/tmp/plancake_import_' . $user->getId() . '_' . time('Y-m-d-H-i-s') . $extension;

          try
          {
            $file->save($fileFullPath);

            // parsing file
            $xml = file_get_contents($fileFullPath);
          }
          catch (Exception $e)
          {
             unlink($fileFullPath);
             throw $e;
          }

          unlink($fileFullPath);

          $data = simplexml_load_string($xml);

          if ($data)
          {
            $this->submitted = true;

            $importer = new PcImporter($user);
            $importer->import($data);
            $user->setLatestImportRequest(time())->save();
          }
          else
          {
            $this->xmlError = true;
          }
      }
    }
  }


  public function executeBackupPackage(sfWebRequest $request)
  {
      $user = PcUserPeer::getLoggedInUser();
      $exporter = new PcExporter($user);

      if (! $user->isSupporter())
      {
          // checking whether the previous backup was earlier than 24Hrs ago
          if ($previousBackupTimestamp = $user->getLatestBackupRequest('U'))
          {
            if ( (time() - $previousBackupTimestamp) < 86400)  // the latest backup was less than 24Hrs ago
            {
                $this->forward('settings', 'backupNotAvailableYet');
            }
          }
      }

      $tempZipFile = '/tmp/plancake_backup_' . $user->getId() . '_' . date('YmdHis') . '.zip';

      $zip = new ZipArchive;
      $zip->open($tempZipFile, ZipArchive::CREATE);
      $zip->addFromString("plancake_backup_" .  date('YmdHis') . ".xml", $exporter->getXmlString());
      $zip->close();


        $this->getResponse()->clearHttpHeaders();
        $this->getResponse()->setContentType('application/zip');
        $this->getResponse()->setHttpHeader('Pragma: public', true);
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=' . basename($tempZipFile));
        $this->getResponse()->setHttpHeader('Content-Length', filesize($tempZipFile));
        $this->getResponse()->sendHttpHeaders();

      ob_start();
      readfile($tempZipFile);
      unlink($tempZipFile);

      $user->setLatestBackupRequest(time())->save();

      ob_end_flush();

      return sfView::HEADER_ONLY;
  }

  public function executeBackupNotAvailableYet(sfWebRequest $request)
  {

  }

  public function executeImportNotAvailableYet(sfWebRequest $request)
  {

  }

  public function executeGenerateUserKey(sfWebRequest $request)
  {
    $userId = PcUserPeer::getLoggedInUser()->getId();  
      
    $userKey = PcUserKeyPeer::retrieveByPK($userId);

    if (!is_object($userKey))
    {
        $userKey = new PcUserKey();
        $userKey->setUserId($userId)
                ->setKey(PcUtils::generate32CharacterRandomHash())
                ->save();
    }
    
    $this->getUser()->setFlash('settingSuccess', __('ACCOUNT_SETTINGS_USER_KEY_SUCCESS'));    
    $this->redirect(sfContext::getInstance()->getController()->genUrl('settings/index'));    
  }  
}
