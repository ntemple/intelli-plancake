<?php

/**
 * Base class that represents a row from the 'pc_subscription' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcSubscription extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcSubscriptionPeer
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
	 * The value for the subscription_type_id field.
	 * @var        int
	 */
	protected $subscription_type_id;

	/**
	 * The value for the was_gift field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $was_gift;

	/**
	 * The value for the was_automatic field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $was_automatic;

	/**
	 * The value for the paypal_transaction_id field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $paypal_transaction_id;

	/**
	 * The value for the is_refunded_or_reversed field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_refunded_or_reversed;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * @var        PcSubscriptionType
	 */
	protected $aPcSubscriptionType;

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
	
	const PEER = 'PcSubscriptionPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->was_gift = false;
		$this->was_automatic = false;
		$this->paypal_transaction_id = '';
		$this->is_refunded_or_reversed = false;
	}

	/**
	 * Initializes internal state of BasePcSubscription object.
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
	 * Get the [subscription_type_id] column value.
	 * 
	 * @return     int
	 */
	public function getSubscriptionTypeId()
	{
		return $this->subscription_type_id;
	}

	/**
	 * Get the [was_gift] column value.
	 * 
	 * @return     boolean
	 */
	public function getWasGift()
	{
		return $this->was_gift;
	}

	/**
	 * Get the [was_automatic] column value.
	 * 
	 * @return     boolean
	 */
	public function getWasAutomatic()
	{
		return $this->was_automatic;
	}

	/**
	 * Get the [paypal_transaction_id] column value.
	 * 
	 * @return     string
	 */
	public function getPaypalTransactionId()
	{
		return $this->paypal_transaction_id;
	}

	/**
	 * Get the [is_refunded_or_reversed] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsRefundedOrReversed()
	{
		return $this->is_refunded_or_reversed;
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
	 * @return     PcSubscription The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcSubscriptionPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcSubscription The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = PcSubscriptionPeer::USER_ID;
		}

		if ($this->aPcUser !== null && $this->aPcUser->getId() !== $v) {
			$this->aPcUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [subscription_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcSubscription The current object (for fluent API support)
	 */
	public function setSubscriptionTypeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->subscription_type_id !== $v) {
			$this->subscription_type_id = $v;
			$this->modifiedColumns[] = PcSubscriptionPeer::SUBSCRIPTION_TYPE_ID;
		}

		if ($this->aPcSubscriptionType !== null && $this->aPcSubscriptionType->getId() !== $v) {
			$this->aPcSubscriptionType = null;
		}

		return $this;
	} // setSubscriptionTypeId()

	/**
	 * Set the value of [was_gift] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcSubscription The current object (for fluent API support)
	 */
	public function setWasGift($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->was_gift !== $v || $this->isNew()) {
			$this->was_gift = $v;
			$this->modifiedColumns[] = PcSubscriptionPeer::WAS_GIFT;
		}

		return $this;
	} // setWasGift()

	/**
	 * Set the value of [was_automatic] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcSubscription The current object (for fluent API support)
	 */
	public function setWasAutomatic($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->was_automatic !== $v || $this->isNew()) {
			$this->was_automatic = $v;
			$this->modifiedColumns[] = PcSubscriptionPeer::WAS_AUTOMATIC;
		}

		return $this;
	} // setWasAutomatic()

	/**
	 * Set the value of [paypal_transaction_id] column.
	 * 
	 * @param      string $v new value
	 * @return     PcSubscription The current object (for fluent API support)
	 */
	public function setPaypalTransactionId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->paypal_transaction_id !== $v || $this->isNew()) {
			$this->paypal_transaction_id = $v;
			$this->modifiedColumns[] = PcSubscriptionPeer::PAYPAL_TRANSACTION_ID;
		}

		return $this;
	} // setPaypalTransactionId()

	/**
	 * Set the value of [is_refunded_or_reversed] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcSubscription The current object (for fluent API support)
	 */
	public function setIsRefundedOrReversed($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_refunded_or_reversed !== $v || $this->isNew()) {
			$this->is_refunded_or_reversed = $v;
			$this->modifiedColumns[] = PcSubscriptionPeer::IS_REFUNDED_OR_REVERSED;
		}

		return $this;
	} // setIsRefundedOrReversed()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcSubscription The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcSubscriptionPeer::CREATED_AT;
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
			if ($this->was_gift !== false) {
				return false;
			}

			if ($this->was_automatic !== false) {
				return false;
			}

			if ($this->paypal_transaction_id !== '') {
				return false;
			}

			if ($this->is_refunded_or_reversed !== false) {
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
			$this->subscription_type_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->was_gift = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
			$this->was_automatic = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
			$this->paypal_transaction_id = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->is_refunded_or_reversed = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
			$this->created_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 8; // 8 = PcSubscriptionPeer::NUM_COLUMNS - PcSubscriptionPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcSubscription object", $e);
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
		if ($this->aPcSubscriptionType !== null && $this->subscription_type_id !== $this->aPcSubscriptionType->getId()) {
			$this->aPcSubscriptionType = null;
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
			$con = Propel::getConnection(PcSubscriptionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcSubscriptionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcSubscriptionType = null;
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
			$con = Propel::getConnection(PcSubscriptionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcSubscription:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcSubscriptionPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcSubscription:delete:post') as $callable)
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
			$con = Propel::getConnection(PcSubscriptionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcSubscription:save:pre') as $callable)
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
				if (!$this->isColumnModified(PcSubscriptionPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcSubscription:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcSubscriptionPeer::addInstanceToPool($this);
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

			if ($this->aPcSubscriptionType !== null) {
				if ($this->aPcSubscriptionType->isModified() || $this->aPcSubscriptionType->isNew()) {
					$affectedRows += $this->aPcSubscriptionType->save($con);
				}
				$this->setPcSubscriptionType($this->aPcSubscriptionType);
			}

			if ($this->aPcUser !== null) {
				if ($this->aPcUser->isModified() || $this->aPcUser->isNew()) {
					$affectedRows += $this->aPcUser->save($con);
				}
				$this->setPcUser($this->aPcUser);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PcSubscriptionPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcSubscriptionPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcSubscriptionPeer::doUpdate($this, $con);
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

			if ($this->aPcSubscriptionType !== null) {
				if (!$this->aPcSubscriptionType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcSubscriptionType->getValidationFailures());
				}
			}

			if ($this->aPcUser !== null) {
				if (!$this->aPcUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcUser->getValidationFailures());
				}
			}


			if (($retval = PcSubscriptionPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PcSubscriptionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSubscriptionTypeId();
				break;
			case 3:
				return $this->getWasGift();
				break;
			case 4:
				return $this->getWasAutomatic();
				break;
			case 5:
				return $this->getPaypalTransactionId();
				break;
			case 6:
				return $this->getIsRefundedOrReversed();
				break;
			case 7:
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
		$keys = PcSubscriptionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUserId(),
			$keys[2] => $this->getSubscriptionTypeId(),
			$keys[3] => $this->getWasGift(),
			$keys[4] => $this->getWasAutomatic(),
			$keys[5] => $this->getPaypalTransactionId(),
			$keys[6] => $this->getIsRefundedOrReversed(),
			$keys[7] => $this->getCreatedAt(),
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
		$pos = PcSubscriptionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSubscriptionTypeId($value);
				break;
			case 3:
				$this->setWasGift($value);
				break;
			case 4:
				$this->setWasAutomatic($value);
				break;
			case 5:
				$this->setPaypalTransactionId($value);
				break;
			case 6:
				$this->setIsRefundedOrReversed($value);
				break;
			case 7:
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
		$keys = PcSubscriptionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSubscriptionTypeId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setWasGift($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setWasAutomatic($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPaypalTransactionId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsRefundedOrReversed($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcSubscriptionPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcSubscriptionPeer::ID)) $criteria->add(PcSubscriptionPeer::ID, $this->id);
		if ($this->isColumnModified(PcSubscriptionPeer::USER_ID)) $criteria->add(PcSubscriptionPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(PcSubscriptionPeer::SUBSCRIPTION_TYPE_ID)) $criteria->add(PcSubscriptionPeer::SUBSCRIPTION_TYPE_ID, $this->subscription_type_id);
		if ($this->isColumnModified(PcSubscriptionPeer::WAS_GIFT)) $criteria->add(PcSubscriptionPeer::WAS_GIFT, $this->was_gift);
		if ($this->isColumnModified(PcSubscriptionPeer::WAS_AUTOMATIC)) $criteria->add(PcSubscriptionPeer::WAS_AUTOMATIC, $this->was_automatic);
		if ($this->isColumnModified(PcSubscriptionPeer::PAYPAL_TRANSACTION_ID)) $criteria->add(PcSubscriptionPeer::PAYPAL_TRANSACTION_ID, $this->paypal_transaction_id);
		if ($this->isColumnModified(PcSubscriptionPeer::IS_REFUNDED_OR_REVERSED)) $criteria->add(PcSubscriptionPeer::IS_REFUNDED_OR_REVERSED, $this->is_refunded_or_reversed);
		if ($this->isColumnModified(PcSubscriptionPeer::CREATED_AT)) $criteria->add(PcSubscriptionPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(PcSubscriptionPeer::DATABASE_NAME);

		$criteria->add(PcSubscriptionPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcSubscription (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUserId($this->user_id);

		$copyObj->setSubscriptionTypeId($this->subscription_type_id);

		$copyObj->setWasGift($this->was_gift);

		$copyObj->setWasAutomatic($this->was_automatic);

		$copyObj->setPaypalTransactionId($this->paypal_transaction_id);

		$copyObj->setIsRefundedOrReversed($this->is_refunded_or_reversed);

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
	 * @return     PcSubscription Clone of current object.
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
	 * @return     PcSubscriptionPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcSubscriptionPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcSubscriptionType object.
	 *
	 * @param      PcSubscriptionType $v
	 * @return     PcSubscription The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcSubscriptionType(PcSubscriptionType $v = null)
	{
		if ($v === null) {
			$this->setSubscriptionTypeId(NULL);
		} else {
			$this->setSubscriptionTypeId($v->getId());
		}

		$this->aPcSubscriptionType = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcSubscriptionType object, it will not be re-added.
		if ($v !== null) {
			$v->addPcSubscription($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcSubscriptionType object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcSubscriptionType The associated PcSubscriptionType object.
	 * @throws     PropelException
	 */
	public function getPcSubscriptionType(PropelPDO $con = null)
	{
		if ($this->aPcSubscriptionType === null && ($this->subscription_type_id !== null)) {
			$this->aPcSubscriptionType = PcSubscriptionTypePeer::retrieveByPk($this->subscription_type_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcSubscriptionType->addPcSubscriptions($this);
			 */
		}
		return $this->aPcSubscriptionType;
	}

	/**
	 * Declares an association between this object and a PcUser object.
	 *
	 * @param      PcUser $v
	 * @return     PcSubscription The current object (for fluent API support)
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
			$v->addPcSubscription($this);
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
			   $this->aPcUser->addPcSubscriptions($this);
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

			$this->aPcSubscriptionType = null;
			$this->aPcUser = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcSubscription:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcSubscription::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcSubscription
