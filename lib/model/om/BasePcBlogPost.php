<?php

/**
 * Base class that represents a row from the 'pc_blog_post' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcBlogPost extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcBlogPostPeer
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
	 * The value for the title field.
	 * @var        string
	 */
	protected $title;

	/**
	 * The value for the slug field.
	 * @var        string
	 */
	protected $slug;

	/**
	 * The value for the content field.
	 * @var        string
	 */
	protected $content;

	/**
	 * The value for the italian_url field.
	 * @var        string
	 */
	protected $italian_url;

	/**
	 * The value for the is_reviewed field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_reviewed;

	/**
	 * The value for the is_published field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_published;

	/**
	 * The value for the published_at field.
	 * @var        string
	 */
	protected $published_at;

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
	 * @var        array PcBlogCategoriesPosts[] Collection to store aggregation of PcBlogCategoriesPosts objects.
	 */
	protected $collPcBlogCategoriesPostss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcBlogCategoriesPostss.
	 */
	private $lastPcBlogCategoriesPostsCriteria = null;

	/**
	 * @var        array PcBlogComment[] Collection to store aggregation of PcBlogComment objects.
	 */
	protected $collPcBlogComments;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcBlogComments.
	 */
	private $lastPcBlogCommentCriteria = null;

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
	
	const PEER = 'PcBlogPostPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_reviewed = false;
		$this->is_published = false;
	}

	/**
	 * Initializes internal state of BasePcBlogPost object.
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
	 * Get the [title] column value.
	 * 
	 * @return     string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Get the [slug] column value.
	 * 
	 * @return     string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * Get the [content] column value.
	 * 
	 * @return     string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Get the [italian_url] column value.
	 * 
	 * @return     string
	 */
	public function getItalianUrl()
	{
		return $this->italian_url;
	}

	/**
	 * Get the [is_reviewed] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsReviewed()
	{
		return $this->is_reviewed;
	}

	/**
	 * Get the [is_published] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsPublished()
	{
		return $this->is_published;
	}

	/**
	 * Get the [optionally formatted] temporal [published_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getPublishedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->published_at === null) {
			return null;
		}


		if ($this->published_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->published_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->published_at, true), $x);
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
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::USER_ID;
		}

		if ($this->aPcUser !== null && $this->aPcUser->getId() !== $v) {
			$this->aPcUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setTitle($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::TITLE;
		}

		return $this;
	} // setTitle()

	/**
	 * Set the value of [slug] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setSlug($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->slug !== $v) {
			$this->slug = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::SLUG;
		}

		return $this;
	} // setSlug()

	/**
	 * Set the value of [content] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setContent($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::CONTENT;
		}

		return $this;
	} // setContent()

	/**
	 * Set the value of [italian_url] column.
	 * 
	 * @param      string $v new value
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setItalianUrl($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->italian_url !== $v) {
			$this->italian_url = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::ITALIAN_URL;
		}

		return $this;
	} // setItalianUrl()

	/**
	 * Set the value of [is_reviewed] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setIsReviewed($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_reviewed !== $v || $this->isNew()) {
			$this->is_reviewed = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::IS_REVIEWED;
		}

		return $this;
	} // setIsReviewed()

	/**
	 * Set the value of [is_published] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setIsPublished($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_published !== $v || $this->isNew()) {
			$this->is_published = $v;
			$this->modifiedColumns[] = PcBlogPostPeer::IS_PUBLISHED;
		}

		return $this;
	} // setIsPublished()

	/**
	 * Sets the value of [published_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcBlogPost The current object (for fluent API support)
	 */
	public function setPublishedAt($v)
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

		if ( $this->published_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->published_at !== null && $tmpDt = new DateTime($this->published_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->published_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PcBlogPostPeer::PUBLISHED_AT;
			}
		} // if either are not null

		return $this;
	} // setPublishedAt()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcBlogPost The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcBlogPostPeer::CREATED_AT;
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
			if ($this->is_reviewed !== false) {
				return false;
			}

			if ($this->is_published !== false) {
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
			$this->title = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->slug = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->content = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->italian_url = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->is_reviewed = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
			$this->is_published = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->published_at = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->created_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 10; // 10 = PcBlogPostPeer::NUM_COLUMNS - PcBlogPostPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcBlogPost object", $e);
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
			$con = Propel::getConnection(PcBlogPostPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcBlogPostPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcUser = null;
			$this->collPcBlogCategoriesPostss = null;
			$this->lastPcBlogCategoriesPostsCriteria = null;

			$this->collPcBlogComments = null;
			$this->lastPcBlogCommentCriteria = null;

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
			$con = Propel::getConnection(PcBlogPostPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcBlogPost:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcBlogPostPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcBlogPost:delete:post') as $callable)
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
			$con = Propel::getConnection(PcBlogPostPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcBlogPost:save:pre') as $callable)
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
				if (!$this->isColumnModified(PcBlogPostPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcBlogPost:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcBlogPostPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = PcBlogPostPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcBlogPostPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcBlogPostPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPcBlogCategoriesPostss !== null) {
				foreach ($this->collPcBlogCategoriesPostss as $referrerFK) {
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


			if (($retval = PcBlogPostPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPcBlogCategoriesPostss !== null) {
					foreach ($this->collPcBlogCategoriesPostss as $referrerFK) {
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
		$pos = PcBlogPostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTitle();
				break;
			case 3:
				return $this->getSlug();
				break;
			case 4:
				return $this->getContent();
				break;
			case 5:
				return $this->getItalianUrl();
				break;
			case 6:
				return $this->getIsReviewed();
				break;
			case 7:
				return $this->getIsPublished();
				break;
			case 8:
				return $this->getPublishedAt();
				break;
			case 9:
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
		$keys = PcBlogPostPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getSlug(),
			$keys[4] => $this->getContent(),
			$keys[5] => $this->getItalianUrl(),
			$keys[6] => $this->getIsReviewed(),
			$keys[7] => $this->getIsPublished(),
			$keys[8] => $this->getPublishedAt(),
			$keys[9] => $this->getCreatedAt(),
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
		$pos = PcBlogPostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTitle($value);
				break;
			case 3:
				$this->setSlug($value);
				break;
			case 4:
				$this->setContent($value);
				break;
			case 5:
				$this->setItalianUrl($value);
				break;
			case 6:
				$this->setIsReviewed($value);
				break;
			case 7:
				$this->setIsPublished($value);
				break;
			case 8:
				$this->setPublishedAt($value);
				break;
			case 9:
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
		$keys = PcBlogPostPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSlug($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContent($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setItalianUrl($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsReviewed($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsPublished($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPublishedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedAt($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcBlogPostPeer::ID)) $criteria->add(PcBlogPostPeer::ID, $this->id);
		if ($this->isColumnModified(PcBlogPostPeer::USER_ID)) $criteria->add(PcBlogPostPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(PcBlogPostPeer::TITLE)) $criteria->add(PcBlogPostPeer::TITLE, $this->title);
		if ($this->isColumnModified(PcBlogPostPeer::SLUG)) $criteria->add(PcBlogPostPeer::SLUG, $this->slug);
		if ($this->isColumnModified(PcBlogPostPeer::CONTENT)) $criteria->add(PcBlogPostPeer::CONTENT, $this->content);
		if ($this->isColumnModified(PcBlogPostPeer::ITALIAN_URL)) $criteria->add(PcBlogPostPeer::ITALIAN_URL, $this->italian_url);
		if ($this->isColumnModified(PcBlogPostPeer::IS_REVIEWED)) $criteria->add(PcBlogPostPeer::IS_REVIEWED, $this->is_reviewed);
		if ($this->isColumnModified(PcBlogPostPeer::IS_PUBLISHED)) $criteria->add(PcBlogPostPeer::IS_PUBLISHED, $this->is_published);
		if ($this->isColumnModified(PcBlogPostPeer::PUBLISHED_AT)) $criteria->add(PcBlogPostPeer::PUBLISHED_AT, $this->published_at);
		if ($this->isColumnModified(PcBlogPostPeer::CREATED_AT)) $criteria->add(PcBlogPostPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);

		$criteria->add(PcBlogPostPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcBlogPost (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setTitle($this->title);

		$copyObj->setSlug($this->slug);

		$copyObj->setContent($this->content);

		$copyObj->setItalianUrl($this->italian_url);

		$copyObj->setIsReviewed($this->is_reviewed);

		$copyObj->setIsPublished($this->is_published);

		$copyObj->setPublishedAt($this->published_at);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPcBlogCategoriesPostss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcBlogCategoriesPosts($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcBlogComments() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcBlogComment($relObj->copy($deepCopy));
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
	 * @return     PcBlogPost Clone of current object.
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
	 * @return     PcBlogPostPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcBlogPostPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcUser object.
	 *
	 * @param      PcUser $v
	 * @return     PcBlogPost The current object (for fluent API support)
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
			$v->addPcBlogPost($this);
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
			   $this->aPcUser->addPcBlogPosts($this);
			 */
		}
		return $this->aPcUser;
	}

	/**
	 * Clears out the collPcBlogCategoriesPostss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcBlogCategoriesPostss()
	 */
	public function clearPcBlogCategoriesPostss()
	{
		$this->collPcBlogCategoriesPostss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcBlogCategoriesPostss collection (array).
	 *
	 * By default this just sets the collPcBlogCategoriesPostss collection to an empty array (like clearcollPcBlogCategoriesPostss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcBlogCategoriesPostss()
	{
		$this->collPcBlogCategoriesPostss = array();
	}

	/**
	 * Gets an array of PcBlogCategoriesPosts objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcBlogPost has previously been saved, it will retrieve
	 * related PcBlogCategoriesPostss from storage. If this PcBlogPost is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcBlogCategoriesPosts[]
	 * @throws     PropelException
	 */
	public function getPcBlogCategoriesPostss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcBlogCategoriesPostss === null) {
			if ($this->isNew()) {
			   $this->collPcBlogCategoriesPostss = array();
			} else {

				$criteria->add(PcBlogCategoriesPostsPeer::POST_ID, $this->id);

				PcBlogCategoriesPostsPeer::addSelectColumns($criteria);
				$this->collPcBlogCategoriesPostss = PcBlogCategoriesPostsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcBlogCategoriesPostsPeer::POST_ID, $this->id);

				PcBlogCategoriesPostsPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcBlogCategoriesPostsCriteria) || !$this->lastPcBlogCategoriesPostsCriteria->equals($criteria)) {
					$this->collPcBlogCategoriesPostss = PcBlogCategoriesPostsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcBlogCategoriesPostsCriteria = $criteria;
		return $this->collPcBlogCategoriesPostss;
	}

	/**
	 * Returns the number of related PcBlogCategoriesPosts objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcBlogCategoriesPosts objects.
	 * @throws     PropelException
	 */
	public function countPcBlogCategoriesPostss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcBlogCategoriesPostss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcBlogCategoriesPostsPeer::POST_ID, $this->id);

				$count = PcBlogCategoriesPostsPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcBlogCategoriesPostsPeer::POST_ID, $this->id);

				if (!isset($this->lastPcBlogCategoriesPostsCriteria) || !$this->lastPcBlogCategoriesPostsCriteria->equals($criteria)) {
					$count = PcBlogCategoriesPostsPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcBlogCategoriesPostss);
				}
			} else {
				$count = count($this->collPcBlogCategoriesPostss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcBlogCategoriesPosts object to this object
	 * through the PcBlogCategoriesPosts foreign key attribute.
	 *
	 * @param      PcBlogCategoriesPosts $l PcBlogCategoriesPosts
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcBlogCategoriesPosts(PcBlogCategoriesPosts $l)
	{
		if ($this->collPcBlogCategoriesPostss === null) {
			$this->initPcBlogCategoriesPostss();
		}
		if (!in_array($l, $this->collPcBlogCategoriesPostss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcBlogCategoriesPostss, $l);
			$l->setPcBlogPost($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcBlogPost is new, it will return
	 * an empty collection; or if this PcBlogPost has previously
	 * been saved, it will retrieve related PcBlogCategoriesPostss from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcBlogPost.
	 */
	public function getPcBlogCategoriesPostssJoinPcBlogCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcBlogCategoriesPostss === null) {
			if ($this->isNew()) {
				$this->collPcBlogCategoriesPostss = array();
			} else {

				$criteria->add(PcBlogCategoriesPostsPeer::POST_ID, $this->id);

				$this->collPcBlogCategoriesPostss = PcBlogCategoriesPostsPeer::doSelectJoinPcBlogCategory($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcBlogCategoriesPostsPeer::POST_ID, $this->id);

			if (!isset($this->lastPcBlogCategoriesPostsCriteria) || !$this->lastPcBlogCategoriesPostsCriteria->equals($criteria)) {
				$this->collPcBlogCategoriesPostss = PcBlogCategoriesPostsPeer::doSelectJoinPcBlogCategory($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcBlogCategoriesPostsCriteria = $criteria;

		return $this->collPcBlogCategoriesPostss;
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
	 * Otherwise if this PcBlogPost has previously been saved, it will retrieve
	 * related PcBlogComments from storage. If this PcBlogPost is new, it will return
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
			$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcBlogComments === null) {
			if ($this->isNew()) {
			   $this->collPcBlogComments = array();
			} else {

				$criteria->add(PcBlogCommentPeer::POST_ID, $this->id);

				PcBlogCommentPeer::addSelectColumns($criteria);
				$this->collPcBlogComments = PcBlogCommentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcBlogCommentPeer::POST_ID, $this->id);

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
			$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);
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

				$criteria->add(PcBlogCommentPeer::POST_ID, $this->id);

				$count = PcBlogCommentPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcBlogCommentPeer::POST_ID, $this->id);

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
			$l->setPcBlogPost($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcBlogPost is new, it will return
	 * an empty collection; or if this PcBlogPost has previously
	 * been saved, it will retrieve related PcBlogComments from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcBlogPost.
	 */
	public function getPcBlogCommentsJoinPcUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcBlogPostPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcBlogComments === null) {
			if ($this->isNew()) {
				$this->collPcBlogComments = array();
			} else {

				$criteria->add(PcBlogCommentPeer::POST_ID, $this->id);

				$this->collPcBlogComments = PcBlogCommentPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcBlogCommentPeer::POST_ID, $this->id);

			if (!isset($this->lastPcBlogCommentCriteria) || !$this->lastPcBlogCommentCriteria->equals($criteria)) {
				$this->collPcBlogComments = PcBlogCommentPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcBlogCommentCriteria = $criteria;

		return $this->collPcBlogComments;
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
			if ($this->collPcBlogCategoriesPostss) {
				foreach ((array) $this->collPcBlogCategoriesPostss as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcBlogComments) {
				foreach ((array) $this->collPcBlogComments as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collPcBlogCategoriesPostss = null;
		$this->collPcBlogComments = null;
			$this->aPcUser = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcBlogPost:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcBlogPost::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcBlogPost
