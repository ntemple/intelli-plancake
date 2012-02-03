<?php

/**
 * Base class that represents a row from the 'pc_api_app' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcApiApp extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcApiAppPeer
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
	 * The value for the api_key field.
	 * @var        string
	 */
	protected $api_key;

	/**
	 * The value for the api_secret field.
	 * @var        string
	 */
	protected $api_secret;

	/**
	 * The value for the user_id field.
	 * @var        int
	 */
	protected $user_id;

	/**
	 * The value for the is_limited field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_limited;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * @var        PcUser
	 */
	protected $aPcUser;

	/**
	 * @var        array PcApiAppStats[] Collection to store aggregation of PcApiAppStats objects.
	 */
	protected $collPcApiAppStatss;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcApiAppStatss.
	 */
	private $lastPcApiAppStatsCriteria = null;

	/**
	 * @var        array PcApiToken[] Collection to store aggregation of PcApiToken objects.
	 */
	protected $collPcApiTokens;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPcApiTokens.
	 */
	private $lastPcApiTokenCriteria = null;

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
	
	const PEER = 'PcApiAppPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_limited = false;
	}

	/**
	 * Initializes internal state of BasePcApiApp object.
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
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [api_key] column value.
	 * 
	 * @return     string
	 */
	public function getApiKey()
	{
		return $this->api_key;
	}

	/**
	 * Get the [api_secret] column value.
	 * 
	 * @return     string
	 */
	public function getApiSecret()
	{
		return $this->api_secret;
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
	 * Get the [is_limited] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsLimited()
	{
		return $this->is_limited;
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
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcApiApp The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcApiAppPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     PcApiApp The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = PcApiAppPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [api_key] column.
	 * 
	 * @param      string $v new value
	 * @return     PcApiApp The current object (for fluent API support)
	 */
	public function setApiKey($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->api_key !== $v) {
			$this->api_key = $v;
			$this->modifiedColumns[] = PcApiAppPeer::API_KEY;
		}

		return $this;
	} // setApiKey()

	/**
	 * Set the value of [api_secret] column.
	 * 
	 * @param      string $v new value
	 * @return     PcApiApp The current object (for fluent API support)
	 */
	public function setApiSecret($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->api_secret !== $v) {
			$this->api_secret = $v;
			$this->modifiedColumns[] = PcApiAppPeer::API_SECRET;
		}

		return $this;
	} // setApiSecret()

	/**
	 * Set the value of [user_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcApiApp The current object (for fluent API support)
	 */
	public function setUserId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = PcApiAppPeer::USER_ID;
		}

		if ($this->aPcUser !== null && $this->aPcUser->getId() !== $v) {
			$this->aPcUser = null;
		}

		return $this;
	} // setUserId()

	/**
	 * Set the value of [is_limited] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PcApiApp The current object (for fluent API support)
	 */
	public function setIsLimited($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_limited !== $v || $this->isNew()) {
			$this->is_limited = $v;
			$this->modifiedColumns[] = PcApiAppPeer::IS_LIMITED;
		}

		return $this;
	} // setIsLimited()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     PcApiApp The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = PcApiAppPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

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
			if ($this->is_limited !== false) {
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
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->api_key = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->api_secret = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->user_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->is_limited = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->description = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 7; // 7 = PcApiAppPeer::NUM_COLUMNS - PcApiAppPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcApiApp object", $e);
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
			$con = Propel::getConnection(PcApiAppPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcApiAppPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcUser = null;
			$this->collPcApiAppStatss = null;
			$this->lastPcApiAppStatsCriteria = null;

			$this->collPcApiTokens = null;
			$this->lastPcApiTokenCriteria = null;

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
			$con = Propel::getConnection(PcApiAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcApiApp:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcApiAppPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcApiApp:delete:post') as $callable)
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
			$con = Propel::getConnection(PcApiAppPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcApiApp:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BasePcApiApp:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcApiAppPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = PcApiAppPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcApiAppPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PcApiAppPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPcApiAppStatss !== null) {
				foreach ($this->collPcApiAppStatss as $referrerFK) {
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


			if (($retval = PcApiAppPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPcApiAppStatss !== null) {
					foreach ($this->collPcApiAppStatss as $referrerFK) {
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
		$pos = PcApiAppPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getApiKey();
				break;
			case 3:
				return $this->getApiSecret();
				break;
			case 4:
				return $this->getUserId();
				break;
			case 5:
				return $this->getIsLimited();
				break;
			case 6:
				return $this->getDescription();
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
		$keys = PcApiAppPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getApiKey(),
			$keys[3] => $this->getApiSecret(),
			$keys[4] => $this->getUserId(),
			$keys[5] => $this->getIsLimited(),
			$keys[6] => $this->getDescription(),
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
		$pos = PcApiAppPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setApiKey($value);
				break;
			case 3:
				$this->setApiSecret($value);
				break;
			case 4:
				$this->setUserId($value);
				break;
			case 5:
				$this->setIsLimited($value);
				break;
			case 6:
				$this->setDescription($value);
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
		$keys = PcApiAppPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setApiKey($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setApiSecret($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUserId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsLimited($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDescription($arr[$keys[6]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcApiAppPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcApiAppPeer::ID)) $criteria->add(PcApiAppPeer::ID, $this->id);
		if ($this->isColumnModified(PcApiAppPeer::NAME)) $criteria->add(PcApiAppPeer::NAME, $this->name);
		if ($this->isColumnModified(PcApiAppPeer::API_KEY)) $criteria->add(PcApiAppPeer::API_KEY, $this->api_key);
		if ($this->isColumnModified(PcApiAppPeer::API_SECRET)) $criteria->add(PcApiAppPeer::API_SECRET, $this->api_secret);
		if ($this->isColumnModified(PcApiAppPeer::USER_ID)) $criteria->add(PcApiAppPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(PcApiAppPeer::IS_LIMITED)) $criteria->add(PcApiAppPeer::IS_LIMITED, $this->is_limited);
		if ($this->isColumnModified(PcApiAppPeer::DESCRIPTION)) $criteria->add(PcApiAppPeer::DESCRIPTION, $this->description);

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
		$criteria = new Criteria(PcApiAppPeer::DATABASE_NAME);

		$criteria->add(PcApiAppPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcApiApp (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setApiKey($this->api_key);

		$copyObj->setApiSecret($this->api_secret);

		$copyObj->setUserId($this->user_id);

		$copyObj->setIsLimited($this->is_limited);

		$copyObj->setDescription($this->description);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPcApiAppStatss() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcApiAppStats($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPcApiTokens() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPcApiToken($relObj->copy($deepCopy));
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
	 * @return     PcApiApp Clone of current object.
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
	 * @return     PcApiAppPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcApiAppPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcUser object.
	 *
	 * @param      PcUser $v
	 * @return     PcApiApp The current object (for fluent API support)
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
			$v->addPcApiApp($this);
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
			   $this->aPcUser->addPcApiApps($this);
			 */
		}
		return $this->aPcUser;
	}

	/**
	 * Clears out the collPcApiAppStatss collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPcApiAppStatss()
	 */
	public function clearPcApiAppStatss()
	{
		$this->collPcApiAppStatss = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPcApiAppStatss collection (array).
	 *
	 * By default this just sets the collPcApiAppStatss collection to an empty array (like clearcollPcApiAppStatss());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPcApiAppStatss()
	{
		$this->collPcApiAppStatss = array();
	}

	/**
	 * Gets an array of PcApiAppStats objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this PcApiApp has previously been saved, it will retrieve
	 * related PcApiAppStatss from storage. If this PcApiApp is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array PcApiAppStats[]
	 * @throws     PropelException
	 */
	public function getPcApiAppStatss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcApiAppPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcApiAppStatss === null) {
			if ($this->isNew()) {
			   $this->collPcApiAppStatss = array();
			} else {

				$criteria->add(PcApiAppStatsPeer::API_APP_ID, $this->id);

				PcApiAppStatsPeer::addSelectColumns($criteria);
				$this->collPcApiAppStatss = PcApiAppStatsPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcApiAppStatsPeer::API_APP_ID, $this->id);

				PcApiAppStatsPeer::addSelectColumns($criteria);
				if (!isset($this->lastPcApiAppStatsCriteria) || !$this->lastPcApiAppStatsCriteria->equals($criteria)) {
					$this->collPcApiAppStatss = PcApiAppStatsPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPcApiAppStatsCriteria = $criteria;
		return $this->collPcApiAppStatss;
	}

	/**
	 * Returns the number of related PcApiAppStats objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PcApiAppStats objects.
	 * @throws     PropelException
	 */
	public function countPcApiAppStatss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcApiAppPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPcApiAppStatss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PcApiAppStatsPeer::API_APP_ID, $this->id);

				$count = PcApiAppStatsPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcApiAppStatsPeer::API_APP_ID, $this->id);

				if (!isset($this->lastPcApiAppStatsCriteria) || !$this->lastPcApiAppStatsCriteria->equals($criteria)) {
					$count = PcApiAppStatsPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPcApiAppStatss);
				}
			} else {
				$count = count($this->collPcApiAppStatss);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a PcApiAppStats object to this object
	 * through the PcApiAppStats foreign key attribute.
	 *
	 * @param      PcApiAppStats $l PcApiAppStats
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPcApiAppStats(PcApiAppStats $l)
	{
		if ($this->collPcApiAppStatss === null) {
			$this->initPcApiAppStatss();
		}
		if (!in_array($l, $this->collPcApiAppStatss, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPcApiAppStatss, $l);
			$l->setPcApiApp($this);
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
	 * Otherwise if this PcApiApp has previously been saved, it will retrieve
	 * related PcApiTokens from storage. If this PcApiApp is new, it will return
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
			$criteria = new Criteria(PcApiAppPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcApiTokens === null) {
			if ($this->isNew()) {
			   $this->collPcApiTokens = array();
			} else {

				$criteria->add(PcApiTokenPeer::API_APP_ID, $this->id);

				PcApiTokenPeer::addSelectColumns($criteria);
				$this->collPcApiTokens = PcApiTokenPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PcApiTokenPeer::API_APP_ID, $this->id);

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
			$criteria = new Criteria(PcApiAppPeer::DATABASE_NAME);
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

				$criteria->add(PcApiTokenPeer::API_APP_ID, $this->id);

				$count = PcApiTokenPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PcApiTokenPeer::API_APP_ID, $this->id);

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
			$l->setPcApiApp($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this PcApiApp is new, it will return
	 * an empty collection; or if this PcApiApp has previously
	 * been saved, it will retrieve related PcApiTokens from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in PcApiApp.
	 */
	public function getPcApiTokensJoinPcUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcApiAppPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPcApiTokens === null) {
			if ($this->isNew()) {
				$this->collPcApiTokens = array();
			} else {

				$criteria->add(PcApiTokenPeer::API_APP_ID, $this->id);

				$this->collPcApiTokens = PcApiTokenPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PcApiTokenPeer::API_APP_ID, $this->id);

			if (!isset($this->lastPcApiTokenCriteria) || !$this->lastPcApiTokenCriteria->equals($criteria)) {
				$this->collPcApiTokens = PcApiTokenPeer::doSelectJoinPcUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastPcApiTokenCriteria = $criteria;

		return $this->collPcApiTokens;
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
			if ($this->collPcApiAppStatss) {
				foreach ((array) $this->collPcApiAppStatss as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPcApiTokens) {
				foreach ((array) $this->collPcApiTokens as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collPcApiAppStatss = null;
		$this->collPcApiTokens = null;
			$this->aPcUser = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcApiApp:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcApiApp::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcApiApp
