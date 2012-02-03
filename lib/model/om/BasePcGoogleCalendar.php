<?php

/**
 * Base class that represents a row from the 'pc_google_calendar' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcGoogleCalendar extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcGoogleCalendarPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;

	/**
	 * The value for the calendar_url field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $calendar_url;

	/**
	 * The value for the session_token field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $session_token;

	/**
	 * The value for the email_address field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $email_address;

	/**
	 * The value for the is_active field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_active;

	/**
	 * The value for the is_syncing field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_syncing;

	/**
	 * The value for the latest_sync_start_timestamp field.
	 * @var        int
	 */
	protected $latest_sync_start_timestamp;

	/**
	 * The value for the latest_sync_end_timestamp field.
	 * @var        int
	 */
	protected $latest_sync_end_timestamp;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * @var        PcUser
	 */
	protected $aPcUser;

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
	
	const PEER = 'PcGoogleCalendarPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->calendar_url = '';
		$this->session_token = '';
		$this->email_address = '';
		$this->is_active = false;
		$this->is_syncing = false;
	}

	/**
	 * Initializes internal state of BasePcGoogleCalendar object.
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
	 * Get the [user_id] column value.
	 * 
	 * @return     int
	 */
	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * Get the [calendar_url] column value.
	 * 
	 * @return     string
	 */
	public function getCalendarUrl()
	{
		return $this->calendar_url;
	}

	/**
	 * Get the [session_token] column value.
	 * 
	 * @return     string
	 */
	public function getSessionToken()
	{
		return $this->session_token;
	}

	/**
	 * Get the [email_address] column value.
	 * 
	 * @return     string
	 */
	public function getEmailAddress()
	{
		return $this->email_address;
	}

	/**
	 * Get the [is_active] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsActive()
	{
		return $this->is_active;
	}

	/**
	 * Get the [is_syncing] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsSyncing()
	{
		return $this->is_syncing;
	}

	/**
	 * Get the [latest_sync_start_timestamp] column value.
	 * 
	 * @return     int
	 */
	public function getLatestSyncStartTimestamp()
	{
		return $this->latest_sync_start_timestamp;
	}

	/**
	 * Get the [latest_sync_end_timestamp] column value.
	 * 
	 * @return     int
	 */
	public function getLatestSyncEndTimestamp()
	{
		return $this->latest_sync_end_timestamp;
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
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
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::USER_ID;
		}

		if ($this->aPcUser !== null && $this->aPcUser->getId() !== $v) {
			$this->aPcUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [calendar_url] column.
	 * 
	 * @param      string $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setCalendarUrl($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->calendar_url !== $v || $this->isNew()) {
			$this->calendar_url = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::CALENDAR_URL;
		}

		return $this;
	} // setCalendarUrl()

	/**
	 * Set the value of [session_token] column.
	 * 
	 * @param      string $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setSessionToken($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->session_token !== $v || $this->isNew()) {
			$this->session_token = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::SESSION_TOKEN;
		}

		return $this;
	} // setSessionToken()

	/**
	 * Set the value of [email_address] column.
	 * 
	 * @param      string $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setEmailAddress($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email_address !== $v || $this->isNew()) {
			$this->email_address = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::EMAIL_ADDRESS;
		}

		return $this;
	} // setEmailAddress()

	/**
	 * Set the value of [is_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setIsActive($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_active !== $v || $this->isNew()) {
			$this->is_active = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::IS_ACTIVE;
		}

		return $this;
	} // setIsActive()

	/**
	 * Set the value of [is_syncing] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setIsSyncing($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_syncing !== $v || $this->isNew()) {
			$this->is_syncing = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::IS_SYNCING;
		}

		return $this;
	} // setIsSyncing()

	/**
	 * Set the value of [latest_sync_start_timestamp] column.
	 * 
	 * @param      int $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setLatestSyncStartTimestamp($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->latest_sync_start_timestamp !== $v) {
			$this->latest_sync_start_timestamp = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::LATEST_SYNC_START_TIMESTAMP;
		}

		return $this;
	} // setLatestSyncStartTimestamp()

	/**
	 * Set the value of [latest_sync_end_timestamp] column.
	 * 
	 * @param      int $v new value
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setLatestSyncEndTimestamp($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->latest_sync_end_timestamp !== $v) {
			$this->latest_sync_end_timestamp = $v;
			$this->modifiedColumns[] = PcGoogleCalendarPeer::LATEST_SYNC_END_TIMESTAMP;
		}

		return $this;
	} // setLatestSyncEndTimestamp()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
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

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcGoogleCalendarPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcGoogleCalendar The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcGoogleCalendarPeer::CREATED_AT;
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
			if ($this->calendar_url !== '') {
				return false;
			}

			if ($this->session_token !== '') {
				return false;
			}

			if ($this->email_address !== '') {
				return false;
			}

			if ($this->is_active !== false) {
				return false;
			}

			if ($this->is_syncing !== false) {
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
			$this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->calendar_url = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->session_token = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->email_address = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->is_active = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->is_syncing = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
			$this->latest_sync_start_timestamp = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->latest_sync_end_timestamp = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->updated_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->created_at = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 11; // 11 = PcGoogleCalendarPeer::NUM_COLUMNS - PcGoogleCalendarPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcGoogleCalendar object", $e);
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

		if ($this->aPcUser !== null && $this->user_id !== $this->aPcUser->getId()) {
			$this->aPcUser = null;
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
			$con = Propel::getConnection(PcGoogleCalendarPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcGoogleCalendarPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcUser = null;
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
			$con = Propel::getConnection(PcGoogleCalendarPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcGoogleCalendar:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcGoogleCalendarPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcGoogleCalendar:delete:post') as $callable)
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
			$con = Propel::getConnection(PcGoogleCalendarPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcGoogleCalendar:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(PcGoogleCalendarPeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(PcGoogleCalendarPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcGoogleCalendar:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcGoogleCalendarPeer::addInstanceToPool($this);
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

			if ($this->aPcUser !== null) {
				if ($this->aPcUser->isModified() || $this->aPcUser->isNew()) {
					$affectedRows += $this->aPcUser->save($con);
				}
				$this->setPcUser($this->aPcUser);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PcGoogleCalendarPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcGoogleCalendarPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcGoogleCalendarPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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

			if ($this->aPcUser !== null) {
				if (!$this->aPcUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcUser->getValidationFailures());
				}
			}


			if (($retval = PcGoogleCalendarPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = PcGoogleCalendarPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getUserId();
				break;
			case 2:
				return $this->getCalendarUrl();
				break;
			case 3:
				return $this->getSessionToken();
				break;
			case 4:
				return $this->getEmailAddress();
				break;
			case 5:
				return $this->getIsActive();
				break;
			case 6:
				return $this->getIsSyncing();
				break;
			case 7:
				return $this->getLatestSyncStartTimestamp();
				break;
			case 8:
				return $this->getLatestSyncEndTimestamp();
				break;
			case 9:
				return $this->getUpdatedAt();
				break;
			case 10:
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
		$keys = PcGoogleCalendarPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getCalendarUrl(),
			$keys[3] => $this->getSessionToken(),
			$keys[4] => $this->getEmailAddress(),
			$keys[5] => $this->getIsActive(),
			$keys[6] => $this->getIsSyncing(),
			$keys[7] => $this->getLatestSyncStartTimestamp(),
			$keys[8] => $this->getLatestSyncEndTimestamp(),
			$keys[9] => $this->getUpdatedAt(),
			$keys[10] => $this->getCreatedAt(),
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
		$pos = PcGoogleCalendarPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUserId($value);
				break;
			case 2:
				$this->setCalendarUrl($value);
				break;
			case 3:
				$this->setSessionToken($value);
				break;
			case 4:
				$this->setEmailAddress($value);
				break;
			case 5:
				$this->setIsActive($value);
				break;
			case 6:
				$this->setIsSyncing($value);
				break;
			case 7:
				$this->setLatestSyncStartTimestamp($value);
				break;
			case 8:
				$this->setLatestSyncEndTimestamp($value);
				break;
			case 9:
				$this->setUpdatedAt($value);
				break;
			case 10:
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
		$keys = PcGoogleCalendarPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCalendarUrl($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSessionToken($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setEmailAddress($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsActive($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsSyncing($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLatestSyncStartTimestamp($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLatestSyncEndTimestamp($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedAt($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedAt($arr[$keys[10]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcGoogleCalendarPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcGoogleCalendarPeer::ID)) $criteria->add(PcGoogleCalendarPeer::ID, $this->id);
		if ($this->isColumnModified(PcGoogleCalendarPeer::USER_ID)) $criteria->add(PcGoogleCalendarPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(PcGoogleCalendarPeer::CALENDAR_URL)) $criteria->add(PcGoogleCalendarPeer::CALENDAR_URL, $this->calendar_url);
		if ($this->isColumnModified(PcGoogleCalendarPeer::SESSION_TOKEN)) $criteria->add(PcGoogleCalendarPeer::SESSION_TOKEN, $this->session_token);
		if ($this->isColumnModified(PcGoogleCalendarPeer::EMAIL_ADDRESS)) $criteria->add(PcGoogleCalendarPeer::EMAIL_ADDRESS, $this->email_address);
		if ($this->isColumnModified(PcGoogleCalendarPeer::IS_ACTIVE)) $criteria->add(PcGoogleCalendarPeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(PcGoogleCalendarPeer::IS_SYNCING)) $criteria->add(PcGoogleCalendarPeer::IS_SYNCING, $this->is_syncing);
		if ($this->isColumnModified(PcGoogleCalendarPeer::LATEST_SYNC_START_TIMESTAMP)) $criteria->add(PcGoogleCalendarPeer::LATEST_SYNC_START_TIMESTAMP, $this->latest_sync_start_timestamp);
		if ($this->isColumnModified(PcGoogleCalendarPeer::LATEST_SYNC_END_TIMESTAMP)) $criteria->add(PcGoogleCalendarPeer::LATEST_SYNC_END_TIMESTAMP, $this->latest_sync_end_timestamp);
		if ($this->isColumnModified(PcGoogleCalendarPeer::UPDATED_AT)) $criteria->add(PcGoogleCalendarPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PcGoogleCalendarPeer::CREATED_AT)) $criteria->add(PcGoogleCalendarPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(PcGoogleCalendarPeer::DATABASE_NAME);

		$criteria->add(PcGoogleCalendarPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcGoogleCalendar (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setCalendarUrl($this->calendar_url);

		$copyObj->setSessionToken($this->session_token);

		$copyObj->setEmailAddress($this->email_address);

		$copyObj->setIsActive($this->is_active);

		$copyObj->setIsSyncing($this->is_syncing);

		$copyObj->setLatestSyncStartTimestamp($this->latest_sync_start_timestamp);

		$copyObj->setLatestSyncEndTimestamp($this->latest_sync_end_timestamp);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCreatedAt($this->created_at);


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
	 * @return     PcGoogleCalendar Clone of current object.
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
	 * @return     PcGoogleCalendarPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcGoogleCalendarPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcUser object.
	 *
	 * @param      PcUser $v
	 * @return     PcGoogleCalendar The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcUser(PcUser $v = null)
	{
		if ($v === null) {
			$this->setUserId(NULL);
		} else {
			$this->setUserId($v->getId());
		}

		$this->aPcUser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcUser object, it will not be re-added.
		if ($v !== null) {
			$v->addPcGoogleCalendar($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcUser object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcUser The associated PcUser object.
	 * @throws     PropelException
	 */
	public function getPcUser(PropelPDO $con = null)
	{
		if ($this->aPcUser === null && ($this->user_id !== null)) {
			$this->aPcUser = PcUserPeer::retrieveByPk($this->user_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcUser->addPcGoogleCalendars($this);
			 */
		}
		return $this->aPcUser;
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
		} // if ($deep)

			$this->aPcUser = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcGoogleCalendar:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcGoogleCalendar::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcGoogleCalendar
