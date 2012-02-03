<?php

/**
 * Base class that represents a row from the 'pc_quote_of_the_day' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcQuoteOfTheDay extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcQuoteOfTheDayPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the quote field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $quote;

	/**
	 * The value for the quote_in_italian field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $quote_in_italian;

	/**
	 * The value for the quote_author field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $quote_author;

	/**
	 * The value for the quote_author_in_italian field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $quote_author_in_italian;

	/**
	 * The value for the is_tip field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_tip;

	/**
	 * The value for the shown_on field.
	 * @var        int
	 */
	protected $shown_on;

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
	
	const PEER = 'PcQuoteOfTheDayPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->quote = '';
		$this->quote_in_italian = '';
		$this->quote_author = '';
		$this->quote_author_in_italian = '';
		$this->is_tip = false;
	}

	/**
	 * Initializes internal state of BasePcQuoteOfTheDay object.
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
	 * Get the [quote] column value.
	 * 
	 * @return     string
	 */
	public function getQuote()
	{
		return $this->quote;
	}

	/**
	 * Get the [quote_in_italian] column value.
	 * 
	 * @return     string
	 */
	public function getQuoteInItalian()
	{
		return $this->quote_in_italian;
	}

	/**
	 * Get the [quote_author] column value.
	 * 
	 * @return     string
	 */
	public function getQuoteAuthor()
	{
		return $this->quote_author;
	}

	/**
	 * Get the [quote_author_in_italian] column value.
	 * 
	 * @return     string
	 */
	public function getQuoteAuthorInItalian()
	{
		return $this->quote_author_in_italian;
	}

	/**
	 * Get the [is_tip] column value.
	 * 0->proper quote, 1->tip from team
	 * @return     boolean
	 */
	public function getIsTip()
	{
		return $this->is_tip;
	}

	/**
	 * Get the [shown_on] column value.
	 * YYYYmmdd format
	 * @return     int
	 */
	public function getShownOn()
	{
		return $this->shown_on;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcQuoteOfTheDay The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcQuoteOfTheDayPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [quote] column.
	 * 
	 * @param      string $v new value
	 * @return     PcQuoteOfTheDay The current object (for fluent API support)
	 */
	public function setQuote($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->quote !== $v || $this->isNew()) {
			$this->quote = $v;
			$this->modifiedColumns[] = PcQuoteOfTheDayPeer::QUOTE;
		}

		return $this;
	} // setQuote()

	/**
	 * Set the value of [quote_in_italian] column.
	 * 
	 * @param      string $v new value
	 * @return     PcQuoteOfTheDay The current object (for fluent API support)
	 */
	public function setQuoteInItalian($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->quote_in_italian !== $v || $this->isNew()) {
			$this->quote_in_italian = $v;
			$this->modifiedColumns[] = PcQuoteOfTheDayPeer::QUOTE_IN_ITALIAN;
		}

		return $this;
	} // setQuoteInItalian()

	/**
	 * Set the value of [quote_author] column.
	 * 
	 * @param      string $v new value
	 * @return     PcQuoteOfTheDay The current object (for fluent API support)
	 */
	public function setQuoteAuthor($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->quote_author !== $v || $this->isNew()) {
			$this->quote_author = $v;
			$this->modifiedColumns[] = PcQuoteOfTheDayPeer::QUOTE_AUTHOR;
		}

		return $this;
	} // setQuoteAuthor()

	/**
	 * Set the value of [quote_author_in_italian] column.
	 * 
	 * @param      string $v new value
	 * @return     PcQuoteOfTheDay The current object (for fluent API support)
	 */
	public function setQuoteAuthorInItalian($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->quote_author_in_italian !== $v || $this->isNew()) {
			$this->quote_author_in_italian = $v;
			$this->modifiedColumns[] = PcQuoteOfTheDayPeer::QUOTE_AUTHOR_IN_ITALIAN;
		}

		return $this;
	} // setQuoteAuthorInItalian()

	/**
	 * Set the value of [is_tip] column.
	 * 0->proper quote, 1->tip from team
	 * @param      boolean $v new value
	 * @return     PcQuoteOfTheDay The current object (for fluent API support)
	 */
	public function setIsTip($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_tip !== $v || $this->isNew()) {
			$this->is_tip = $v;
			$this->modifiedColumns[] = PcQuoteOfTheDayPeer::IS_TIP;
		}

		return $this;
	} // setIsTip()

	/**
	 * Set the value of [shown_on] column.
	 * YYYYmmdd format
	 * @param      int $v new value
	 * @return     PcQuoteOfTheDay The current object (for fluent API support)
	 */
	public function setShownOn($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->shown_on !== $v) {
			$this->shown_on = $v;
			$this->modifiedColumns[] = PcQuoteOfTheDayPeer::SHOWN_ON;
		}

		return $this;
	} // setShownOn()

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
			if ($this->quote !== '') {
				return false;
			}

			if ($this->quote_in_italian !== '') {
				return false;
			}

			if ($this->quote_author !== '') {
				return false;
			}

			if ($this->quote_author_in_italian !== '') {
				return false;
			}

			if ($this->is_tip !== false) {
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
			$this->quote = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->quote_in_italian = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->quote_author = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->quote_author_in_italian = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->is_tip = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->shown_on = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 7; // 7 = PcQuoteOfTheDayPeer::NUM_COLUMNS - PcQuoteOfTheDayPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcQuoteOfTheDay object", $e);
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
			$con = Propel::getConnection(PcQuoteOfTheDayPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcQuoteOfTheDayPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

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
			$con = Propel::getConnection(PcQuoteOfTheDayPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcQuoteOfTheDay:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcQuoteOfTheDayPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcQuoteOfTheDay:delete:post') as $callable)
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
			$con = Propel::getConnection(PcQuoteOfTheDayPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcQuoteOfTheDay:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
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
				foreach (sfMixer::getCallables('BasePcQuoteOfTheDay:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcQuoteOfTheDayPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = PcQuoteOfTheDayPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcQuoteOfTheDayPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcQuoteOfTheDayPeer::doUpdate($this, $con);
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


			if (($retval = PcQuoteOfTheDayPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PcQuoteOfTheDayPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getQuote();
				break;
			case 2:
				return $this->getQuoteInItalian();
				break;
			case 3:
				return $this->getQuoteAuthor();
				break;
			case 4:
				return $this->getQuoteAuthorInItalian();
				break;
			case 5:
				return $this->getIsTip();
				break;
			case 6:
				return $this->getShownOn();
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
		$keys = PcQuoteOfTheDayPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getQuote(),
			$keys[2] => $this->getQuoteInItalian(),
			$keys[3] => $this->getQuoteAuthor(),
			$keys[4] => $this->getQuoteAuthorInItalian(),
			$keys[5] => $this->getIsTip(),
			$keys[6] => $this->getShownOn(),
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
		$pos = PcQuoteOfTheDayPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setQuote($value);
				break;
			case 2:
				$this->setQuoteInItalian($value);
				break;
			case 3:
				$this->setQuoteAuthor($value);
				break;
			case 4:
				$this->setQuoteAuthorInItalian($value);
				break;
			case 5:
				$this->setIsTip($value);
				break;
			case 6:
				$this->setShownOn($value);
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
		$keys = PcQuoteOfTheDayPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setQuote($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setQuoteInItalian($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setQuoteAuthor($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setQuoteAuthorInItalian($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsTip($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setShownOn($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcQuoteOfTheDayPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcQuoteOfTheDayPeer::ID)) $criteria->add(PcQuoteOfTheDayPeer::ID, $this->id);
		if ($this->isColumnModified(PcQuoteOfTheDayPeer::QUOTE)) $criteria->add(PcQuoteOfTheDayPeer::QUOTE, $this->quote);
		if ($this->isColumnModified(PcQuoteOfTheDayPeer::QUOTE_IN_ITALIAN)) $criteria->add(PcQuoteOfTheDayPeer::QUOTE_IN_ITALIAN, $this->quote_in_italian);
		if ($this->isColumnModified(PcQuoteOfTheDayPeer::QUOTE_AUTHOR)) $criteria->add(PcQuoteOfTheDayPeer::QUOTE_AUTHOR, $this->quote_author);
		if ($this->isColumnModified(PcQuoteOfTheDayPeer::QUOTE_AUTHOR_IN_ITALIAN)) $criteria->add(PcQuoteOfTheDayPeer::QUOTE_AUTHOR_IN_ITALIAN, $this->quote_author_in_italian);
		if ($this->isColumnModified(PcQuoteOfTheDayPeer::IS_TIP)) $criteria->add(PcQuoteOfTheDayPeer::IS_TIP, $this->is_tip);
		if ($this->isColumnModified(PcQuoteOfTheDayPeer::SHOWN_ON)) $criteria->add(PcQuoteOfTheDayPeer::SHOWN_ON, $this->shown_on);

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
		$criteria = new Criteria(PcQuoteOfTheDayPeer::DATABASE_NAME);

		$criteria->add(PcQuoteOfTheDayPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcQuoteOfTheDay (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setQuote($this->quote);

		$copyObj->setQuoteInItalian($this->quote_in_italian);

		$copyObj->setQuoteAuthor($this->quote_author);

		$copyObj->setQuoteAuthorInItalian($this->quote_author_in_italian);

		$copyObj->setIsTip($this->is_tip);

		$copyObj->setShownOn($this->shown_on);


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
	 * @return     PcQuoteOfTheDay Clone of current object.
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
	 * @return     PcQuoteOfTheDayPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcQuoteOfTheDayPeer();
		}
		return self::$peer;
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

	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcQuoteOfTheDay:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcQuoteOfTheDay::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcQuoteOfTheDay
