<?php

/**
 * Base class that represents a row from the 'pc_user' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcUser extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcUserPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;

	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;

	/**
	 * The value for the encrypted_password field.
	 * @var        string
	 */
	protected $encrypted_password;

	/**
	 * The value for the salt field.
	 * @var        string
	 */
	protected $salt;

	/**
	 * The value for the date_format field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $date_format;

	/**
	 * The value for the time_format field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $time_format;

	/**
	 * The value for the timezone_id field.
	 * @var        int
	 */
	protected $timezone_id;

	/**
	 * The value for the week_start field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $week_start;

	/**
	 * The value for the dst_active field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $dst_active;

	/**
	 * The value for the rememberme_key field.
	 * @var        string
	 */
	protected $rememberme_key;

	/**
	 * The value for the awaiting_activation field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $awaiting_activation;

	/**
	 * The value for the newsletter field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $newsletter;

	/**
	 * The value for the forum_id field.
	 * @var        int
	 */
	protected $forum_id;

	/**
	 * The value for the last_login field.
	 * @var        string
	 */
	protected $last_login;

	/**
	 * The value for the language field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $language;

	/**
	 * The value for the preferred_language field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $preferred_language;

	/**
	 * The value for the ip_address field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $ip_address;

	/**
	 * The value for the has_desktop_app_been_loaded field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $has_desktop_app_been_loaded;

	/**
	 * The value for the has_requested_free_trial field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $has_requested_free_trial;

	/**
	 * The value for the avatar_random_suffix field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $avatar_random_suffix;

	/**
	 * The value for the reminders_active field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $reminders_active;

	/**
	 * The value for the latest_blog_access field.
	 * @var        string
	 */
	protected $latest_blog_access;

	/**
	 * The value for the latest_backup_request field.
	 * @var        string
	 */
	protected $latest_backup_request;

	/**
	 * The value for the latest_import_request field.
	 * @var        string
	 */
	protected $latest_import_request;

	/**
	 * The value for the latest_breaking_news_closed field.
	 * @var        int
	 */
	protected $latest_breaking_news_closed;

	/**
	 * The value for the last_promotional_code_inserted field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $last_promotional_code_inserted;

	/**
	 * The value for the session_entry_point field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $session_entry_point;

	/**
	 * The value for the session_referral field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $session_referral;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * @var        PcTimezone
	 */
	protected $aPcTimezone;

	/**
	 * @var        array PcDirtyTask[] Collection to store aggregation of PcDirtyTask objects.
	 */
	protected $collPcDirtyTasks;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcDirtyTasks.
	 */
	private $lastPcDirtyTaskCriteria = null;

	/**
	 * @var        PcFailedLogins one-to-one related PcFailedLogins object
	 */
	protected $singlePcFailedLogins;

	/**
	 * @var        PcActivationToken one-to-one related PcActivationToken object
	 */
	protected $singlePcActivationToken;

	/**
	 * @var        PcPasswordResetToken one-to-one related PcPasswordResetToken object
	 */
	protected $singlePcPasswordResetToken;

	/**
	 * @var        PcPlancakeEmailAddress one-to-one related PcPlancakeEmailAddress object
	 */
	protected $singlePcPlancakeEmailAddress;

	/**
	 * @var        array PcList[] Collection to store aggregation of PcList objects.
	 */
	protected $collPcLists;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcLists.
	 */
	private $lastPcListCriteria = null;

	/**
	 * @var        array PcUsersLists[] Collection to store aggregation of PcUsersLists objects.
	 */
	protected $collPcUsersListss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcUsersListss.
	 */
	private $lastPcUsersListsCriteria = null;

	/**
	 * @var        array PcEmailChangeHistory[] Collection to store aggregation of PcEmailChangeHistory objects.
	 */
	protected $collPcEmailChangeHistorys;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcEmailChangeHistorys.
	 */
	private $lastPcEmailChangeHistoryCriteria = null;

	/**
	 * @var        array PcUsersContexts[] Collection to store aggregation of PcUsersContexts objects.
	 */
	protected $collPcUsersContextss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcUsersContextss.
	 */
	private $lastPcUsersContextsCriteria = null;

	/**
	 * @var        PcSupporter one-to-one related PcSupporter object
	 */
	protected $singlePcSupporter;

	/**
	 * @var        array PcBlogPost[] Collection to store aggregation of PcBlogPost objects.
	 */
	protected $collPcBlogPosts;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcBlogPosts.
	 */
	private $lastPcBlogPostCriteria = null;

	/**
	 * @var        array PcBlogComment[] Collection to store aggregation of PcBlogComment objects.
	 */
	protected $collPcBlogComments;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcBlogComments.
	 */
	private $lastPcBlogCommentCriteria = null;

	/**
	 * @var        array PcApiApp[] Collection to store aggregation of PcApiApp objects.
	 */
	protected $collPcApiApps;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcApiApps.
	 */
	private $lastPcApiAppCriteria = null;

	/**
	 * @var        array PcApiToken[] Collection to store aggregation of PcApiToken objects.
	 */
	protected $collPcApiTokens;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcApiTokens.
	 */
	private $lastPcApiTokenCriteria = null;

	/**
	 * @var        array PcNote[] Collection to store aggregation of PcNote objects.
	 */
	protected $collPcNotes;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcNotes.
	 */
	private $lastPcNoteCriteria = null;

	/**
	 * @var        array PcSubscription[] Collection to store aggregation of PcSubscription objects.
	 */
	protected $collPcSubscriptions;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcSubscriptions.
	 */
	private $lastPcSubscriptionCriteria = null;

	/**
	 * @var        array PcGoogleCalendar[] Collection to store aggregation of PcGoogleCalendar objects.
	 */
	protected $collPcGoogleCalendars;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcGoogleCalendars.
	 */
	private $lastPcGoogleCalendarCriteria = null;

	/**
	 * @var        PcUserKey one-to-one related PcUserKey object
	 */
	protected $singlePcUserKey;

	/**
	 * @var        array PcContact[] Collection to store aggregation of PcContact objects.
	 */
	protected $collPcContacts;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcContacts.
	 */
	private $lastPcContactCriteria = null;

	/**
	 * @var        array PcContactTag[] Collection to store aggregation of PcContactTag objects.
	 */
	protected $collPcContactTags;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcContactTags.
	 */
	private $lastPcContactTagCriteria = null;

	/**
	 * @var        array PcContactsTags[] Collection to store aggregation of PcContactsTags objects.
	 */
	protected $collPcContactsTagss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcContactsTagss.
	 */
	private $lastPcContactsTagsCriteria = null;

	/**
	 * @var        array PcContactNote[] Collection to store aggregation of PcContactNote objects.
	 */
	protected $collPcContactNotes;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcContactNotes.
	 */
	private $lastPcContactNoteCriteria = null;

	/**
	 * @var        PcHideableHintsSetting one-to-one related PcHideableHintsSetting object
	 */
	protected $singlePcHideableHintsSetting;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'PcUserPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->date_format = 0;
		$this->time_format = 0;
		$this->week_start = 0;
		$this->dst_active = false;
		$this->awaiting_activation = true;
		$this->newsletter = false;
		$this->language = '';
		$this->preferred_language = '';
		$this->ip_address = '';
		$this->has_desktop_app_been_loaded = false;
		$this->has_requested_free_trial = false;
		$this->avatar_random_suffix = '';
		$this->reminders_active = false;
		$this->last_promotional_code_inserted = '';
		$this->session_entry_point = '';
		$this->session_referral = '';
	}

	/**
	 * Initializes internal state of BasePcUser object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [username] column value.
	 * 
	 * @return     string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Get the [email] column value.
	 * 
	 * @return     string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Get the [encrypted_password] column value.
	 * 
	 * @return     string
	 */
	public function getEncryptedPassword()
	{
		return $this->encrypted_password;
	}

	/**
	 * Get the [salt] column value.
	 * for strengthening of password
	 * @return     string
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Get the [date_format] column value.
	 * 0->Y-m-d, 3->d-m-Y, 4->m-d-Y
	 * @return     int
	 */
	public function getDateFormat()
	{
		return $this->date_format;
	}

	/**
	 * Get the [time_format] column value.
	 * 0->5:00pm, 1->17:00
	 * @return     int
	 */
	public function getTimeFormat()
	{
		return $this->time_format;
	}

	/**
	 * Get the [timezone_id] column value.
	 * 
	 * @return     int
	 */
	public function getTimezoneId()
	{
		return $this->timezone_id;
	}

	/**
	 * Get the [week_start] column value.
	 * 0->Sunday, 1->Monday
	 * @return     int
	 */
	public function getWeekStart()
	{
		return $this->week_start;
	}

	/**
	 * Get the [dst_active] column value.
	 * 
	 * @return     boolean
	 */
	public function getDstActive()
	{
		return $this->dst_active;
	}

	/**
	 * Get the [rememberme_key] column value.
	 * 
	 * @return     string
	 */
	public function getRemembermeKey()
	{
		return $this->rememberme_key;
	}

	/**
	 * Get the [awaiting_activation] column value.
	 * 
	 * @return     boolean
	 */
	public function getAwaitingActivation()
	{
		return $this->awaiting_activation;
	}

	/**
	 * Get the [newsletter] column value.
	 * 
	 * @return     boolean
	 */
	public function getNewsletter()
	{
		return $this->newsletter;
	}

	/**
	 * Get the [forum_id] column value.
	 * it's the corresponding id in the forum_users table
	 * @return     int
	 */
	public function getForumId()
	{
		return $this->forum_id;
	}

	/**
	 * Get the [optionally formatted] temporal [last_login] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getLastLogin($format = 'Y-m-d H:i:s')
	{
		if ($this->last_login === null) {
			return null;
		}


		if ($this->last_login === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->last_login);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_login, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [language] column value.
	 * comes from the user agent accept language
	 * @return     string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * Get the [preferred_language] column value.
	 * standard 2-char language abbreviation
	 * @return     string
	 */
	public function getPreferredLanguage()
	{
		return $this->preferred_language;
	}

	/**
	 * Get the [ip_address] column value.
	 * 
	 * @return     string
	 */
	public function getIpAddress()
	{
		return $this->ip_address;
	}

	/**
	 * Get the [has_desktop_app_been_loaded] column value.
	 * 
	 * @return     boolean
	 */
	public function getHasDesktopAppBeenLoaded()
	{
		return $this->has_desktop_app_been_loaded;
	}

	/**
	 * Get the [has_requested_free_trial] column value.
	 * 
	 * @return     boolean
	 */
	public function getHasRequestedFreeTrial()
	{
		return $this->has_requested_free_trial;
	}

	/**
	 * Get the [avatar_random_suffix] column value.
	 * 
	 * @return     string
	 */
	public function getAvatarRandomSuffix()
	{
		return $this->avatar_random_suffix;
	}

	/**
	 * Get the [reminders_active] column value.
	 * 
	 * @return     boolean
	 */
	public function getRemindersActive()
	{
		return $this->reminders_active;
	}

	/**
	 * Get the [optionally formatted] temporal [latest_blog_access] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getLatestBlogAccess($format = 'Y-m-d H:i:s')
	{
		if ($this->latest_blog_access === null) {
			return null;
		}


		if ($this->latest_blog_access === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->latest_blog_access);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->latest_blog_access, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [latest_backup_request] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getLatestBackupRequest($format = 'Y-m-d H:i:s')
	{
		if ($this->latest_backup_request === null) {
			return null;
		}


		if ($this->latest_backup_request === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->latest_backup_request);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->latest_backup_request, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [latest_import_request] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getLatestImportRequest($format = 'Y-m-d H:i:s')
	{
		if ($this->latest_import_request === null) {
			return null;
		}


		if ($this->latest_import_request === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->latest_import_request);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->latest_import_request, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [latest_breaking_news_closed] column value.
	 * 
	 * @return     int
	 */
	public function getLatestBreakingNewsClosed()
	{
		return $this->latest_breaking_news_closed;
	}

	/**
	 * Get the [last_promotional_code_inserted] column value.
	 * the user hasn't necessarily used it
	 * @return     string
	 */
	public function getLastPromotionalCodeInserted()
	{
		return $this->last_promotional_code_inserted;
	}

	/**
	 * Get the [session_entry_point] column value.
	 * 
	 * @return     string
	 */
	public function getSessionEntryPoint()
	{
		return $this->session_entry_point;
	}

	/**
	 * Get the [session_referral] column value.
	 * 
	 * @return     string
	 */
	public function getSessionReferral()
	{
		return $this->session_referral;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcUserPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [username] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setUsername($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = PcUserPeer::USERNAME;
		}

		return $this;
	} // setUsername()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setEmail($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = PcUserPeer::EMAIL;
		}

		return $this;
	} // setEmail()

	/**
	 * Set the value of [encrypted_password] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setEncryptedPassword($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->encrypted_password !== $v) {
			$this->encrypted_password = $v;
			$this->modifiedColumns[] = PcUserPeer::ENCRYPTED_PASSWORD;
		}

		return $this;
	} // setEncryptedPassword()

	/**
	 * Set the value of [salt] column.
	 * for strengthening of password
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setSalt($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->salt !== $v) {
			$this->salt = $v;
			$this->modifiedColumns[] = PcUserPeer::SALT;
		}

		return $this;
	} // setSalt()

	/**
	 * Set the value of [date_format] column.
	 * 0->Y-m-d, 3->d-m-Y, 4->m-d-Y
	 * @param      int $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setDateFormat($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->date_format !== $v || $this->isNew()) {
			$this->date_format = $v;
			$this->modifiedColumns[] = PcUserPeer::DATE_FORMAT;
		}

		return $this;
	} // setDateFormat()

	/**
	 * Set the value of [time_format] column.
	 * 0->5:00pm, 1->17:00
	 * @param      int $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setTimeFormat($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->time_format !== $v || $this->isNew()) {
			$this->time_format = $v;
			$this->modifiedColumns[] = PcUserPeer::TIME_FORMAT;
		}

		return $this;
	} // setTimeFormat()

	/**
	 * Set the value of [timezone_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setTimezoneId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->timezone_id !== $v) {
			$this->timezone_id = $v;
			$this->modifiedColumns[] = PcUserPeer::TIMEZONE_ID;
		}

		if ($this->aPcTimezone !== null && $this->aPcTimezone->getId() !== $v) {
			$this->aPcTimezone = null;
		}

		return $this;
	} // setTimezoneId()

	/**
	 * Set the value of [week_start] column.
	 * 0->Sunday, 1->Monday
	 * @param      int $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setWeekStart($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->week_start !== $v || $this->isNew()) {
			$this->week_start = $v;
			$this->modifiedColumns[] = PcUserPeer::WEEK_START;
		}

		return $this;
	} // setWeekStart()

	/**
	 * Set the value of [dst_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setDstActive($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->dst_active !== $v || $this->isNew()) {
			$this->dst_active = $v;
			$this->modifiedColumns[] = PcUserPeer::DST_ACTIVE;
		}

		return $this;
	} // setDstActive()

	/**
	 * Set the value of [rememberme_key] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setRemembermeKey($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->rememberme_key !== $v) {
			$this->rememberme_key = $v;
			$this->modifiedColumns[] = PcUserPeer::REMEMBERME_KEY;
		}

		return $this;
	} // setRemembermeKey()

	/**
	 * Set the value of [awaiting_activation] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setAwaitingActivation($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->awaiting_activation !== $v || $this->isNew()) {
			$this->awaiting_activation = $v;
			$this->modifiedColumns[] = PcUserPeer::AWAITING_ACTIVATION;
		}

		return $this;
	} // setAwaitingActivation()

	/**
	 * Set the value of [newsletter] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setNewsletter($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->newsletter !== $v || $this->isNew()) {
			$this->newsletter = $v;
			$this->modifiedColumns[] = PcUserPeer::NEWSLETTER;
		}

		return $this;
	} // setNewsletter()

	/**
	 * Set the value of [forum_id] column.
	 * it's the corresponding id in the forum_users table
	 * @param      int $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setForumId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->forum_id !== $v) {
			$this->forum_id = $v;
			$this->modifiedColumns[] = PcUserPeer::FORUM_ID;
		}

		return $this;
	} // setForumId()

	/**
	 * Sets the value of [last_login] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setLastLogin($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->last_login !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->last_login !== null && $tmpDt = new DateTime($this->last_login)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->last_login = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcUserPeer::LAST_LOGIN;
			}
		} // if either are not null

		return $this;
	} // setLastLogin()

	/**
	 * Set the value of [language] column.
	 * comes from the user agent accept language
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setLanguage($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->language !== $v || $this->isNew()) {
			$this->language = $v;
			$this->modifiedColumns[] = PcUserPeer::LANGUAGE;
		}

		return $this;
	} // setLanguage()

	/**
	 * Set the value of [preferred_language] column.
	 * standard 2-char language abbreviation
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setPreferredLanguage($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->preferred_language !== $v || $this->isNew()) {
			$this->preferred_language = $v;
			$this->modifiedColumns[] = PcUserPeer::PREFERRED_LANGUAGE;
		}

		return $this;
	} // setPreferredLanguage()

	/**
	 * Set the value of [ip_address] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setIpAddress($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->ip_address !== $v || $this->isNew()) {
			$this->ip_address = $v;
			$this->modifiedColumns[] = PcUserPeer::IP_ADDRESS;
		}

		return $this;
	} // setIpAddress()

	/**
	 * Set the value of [has_desktop_app_been_loaded] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setHasDesktopAppBeenLoaded($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->has_desktop_app_been_loaded !== $v || $this->isNew()) {
			$this->has_desktop_app_been_loaded = $v;
			$this->modifiedColumns[] = PcUserPeer::HAS_DESKTOP_APP_BEEN_LOADED;
		}

		return $this;
	} // setHasDesktopAppBeenLoaded()

	/**
	 * Set the value of [has_requested_free_trial] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setHasRequestedFreeTrial($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->has_requested_free_trial !== $v || $this->isNew()) {
			$this->has_requested_free_trial = $v;
			$this->modifiedColumns[] = PcUserPeer::HAS_REQUESTED_FREE_TRIAL;
		}

		return $this;
	} // setHasRequestedFreeTrial()

	/**
	 * Set the value of [avatar_random_suffix] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setAvatarRandomSuffix($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->avatar_random_suffix !== $v || $this->isNew()) {
			$this->avatar_random_suffix = $v;
			$this->modifiedColumns[] = PcUserPeer::AVATAR_RANDOM_SUFFIX;
		}

		return $this;
	} // setAvatarRandomSuffix()

	/**
	 * Set the value of [reminders_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setRemindersActive($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->reminders_active !== $v || $this->isNew()) {
			$this->reminders_active = $v;
			$this->modifiedColumns[] = PcUserPeer::REMINDERS_ACTIVE;
		}

		return $this;
	} // setRemindersActive()

	/**
	 * Sets the value of [latest_blog_access] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setLatestBlogAccess($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->latest_blog_access !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->latest_blog_access !== null && $tmpDt = new DateTime($this->latest_blog_access)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->latest_blog_access = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcUserPeer::LATEST_BLOG_ACCESS;
			}
		} // if either are not null

		return $this;
	} // setLatestBlogAccess()

	/**
	 * Sets the value of [latest_backup_request] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setLatestBackupRequest($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->latest_backup_request !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->latest_backup_request !== null && $tmpDt = new DateTime($this->latest_backup_request)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->latest_backup_request = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcUserPeer::LATEST_BACKUP_REQUEST;
			}
		} // if either are not null

		return $this;
	} // setLatestBackupRequest()

	/**
	 * Sets the value of [latest_import_request] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setLatestImportRequest($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->latest_import_request !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->latest_import_request !== null && $tmpDt = new DateTime($this->latest_import_request)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->latest_import_request = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcUserPeer::LATEST_IMPORT_REQUEST;
			}
		} // if either are not null

		return $this;
	} // setLatestImportRequest()

	/**
	 * Set the value of [latest_breaking_news_closed] column.
	 * 
	 * @param      int $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setLatestBreakingNewsClosed($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->latest_breaking_news_closed !== $v) {
			$this->latest_breaking_news_closed = $v;
			$this->modifiedColumns[] = PcUserPeer::LATEST_BREAKING_NEWS_CLOSED;
		}

		return $this;
	} // setLatestBreakingNewsClosed()

	/**
	 * Set the value of [last_promotional_code_inserted] column.
	 * the user hasn't necessarily used it
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setLastPromotionalCodeInserted($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->last_promotional_code_inserted !== $v || $this->isNew()) {
			$this->last_promotional_code_inserted = $v;
			$this->modifiedColumns[] = PcUserPeer::LAST_PROMOTIONAL_CODE_INSERTED;
		}

		return $this;
	} // setLastPromotionalCodeInserted()

	/**
	 * Set the value of [session_entry_point] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setSessionEntryPoint($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->session_entry_point !== $v || $this->isNew()) {
			$this->session_entry_point = $v;
			$this->modifiedColumns[] = PcUserPeer::SESSION_ENTRY_POINT;
		}

		return $this;
	} // setSessionEntryPoint()

	/**
	 * Set the value of [session_referral] column.
	 * 
	 * @param      string $v new value
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setSessionReferral($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->session_referral !== $v || $this->isNew()) {
			$this->session_referral = $v;
			$this->modifiedColumns[] = PcUserPeer::SESSION_REFERRAL;
		}

		return $this;
	} // setSessionReferral()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcUser The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcUserPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->date_format !== 0) {
				return false;
			}

			if ($this->time_format !== 0) {
				return false;
			}

			if ($this->week_start !== 0) {
				return false;
			}

			if ($this->dst_active !== false) {
				return false;
			}

			if ($this->awaiting_activation !== true) {
				return false;
			}

			if ($this->newsletter !== false) {
				return false;
			}

			if ($this->language !== '') {
				return false;
			}

			if ($this->preferred_language !== '') {
				return false;
			}

			if ($this->ip_address !== '') {
				return false;
			}

			if ($this->has_desktop_app_been_loaded !== false) {
				return false;
			}

			if ($this->has_requested_free_trial !== false) {
				return false;
			}

			if ($this->avatar_random_suffix !== '') {
				return false;
			}

			if ($this->reminders_active !== false) {
				return false;
			}

			if ($this->last_promotional_code_inserted !== '') {
				return false;
			}

			if ($this->session_entry_point !== '') {
				return false;
			}

			if ($this->session_referral !== '') {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->username = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->email = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->encrypted_password = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->salt = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->date_format = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->time_format = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->timezone_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->week_start = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->dst_active = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
			$this->rememberme_key = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->awaiting_activation = ($row[$startcol + 11] !== null) ? (boolean) $row[$startcol + 11] : null;
			$this->newsletter = ($row[$startcol + 12] !== null) ? (boolean) $row[$startcol + 12] : null;
			$this->forum_id = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
			$this->last_login = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
			$this->language = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
			$this->preferred_language = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
			$this->ip_address = ($row[$startcol + 17] !== null) ? (string) $row[$startcol + 17] : null;
			$this->has_desktop_app_been_loaded = ($row[$startcol + 18] !== null) ? (boolean) $row[$startcol + 18] : null;
			$this->has_requested_free_trial = ($row[$startcol + 19] !== null) ? (boolean) $row[$startcol + 19] : null;
			$this->avatar_random_suffix = ($row[$startcol + 20] !== null) ? (string) $row[$startcol + 20] : null;
			$this->reminders_active = ($row[$startcol + 21] !== null) ? (boolean) $row[$startcol + 21] : null;
			$this->latest_blog_access = ($row[$startcol + 22] !== null) ? (string) $row[$startcol + 22] : null;
			$this->latest_backup_request = ($row[$startcol + 23] !== null) ? (string) $row[$startcol + 23] : null;
			$this->latest_import_request = ($row[$startcol + 24] !== null) ? (string) $row[$startcol + 24] : null;
			$this->latest_breaking_news_closed = ($row[$startcol + 25] !== null) ? (int) $row[$startcol + 25] : null;
			$this->last_promotional_code_inserted = ($row[$startcol + 26] !== null) ? (string) $row[$startcol + 26] : null;
			$this->session_entry_point = ($row[$startcol + 27] !== null) ? (string) $row[$startcol + 27] : null;
			$this->session_referral = ($row[$startcol + 28] !== null) ? (string) $row[$startcol + 28] : null;
			$this->created_at = ($row[$startcol + 29] !== null) ? (string) $row[$startcol + 29] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 30; // 30 = PcUserPeer::NUM_COLUMNS - PcUserPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcUser object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aPcTimezone !== null && $this->timezone_id !== $this->aPcTimezone->getId()) {
			$this->aPcTimezone = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcUserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcTimezone = null;
			$this->collPcDirtyTasks = null;
			$this->lastPcDirtyTaskCriteria = null;

			$this->singlePcFailedLogins = null;

			$this->singlePcActivationToken = null;

			$this->singlePcPasswordResetToken = null;

			$this->singlePcPlancakeEmailAddress = null;

			$this->collPcLists = null;
			$this->lastPcListCriteria = null;

			$this->collPcUsersListss = null;
			$this->lastPcUsersListsCriteria = null;

			$this->collPcEmailChangeHistorys = null;
			$this->lastPcEmailChangeHistoryCriteria = null;

			$this->collPcUsersContextss = null;
			$this->lastPcUsersContextsCriteria = null;

			$this->singlePcSupporter = null;

			$this->collPcBlogPosts = null;
			$this->lastPcBlogPostCriteria = null;

			$this->collPcBlogComments = null;
			$this->lastPcBlogCommentCriteria = null;

			$this->collPcApiApps = null;
			$this->lastPcApiAppCriteria = null;

			$this->collPcApiTokens = null;
			$this->lastPcApiTokenCriteria = null;

			$this->collPcNotes = null;
			$this->lastPcNoteCriteria = null;

			$this->collPcSubscriptions = null;
			$this->lastPcSubscriptionCriteria = null;

			$this->collPcGoogleCalendars = null;
			$this->lastPcGoogleCalendarCriteria = null;

			$this->singlePcUserKey = null;

			$this->collPcContacts = null;
			$this->lastPcContactCriteria = null;

			$this->collPcContactTags = null;
			$this->lastPcContactTagCriteria = null;

			$this->collPcContactsTagss = null;
			$this->lastPcContactsTagsCriteria = null;

			$this->collPcContactNotes = null;
			$this->lastPcContactNoteCriteria = null;

			$this->singlePcHideableHintsSetting = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcUser:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcUserPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcUser:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcUser:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(PcUserPeer::CREATED_AT))
				{
				  $this->setCreatedAt(time());
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcUser:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcUserPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aPcTimezone !== null) {
				if ($this->aPcTimezone->isModified() || $this->aPcTimezone->isNew()) {
					$affectedRows += $this->aPcTimezone->save($con);
				}
				$this->setPcTimezone($this->aPcTimezone);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PcUserPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcUserPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcUserPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPcDirtyTasks !== null) {
				foreach ($this->collPcDirtyTasks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->singlePcFailedLogins !== null) {
				if (!$this->singlePcFailedLogins->isDeleted()) {
						$affectedRows += $this->singlePcFailedLogins->save($con);
				}
			}

			if ($this->singlePcActivationToken !== null) {
				if (!$this->singlePcActivationToken->isDeleted()) {
						$affectedRows += $this->singlePcActivationToken->save($con);
				}
			}

			if ($this->singlePcPasswordResetToken !== null) {
				if (!$this->singlePcPasswordResetToken->isDeleted()) {
						$affectedRows += $this->singlePcPasswordResetToken->save($con);
				}
			}

			if ($this->singlePcPlancakeEmailAddress !== null) {
				if (!$this->singlePcPlancakeEmailAddress->isDeleted()) {
						$affectedRows += $this->singlePcPlancakeEmailAddress->save($con);
				}
			}

			if ($this->collPcLists !== null) {
				foreach ($this->collPcLists as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcUsersListss !== null) {
				foreach ($this->collPcUsersListss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcEmailChangeHistorys !== null) {
				foreach ($this->collPcEmailChangeHistorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcUsersContextss !== null) {
				foreach ($this->collPcUsersContextss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->singlePcSupporter !== null) {
				if (!$this->singlePcSupporter->isDeleted()) {
						$affectedRows += $this->singlePcSupporter->save($con);
				}
			}

			if ($this->collPcBlogPosts !== null) {
				foreach ($this->collPcBlogPosts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcBlogComments !== null) {
				foreach ($this->collPcBlogComments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcApiApps !== null) {
				foreach ($this->collPcApiApps as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcApiTokens !== null) {
				foreach ($this->collPcApiTokens as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcNotes !== null) {
				foreach ($this->collPcNotes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcSubscriptions !== null) {
				foreach ($this->collPcSubscriptions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcGoogleCalendars !== null) {
				foreach ($this->collPcGoogleCalendars as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->singlePcUserKey !== null) {
				if (!$this->singlePcUserKey->isDeleted()) {
						$affectedRows += $this->singlePcUserKey->save($con);
				}
			}

			if ($this->collPcContacts !== null) {
				foreach ($this->collPcContacts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcContactTags !== null) {
				foreach ($this->collPcContactTags as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcContactsTagss !== null) {
				foreach ($this->collPcContactsTagss as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcContactNotes !== null) {
				foreach ($this->collPcContactNotes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->singlePcHideableHintsSetting !== null) {
				if (!$this->singlePcHideableHintsSetting->isDeleted()) {
						$affectedRows += $this->singlePcHideableHintsSetting->save($con);
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aPcTimezone !== null) {
				if (!$this->aPcTimezone->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcTimezone->getValidationFailures());
				}
			}


			if (($retval = PcUserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPcDirtyTasks !== null) {
					foreach ($this->collPcDirtyTasks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->singlePcFailedLogins !== null) {
					if (!$this->singlePcFailedLogins->validate($columns)) {
						$failureMap = array_merge($failureMap, $this->singlePcFailedLogins->getValidationFailures());
					}
				}

				if ($this->singlePcActivationToken !== null) {
					if (!$this->singlePcActivationToken->validate($columns)) {
						$failureMap = array_merge($failureMap, $this->singlePcActivationToken->getValidationFailures());
					}
				}

				if ($this->singlePcPasswordResetToken !== null) {
					if (!$this->singlePcPasswordResetToken->validate($columns)) {
						$failureMap = array_merge($failureMap, $this->singlePcPasswordResetToken->getValidationFailures());
					}
				}

				if ($this->singlePcPlancakeEmailAddress !== null) {
					if (!$this->singlePcPlancakeEmailAddress->validate($columns)) {
						$failureMap = array_merge($failureMap, $this->singlePcPlancakeEmailAddress->getValidationFailures());
					}
				}

				if ($this->collPcLists !== null) {
					foreach ($this->collPcLists as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcUsersListss !== null) {
					foreach ($this->collPcUsersListss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcEmailChangeHistorys !== null) {
					foreach ($this->collPcEmailChangeHistorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcUsersContextss !== null) {
					foreach ($this->collPcUsersContextss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->singlePcSupporter !== null) {
					if (!$this->singlePcSupporter->validate($columns)) {
						$failureMap = array_merge($failureMap, $this->singlePcSupporter->getValidationFailures());
					}
				}

				if ($this->collPcBlogPosts !== null) {
					foreach ($this->collPcBlogPosts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcBlogComments !== null) {
					foreach ($this->collPcBlogComments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcApiApps !== null) {
					foreach ($this->collPcApiApps as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcApiTokens !== null) {
					foreach ($this->collPcApiTokens as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcNotes !== null) {
					foreach ($this->collPcNotes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcSubscriptions !== null) {
					foreach ($this->collPcSubscriptions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcGoogleCalendars !== null) {
					foreach ($this->collPcGoogleCalendars as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->singlePcUserKey !== null) {
					if (!$this->singlePcUserKey->validate($columns)) {
						$failureMap = array_merge($failureMap, $this->singlePcUserKey->getValidationFailures());
					}
				}

				if ($this->collPcContacts !== null) {
					foreach ($this->collPcContacts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcContactTags !== null) {
					foreach ($this->collPcContactTags as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcContactsTagss !== null) {
					foreach ($this->collPcContactsTagss as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcContactNotes !== null) {
					foreach ($this->collPcContactNotes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->singlePcHideableHintsSetting !== null) {
					if (!$this->singlePcHideableHintsSetting->validate($columns)) {
						$failureMap = array_merge($failureMap, $this->singlePcHideableHintsSetting->getValidationFailures());
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PcUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUsername();
				break;
			case 2:
				return $this->getEmail();
				break;
			case 3:
				return $this->getEncryptedPassword();
				break;
			case 4:
				return $this->getSalt();
				break;
			case 5:
				return $this->getDateFormat();
				break;
			case 6:
				return $this->getTimeFormat();
				break;
			case 7:
				return $this->getTimezoneId();
				break;
			case 8:
				return $this->getWeekStart();
				break;
			case 9:
				return $this->getDstActive();
				break;
			case 10:
				return $this->getRemembermeKey();
				break;
			case 11:
				return $this->getAwaitingActivation();
				break;
			case 12:
				return $this->getNewsletter();
				break;
			case 13:
				return $this->getForumId();
				break;
			case 14:
				return $this->getLastLogin();
				break;
			case 15:
				return $this->getLanguage();
				break;
			case 16:
				return $this->getPreferredLanguage();
				break;
			case 17:
				return $this->getIpAddress();
				break;
			case 18:
				return $this->getHasDesktopAppBeenLoaded();
				break;
			case 19:
				return $this->getHasRequestedFreeTrial();
				break;
			case 20:
				return $this->getAvatarRandomSuffix();
				break;
			case 21:
				return $this->getRemindersActive();
				break;
			case 22:
				return $this->getLatestBlogAccess();
				break;
			case 23:
				return $this->getLatestBackupRequest();
				break;
			case 24:
				return $this->getLatestImportRequest();
				break;
			case 25:
				return $this->getLatestBreakingNewsClosed();
				break;
			case 26:
				return $this->getLastPromotionalCodeInserted();
				break;
			case 27:
				return $this->getSessionEntryPoint();
				break;
			case 28:
				return $this->getSessionReferral();
				break;
			case 29:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = PcUserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getEmail(),
			$keys[3] => $this->getEncryptedPassword(),
			$keys[4] => $this->getSalt(),
			$keys[5] => $this->getDateFormat(),
			$keys[6] => $this->getTimeFormat(),
			$keys[7] => $this->getTimezoneId(),
			$keys[8] => $this->getWeekStart(),
			$keys[9] => $this->getDstActive(),
			$keys[10] => $this->getRemembermeKey(),
			$keys[11] => $this->getAwaitingActivation(),
			$keys[12] => $this->getNewsletter(),
			$keys[13] => $this->getForumId(),
			$keys[14] => $this->getLastLogin(),
			$keys[15] => $this->getLanguage(),
			$keys[16] => $this->getPreferredLanguage(),
			$keys[17] => $this->getIpAddress(),
			$keys[18] => $this->getHasDesktopAppBeenLoaded(),
			$keys[19] => $this->getHasRequestedFreeTrial(),
			$keys[20] => $this->getAvatarRandomSuffix(),
			$keys[21] => $this->getRemindersActive(),
			$keys[22] => $this->getLatestBlogAccess(),
			$keys[23] => $this->getLatestBackupRequest(),
			$keys[24] => $this->getLatestImportRequest(),
			$keys[25] => $this->getLatestBreakingNewsClosed(),
			$keys[26] => $this->getLastPromotionalCodeInserted(),
			$keys[27] => $this->getSessionEntryPoint(),
			$keys[28] => $this->getSessionReferral(),
			$keys[29] => $this->getCreatedAt(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PcUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUsername($value);
				break;
			case 2:
				$this->setEmail($value);
				break;
			case 3:
				$this->setEncryptedPassword($value);
				break;
			case 4:
				$this->setSalt($value);
				break;
			case 5:
				$this->setDateFormat($value);
				break;
			case 6:
				$this->setTimeFormat($value);
				break;
			case 7:
				$this->setTimezoneId($value);
				break;
			case 8:
				$this->setWeekStart($value);
				break;
			case 9:
				$this->setDstActive($value);
				break;
			case 10:
				$this->setRemembermeKey($value);
				break;
			case 11:
				$this->setAwaitingActivation($value);
				break;
			case 12:
				$this->setNewsletter($value);
				break;
			case 13:
				$this->setForumId($value);
				break;
			case 14:
				$this->setLastLogin($value);
				break;
			case 15:
				$this->setLanguage($value);
				break;
			case 16:
				$this->setPreferredLanguage($value);
				break;
			case 17:
				$this->setIpAddress($value);
				break;
			case 18:
				$this->setHasDesktopAppBeenLoaded($value);
				break;
			case 19:
				$this->setHasRequestedFreeTrial($value);
				break;
			case 20:
				$this->setAvatarRandomSuffix($value);
				break;
			case 21:
				$this->setRemindersActive($value);
				break;
			case 22:
				$this->setLatestBlogAccess($value);
				break;
			case 23:
				$this->setLatestBackupRequest($value);
				break;
			case 24:
				$this->setLatestImportRequest($value);
				break;
			case 25:
				$this->setLatestBreakingNewsClosed($value);
				break;
			case 26:
				$this->setLastPromotionalCodeInserted($value);
				break;
			case 27:
				$this->setSessionEntryPoint($value);
				break;
			case 28:
				$this->setSessionReferral($value);
				break;
			case 29:
				$this->setCreatedAt($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PcUserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setEmail($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEncryptedPassword($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSalt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDateFormat($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setTimeFormat($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setTimezoneId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setWeekStart($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDstActive($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setRemembermeKey($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setAwaitingActivation($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setNewsletter($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setForumId($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setLastLogin($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setLanguage($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setPreferredLanguage($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setIpAddress($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setHasDesktopAppBeenLoaded($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setHasRequestedFreeTrial($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setAvatarRandomSuffix($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setRemindersActive($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setLatestBlogAccess($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setLatestBackupRequest($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setLatestImportRequest($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setLatestBreakingNewsClosed($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setLastPromotionalCodeInserted($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setSessionEntryPoint($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setSessionReferral($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setCreatedAt($arr[$keys[29]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcUserPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcUserPeer::ID)) $criteria->add(PcUserPeer::ID, $this->id);
		if ($this->isColumnModified(PcUserPeer::USERNAME)) $criteria->add(PcUserPeer::USERNAME, $this->username);
		if ($this->isColumnModified(PcUserPeer::EMAIL)) $criteria->add(PcUserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(PcUserPeer::ENCRYPTED_PASSWORD)) $criteria->add(PcUserPeer::ENCRYPTED_PASSWORD, $this->encrypted_password);
		if ($this->isColumnModified(PcUserPeer::SALT)) $criteria->add(PcUserPeer::SALT, $this->salt);
		if ($this->isColumnModified(PcUserPeer::DATE_FORMAT)) $criteria->add(PcUserPeer::DATE_FORMAT, $this->date_format);
		if ($this->isColumnModified(PcUserPeer::TIME_FORMAT)) $criteria->add(PcUserPeer::TIME_FORMAT, $this->time_format);
		if ($this->isColumnModified(PcUserPeer::TIMEZONE_ID)) $criteria->add(PcUserPeer::TIMEZONE_ID, $this->timezone_id);
		if ($this->isColumnModified(PcUserPeer::WEEK_START)) $criteria->add(PcUserPeer::WEEK_START, $this->week_start);
		if ($this->isColumnModified(PcUserPeer::DST_ACTIVE)) $criteria->add(PcUserPeer::DST_ACTIVE, $this->dst_active);
		if ($this->isColumnModified(PcUserPeer::REMEMBERME_KEY)) $criteria->add(PcUserPeer::REMEMBERME_KEY, $this->rememberme_key);
		if ($this->isColumnModified(PcUserPeer::AWAITING_ACTIVATION)) $criteria->add(PcUserPeer::AWAITING_ACTIVATION, $this->awaiting_activation);
		if ($this->isColumnModified(PcUserPeer::NEWSLETTER)) $criteria->add(PcUserPeer::NEWSLETTER, $this->newsletter);
		if ($this->isColumnModified(PcUserPeer::FORUM_ID)) $criteria->add(PcUserPeer::FORUM_ID, $this->forum_id);
		if ($this->isColumnModified(PcUserPeer::LAST_LOGIN)) $criteria->add(PcUserPeer::LAST_LOGIN, $this->last_login);
		if ($this->isColumnModified(PcUserPeer::LANGUAGE)) $criteria->add(PcUserPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(PcUserPeer::PREFERRED_LANGUAGE)) $criteria->add(PcUserPeer::PREFERRED_LANGUAGE, $this->preferred_language);
		if ($this->isColumnModified(PcUserPeer::IP_ADDRESS)) $criteria->add(PcUserPeer::IP_ADDRESS, $this->ip_address);
		if ($this->isColumnModified(PcUserPeer::HAS_DESKTOP_APP_BEEN_LOADED)) $criteria->add(PcUserPeer::HAS_DESKTOP_APP_BEEN_LOADED, $this->has_desktop_app_been_loaded);
		if ($this->isColumnModified(PcUserPeer::HAS_REQUESTED_FREE_TRIAL)) $criteria->add(PcUserPeer::HAS_REQUESTED_FREE_TRIAL, $this->has_requested_free_trial);
		if ($this->isColumnModified(PcUserPeer::AVATAR_RANDOM_SUFFIX)) $criteria->add(PcUserPeer::AVATAR_RANDOM_SUFFIX, $this->avatar_random_suffix);
		if ($this->isColumnModified(PcUserPeer::REMINDERS_ACTIVE)) $criteria->add(PcUserPeer::REMINDERS_ACTIVE, $this->reminders_active);
		if ($this->isColumnModified(PcUserPeer::LATEST_BLOG_ACCESS)) $criteria->add(PcUserPeer::LATEST_BLOG_ACCESS, $this->latest_blog_access);
		if ($this->isColumnModified(PcUserPeer::LATEST_BACKUP_REQUEST)) $criteria->add(PcUserPeer::LATEST_BACKUP_REQUEST, $this->latest_backup_request);
		if ($this->isColumnModified(PcUserPeer::LATEST_IMPORT_REQUEST)) $criteria->add(PcUserPeer::LATEST_IMPORT_REQUEST, $this->latest_import_request);
		if ($this->isColumnModified(PcUserPeer::LATEST_BREAKING_NEWS_CLOSED)) $criteria->add(PcUserPeer::LATEST_BREAKING_NEWS_CLOSED, $this->latest_breaking_news_closed);
		if ($this->isColumnModified(PcUserPeer::LAST_PROMOTIONAL_CODE_INSERTED)) $criteria->add(PcUserPeer::LAST_PROMOTIONAL_CODE_INSERTED, $this->last_promotional_code_inserted);
		if ($this->isColumnModified(PcUserPeer::SESSION_ENTRY_POINT)) $criteria->add(PcUserPeer::SESSION_ENTRY_POINT, $this->session_entry_point);
		if ($this->isColumnModified(PcUserPeer::SESSION_REFERRAL)) $criteria->add(PcUserPeer::SESSION_REFERRAL, $this->session_referral);
		if ($this->isColumnModified(PcUserPeer::CREATED_AT)) $criteria->add(PcUserPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PcUserPeer::DATABASE_NAME);

		$criteria->add(PcUserPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of PcUser (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUsername($this->username);

		$copyObj->setEmail($this->email);

		$copyObj->setEncryptedPassword($this->encrypted_password);

		$copyObj->setSalt($this->salt);

		$copyObj->setDateFormat($this->date_format);

		$copyObj->setTimeFormat($this->time_format);

		$copyObj->setTimezoneId($this->timezone_id);

		$copyObj->setWeekStart($this->week_start);

		$copyObj->setDstActive($this->dst_active);

		$copyObj->setRemembermeKey($this->rememberme_key);

		$copyObj->setAwaitingActivation($this->awaiting_activation);

		$copyObj->setNewsletter($this->newsletter);

		$copyObj->setForumId($this->forum_id);

		$copyObj->setLastLogin($this->last_login);

		$copyObj->setLanguage($this->language);

		$copyObj->setPreferredLanguage($this->preferred_language);

		$copyObj->setIpAddress($this->ip_address);

		$copyObj->setHasDesktopAppBeenLoaded($this->has_desktop_app_been_loaded);

		$copyObj->setHasRequestedFreeTrial($this->has_requested_free_trial);

		$copyObj->setAvatarRandomSuffix($this->avatar_random_suffix);

		$copyObj->setRemindersActive($this->reminders_active);

		$copyObj->setLatestBlogAccess($this->latest_blog_access);

		$copyObj->setLatestBackupRequest($this->latest_backup_request);

		$copyObj->setLatestImportRequest($this->latest_import_request);

		$copyObj->setLatestBreakingNewsClosed($this->latest_breaking_news_closed);

		$copyObj->setLastPromotionalCodeInserted($this->last_promotional_code_inserted);

		$copyObj->setSessionEntryPoint($this->session_entry_point);

		$copyObj->setSessionReferral($this->session_referral);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPcDirtyTasks() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcDirtyTask($relObj->copy($deepCopy));
				}
			}

			$relObj = $this->getPcFailedLogins();
			if ($relObj) {
				$copyObj->setPcFailedLogins($relObj->copy($deepCopy));
			}

			$relObj = $this->getPcActivationToken();
			if ($relObj) {
				$copyObj->setPcActivationToken($relObj->copy($deepCopy));
			}

			$relObj = $this->getPcPasswordResetToken();
			if ($relObj) {
				$copyObj->setPcPasswordResetToken($relObj->copy($deepCopy));
			}

			$relObj = $this->getPcPlancakeEmailAddress();
			if ($relObj) {
				$copyObj->setPcPlancakeEmailAddress($relObj->copy($deepCopy));
			}

			foreach ($this->getPcLists() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcList($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcUsersListss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcUsersLists($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcEmailChangeHistorys() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcEmailChangeHistory($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcUsersContextss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcUsersContexts($relObj->copy($deepCopy));
				}
			}

			$relObj = $this->getPcSupporter();
			if ($relObj) {
				$copyObj->setPcSupporter($relObj->copy($deepCopy));
			}

			foreach ($this->getPcBlogPosts() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcBlogPost($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcBlogComments() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcBlogComment($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcApiApps() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcApiApp($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcApiTokens() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcApiToken($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcNotes() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcNote($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcSubscriptions() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcSubscription($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcGoogleCalendars() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcGoogleCalendar($relObj->copy($deepCopy));
				}
			}

			$relObj = $this->getPcUserKey();
			if ($relObj) {
				$copyObj->setPcUserKey($relObj->copy($deepCopy));
			}

			foreach ($this->getPcContacts() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcContact($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcContactTags() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcContactTag($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcContactsTagss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcContactsTags($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcContactNotes() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcContactNote($relObj->copy($deepCopy));
				}
			}

			$relObj = $this->getPcHideableHintsSetting();
			if ($relObj) {
				$copyObj->setPcHideableHintsSetting($relObj->copy($deepCopy));
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     PcUser Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     PcUserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcUserPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcTimezone object.
	 *
	 * @param      PcTimezone $v
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcTimezone(PcTimezone $v = null)
	{
		if ($v === null) {
			$this->setTimezoneId(NULL);
		} else {
			$this->setTimezoneId($v->getId());
		}

		$this->aPcTimezone = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcTimezone object, it will not be re-added.
		if ($v !== null) {
			$v->addPcUser($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcTimezone object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcTimezone The associated PcTimezone object.
	 * @throws     PropelException
	 */
	public function getPcTimezone(PropelPDO $con = null)
	{
		if ($this->aPcTimezone === null && ($this->timezone_id !== null)) {
			$this->aPcTimezone = PcTimezonePeer::retrieveByPk($this->timezone_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcTimezone->addPcUsers($this);
			 */
		}
		return $this->aPcTimezone;
	}

	/**
	 * Clears out the collPcDirtyTasks collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcDirtyTasks()
	 */
	public function clearPcDirtyTasks()
	{
		$this->collPcDirtyTasks = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcDirtyTasks collection (array).
	 *
	 * By default this just sets the collPcDirtyTasks collection to an empty array (like clearcollPcDirtyTasks());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcDirtyTasks()
	{
		$this->collPcDirtyTasks = array();
	}

	/**
	 * Gets an array of PcDirtyTask objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcDirtyTasks from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcDirtyTask[]
	 * @throws     PropelException
	 */
	public function getPcDirtyTasks($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcDirtyTasks === null) {
			if ($this->isNew()) {
			   $this->collPcDirtyTasks = array();
			} else {

				$criteria->add(PcDirtyTaskPeer::USER_ID, $this->id);

				PcDirtyTaskPeer::addSelectColumns($criteria);
				$this->collPcDirtyTasks = PcDirtyTaskPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcDirtyTaskPeer::USER_ID, $this->id);

				PcDirtyTaskPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcDirtyTaskCriteria) || !$this->lastPcDirtyTaskCriteria->equals($criteria)) {
					$this->collPcDirtyTasks = PcDirtyTaskPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcDirtyTaskCriteria = $criteria;
		return $this->collPcDirtyTasks;
	}

	/**
	 * Returns the number of related PcDirtyTask objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcDirtyTask objects.
	 * @throws     PropelException
	 */
	public function countPcDirtyTasks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcDirtyTasks === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcDirtyTaskPeer::USER_ID, $this->id);

				$count = PcDirtyTaskPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcDirtyTaskPeer::USER_ID, $this->id);

				if (!isset($this->lastPcDirtyTaskCriteria) || !$this->lastPcDirtyTaskCriteria->equals($criteria)) {
					$count = PcDirtyTaskPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcDirtyTasks);
				}
			} else {
				$count = count($this->collPcDirtyTasks);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcDirtyTask object to this object
	 * through the PcDirtyTask foreign key attribute.
	 *
	 * @param      PcDirtyTask $l PcDirtyTask
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcDirtyTask(PcDirtyTask $l)
	{
		if ($this->collPcDirtyTasks === null) {
			$this->initPcDirtyTasks();
		}
		if (!in_array($l, $this->collPcDirtyTasks, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcDirtyTasks, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcDirtyTasks from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcDirtyTasksJoinPcTask($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcDirtyTasks === null) {
			if ($this->isNew()) {
				$this->collPcDirtyTasks = array();
			} else {

				$criteria->add(PcDirtyTaskPeer::USER_ID, $this->id);

				$this->collPcDirtyTasks = PcDirtyTaskPeer::doSelectJoinPcTask($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcDirtyTaskPeer::USER_ID, $this->id);

			if (!isset($this->lastPcDirtyTaskCriteria) || !$this->lastPcDirtyTaskCriteria->equals($criteria)) {
				$this->collPcDirtyTasks = PcDirtyTaskPeer::doSelectJoinPcTask($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcDirtyTaskCriteria = $criteria;

		return $this->collPcDirtyTasks;
	}

	/**
	 * Gets a single PcFailedLogins object, which is related to this object by a one-to-one relationship.
	 *
	 * @param      PropelPDO $con
	 * @return     PcFailedLogins
	 * @throws     PropelException
	 */
	public function getPcFailedLogins(PropelPDO $con = null)
	{

		if ($this->singlePcFailedLogins === null && !$this->isNew()) {
			$this->singlePcFailedLogins = PcFailedLoginsPeer::retrieveByPK($this->id, $con);
		}

		return $this->singlePcFailedLogins;
	}

	/**
	 * Sets a single PcFailedLogins object as related to this object by a one-to-one relationship.
	 *
	 * @param      PcFailedLogins $l PcFailedLogins
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcFailedLogins(PcFailedLogins $v)
	{
		$this->singlePcFailedLogins = $v;

		// Make sure that that the passed-in PcFailedLogins isn't already associated with this object
		if ($v->getPcUser() === null) {
			$v->setPcUser($this);
		}

		return $this;
	}

	/**
	 * Gets a single PcActivationToken object, which is related to this object by a one-to-one relationship.
	 *
	 * @param      PropelPDO $con
	 * @return     PcActivationToken
	 * @throws     PropelException
	 */
	public function getPcActivationToken(PropelPDO $con = null)
	{

		if ($this->singlePcActivationToken === null && !$this->isNew()) {
			$this->singlePcActivationToken = PcActivationTokenPeer::retrieveByPK($this->id, $con);
		}

		return $this->singlePcActivationToken;
	}

	/**
	 * Sets a single PcActivationToken object as related to this object by a one-to-one relationship.
	 *
	 * @param      PcActivationToken $l PcActivationToken
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcActivationToken(PcActivationToken $v)
	{
		$this->singlePcActivationToken = $v;

		// Make sure that that the passed-in PcActivationToken isn't already associated with this object
		if ($v->getPcUser() === null) {
			$v->setPcUser($this);
		}

		return $this;
	}

	/**
	 * Gets a single PcPasswordResetToken object, which is related to this object by a one-to-one relationship.
	 *
	 * @param      PropelPDO $con
	 * @return     PcPasswordResetToken
	 * @throws     PropelException
	 */
	public function getPcPasswordResetToken(PropelPDO $con = null)
	{

		if ($this->singlePcPasswordResetToken === null && !$this->isNew()) {
			$this->singlePcPasswordResetToken = PcPasswordResetTokenPeer::retrieveByPK($this->id, $con);
		}

		return $this->singlePcPasswordResetToken;
	}

	/**
	 * Sets a single PcPasswordResetToken object as related to this object by a one-to-one relationship.
	 *
	 * @param      PcPasswordResetToken $l PcPasswordResetToken
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcPasswordResetToken(PcPasswordResetToken $v)
	{
		$this->singlePcPasswordResetToken = $v;

		// Make sure that that the passed-in PcPasswordResetToken isn't already associated with this object
		if ($v->getPcUser() === null) {
			$v->setPcUser($this);
		}

		return $this;
	}

	/**
	 * Gets a single PcPlancakeEmailAddress object, which is related to this object by a one-to-one relationship.
	 *
	 * @param      PropelPDO $con
	 * @return     PcPlancakeEmailAddress
	 * @throws     PropelException
	 */
	public function getPcPlancakeEmailAddress(PropelPDO $con = null)
	{

		if ($this->singlePcPlancakeEmailAddress === null && !$this->isNew()) {
			$this->singlePcPlancakeEmailAddress = PcPlancakeEmailAddressPeer::retrieveByPK($this->id, $con);
		}

		return $this->singlePcPlancakeEmailAddress;
	}

	/**
	 * Sets a single PcPlancakeEmailAddress object as related to this object by a one-to-one relationship.
	 *
	 * @param      PcPlancakeEmailAddress $l PcPlancakeEmailAddress
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcPlancakeEmailAddress(PcPlancakeEmailAddress $v)
	{
		$this->singlePcPlancakeEmailAddress = $v;

		// Make sure that that the passed-in PcPlancakeEmailAddress isn't already associated with this object
		if ($v->getPcUser() === null) {
			$v->setPcUser($this);
		}

		return $this;
	}

	/**
	 * Clears out the collPcLists collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcLists()
	 */
	public function clearPcLists()
	{
		$this->collPcLists = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcLists collection (array).
	 *
	 * By default this just sets the collPcLists collection to an empty array (like clearcollPcLists());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcLists()
	{
		$this->collPcLists = array();
	}

	/**
	 * Gets an array of PcList objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcLists from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcList[]
	 * @throws     PropelException
	 */
	public function getPcLists($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcLists === null) {
			if ($this->isNew()) {
			   $this->collPcLists = array();
			} else {

				$criteria->add(PcListPeer::CREATOR_ID, $this->id);

				PcListPeer::addSelectColumns($criteria);
				$this->collPcLists = PcListPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcListPeer::CREATOR_ID, $this->id);

				PcListPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcListCriteria) || !$this->lastPcListCriteria->equals($criteria)) {
					$this->collPcLists = PcListPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcListCriteria = $criteria;
		return $this->collPcLists;
	}

	/**
	 * Returns the number of related PcList objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcList objects.
	 * @throws     PropelException
	 */
	public function countPcLists(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcLists === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcListPeer::CREATOR_ID, $this->id);

				$count = PcListPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcListPeer::CREATOR_ID, $this->id);

				if (!isset($this->lastPcListCriteria) || !$this->lastPcListCriteria->equals($criteria)) {
					$count = PcListPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcLists);
				}
			} else {
				$count = count($this->collPcLists);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcList object to this object
	 * through the PcList foreign key attribute.
	 *
	 * @param      PcList $l PcList
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcList(PcList $l)
	{
		if ($this->collPcLists === null) {
			$this->initPcLists();
		}
		if (!in_array($l, $this->collPcLists, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcLists, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Clears out the collPcUsersListss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcUsersListss()
	 */
	public function clearPcUsersListss()
	{
		$this->collPcUsersListss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcUsersListss collection (array).
	 *
	 * By default this just sets the collPcUsersListss collection to an empty array (like clearcollPcUsersListss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcUsersListss()
	{
		$this->collPcUsersListss = array();
	}

	/**
	 * Gets an array of PcUsersLists objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcUsersListss from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcUsersLists[]
	 * @throws     PropelException
	 */
	public function getPcUsersListss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcUsersListss === null) {
			if ($this->isNew()) {
			   $this->collPcUsersListss = array();
			} else {

				$criteria->add(PcUsersListsPeer::USER_ID, $this->id);

				PcUsersListsPeer::addSelectColumns($criteria);
				$this->collPcUsersListss = PcUsersListsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcUsersListsPeer::USER_ID, $this->id);

				PcUsersListsPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcUsersListsCriteria) || !$this->lastPcUsersListsCriteria->equals($criteria)) {
					$this->collPcUsersListss = PcUsersListsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcUsersListsCriteria = $criteria;
		return $this->collPcUsersListss;
	}

	/**
	 * Returns the number of related PcUsersLists objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcUsersLists objects.
	 * @throws     PropelException
	 */
	public function countPcUsersListss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcUsersListss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcUsersListsPeer::USER_ID, $this->id);

				$count = PcUsersListsPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcUsersListsPeer::USER_ID, $this->id);

				if (!isset($this->lastPcUsersListsCriteria) || !$this->lastPcUsersListsCriteria->equals($criteria)) {
					$count = PcUsersListsPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcUsersListss);
				}
			} else {
				$count = count($this->collPcUsersListss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcUsersLists object to this object
	 * through the PcUsersLists foreign key attribute.
	 *
	 * @param      PcUsersLists $l PcUsersLists
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcUsersLists(PcUsersLists $l)
	{
		if ($this->collPcUsersListss === null) {
			$this->initPcUsersListss();
		}
		if (!in_array($l, $this->collPcUsersListss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcUsersListss, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcUsersListss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcUsersListssJoinPcList($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcUsersListss === null) {
			if ($this->isNew()) {
				$this->collPcUsersListss = array();
			} else {

				$criteria->add(PcUsersListsPeer::USER_ID, $this->id);

				$this->collPcUsersListss = PcUsersListsPeer::doSelectJoinPcList($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcUsersListsPeer::USER_ID, $this->id);

			if (!isset($this->lastPcUsersListsCriteria) || !$this->lastPcUsersListsCriteria->equals($criteria)) {
				$this->collPcUsersListss = PcUsersListsPeer::doSelectJoinPcList($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcUsersListsCriteria = $criteria;

		return $this->collPcUsersListss;
	}

	/**
	 * Clears out the collPcEmailChangeHistorys collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcEmailChangeHistorys()
	 */
	public function clearPcEmailChangeHistorys()
	{
		$this->collPcEmailChangeHistorys = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcEmailChangeHistorys collection (array).
	 *
	 * By default this just sets the collPcEmailChangeHistorys collection to an empty array (like clearcollPcEmailChangeHistorys());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcEmailChangeHistorys()
	{
		$this->collPcEmailChangeHistorys = array();
	}

	/**
	 * Gets an array of PcEmailChangeHistory objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcEmailChangeHistorys from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcEmailChangeHistory[]
	 * @throws     PropelException
	 */
	public function getPcEmailChangeHistorys($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcEmailChangeHistorys === null) {
			if ($this->isNew()) {
			   $this->collPcEmailChangeHistorys = array();
			} else {

				$criteria->add(PcEmailChangeHistoryPeer::USER_ID, $this->id);

				PcEmailChangeHistoryPeer::addSelectColumns($criteria);
				$this->collPcEmailChangeHistorys = PcEmailChangeHistoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcEmailChangeHistoryPeer::USER_ID, $this->id);

				PcEmailChangeHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcEmailChangeHistoryCriteria) || !$this->lastPcEmailChangeHistoryCriteria->equals($criteria)) {
					$this->collPcEmailChangeHistorys = PcEmailChangeHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcEmailChangeHistoryCriteria = $criteria;
		return $this->collPcEmailChangeHistorys;
	}

	/**
	 * Returns the number of related PcEmailChangeHistory objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcEmailChangeHistory objects.
	 * @throws     PropelException
	 */
	public function countPcEmailChangeHistorys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcEmailChangeHistorys === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcEmailChangeHistoryPeer::USER_ID, $this->id);

				$count = PcEmailChangeHistoryPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcEmailChangeHistoryPeer::USER_ID, $this->id);

				if (!isset($this->lastPcEmailChangeHistoryCriteria) || !$this->lastPcEmailChangeHistoryCriteria->equals($criteria)) {
					$count = PcEmailChangeHistoryPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcEmailChangeHistorys);
				}
			} else {
				$count = count($this->collPcEmailChangeHistorys);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcEmailChangeHistory object to this object
	 * through the PcEmailChangeHistory foreign key attribute.
	 *
	 * @param      PcEmailChangeHistory $l PcEmailChangeHistory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcEmailChangeHistory(PcEmailChangeHistory $l)
	{
		if ($this->collPcEmailChangeHistorys === null) {
			$this->initPcEmailChangeHistorys();
		}
		if (!in_array($l, $this->collPcEmailChangeHistorys, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcEmailChangeHistorys, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Clears out the collPcUsersContextss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcUsersContextss()
	 */
	public function clearPcUsersContextss()
	{
		$this->collPcUsersContextss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcUsersContextss collection (array).
	 *
	 * By default this just sets the collPcUsersContextss collection to an empty array (like clearcollPcUsersContextss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcUsersContextss()
	{
		$this->collPcUsersContextss = array();
	}

	/**
	 * Gets an array of PcUsersContexts objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcUsersContextss from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcUsersContexts[]
	 * @throws     PropelException
	 */
	public function getPcUsersContextss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcUsersContextss === null) {
			if ($this->isNew()) {
			   $this->collPcUsersContextss = array();
			} else {

				$criteria->add(PcUsersContextsPeer::USER_ID, $this->id);

				PcUsersContextsPeer::addSelectColumns($criteria);
				$this->collPcUsersContextss = PcUsersContextsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcUsersContextsPeer::USER_ID, $this->id);

				PcUsersContextsPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcUsersContextsCriteria) || !$this->lastPcUsersContextsCriteria->equals($criteria)) {
					$this->collPcUsersContextss = PcUsersContextsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcUsersContextsCriteria = $criteria;
		return $this->collPcUsersContextss;
	}

	/**
	 * Returns the number of related PcUsersContexts objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcUsersContexts objects.
	 * @throws     PropelException
	 */
	public function countPcUsersContextss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcUsersContextss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcUsersContextsPeer::USER_ID, $this->id);

				$count = PcUsersContextsPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcUsersContextsPeer::USER_ID, $this->id);

				if (!isset($this->lastPcUsersContextsCriteria) || !$this->lastPcUsersContextsCriteria->equals($criteria)) {
					$count = PcUsersContextsPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcUsersContextss);
				}
			} else {
				$count = count($this->collPcUsersContextss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcUsersContexts object to this object
	 * through the PcUsersContexts foreign key attribute.
	 *
	 * @param      PcUsersContexts $l PcUsersContexts
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcUsersContexts(PcUsersContexts $l)
	{
		if ($this->collPcUsersContextss === null) {
			$this->initPcUsersContextss();
		}
		if (!in_array($l, $this->collPcUsersContextss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcUsersContextss, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Gets a single PcSupporter object, which is related to this object by a one-to-one relationship.
	 *
	 * @param      PropelPDO $con
	 * @return     PcSupporter
	 * @throws     PropelException
	 */
	public function getPcSupporter(PropelPDO $con = null)
	{

		if ($this->singlePcSupporter === null && !$this->isNew()) {
			$this->singlePcSupporter = PcSupporterPeer::retrieveByPK($this->id, $con);
		}

		return $this->singlePcSupporter;
	}

	/**
	 * Sets a single PcSupporter object as related to this object by a one-to-one relationship.
	 *
	 * @param      PcSupporter $l PcSupporter
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcSupporter(PcSupporter $v)
	{
		$this->singlePcSupporter = $v;

		// Make sure that that the passed-in PcSupporter isn't already associated with this object
		if ($v->getPcUser() === null) {
			$v->setPcUser($this);
		}

		return $this;
	}

	/**
	 * Clears out the collPcBlogPosts collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcBlogPosts()
	 */
	public function clearPcBlogPosts()
	{
		$this->collPcBlogPosts = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcBlogPosts collection (array).
	 *
	 * By default this just sets the collPcBlogPosts collection to an empty array (like clearcollPcBlogPosts());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcBlogPosts()
	{
		$this->collPcBlogPosts = array();
	}

	/**
	 * Gets an array of PcBlogPost objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcBlogPosts from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcBlogPost[]
	 * @throws     PropelException
	 */
	public function getPcBlogPosts($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcBlogPosts === null) {
			if ($this->isNew()) {
			   $this->collPcBlogPosts = array();
			} else {

				$criteria->add(PcBlogPostPeer::USER_ID, $this->id);

				PcBlogPostPeer::addSelectColumns($criteria);
				$this->collPcBlogPosts = PcBlogPostPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcBlogPostPeer::USER_ID, $this->id);

				PcBlogPostPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcBlogPostCriteria) || !$this->lastPcBlogPostCriteria->equals($criteria)) {
					$this->collPcBlogPosts = PcBlogPostPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcBlogPostCriteria = $criteria;
		return $this->collPcBlogPosts;
	}

	/**
	 * Returns the number of related PcBlogPost objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcBlogPost objects.
	 * @throws     PropelException
	 */
	public function countPcBlogPosts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcBlogPosts === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcBlogPostPeer::USER_ID, $this->id);

				$count = PcBlogPostPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcBlogPostPeer::USER_ID, $this->id);

				if (!isset($this->lastPcBlogPostCriteria) || !$this->lastPcBlogPostCriteria->equals($criteria)) {
					$count = PcBlogPostPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcBlogPosts);
				}
			} else {
				$count = count($this->collPcBlogPosts);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcBlogPost object to this object
	 * through the PcBlogPost foreign key attribute.
	 *
	 * @param      PcBlogPost $l PcBlogPost
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcBlogPost(PcBlogPost $l)
	{
		if ($this->collPcBlogPosts === null) {
			$this->initPcBlogPosts();
		}
		if (!in_array($l, $this->collPcBlogPosts, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcBlogPosts, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Clears out the collPcBlogComments collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcBlogComments()
	 */
	public function clearPcBlogComments()
	{
		$this->collPcBlogComments = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcBlogComments collection (array).
	 *
	 * By default this just sets the collPcBlogComments collection to an empty array (like clearcollPcBlogComments());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcBlogComments()
	{
		$this->collPcBlogComments = array();
	}

	/**
	 * Gets an array of PcBlogComment objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcBlogComments from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcBlogComment[]
	 * @throws     PropelException
	 */
	public function getPcBlogComments($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcBlogComments === null) {
			if ($this->isNew()) {
			   $this->collPcBlogComments = array();
			} else {

				$criteria->add(PcBlogCommentPeer::USER_ID, $this->id);

				PcBlogCommentPeer::addSelectColumns($criteria);
				$this->collPcBlogComments = PcBlogCommentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcBlogCommentPeer::USER_ID, $this->id);

				PcBlogCommentPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcBlogCommentCriteria) || !$this->lastPcBlogCommentCriteria->equals($criteria)) {
					$this->collPcBlogComments = PcBlogCommentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcBlogCommentCriteria = $criteria;
		return $this->collPcBlogComments;
	}

	/**
	 * Returns the number of related PcBlogComment objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcBlogComment objects.
	 * @throws     PropelException
	 */
	public function countPcBlogComments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcBlogComments === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcBlogCommentPeer::USER_ID, $this->id);

				$count = PcBlogCommentPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcBlogCommentPeer::USER_ID, $this->id);

				if (!isset($this->lastPcBlogCommentCriteria) || !$this->lastPcBlogCommentCriteria->equals($criteria)) {
					$count = PcBlogCommentPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcBlogComments);
				}
			} else {
				$count = count($this->collPcBlogComments);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcBlogComment object to this object
	 * through the PcBlogComment foreign key attribute.
	 *
	 * @param      PcBlogComment $l PcBlogComment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcBlogComment(PcBlogComment $l)
	{
		if ($this->collPcBlogComments === null) {
			$this->initPcBlogComments();
		}
		if (!in_array($l, $this->collPcBlogComments, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcBlogComments, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcBlogComments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcBlogCommentsJoinPcBlogPost($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcBlogComments === null) {
			if ($this->isNew()) {
				$this->collPcBlogComments = array();
			} else {

				$criteria->add(PcBlogCommentPeer::USER_ID, $this->id);

				$this->collPcBlogComments = PcBlogCommentPeer::doSelectJoinPcBlogPost($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcBlogCommentPeer::USER_ID, $this->id);

			if (!isset($this->lastPcBlogCommentCriteria) || !$this->lastPcBlogCommentCriteria->equals($criteria)) {
				$this->collPcBlogComments = PcBlogCommentPeer::doSelectJoinPcBlogPost($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcBlogCommentCriteria = $criteria;

		return $this->collPcBlogComments;
	}

	/**
	 * Clears out the collPcApiApps collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcApiApps()
	 */
	public function clearPcApiApps()
	{
		$this->collPcApiApps = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcApiApps collection (array).
	 *
	 * By default this just sets the collPcApiApps collection to an empty array (like clearcollPcApiApps());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcApiApps()
	{
		$this->collPcApiApps = array();
	}

	/**
	 * Gets an array of PcApiApp objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcApiApps from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcApiApp[]
	 * @throws     PropelException
	 */
	public function getPcApiApps($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcApiApps === null) {
			if ($this->isNew()) {
			   $this->collPcApiApps = array();
			} else {

				$criteria->add(PcApiAppPeer::USER_ID, $this->id);

				PcApiAppPeer::addSelectColumns($criteria);
				$this->collPcApiApps = PcApiAppPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcApiAppPeer::USER_ID, $this->id);

				PcApiAppPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcApiAppCriteria) || !$this->lastPcApiAppCriteria->equals($criteria)) {
					$this->collPcApiApps = PcApiAppPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcApiAppCriteria = $criteria;
		return $this->collPcApiApps;
	}

	/**
	 * Returns the number of related PcApiApp objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcApiApp objects.
	 * @throws     PropelException
	 */
	public function countPcApiApps(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcApiApps === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcApiAppPeer::USER_ID, $this->id);

				$count = PcApiAppPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcApiAppPeer::USER_ID, $this->id);

				if (!isset($this->lastPcApiAppCriteria) || !$this->lastPcApiAppCriteria->equals($criteria)) {
					$count = PcApiAppPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcApiApps);
				}
			} else {
				$count = count($this->collPcApiApps);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcApiApp object to this object
	 * through the PcApiApp foreign key attribute.
	 *
	 * @param      PcApiApp $l PcApiApp
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcApiApp(PcApiApp $l)
	{
		if ($this->collPcApiApps === null) {
			$this->initPcApiApps();
		}
		if (!in_array($l, $this->collPcApiApps, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcApiApps, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Clears out the collPcApiTokens collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcApiTokens()
	 */
	public function clearPcApiTokens()
	{
		$this->collPcApiTokens = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcApiTokens collection (array).
	 *
	 * By default this just sets the collPcApiTokens collection to an empty array (like clearcollPcApiTokens());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcApiTokens()
	{
		$this->collPcApiTokens = array();
	}

	/**
	 * Gets an array of PcApiToken objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcApiTokens from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcApiToken[]
	 * @throws     PropelException
	 */
	public function getPcApiTokens($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcApiTokens === null) {
			if ($this->isNew()) {
			   $this->collPcApiTokens = array();
			} else {

				$criteria->add(PcApiTokenPeer::USER_ID, $this->id);

				PcApiTokenPeer::addSelectColumns($criteria);
				$this->collPcApiTokens = PcApiTokenPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcApiTokenPeer::USER_ID, $this->id);

				PcApiTokenPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcApiTokenCriteria) || !$this->lastPcApiTokenCriteria->equals($criteria)) {
					$this->collPcApiTokens = PcApiTokenPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcApiTokenCriteria = $criteria;
		return $this->collPcApiTokens;
	}

	/**
	 * Returns the number of related PcApiToken objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcApiToken objects.
	 * @throws     PropelException
	 */
	public function countPcApiTokens(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcApiTokens === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcApiTokenPeer::USER_ID, $this->id);

				$count = PcApiTokenPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcApiTokenPeer::USER_ID, $this->id);

				if (!isset($this->lastPcApiTokenCriteria) || !$this->lastPcApiTokenCriteria->equals($criteria)) {
					$count = PcApiTokenPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcApiTokens);
				}
			} else {
				$count = count($this->collPcApiTokens);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcApiToken object to this object
	 * through the PcApiToken foreign key attribute.
	 *
	 * @param      PcApiToken $l PcApiToken
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcApiToken(PcApiToken $l)
	{
		if ($this->collPcApiTokens === null) {
			$this->initPcApiTokens();
		}
		if (!in_array($l, $this->collPcApiTokens, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcApiTokens, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcApiTokens from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcApiTokensJoinPcApiApp($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcApiTokens === null) {
			if ($this->isNew()) {
				$this->collPcApiTokens = array();
			} else {

				$criteria->add(PcApiTokenPeer::USER_ID, $this->id);

				$this->collPcApiTokens = PcApiTokenPeer::doSelectJoinPcApiApp($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcApiTokenPeer::USER_ID, $this->id);

			if (!isset($this->lastPcApiTokenCriteria) || !$this->lastPcApiTokenCriteria->equals($criteria)) {
				$this->collPcApiTokens = PcApiTokenPeer::doSelectJoinPcApiApp($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcApiTokenCriteria = $criteria;

		return $this->collPcApiTokens;
	}

	/**
	 * Clears out the collPcNotes collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcNotes()
	 */
	public function clearPcNotes()
	{
		$this->collPcNotes = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcNotes collection (array).
	 *
	 * By default this just sets the collPcNotes collection to an empty array (like clearcollPcNotes());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcNotes()
	{
		$this->collPcNotes = array();
	}

	/**
	 * Gets an array of PcNote objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcNotes from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcNote[]
	 * @throws     PropelException
	 */
	public function getPcNotes($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcNotes === null) {
			if ($this->isNew()) {
			   $this->collPcNotes = array();
			} else {

				$criteria->add(PcNotePeer::CREATOR_ID, $this->id);

				PcNotePeer::addSelectColumns($criteria);
				$this->collPcNotes = PcNotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcNotePeer::CREATOR_ID, $this->id);

				PcNotePeer::addSelectColumns($criteria);
				if (!isset($this->lastPcNoteCriteria) || !$this->lastPcNoteCriteria->equals($criteria)) {
					$this->collPcNotes = PcNotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcNoteCriteria = $criteria;
		return $this->collPcNotes;
	}

	/**
	 * Returns the number of related PcNote objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcNote objects.
	 * @throws     PropelException
	 */
	public function countPcNotes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcNotes === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcNotePeer::CREATOR_ID, $this->id);

				$count = PcNotePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcNotePeer::CREATOR_ID, $this->id);

				if (!isset($this->lastPcNoteCriteria) || !$this->lastPcNoteCriteria->equals($criteria)) {
					$count = PcNotePeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcNotes);
				}
			} else {
				$count = count($this->collPcNotes);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcNote object to this object
	 * through the PcNote foreign key attribute.
	 *
	 * @param      PcNote $l PcNote
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcNote(PcNote $l)
	{
		if ($this->collPcNotes === null) {
			$this->initPcNotes();
		}
		if (!in_array($l, $this->collPcNotes, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcNotes, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Clears out the collPcSubscriptions collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcSubscriptions()
	 */
	public function clearPcSubscriptions()
	{
		$this->collPcSubscriptions = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcSubscriptions collection (array).
	 *
	 * By default this just sets the collPcSubscriptions collection to an empty array (like clearcollPcSubscriptions());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcSubscriptions()
	{
		$this->collPcSubscriptions = array();
	}

	/**
	 * Gets an array of PcSubscription objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcSubscriptions from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcSubscription[]
	 * @throws     PropelException
	 */
	public function getPcSubscriptions($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcSubscriptions === null) {
			if ($this->isNew()) {
			   $this->collPcSubscriptions = array();
			} else {

				$criteria->add(PcSubscriptionPeer::USER_ID, $this->id);

				PcSubscriptionPeer::addSelectColumns($criteria);
				$this->collPcSubscriptions = PcSubscriptionPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcSubscriptionPeer::USER_ID, $this->id);

				PcSubscriptionPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcSubscriptionCriteria) || !$this->lastPcSubscriptionCriteria->equals($criteria)) {
					$this->collPcSubscriptions = PcSubscriptionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcSubscriptionCriteria = $criteria;
		return $this->collPcSubscriptions;
	}

	/**
	 * Returns the number of related PcSubscription objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcSubscription objects.
	 * @throws     PropelException
	 */
	public function countPcSubscriptions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcSubscriptions === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcSubscriptionPeer::USER_ID, $this->id);

				$count = PcSubscriptionPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcSubscriptionPeer::USER_ID, $this->id);

				if (!isset($this->lastPcSubscriptionCriteria) || !$this->lastPcSubscriptionCriteria->equals($criteria)) {
					$count = PcSubscriptionPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcSubscriptions);
				}
			} else {
				$count = count($this->collPcSubscriptions);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcSubscription object to this object
	 * through the PcSubscription foreign key attribute.
	 *
	 * @param      PcSubscription $l PcSubscription
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcSubscription(PcSubscription $l)
	{
		if ($this->collPcSubscriptions === null) {
			$this->initPcSubscriptions();
		}
		if (!in_array($l, $this->collPcSubscriptions, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcSubscriptions, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcSubscriptions from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcSubscriptionsJoinPcSubscriptionType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcSubscriptions === null) {
			if ($this->isNew()) {
				$this->collPcSubscriptions = array();
			} else {

				$criteria->add(PcSubscriptionPeer::USER_ID, $this->id);

				$this->collPcSubscriptions = PcSubscriptionPeer::doSelectJoinPcSubscriptionType($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcSubscriptionPeer::USER_ID, $this->id);

			if (!isset($this->lastPcSubscriptionCriteria) || !$this->lastPcSubscriptionCriteria->equals($criteria)) {
				$this->collPcSubscriptions = PcSubscriptionPeer::doSelectJoinPcSubscriptionType($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcSubscriptionCriteria = $criteria;

		return $this->collPcSubscriptions;
	}

	/**
	 * Clears out the collPcGoogleCalendars collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcGoogleCalendars()
	 */
	public function clearPcGoogleCalendars()
	{
		$this->collPcGoogleCalendars = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcGoogleCalendars collection (array).
	 *
	 * By default this just sets the collPcGoogleCalendars collection to an empty array (like clearcollPcGoogleCalendars());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcGoogleCalendars()
	{
		$this->collPcGoogleCalendars = array();
	}

	/**
	 * Gets an array of PcGoogleCalendar objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcGoogleCalendars from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcGoogleCalendar[]
	 * @throws     PropelException
	 */
	public function getPcGoogleCalendars($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcGoogleCalendars === null) {
			if ($this->isNew()) {
			   $this->collPcGoogleCalendars = array();
			} else {

				$criteria->add(PcGoogleCalendarPeer::USER_ID, $this->id);

				PcGoogleCalendarPeer::addSelectColumns($criteria);
				$this->collPcGoogleCalendars = PcGoogleCalendarPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcGoogleCalendarPeer::USER_ID, $this->id);

				PcGoogleCalendarPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcGoogleCalendarCriteria) || !$this->lastPcGoogleCalendarCriteria->equals($criteria)) {
					$this->collPcGoogleCalendars = PcGoogleCalendarPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcGoogleCalendarCriteria = $criteria;
		return $this->collPcGoogleCalendars;
	}

	/**
	 * Returns the number of related PcGoogleCalendar objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcGoogleCalendar objects.
	 * @throws     PropelException
	 */
	public function countPcGoogleCalendars(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcGoogleCalendars === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcGoogleCalendarPeer::USER_ID, $this->id);

				$count = PcGoogleCalendarPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcGoogleCalendarPeer::USER_ID, $this->id);

				if (!isset($this->lastPcGoogleCalendarCriteria) || !$this->lastPcGoogleCalendarCriteria->equals($criteria)) {
					$count = PcGoogleCalendarPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcGoogleCalendars);
				}
			} else {
				$count = count($this->collPcGoogleCalendars);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcGoogleCalendar object to this object
	 * through the PcGoogleCalendar foreign key attribute.
	 *
	 * @param      PcGoogleCalendar $l PcGoogleCalendar
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcGoogleCalendar(PcGoogleCalendar $l)
	{
		if ($this->collPcGoogleCalendars === null) {
			$this->initPcGoogleCalendars();
		}
		if (!in_array($l, $this->collPcGoogleCalendars, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcGoogleCalendars, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Gets a single PcUserKey object, which is related to this object by a one-to-one relationship.
	 *
	 * @param      PropelPDO $con
	 * @return     PcUserKey
	 * @throws     PropelException
	 */
	public function getPcUserKey(PropelPDO $con = null)
	{

		if ($this->singlePcUserKey === null && !$this->isNew()) {
			$this->singlePcUserKey = PcUserKeyPeer::retrieveByPK($this->id, $con);
		}

		return $this->singlePcUserKey;
	}

	/**
	 * Sets a single PcUserKey object as related to this object by a one-to-one relationship.
	 *
	 * @param      PcUserKey $l PcUserKey
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcUserKey(PcUserKey $v)
	{
		$this->singlePcUserKey = $v;

		// Make sure that that the passed-in PcUserKey isn't already associated with this object
		if ($v->getPcUser() === null) {
			$v->setPcUser($this);
		}

		return $this;
	}

	/**
	 * Clears out the collPcContacts collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcContacts()
	 */
	public function clearPcContacts()
	{
		$this->collPcContacts = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcContacts collection (array).
	 *
	 * By default this just sets the collPcContacts collection to an empty array (like clearcollPcContacts());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcContacts()
	{
		$this->collPcContacts = array();
	}

	/**
	 * Gets an array of PcContact objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcContacts from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcContact[]
	 * @throws     PropelException
	 */
	public function getPcContacts($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContacts === null) {
			if ($this->isNew()) {
			   $this->collPcContacts = array();
			} else {

				$criteria->add(PcContactPeer::CREATOR_ID, $this->id);

				PcContactPeer::addSelectColumns($criteria);
				$this->collPcContacts = PcContactPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcContactPeer::CREATOR_ID, $this->id);

				PcContactPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcContactCriteria) || !$this->lastPcContactCriteria->equals($criteria)) {
					$this->collPcContacts = PcContactPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcContactCriteria = $criteria;
		return $this->collPcContacts;
	}

	/**
	 * Returns the number of related PcContact objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcContact objects.
	 * @throws     PropelException
	 */
	public function countPcContacts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcContacts === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcContactPeer::CREATOR_ID, $this->id);

				$count = PcContactPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcContactPeer::CREATOR_ID, $this->id);

				if (!isset($this->lastPcContactCriteria) || !$this->lastPcContactCriteria->equals($criteria)) {
					$count = PcContactPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcContacts);
				}
			} else {
				$count = count($this->collPcContacts);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcContact object to this object
	 * through the PcContact foreign key attribute.
	 *
	 * @param      PcContact $l PcContact
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcContact(PcContact $l)
	{
		if ($this->collPcContacts === null) {
			$this->initPcContacts();
		}
		if (!in_array($l, $this->collPcContacts, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcContacts, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcContacts from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcContactsJoinPcContactCompany($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContacts === null) {
			if ($this->isNew()) {
				$this->collPcContacts = array();
			} else {

				$criteria->add(PcContactPeer::CREATOR_ID, $this->id);

				$this->collPcContacts = PcContactPeer::doSelectJoinPcContactCompany($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcContactPeer::CREATOR_ID, $this->id);

			if (!isset($this->lastPcContactCriteria) || !$this->lastPcContactCriteria->equals($criteria)) {
				$this->collPcContacts = PcContactPeer::doSelectJoinPcContactCompany($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcContactCriteria = $criteria;

		return $this->collPcContacts;
	}

	/**
	 * Clears out the collPcContactTags collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcContactTags()
	 */
	public function clearPcContactTags()
	{
		$this->collPcContactTags = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcContactTags collection (array).
	 *
	 * By default this just sets the collPcContactTags collection to an empty array (like clearcollPcContactTags());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcContactTags()
	{
		$this->collPcContactTags = array();
	}

	/**
	 * Gets an array of PcContactTag objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcContactTags from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcContactTag[]
	 * @throws     PropelException
	 */
	public function getPcContactTags($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactTags === null) {
			if ($this->isNew()) {
			   $this->collPcContactTags = array();
			} else {

				$criteria->add(PcContactTagPeer::CREATOR_ID, $this->id);

				PcContactTagPeer::addSelectColumns($criteria);
				$this->collPcContactTags = PcContactTagPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcContactTagPeer::CREATOR_ID, $this->id);

				PcContactTagPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcContactTagCriteria) || !$this->lastPcContactTagCriteria->equals($criteria)) {
					$this->collPcContactTags = PcContactTagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcContactTagCriteria = $criteria;
		return $this->collPcContactTags;
	}

	/**
	 * Returns the number of related PcContactTag objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcContactTag objects.
	 * @throws     PropelException
	 */
	public function countPcContactTags(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcContactTags === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcContactTagPeer::CREATOR_ID, $this->id);

				$count = PcContactTagPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcContactTagPeer::CREATOR_ID, $this->id);

				if (!isset($this->lastPcContactTagCriteria) || !$this->lastPcContactTagCriteria->equals($criteria)) {
					$count = PcContactTagPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcContactTags);
				}
			} else {
				$count = count($this->collPcContactTags);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcContactTag object to this object
	 * through the PcContactTag foreign key attribute.
	 *
	 * @param      PcContactTag $l PcContactTag
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcContactTag(PcContactTag $l)
	{
		if ($this->collPcContactTags === null) {
			$this->initPcContactTags();
		}
		if (!in_array($l, $this->collPcContactTags, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcContactTags, $l);
			$l->setPcUser($this);
		}
	}

	/**
	 * Clears out the collPcContactsTagss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcContactsTagss()
	 */
	public function clearPcContactsTagss()
	{
		$this->collPcContactsTagss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcContactsTagss collection (array).
	 *
	 * By default this just sets the collPcContactsTagss collection to an empty array (like clearcollPcContactsTagss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcContactsTagss()
	{
		$this->collPcContactsTagss = array();
	}

	/**
	 * Gets an array of PcContactsTags objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcContactsTagss from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcContactsTags[]
	 * @throws     PropelException
	 */
	public function getPcContactsTagss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactsTagss === null) {
			if ($this->isNew()) {
			   $this->collPcContactsTagss = array();
			} else {

				$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

				PcContactsTagsPeer::addSelectColumns($criteria);
				$this->collPcContactsTagss = PcContactsTagsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

				PcContactsTagsPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcContactsTagsCriteria) || !$this->lastPcContactsTagsCriteria->equals($criteria)) {
					$this->collPcContactsTagss = PcContactsTagsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcContactsTagsCriteria = $criteria;
		return $this->collPcContactsTagss;
	}

	/**
	 * Returns the number of related PcContactsTags objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcContactsTags objects.
	 * @throws     PropelException
	 */
	public function countPcContactsTagss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcContactsTagss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

				$count = PcContactsTagsPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

				if (!isset($this->lastPcContactsTagsCriteria) || !$this->lastPcContactsTagsCriteria->equals($criteria)) {
					$count = PcContactsTagsPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcContactsTagss);
				}
			} else {
				$count = count($this->collPcContactsTagss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcContactsTags object to this object
	 * through the PcContactsTags foreign key attribute.
	 *
	 * @param      PcContactsTags $l PcContactsTags
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcContactsTags(PcContactsTags $l)
	{
		if ($this->collPcContactsTagss === null) {
			$this->initPcContactsTagss();
		}
		if (!in_array($l, $this->collPcContactsTagss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcContactsTagss, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcContactsTagss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcContactsTagssJoinPcContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactsTagss === null) {
			if ($this->isNew()) {
				$this->collPcContactsTagss = array();
			} else {

				$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcContact($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

			if (!isset($this->lastPcContactsTagsCriteria) || !$this->lastPcContactsTagsCriteria->equals($criteria)) {
				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcContact($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcContactsTagsCriteria = $criteria;

		return $this->collPcContactsTagss;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcContactsTagss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcContactsTagssJoinPcContactTag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactsTagss === null) {
			if ($this->isNew()) {
				$this->collPcContactsTagss = array();
			} else {

				$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcContactTag($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcContactsTagsPeer::CREATOR_ID, $this->id);

			if (!isset($this->lastPcContactsTagsCriteria) || !$this->lastPcContactsTagsCriteria->equals($criteria)) {
				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcContactTag($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcContactsTagsCriteria = $criteria;

		return $this->collPcContactsTagss;
	}

	/**
	 * Clears out the collPcContactNotes collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcContactNotes()
	 */
	public function clearPcContactNotes()
	{
		$this->collPcContactNotes = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcContactNotes collection (array).
	 *
	 * By default this just sets the collPcContactNotes collection to an empty array (like clearcollPcContactNotes());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcContactNotes()
	{
		$this->collPcContactNotes = array();
	}

	/**
	 * Gets an array of PcContactNote objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcUser has previously been saved, it will retrieve
	 * related PcContactNotes from storage. If this PcUser is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcContactNote[]
	 * @throws     PropelException
	 */
	public function getPcContactNotes($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactNotes === null) {
			if ($this->isNew()) {
			   $this->collPcContactNotes = array();
			} else {

				$criteria->add(PcContactNotePeer::CREATOR_ID, $this->id);

				PcContactNotePeer::addSelectColumns($criteria);
				$this->collPcContactNotes = PcContactNotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcContactNotePeer::CREATOR_ID, $this->id);

				PcContactNotePeer::addSelectColumns($criteria);
				if (!isset($this->lastPcContactNoteCriteria) || !$this->lastPcContactNoteCriteria->equals($criteria)) {
					$this->collPcContactNotes = PcContactNotePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcContactNoteCriteria = $criteria;
		return $this->collPcContactNotes;
	}

	/**
	 * Returns the number of related PcContactNote objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcContactNote objects.
	 * @throws     PropelException
	 */
	public function countPcContactNotes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcContactNotes === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcContactNotePeer::CREATOR_ID, $this->id);

				$count = PcContactNotePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcContactNotePeer::CREATOR_ID, $this->id);

				if (!isset($this->lastPcContactNoteCriteria) || !$this->lastPcContactNoteCriteria->equals($criteria)) {
					$count = PcContactNotePeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcContactNotes);
				}
			} else {
				$count = count($this->collPcContactNotes);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcContactNote object to this object
	 * through the PcContactNote foreign key attribute.
	 *
	 * @param      PcContactNote $l PcContactNote
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcContactNote(PcContactNote $l)
	{
		if ($this->collPcContactNotes === null) {
			$this->initPcContactNotes();
		}
		if (!in_array($l, $this->collPcContactNotes, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcContactNotes, $l);
			$l->setPcUser($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcUser is new, it will return
	 * an empty collection; or if this PcUser has previously
	 * been saved, it will retrieve related PcContactNotes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcUser.
	 */
	public function getPcContactNotesJoinPcContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactNotes === null) {
			if ($this->isNew()) {
				$this->collPcContactNotes = array();
			} else {

				$criteria->add(PcContactNotePeer::CREATOR_ID, $this->id);

				$this->collPcContactNotes = PcContactNotePeer::doSelectJoinPcContact($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcContactNotePeer::CREATOR_ID, $this->id);

			if (!isset($this->lastPcContactNoteCriteria) || !$this->lastPcContactNoteCriteria->equals($criteria)) {
				$this->collPcContactNotes = PcContactNotePeer::doSelectJoinPcContact($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcContactNoteCriteria = $criteria;

		return $this->collPcContactNotes;
	}

	/**
	 * Gets a single PcHideableHintsSetting object, which is related to this object by a one-to-one relationship.
	 *
	 * @param      PropelPDO $con
	 * @return     PcHideableHintsSetting
	 * @throws     PropelException
	 */
	public function getPcHideableHintsSetting(PropelPDO $con = null)
	{

		if ($this->singlePcHideableHintsSetting === null && !$this->isNew()) {
			$this->singlePcHideableHintsSetting = PcHideableHintsSettingPeer::retrieveByPK($this->id, $con);
		}

		return $this->singlePcHideableHintsSetting;
	}

	/**
	 * Sets a single PcHideableHintsSetting object as related to this object by a one-to-one relationship.
	 *
	 * @param      PcHideableHintsSetting $l PcHideableHintsSetting
	 * @return     PcUser The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcHideableHintsSetting(PcHideableHintsSetting $v)
	{
		$this->singlePcHideableHintsSetting = $v;

		// Make sure that that the passed-in PcHideableHintsSetting isn't already associated with this object
		if ($v->getPcUser() === null) {
			$v->setPcUser($this);
		}

		return $this;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collPcDirtyTasks) {
				foreach ((array) $this->collPcDirtyTasks as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->singlePcFailedLogins) {
				$this->singlePcFailedLogins->clearAllReferences($deep);
			}
			if ($this->singlePcActivationToken) {
				$this->singlePcActivationToken->clearAllReferences($deep);
			}
			if ($this->singlePcPasswordResetToken) {
				$this->singlePcPasswordResetToken->clearAllReferences($deep);
			}
			if ($this->singlePcPlancakeEmailAddress) {
				$this->singlePcPlancakeEmailAddress->clearAllReferences($deep);
			}
			if ($this->collPcLists) {
				foreach ((array) $this->collPcLists as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcUsersListss) {
				foreach ((array) $this->collPcUsersListss as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcEmailChangeHistorys) {
				foreach ((array) $this->collPcEmailChangeHistorys as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcUsersContextss) {
				foreach ((array) $this->collPcUsersContextss as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->singlePcSupporter) {
				$this->singlePcSupporter->clearAllReferences($deep);
			}
			if ($this->collPcBlogPosts) {
				foreach ((array) $this->collPcBlogPosts as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcBlogComments) {
				foreach ((array) $this->collPcBlogComments as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcApiApps) {
				foreach ((array) $this->collPcApiApps as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcApiTokens) {
				foreach ((array) $this->collPcApiTokens as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcNotes) {
				foreach ((array) $this->collPcNotes as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcSubscriptions) {
				foreach ((array) $this->collPcSubscriptions as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcGoogleCalendars) {
				foreach ((array) $this->collPcGoogleCalendars as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->singlePcUserKey) {
				$this->singlePcUserKey->clearAllReferences($deep);
			}
			if ($this->collPcContacts) {
				foreach ((array) $this->collPcContacts as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcContactTags) {
				foreach ((array) $this->collPcContactTags as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcContactsTagss) {
				foreach ((array) $this->collPcContactsTagss as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcContactNotes) {
				foreach ((array) $this->collPcContactNotes as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->singlePcHideableHintsSetting) {
				$this->singlePcHideableHintsSetting->clearAllReferences($deep);
			}
		} // if ($deep)

		$this->collPcDirtyTasks = null;
		$this->singlePcFailedLogins = null;
		$this->singlePcActivationToken = null;
		$this->singlePcPasswordResetToken = null;
		$this->singlePcPlancakeEmailAddress = null;
		$this->collPcLists = null;
		$this->collPcUsersListss = null;
		$this->collPcEmailChangeHistorys = null;
		$this->collPcUsersContextss = null;
		$this->singlePcSupporter = null;
		$this->collPcBlogPosts = null;
		$this->collPcBlogComments = null;
		$this->collPcApiApps = null;
		$this->collPcApiTokens = null;
		$this->collPcNotes = null;
		$this->collPcSubscriptions = null;
		$this->collPcGoogleCalendars = null;
		$this->singlePcUserKey = null;
		$this->collPcContacts = null;
		$this->collPcContactTags = null;
		$this->collPcContactsTagss = null;
		$this->collPcContactNotes = null;
		$this->singlePcHideableHintsSetting = null;
			$this->aPcTimezone = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcUser:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcUser::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcUser
