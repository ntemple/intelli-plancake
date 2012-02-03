<?php

/**
 * Base class that represents a row from the 'pc_contact' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcContact extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcContactPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the position field.
	 * @var        string
	 */
	protected $position;

	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;

	/**
	 * The value for the phone field.
	 * @var        string
	 */
	protected $phone;

	/**
	 * The value for the website field.
	 * @var        string
	 */
	protected $website;

	/**
	 * The value for the link field.
	 * @var        string
	 */
	protected $link;

	/**
	 * The value for the twitter field.
	 * @var        string
	 */
	protected $twitter;

	/**
	 * The value for the language field.
	 * @var        string
	 */
	protected $language;

	/**
	 * The value for the company_id field.
	 * @var        int
	 */
	protected $company_id;

	/**
	 * The value for the creator_id field.
	 * @var        int
	 */
	protected $creator_id;

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
	 * @var        PcContactCompany
	 */
	protected $aPcContactCompany;

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
	 * @var        array PcReview[] Collection to store aggregation of PcReview objects.
	 */
	protected $collPcReviews;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcReviews.
	 */
	private $lastPcReviewCriteria = null;

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
	
	const PEER = 'PcContactPeer';

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
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Get the [position] column value.
	 * 
	 * @return     string
	 */
	public function getPosition()
	{
		return $this->position;
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
	 * Get the [phone] column value.
	 * 
	 * @return     string
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * Get the [website] column value.
	 * 
	 * @return     string
	 */
	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * Get the [link] column value.
	 * 
	 * @return     string
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * Get the [twitter] column value.
	 * 
	 * @return     string
	 */
	public function getTwitter()
	{
		return $this->twitter;
	}

	/**
	 * Get the [language] column value.
	 * 
	 * @return     string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * Get the [company_id] column value.
	 * 
	 * @return     int
	 */
	public function getCompanyId()
	{
		return $this->company_id;
	}

	/**
	 * Get the [creator_id] column value.
	 * 
	 * @return     int
	 */
	public function getCreatorId()
	{
		return $this->creator_id;
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
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcContactPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = PcContactPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = PcContactPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Set the value of [position] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setPosition($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->position !== $v) {
			$this->position = $v;
			$this->modifiedColumns[] = PcContactPeer::POSITION;
		}

		return $this;
	} // setPosition()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setEmail($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = PcContactPeer::EMAIL;
		}

		return $this;
	} // setEmail()

	/**
	 * Set the value of [phone] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setPhone($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->phone !== $v) {
			$this->phone = $v;
			$this->modifiedColumns[] = PcContactPeer::PHONE;
		}

		return $this;
	} // setPhone()

	/**
	 * Set the value of [website] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setWebsite($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->website !== $v) {
			$this->website = $v;
			$this->modifiedColumns[] = PcContactPeer::WEBSITE;
		}

		return $this;
	} // setWebsite()

	/**
	 * Set the value of [link] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setLink($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->link !== $v) {
			$this->link = $v;
			$this->modifiedColumns[] = PcContactPeer::LINK;
		}

		return $this;
	} // setLink()

	/**
	 * Set the value of [twitter] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setTwitter($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->twitter !== $v) {
			$this->twitter = $v;
			$this->modifiedColumns[] = PcContactPeer::TWITTER;
		}

		return $this;
	} // setTwitter()

	/**
	 * Set the value of [language] column.
	 * 
	 * @param      string $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setLanguage($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->language !== $v) {
			$this->language = $v;
			$this->modifiedColumns[] = PcContactPeer::LANGUAGE;
		}

		return $this;
	} // setLanguage()

	/**
	 * Set the value of [company_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setCompanyId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->company_id !== $v) {
			$this->company_id = $v;
			$this->modifiedColumns[] = PcContactPeer::COMPANY_ID;
		}

		if ($this->aPcContactCompany !== null && $this->aPcContactCompany->getId() !== $v) {
			$this->aPcContactCompany = null;
		}

		return $this;
	} // setCompanyId()

	/**
	 * Set the value of [creator_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcContact The current object (for fluent API support)
	 */
	public function setCreatorId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->creator_id !== $v) {
			$this->creator_id = $v;
			$this->modifiedColumns[] = PcContactPeer::CREATOR_ID;
		}

		if ($this->aPcUser !== null && $this->aPcUser->getId() !== $v) {
			$this->aPcUser = null;
		}

		return $this;
	} // setCreatorId()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcContact The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcContactPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcContact The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcContactPeer::CREATED_AT;
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
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->position = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->email = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->phone = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->website = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->link = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->twitter = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->language = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->company_id = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
			$this->creator_id = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
			$this->updated_at = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->created_at = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 14; // 14 = PcContactPeer::NUM_COLUMNS - PcContactPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcContact object", $e);
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

		if ($this->aPcContactCompany !== null && $this->company_id !== $this->aPcContactCompany->getId()) {
			$this->aPcContactCompany = null;
		}
		if ($this->aPcUser !== null && $this->creator_id !== $this->aPcUser->getId()) {
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
			$con = Propel::getConnection(PcContactPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcContactPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcUser = null;
			$this->aPcContactCompany = null;
			$this->collPcContactsTagss = null;
			$this->lastPcContactsTagsCriteria = null;

			$this->collPcContactNotes = null;
			$this->lastPcContactNoteCriteria = null;

			$this->collPcReviews = null;
			$this->lastPcReviewCriteria = null;

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
			$con = Propel::getConnection(PcContactPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcContact:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcContactPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcContact:delete:post') as $callable)
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
			$con = Propel::getConnection(PcContactPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcContact:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(PcContactPeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				if (!$this->isColumnModified(PcContactPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcContact:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcContactPeer::addInstanceToPool($this);
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

			if ($this->aPcContactCompany !== null) {
				if ($this->aPcContactCompany->isModified() || $this->aPcContactCompany->isNew()) {
					$affectedRows += $this->aPcContactCompany->save($con);
				}
				$this->setPcContactCompany($this->aPcContactCompany);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PcContactPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcContactPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcContactPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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

			if ($this->collPcReviews !== null) {
				foreach ($this->collPcReviews as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
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

			if ($this->aPcUser !== null) {
				if (!$this->aPcUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcUser->getValidationFailures());
				}
			}

			if ($this->aPcContactCompany !== null) {
				if (!$this->aPcContactCompany->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcContactCompany->getValidationFailures());
				}
			}


			if (($retval = PcContactPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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

				if ($this->collPcReviews !== null) {
					foreach ($this->collPcReviews as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
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
		$pos = PcContactPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 2:
				return $this->getDescription();
				break;
			case 3:
				return $this->getPosition();
				break;
			case 4:
				return $this->getEmail();
				break;
			case 5:
				return $this->getPhone();
				break;
			case 6:
				return $this->getWebsite();
				break;
			case 7:
				return $this->getLink();
				break;
			case 8:
				return $this->getTwitter();
				break;
			case 9:
				return $this->getLanguage();
				break;
			case 10:
				return $this->getCompanyId();
				break;
			case 11:
				return $this->getCreatorId();
				break;
			case 12:
				return $this->getUpdatedAt();
				break;
			case 13:
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
		$keys = PcContactPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getDescription(),
			$keys[3] => $this->getPosition(),
			$keys[4] => $this->getEmail(),
			$keys[5] => $this->getPhone(),
			$keys[6] => $this->getWebsite(),
			$keys[7] => $this->getLink(),
			$keys[8] => $this->getTwitter(),
			$keys[9] => $this->getLanguage(),
			$keys[10] => $this->getCompanyId(),
			$keys[11] => $this->getCreatorId(),
			$keys[12] => $this->getUpdatedAt(),
			$keys[13] => $this->getCreatedAt(),
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
		$pos = PcContactPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setName($value);
				break;
			case 2:
				$this->setDescription($value);
				break;
			case 3:
				$this->setPosition($value);
				break;
			case 4:
				$this->setEmail($value);
				break;
			case 5:
				$this->setPhone($value);
				break;
			case 6:
				$this->setWebsite($value);
				break;
			case 7:
				$this->setLink($value);
				break;
			case 8:
				$this->setTwitter($value);
				break;
			case 9:
				$this->setLanguage($value);
				break;
			case 10:
				$this->setCompanyId($value);
				break;
			case 11:
				$this->setCreatorId($value);
				break;
			case 12:
				$this->setUpdatedAt($value);
				break;
			case 13:
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
		$keys = PcContactPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPosition($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setEmail($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPhone($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setWebsite($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLink($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTwitter($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLanguage($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCompanyId($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatorId($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedAt($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCreatedAt($arr[$keys[13]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcContactPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcContactPeer::ID)) $criteria->add(PcContactPeer::ID, $this->id);
		if ($this->isColumnModified(PcContactPeer::NAME)) $criteria->add(PcContactPeer::NAME, $this->name);
		if ($this->isColumnModified(PcContactPeer::DESCRIPTION)) $criteria->add(PcContactPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PcContactPeer::POSITION)) $criteria->add(PcContactPeer::POSITION, $this->position);
		if ($this->isColumnModified(PcContactPeer::EMAIL)) $criteria->add(PcContactPeer::EMAIL, $this->email);
		if ($this->isColumnModified(PcContactPeer::PHONE)) $criteria->add(PcContactPeer::PHONE, $this->phone);
		if ($this->isColumnModified(PcContactPeer::WEBSITE)) $criteria->add(PcContactPeer::WEBSITE, $this->website);
		if ($this->isColumnModified(PcContactPeer::LINK)) $criteria->add(PcContactPeer::LINK, $this->link);
		if ($this->isColumnModified(PcContactPeer::TWITTER)) $criteria->add(PcContactPeer::TWITTER, $this->twitter);
		if ($this->isColumnModified(PcContactPeer::LANGUAGE)) $criteria->add(PcContactPeer::LANGUAGE, $this->language);
		if ($this->isColumnModified(PcContactPeer::COMPANY_ID)) $criteria->add(PcContactPeer::COMPANY_ID, $this->company_id);
		if ($this->isColumnModified(PcContactPeer::CREATOR_ID)) $criteria->add(PcContactPeer::CREATOR_ID, $this->creator_id);
		if ($this->isColumnModified(PcContactPeer::UPDATED_AT)) $criteria->add(PcContactPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PcContactPeer::CREATED_AT)) $criteria->add(PcContactPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(PcContactPeer::DATABASE_NAME);

		$criteria->add(PcContactPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcContact (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setDescription($this->description);

		$copyObj->setPosition($this->position);

		$copyObj->setEmail($this->email);

		$copyObj->setPhone($this->phone);

		$copyObj->setWebsite($this->website);

		$copyObj->setLink($this->link);

		$copyObj->setTwitter($this->twitter);

		$copyObj->setLanguage($this->language);

		$copyObj->setCompanyId($this->company_id);

		$copyObj->setCreatorId($this->creator_id);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

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

			foreach ($this->getPcReviews() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcReview($relObj->copy($deepCopy));
				}
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
	 * @return     PcContact Clone of current object.
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
	 * @return     PcContactPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcContactPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcUser object.
	 *
	 * @param      PcUser $v
	 * @return     PcContact The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcUser(PcUser $v = null)
	{
		if ($v === null) {
			$this->setCreatorId(NULL);
		} else {
			$this->setCreatorId($v->getId());
		}

		$this->aPcUser = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcUser object, it will not be re-added.
		if ($v !== null) {
			$v->addPcContact($this);
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
		if ($this->aPcUser === null && ($this->creator_id !== null)) {
			$this->aPcUser = PcUserPeer::retrieveByPk($this->creator_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcUser->addPcContacts($this);
			 */
		}
		return $this->aPcUser;
	}

	/**
	 * Declares an association between this object and a PcContactCompany object.
	 *
	 * @param      PcContactCompany $v
	 * @return     PcContact The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcContactCompany(PcContactCompany $v = null)
	{
		if ($v === null) {
			$this->setCompanyId(NULL);
		} else {
			$this->setCompanyId($v->getId());
		}

		$this->aPcContactCompany = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcContactCompany object, it will not be re-added.
		if ($v !== null) {
			$v->addPcContact($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcContactCompany object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcContactCompany The associated PcContactCompany object.
	 * @throws     PropelException
	 */
	public function getPcContactCompany(PropelPDO $con = null)
	{
		if ($this->aPcContactCompany === null && ($this->company_id !== null)) {
			$this->aPcContactCompany = PcContactCompanyPeer::retrieveByPk($this->company_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcContactCompany->addPcContacts($this);
			 */
		}
		return $this->aPcContactCompany;
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
	 * Otherwise if this PcContact has previously been saved, it will retrieve
	 * related PcContactsTagss from storage. If this PcContact is new, it will return
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
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactsTagss === null) {
			if ($this->isNew()) {
			   $this->collPcContactsTagss = array();
			} else {

				$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

				PcContactsTagsPeer::addSelectColumns($criteria);
				$this->collPcContactsTagss = PcContactsTagsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

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
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
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

				$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

				$count = PcContactsTagsPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

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
			$l->setPcContact($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcContact is new, it will return
	 * an empty collection; or if this PcContact has previously
	 * been saved, it will retrieve related PcContactsTagss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcContact.
	 */
	public function getPcContactsTagssJoinPcContactTag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactsTagss === null) {
			if ($this->isNew()) {
				$this->collPcContactsTagss = array();
			} else {

				$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcContactTag($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

			if (!isset($this->lastPcContactsTagsCriteria) || !$this->lastPcContactsTagsCriteria->equals($criteria)) {
				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcContactTag($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcContactsTagsCriteria = $criteria;

		return $this->collPcContactsTagss;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcContact is new, it will return
	 * an empty collection; or if this PcContact has previously
	 * been saved, it will retrieve related PcContactsTagss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcContact.
	 */
	public function getPcContactsTagssJoinPcUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactsTagss === null) {
			if ($this->isNew()) {
				$this->collPcContactsTagss = array();
			} else {

				$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcContactsTagsPeer::CONTACT_ID, $this->id);

			if (!isset($this->lastPcContactsTagsCriteria) || !$this->lastPcContactsTagsCriteria->equals($criteria)) {
				$this->collPcContactsTagss = PcContactsTagsPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
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
	 * Otherwise if this PcContact has previously been saved, it will retrieve
	 * related PcContactNotes from storage. If this PcContact is new, it will return
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
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactNotes === null) {
			if ($this->isNew()) {
			   $this->collPcContactNotes = array();
			} else {

				$criteria->add(PcContactNotePeer::CONTACT_ID, $this->id);

				PcContactNotePeer::addSelectColumns($criteria);
				$this->collPcContactNotes = PcContactNotePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcContactNotePeer::CONTACT_ID, $this->id);

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
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
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

				$criteria->add(PcContactNotePeer::CONTACT_ID, $this->id);

				$count = PcContactNotePeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcContactNotePeer::CONTACT_ID, $this->id);

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
			$l->setPcContact($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcContact is new, it will return
	 * an empty collection; or if this PcContact has previously
	 * been saved, it will retrieve related PcContactNotes from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcContact.
	 */
	public function getPcContactNotesJoinPcUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcContactNotes === null) {
			if ($this->isNew()) {
				$this->collPcContactNotes = array();
			} else {

				$criteria->add(PcContactNotePeer::CONTACT_ID, $this->id);

				$this->collPcContactNotes = PcContactNotePeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcContactNotePeer::CONTACT_ID, $this->id);

			if (!isset($this->lastPcContactNoteCriteria) || !$this->lastPcContactNoteCriteria->equals($criteria)) {
				$this->collPcContactNotes = PcContactNotePeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcContactNoteCriteria = $criteria;

		return $this->collPcContactNotes;
	}

	/**
	 * Clears out the collPcReviews collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcReviews()
	 */
	public function clearPcReviews()
	{
		$this->collPcReviews = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcReviews collection (array).
	 *
	 * By default this just sets the collPcReviews collection to an empty array (like clearcollPcReviews());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcReviews()
	{
		$this->collPcReviews = array();
	}

	/**
	 * Gets an array of PcReview objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcContact has previously been saved, it will retrieve
	 * related PcReviews from storage. If this PcContact is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcReview[]
	 * @throws     PropelException
	 */
	public function getPcReviews($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcReviews === null) {
			if ($this->isNew()) {
			   $this->collPcReviews = array();
			} else {

				$criteria->add(PcReviewPeer::CONTACT_ID, $this->id);

				PcReviewPeer::addSelectColumns($criteria);
				$this->collPcReviews = PcReviewPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcReviewPeer::CONTACT_ID, $this->id);

				PcReviewPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcReviewCriteria) || !$this->lastPcReviewCriteria->equals($criteria)) {
					$this->collPcReviews = PcReviewPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcReviewCriteria = $criteria;
		return $this->collPcReviews;
	}

	/**
	 * Returns the number of related PcReview objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcReview objects.
	 * @throws     PropelException
	 */
	public function countPcReviews(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcContactPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcReviews === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcReviewPeer::CONTACT_ID, $this->id);

				$count = PcReviewPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcReviewPeer::CONTACT_ID, $this->id);

				if (!isset($this->lastPcReviewCriteria) || !$this->lastPcReviewCriteria->equals($criteria)) {
					$count = PcReviewPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcReviews);
				}
			} else {
				$count = count($this->collPcReviews);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcReview object to this object
	 * through the PcReview foreign key attribute.
	 *
	 * @param      PcReview $l PcReview
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcReview(PcReview $l)
	{
		if ($this->collPcReviews === null) {
			$this->initPcReviews();
		}
		if (!in_array($l, $this->collPcReviews, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcReviews, $l);
			$l->setPcContact($this);
		}
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
			if ($this->collPcReviews) {
				foreach ((array) $this->collPcReviews as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collPcContactsTagss = null;
		$this->collPcContactNotes = null;
		$this->collPcReviews = null;
			$this->aPcUser = null;
			$this->aPcContactCompany = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcContact:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcContact::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcContact
