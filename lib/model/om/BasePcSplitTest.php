<?php

/**
 * Base class that represents a row from the 'pc_split_test' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcSplitTest extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcSplitTestPeer
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
	 * The value for the number_of_variants field.
	 * @var        int
	 */
	protected $number_of_variants;

	/**
	 * The value for the variants_description field.
	 * @var        string
	 */
	protected $variants_description;

	/**
	 * The value for the comment field.
	 * @var        string
	 */
	protected $comment;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * @var        array PcSplitTestResult[] Collection to store aggregation of PcSplitTestResult objects.
	 */
	protected $collPcSplitTestResults;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcSplitTestResults.
	 */
	private $lastPcSplitTestResultCriteria = null;

	/**
	 * @var        array PcSplitTestUserResult[] Collection to store aggregation of PcSplitTestUserResult objects.
	 */
	protected $collPcSplitTestUserResults;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcSplitTestUserResults.
	 */
	private $lastPcSplitTestUserResultCriteria = null;

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
	
	const PEER = 'PcSplitTestPeer';

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
	 * Get the [number_of_variants] column value.
	 * 
	 * @return     int
	 */
	public function getNumberOfVariants()
	{
		return $this->number_of_variants;
	}

	/**
	 * Get the [variants_description] column value.
	 * 
	 * @return     string
	 */
	public function getVariantsDescription()
	{
		return $this->variants_description;
	}

	/**
	 * Get the [comment] column value.
	 * 
	 * @return     string
	 */
	public function getComment()
	{
		return $this->comment;
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
	 * @return     PcSplitTest The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcSplitTestPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     PcSplitTest The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = PcSplitTestPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [number_of_variants] column.
	 * 
	 * @param      int $v new value
	 * @return     PcSplitTest The current object (for fluent API support)
	 */
	public function setNumberOfVariants($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->number_of_variants !== $v) {
			$this->number_of_variants = $v;
			$this->modifiedColumns[] = PcSplitTestPeer::NUMBER_OF_VARIANTS;
		}

		return $this;
	} // setNumberOfVariants()

	/**
	 * Set the value of [variants_description] column.
	 * 
	 * @param      string $v new value
	 * @return     PcSplitTest The current object (for fluent API support)
	 */
	public function setVariantsDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->variants_description !== $v) {
			$this->variants_description = $v;
			$this->modifiedColumns[] = PcSplitTestPeer::VARIANTS_DESCRIPTION;
		}

		return $this;
	} // setVariantsDescription()

	/**
	 * Set the value of [comment] column.
	 * 
	 * @param      string $v new value
	 * @return     PcSplitTest The current object (for fluent API support)
	 */
	public function setComment($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->comment !== $v) {
			$this->comment = $v;
			$this->modifiedColumns[] = PcSplitTestPeer::COMMENT;
		}

		return $this;
	} // setComment()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PcSplitTest The current object (for fluent API support)
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
				$this->modifiedColumns[] = PcSplitTestPeer::CREATED_AT;
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
			$this->number_of_variants = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->variants_description = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->comment = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = PcSplitTestPeer::NUM_COLUMNS - PcSplitTestPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcSplitTest object", $e);
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
			$con = Propel::getConnection(PcSplitTestPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcSplitTestPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collPcSplitTestResults = null;
			$this->lastPcSplitTestResultCriteria = null;

			$this->collPcSplitTestUserResults = null;
			$this->lastPcSplitTestUserResultCriteria = null;

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
			$con = Propel::getConnection(PcSplitTestPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcSplitTest:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcSplitTestPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcSplitTest:delete:post') as $callable)
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
			$con = Propel::getConnection(PcSplitTestPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcSplitTest:save:pre') as $callable)
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
				if (!$this->isColumnModified(PcSplitTestPeer::CREATED_AT))
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
				foreach (sfMixer::getCallables('BasePcSplitTest:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcSplitTestPeer::addInstanceToPool($this);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PcSplitTestPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcSplitTestPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcSplitTestPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPcSplitTestResults !== null) {
				foreach ($this->collPcSplitTestResults as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPcSplitTestUserResults !== null) {
				foreach ($this->collPcSplitTestUserResults as $referrerFK) {
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


			if (($retval = PcSplitTestPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPcSplitTestResults !== null) {
					foreach ($this->collPcSplitTestResults as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPcSplitTestUserResults !== null) {
					foreach ($this->collPcSplitTestUserResults as $referrerFK) {
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
		$pos = PcSplitTestPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getNumberOfVariants();
				break;
			case 3:
				return $this->getVariantsDescription();
				break;
			case 4:
				return $this->getComment();
				break;
			case 5:
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
		$keys = PcSplitTestPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getNumberOfVariants(),
			$keys[3] => $this->getVariantsDescription(),
			$keys[4] => $this->getComment(),
			$keys[5] => $this->getCreatedAt(),
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
		$pos = PcSplitTestPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setNumberOfVariants($value);
				break;
			case 3:
				$this->setVariantsDescription($value);
				break;
			case 4:
				$this->setComment($value);
				break;
			case 5:
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
		$keys = PcSplitTestPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNumberOfVariants($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setVariantsDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setComment($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcSplitTestPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcSplitTestPeer::ID)) $criteria->add(PcSplitTestPeer::ID, $this->id);
		if ($this->isColumnModified(PcSplitTestPeer::NAME)) $criteria->add(PcSplitTestPeer::NAME, $this->name);
		if ($this->isColumnModified(PcSplitTestPeer::NUMBER_OF_VARIANTS)) $criteria->add(PcSplitTestPeer::NUMBER_OF_VARIANTS, $this->number_of_variants);
		if ($this->isColumnModified(PcSplitTestPeer::VARIANTS_DESCRIPTION)) $criteria->add(PcSplitTestPeer::VARIANTS_DESCRIPTION, $this->variants_description);
		if ($this->isColumnModified(PcSplitTestPeer::COMMENT)) $criteria->add(PcSplitTestPeer::COMMENT, $this->comment);
		if ($this->isColumnModified(PcSplitTestPeer::CREATED_AT)) $criteria->add(PcSplitTestPeer::CREATED_AT, $this->created_at);

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
		$criteria = new Criteria(PcSplitTestPeer::DATABASE_NAME);

		$criteria->add(PcSplitTestPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcSplitTest (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setNumberOfVariants($this->number_of_variants);

		$copyObj->setVariantsDescription($this->variants_description);

		$copyObj->setComment($this->comment);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPcSplitTestResults() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcSplitTestResult($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcSplitTestUserResults() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcSplitTestUserResult($relObj->copy($deepCopy));
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
	 * @return     PcSplitTest Clone of current object.
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
	 * @return     PcSplitTestPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcSplitTestPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collPcSplitTestResults collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcSplitTestResults()
	 */
	public function clearPcSplitTestResults()
	{
		$this->collPcSplitTestResults = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcSplitTestResults collection (array).
	 *
	 * By default this just sets the collPcSplitTestResults collection to an empty array (like clearcollPcSplitTestResults());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcSplitTestResults()
	{
		$this->collPcSplitTestResults = array();
	}

	/**
	 * Gets an array of PcSplitTestResult objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcSplitTest has previously been saved, it will retrieve
	 * related PcSplitTestResults from storage. If this PcSplitTest is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcSplitTestResult[]
	 * @throws     PropelException
	 */
	public function getPcSplitTestResults($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcSplitTestPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcSplitTestResults === null) {
			if ($this->isNew()) {
			   $this->collPcSplitTestResults = array();
			} else {

				$criteria->add(PcSplitTestResultPeer::TEST_ID, $this->id);

				PcSplitTestResultPeer::addSelectColumns($criteria);
				$this->collPcSplitTestResults = PcSplitTestResultPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcSplitTestResultPeer::TEST_ID, $this->id);

				PcSplitTestResultPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcSplitTestResultCriteria) || !$this->lastPcSplitTestResultCriteria->equals($criteria)) {
					$this->collPcSplitTestResults = PcSplitTestResultPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcSplitTestResultCriteria = $criteria;
		return $this->collPcSplitTestResults;
	}

	/**
	 * Returns the number of related PcSplitTestResult objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcSplitTestResult objects.
	 * @throws     PropelException
	 */
	public function countPcSplitTestResults(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcSplitTestPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcSplitTestResults === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcSplitTestResultPeer::TEST_ID, $this->id);

				$count = PcSplitTestResultPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcSplitTestResultPeer::TEST_ID, $this->id);

				if (!isset($this->lastPcSplitTestResultCriteria) || !$this->lastPcSplitTestResultCriteria->equals($criteria)) {
					$count = PcSplitTestResultPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcSplitTestResults);
				}
			} else {
				$count = count($this->collPcSplitTestResults);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcSplitTestResult object to this object
	 * through the PcSplitTestResult foreign key attribute.
	 *
	 * @param      PcSplitTestResult $l PcSplitTestResult
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcSplitTestResult(PcSplitTestResult $l)
	{
		if ($this->collPcSplitTestResults === null) {
			$this->initPcSplitTestResults();
		}
		if (!in_array($l, $this->collPcSplitTestResults, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcSplitTestResults, $l);
			$l->setPcSplitTest($this);
		}
	}

	/**
	 * Clears out the collPcSplitTestUserResults collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcSplitTestUserResults()
	 */
	public function clearPcSplitTestUserResults()
	{
		$this->collPcSplitTestUserResults = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcSplitTestUserResults collection (array).
	 *
	 * By default this just sets the collPcSplitTestUserResults collection to an empty array (like clearcollPcSplitTestUserResults());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcSplitTestUserResults()
	{
		$this->collPcSplitTestUserResults = array();
	}

	/**
	 * Gets an array of PcSplitTestUserResult objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcSplitTest has previously been saved, it will retrieve
	 * related PcSplitTestUserResults from storage. If this PcSplitTest is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcSplitTestUserResult[]
	 * @throws     PropelException
	 */
	public function getPcSplitTestUserResults($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcSplitTestPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcSplitTestUserResults === null) {
			if ($this->isNew()) {
			   $this->collPcSplitTestUserResults = array();
			} else {

				$criteria->add(PcSplitTestUserResultPeer::TEST_ID, $this->id);

				PcSplitTestUserResultPeer::addSelectColumns($criteria);
				$this->collPcSplitTestUserResults = PcSplitTestUserResultPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcSplitTestUserResultPeer::TEST_ID, $this->id);

				PcSplitTestUserResultPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcSplitTestUserResultCriteria) || !$this->lastPcSplitTestUserResultCriteria->equals($criteria)) {
					$this->collPcSplitTestUserResults = PcSplitTestUserResultPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcSplitTestUserResultCriteria = $criteria;
		return $this->collPcSplitTestUserResults;
	}

	/**
	 * Returns the number of related PcSplitTestUserResult objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcSplitTestUserResult objects.
	 * @throws     PropelException
	 */
	public function countPcSplitTestUserResults(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcSplitTestPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcSplitTestUserResults === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcSplitTestUserResultPeer::TEST_ID, $this->id);

				$count = PcSplitTestUserResultPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcSplitTestUserResultPeer::TEST_ID, $this->id);

				if (!isset($this->lastPcSplitTestUserResultCriteria) || !$this->lastPcSplitTestUserResultCriteria->equals($criteria)) {
					$count = PcSplitTestUserResultPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcSplitTestUserResults);
				}
			} else {
				$count = count($this->collPcSplitTestUserResults);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcSplitTestUserResult object to this object
	 * through the PcSplitTestUserResult foreign key attribute.
	 *
	 * @param      PcSplitTestUserResult $l PcSplitTestUserResult
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcSplitTestUserResult(PcSplitTestUserResult $l)
	{
		if ($this->collPcSplitTestUserResults === null) {
			$this->initPcSplitTestUserResults();
		}
		if (!in_array($l, $this->collPcSplitTestUserResults, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcSplitTestUserResults, $l);
			$l->setPcSplitTest($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcSplitTest is new, it will return
	 * an empty collection; or if this PcSplitTest has previously
	 * been saved, it will retrieve related PcSplitTestUserResults from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcSplitTest.
	 */
	public function getPcSplitTestUserResultsJoinPcUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcSplitTestPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcSplitTestUserResults === null) {
			if ($this->isNew()) {
				$this->collPcSplitTestUserResults = array();
			} else {

				$criteria->add(PcSplitTestUserResultPeer::TEST_ID, $this->id);

				$this->collPcSplitTestUserResults = PcSplitTestUserResultPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcSplitTestUserResultPeer::TEST_ID, $this->id);

			if (!isset($this->lastPcSplitTestUserResultCriteria) || !$this->lastPcSplitTestUserResultCriteria->equals($criteria)) {
				$this->collPcSplitTestUserResults = PcSplitTestUserResultPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcSplitTestUserResultCriteria = $criteria;

		return $this->collPcSplitTestUserResults;
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
			if ($this->collPcSplitTestResults) {
				foreach ((array) $this->collPcSplitTestResults as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcSplitTestUserResults) {
				foreach ((array) $this->collPcSplitTestUserResults as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collPcSplitTestResults = null;
		$this->collPcSplitTestUserResults = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcSplitTest:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcSplitTest::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcSplitTest
