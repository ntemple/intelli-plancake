<?php

/**
 * Base class that represents a row from the 'pc_string' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcString extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcStringPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        string
	 */
	protected $id;

	/**
	 * The value for the category_id field.
	 * @var        int
	 */
	protected $category_id;

	/**
	 * The value for the sort_order_in_category field.
	 * @var        int
	 */
	protected $sort_order_in_category;

	/**
	 * The value for the max_length field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $max_length;

	/**
	 * The value for the note field.
	 * @var        string
	 */
	protected $note;

	/**
	 * The value for the is_archived field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_archived;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * @var        PcStringCategory
	 */
	protected $aPcStringCategory;

	/**
	 * @var        array PcTranslation[] Collection to store aggregation of PcTranslation objects.
	 */
	protected $collPcTranslations;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcTranslations.
	 */
	private $lastPcTranslationCriteria = null;

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
	
	const PEER = 'PcStringPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->max_length = 0;
		$this->is_archived = false;
	}

	/**
	 * Initializes internal state of BasePcString object.
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
	 * @return     string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [category_id] column value.
	 * 
	 * @return     int
	 */
	public function getCategoryId()
	{
		return $this->category_id;
	}

	/**
	 * Get the [sort_order_in_category] column value.
	 * 
	 * @return     int
	 */
	public function getSortOrderInCategory()
	{
		return $this->sort_order_in_category;
	}

	/**
	 * Get the [max_length] column value.
	 * 
	 * @return     int
	 */
	public function getMaxLength()
	{
		return $this->max_length;
	}

	/**
	 * Get the [note] column value.
	 * 
	 * @return     string
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * Get the [is_archived] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsArchived()
	{
		return $this->is_archived;
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
	 * @param      string $v new value
	 * @return     PcString The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcStringPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [category_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcString The current object (for fluent API support)
	 */
	public function setCategoryId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->category_id !== $v) {
			$this->category_id = $v;
			$this->modifiedColumns[] = PcStringPeer::CATEGORY_ID;
		}

		if ($this->aPcStringCategory !== null && $this->aPcStringCategory->getId() !== $v) {
			$this->aPcStringCategory = null;
		}

		return $this;
	} // setCategoryId()

	/**
	 * Set the value of [sort_order_in_category] column.
	 * 
	 * @param      int $v new value
	 * @return     PcString The current object (for fluent API support)
	 */
	public function setSortOrderInCategory($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sort_order_in_category !== $v) {
			$this->sort_order_in_category = $v;
			$this->modifiedColumns[] = PcStringPeer::SORT_ORDER_IN_CATEGORY;
		}

		return $this;
	} // setSortOrderInCategory()

	/**
	 * Set the value of [max_length] column.
	 * 
	 * @param      int $v new value
	 * @return     PcString The current object (for fluent API support)
	 */
	public function setMaxLength($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->max_length !== $v || $this->isNew()) {
			$this->max_length = $v;
			$this->modifiedColumns[] = PcStringPeer::MAX_LENGTH;
		}

		return $this;
	} // setMaxLength()

	/**
	 * Set the value of [note] column.
	 * 
	 * @param      string $v new value
	 * @return     PcString The current object (for fluent API support)
	 */
	public function setNote($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->note !== $v) {
			$this->note = $v;
			$this->modifiedColumns[] = PcStringPeer::NOTE;
		}

		return $this;
	} // setNote()

	/**
	 * Set the value of [is_archived] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcString The current object (for fluent API support)
	 */
	public function setIsArchived($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_archived !== $v || $this->isNew()) {
			$this->is_archived = $v;
			$this->modifiedColumns[] = PcStringPeer::IS_ARCHIVED;
		}

		return $this;
	} // setIsArchived()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcString The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcStringPeer::CREATED_AT;
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
			if ($this->max_length !== 0) {
				return false;
			}

			if ($this->is_archived !== false) {
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

			$this->id = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
			$this->category_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->sort_order_in_category = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->max_length = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->note = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->is_archived = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->created_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 7; // 7 = PcStringPeer::NUM_COLUMNS - PcStringPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcString object", $e);
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

		if ($this->aPcStringCategory !== null && $this->category_id !== $this->aPcStringCategory->getId()) {
			$this->aPcStringCategory = null;
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
			$con = Propel::getConnection(PcStringPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcStringPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcStringCategory = null;
			$this->collPcTranslations = null;
			$this->lastPcTranslationCriteria = null;

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
			$con = Propel::getConnection(PcStringPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcString:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcStringPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcString:delete:post') as $callable)
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
			$con = Propel::getConnection(PcStringPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcString:save:pre') as $callable)
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
				if (!$this->isColumnModified(PcStringPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcString:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcStringPeer::addInstanceToPool($this);
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

			if ($this->aPcStringCategory !== null) {
				if ($this->aPcStringCategory->isModified() || $this->aPcStringCategory->isNew()) {
					$affectedRows += $this->aPcStringCategory->save($con);
				}
				$this->setPcStringCategory($this->aPcStringCategory);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcStringPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += PcStringPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPcTranslations !== null) {
				foreach ($this->collPcTranslations as $referrerFK) {
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

			if ($this->aPcStringCategory !== null) {
				if (!$this->aPcStringCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcStringCategory->getValidationFailures());
				}
			}


			if (($retval = PcStringPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPcTranslations !== null) {
					foreach ($this->collPcTranslations as $referrerFK) {
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
		$pos = PcStringPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCategoryId();
				break;
			case 2:
				return $this->getSortOrderInCategory();
				break;
			case 3:
				return $this->getMaxLength();
				break;
			case 4:
				return $this->getNote();
				break;
			case 5:
				return $this->getIsArchived();
				break;
			case 6:
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
		$keys = PcStringPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCategoryId(),
			$keys[2] => $this->getSortOrderInCategory(),
			$keys[3] => $this->getMaxLength(),
			$keys[4] => $this->getNote(),
			$keys[5] => $this->getIsArchived(),
			$keys[6] => $this->getCreatedAt(),
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
		$pos = PcStringPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCategoryId($value);
				break;
			case 2:
				$this->setSortOrderInCategory($value);
				break;
			case 3:
				$this->setMaxLength($value);
				break;
			case 4:
				$this->setNote($value);
				break;
			case 5:
				$this->setIsArchived($value);
				break;
			case 6:
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
		$keys = PcStringPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSortOrderInCategory($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMaxLength($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNote($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsArchived($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcStringPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcStringPeer::ID)) $criteria->add(PcStringPeer::ID, $this->id);
		if ($this->isColumnModified(PcStringPeer::CATEGORY_ID)) $criteria->add(PcStringPeer::CATEGORY_ID, $this->category_id);
		if ($this->isColumnModified(PcStringPeer::SORT_ORDER_IN_CATEGORY)) $criteria->add(PcStringPeer::SORT_ORDER_IN_CATEGORY, $this->sort_order_in_category);
		if ($this->isColumnModified(PcStringPeer::MAX_LENGTH)) $criteria->add(PcStringPeer::MAX_LENGTH, $this->max_length);
		if ($this->isColumnModified(PcStringPeer::NOTE)) $criteria->add(PcStringPeer::NOTE, $this->note);
		if ($this->isColumnModified(PcStringPeer::IS_ARCHIVED)) $criteria->add(PcStringPeer::IS_ARCHIVED, $this->is_archived);
		if ($this->isColumnModified(PcStringPeer::CREATED_AT)) $criteria->add(PcStringPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(PcStringPeer::DATABASE_NAME);

		$criteria->add(PcStringPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     string
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      string $key Primary key.
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
	 * @param      object $copyObj An object of PcString (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setId($this->id);

		$copyObj->setCategoryId($this->category_id);

		$copyObj->setSortOrderInCategory($this->sort_order_in_category);

		$copyObj->setMaxLength($this->max_length);

		$copyObj->setNote($this->note);

		$copyObj->setIsArchived($this->is_archived);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPcTranslations() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcTranslation($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

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
	 * @return     PcString Clone of current object.
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
	 * @return     PcStringPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcStringPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcStringCategory object.
	 *
	 * @param      PcStringCategory $v
	 * @return     PcString The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPcStringCategory(PcStringCategory $v = null)
	{
		if ($v === null) {
			$this->setCategoryId(NULL);
		} else {
			$this->setCategoryId($v->getId());
		}

		$this->aPcStringCategory = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the PcStringCategory object, it will not be re-added.
		if ($v !== null) {
			$v->addPcString($this);
		}

		return $this;
	}


	/**
	 * Get the associated PcStringCategory object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     PcStringCategory The associated PcStringCategory object.
	 * @throws     PropelException
	 */
	public function getPcStringCategory(PropelPDO $con = null)
	{
		if ($this->aPcStringCategory === null && ($this->category_id !== null)) {
			$this->aPcStringCategory = PcStringCategoryPeer::retrieveByPk($this->category_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPcStringCategory->addPcStrings($this);
			 */
		}
		return $this->aPcStringCategory;
	}

	/**
	 * Clears out the collPcTranslations collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcTranslations()
	 */
	public function clearPcTranslations()
	{
		$this->collPcTranslations = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcTranslations collection (array).
	 *
	 * By default this just sets the collPcTranslations collection to an empty array (like clearcollPcTranslations());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcTranslations()
	{
		$this->collPcTranslations = array();
	}

	/**
	 * Gets an array of PcTranslation objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcString has previously been saved, it will retrieve
	 * related PcTranslations from storage. If this PcString is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcTranslation[]
	 * @throws     PropelException
	 */
	public function getPcTranslations($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcStringPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcTranslations === null) {
			if ($this->isNew()) {
			   $this->collPcTranslations = array();
			} else {

				$criteria->add(PcTranslationPeer::STRING_ID, $this->id);

				PcTranslationPeer::addSelectColumns($criteria);
				$this->collPcTranslations = PcTranslationPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcTranslationPeer::STRING_ID, $this->id);

				PcTranslationPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcTranslationCriteria) || !$this->lastPcTranslationCriteria->equals($criteria)) {
					$this->collPcTranslations = PcTranslationPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcTranslationCriteria = $criteria;
		return $this->collPcTranslations;
	}

	/**
	 * Returns the number of related PcTranslation objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcTranslation objects.
	 * @throws     PropelException
	 */
	public function countPcTranslations(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcStringPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcTranslations === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcTranslationPeer::STRING_ID, $this->id);

				$count = PcTranslationPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcTranslationPeer::STRING_ID, $this->id);

				if (!isset($this->lastPcTranslationCriteria) || !$this->lastPcTranslationCriteria->equals($criteria)) {
					$count = PcTranslationPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcTranslations);
				}
			} else {
				$count = count($this->collPcTranslations);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcTranslation object to this object
	 * through the PcTranslation foreign key attribute.
	 *
	 * @param      PcTranslation $l PcTranslation
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcTranslation(PcTranslation $l)
	{
		if ($this->collPcTranslations === null) {
			$this->initPcTranslations();
		}
		if (!in_array($l, $this->collPcTranslations, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcTranslations, $l);
			$l->setPcString($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcString is new, it will return
	 * an empty collection; or if this PcString has previously
	 * been saved, it will retrieve related PcTranslations from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcString.
	 */
	public function getPcTranslationsJoinPcLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcStringPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcTranslations === null) {
			if ($this->isNew()) {
				$this->collPcTranslations = array();
			} else {

				$criteria->add(PcTranslationPeer::STRING_ID, $this->id);

				$this->collPcTranslations = PcTranslationPeer::doSelectJoinPcLanguage($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcTranslationPeer::STRING_ID, $this->id);

			if (!isset($this->lastPcTranslationCriteria) || !$this->lastPcTranslationCriteria->equals($criteria)) {
				$this->collPcTranslations = PcTranslationPeer::doSelectJoinPcLanguage($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcTranslationCriteria = $criteria;

		return $this->collPcTranslations;
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
			if ($this->collPcTranslations) {
				foreach ((array) $this->collPcTranslations as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collPcTranslations = null;
			$this->aPcStringCategory = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcString:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcString::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcString
