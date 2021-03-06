<?php

/**
 * Base class that represents a row from the 'pc_paypal_product' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcPaypalProduct extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PcPaypalProductPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the item_number field.
	 * @var        string
	 */
	protected $item_number;

	/**
	 * The value for the item_name field.
	 * @var        string
	 */
	protected $item_name;

	/**
	 * The value for the item_price field.
	 * @var        string
	 */
	protected $item_price;

	/**
	 * The value for the item_price_currency field.
	 * @var        string
	 */
	protected $item_price_currency;

	/**
	 * The value for the discount_percentage field.
	 * @var        int
	 */
	protected $discount_percentage;

	/**
	 * The value for the subscription_type_id field.
	 * @var        int
	 */
	protected $subscription_type_id;

	/**
	 * The value for the paypal_button_code field.
	 * @var        string
	 */
	protected $paypal_button_code;

	/**
	 * @var        PcSubscriptionType
	 */
	protected $aPcSubscriptionType;

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
	
	const PEER = 'PcPaypalProductPeer';

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
	 * Get the [item_number] column value.
	 * 
	 * @return     string
	 */
	public function getItemNumber()
	{
		return $this->item_number;
	}

	/**
	 * Get the [item_name] column value.
	 * 
	 * @return     string
	 */
	public function getItemName()
	{
		return $this->item_name;
	}

	/**
	 * Get the [item_price] column value.
	 * 
	 * @return     string
	 */
	public function getItemPrice()
	{
		return $this->item_price;
	}

	/**
	 * Get the [item_price_currency] column value.
	 * 
	 * @return     string
	 */
	public function getItemPriceCurrency()
	{
		return $this->item_price_currency;
	}

	/**
	 * Get the [discount_percentage] column value.
	 * 
	 * @return     int
	 */
	public function getDiscountPercentage()
	{
		return $this->discount_percentage;
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
	 * Get the [paypal_button_code] column value.
	 * 
	 * @return     string
	 */
	public function getPaypalButtonCode()
	{
		return $this->paypal_button_code;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [item_number] column.
	 * 
	 * @param      string $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setItemNumber($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->item_number !== $v) {
			$this->item_number = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::ITEM_NUMBER;
		}

		return $this;
	} // setItemNumber()

	/**
	 * Set the value of [item_name] column.
	 * 
	 * @param      string $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setItemName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->item_name !== $v) {
			$this->item_name = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::ITEM_NAME;
		}

		return $this;
	} // setItemName()

	/**
	 * Set the value of [item_price] column.
	 * 
	 * @param      string $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setItemPrice($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->item_price !== $v) {
			$this->item_price = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::ITEM_PRICE;
		}

		return $this;
	} // setItemPrice()

	/**
	 * Set the value of [item_price_currency] column.
	 * 
	 * @param      string $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setItemPriceCurrency($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->item_price_currency !== $v) {
			$this->item_price_currency = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::ITEM_PRICE_CURRENCY;
		}

		return $this;
	} // setItemPriceCurrency()

	/**
	 * Set the value of [discount_percentage] column.
	 * 
	 * @param      int $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setDiscountPercentage($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->discount_percentage !== $v) {
			$this->discount_percentage = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::DISCOUNT_PERCENTAGE;
		}

		return $this;
	} // setDiscountPercentage()

	/**
	 * Set the value of [subscription_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setSubscriptionTypeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->subscription_type_id !== $v) {
			$this->subscription_type_id = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID;
		}

		if ($this->aPcSubscriptionType !== null && $this->aPcSubscriptionType->getId() !== $v) {
			$this->aPcSubscriptionType = null;
		}

		return $this;
	} // setSubscriptionTypeId()

	/**
	 * Set the value of [paypal_button_code] column.
	 * 
	 * @param      string $v new value
	 * @return     PcPaypalProduct The current object (for fluent API support)
	 */
	public function setPaypalButtonCode($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->paypal_button_code !== $v) {
			$this->paypal_button_code = $v;
			$this->modifiedColumns[] = PcPaypalProductPeer::PAYPAL_BUTTON_CODE;
		}

		return $this;
	} // setPaypalButtonCode()

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
			$this->item_number = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->item_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->item_price = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->item_price_currency = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->discount_percentage = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->subscription_type_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->paypal_button_code = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 8; // 8 = PcPaypalProductPeer::NUM_COLUMNS - PcPaypalProductPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PcPaypalProduct object", $e);
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
			$con = Propel::getConnection(PcPaypalProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PcPaypalProductPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPcSubscriptionType = null;
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
			$con = Propel::getConnection(PcPaypalProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcPaypalProduct:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				PcPaypalProductPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BasePcPaypalProduct:delete:post') as $callable)
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
			$con = Propel::getConnection(PcPaypalProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BasePcPaypalProduct:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BasePcPaypalProduct:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				PcPaypalProductPeer::addInstanceToPool($this);
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcPaypalProductPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += PcPaypalProductPeer::doUpdate($this, $con);
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


			if (($retval = PcPaypalProductPeer::doValidate($this, $columns)) !== true) {
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
		$pos = PcPaypalProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getItemNumber();
				break;
			case 2:
				return $this->getItemName();
				break;
			case 3:
				return $this->getItemPrice();
				break;
			case 4:
				return $this->getItemPriceCurrency();
				break;
			case 5:
				return $this->getDiscountPercentage();
				break;
			case 6:
				return $this->getSubscriptionTypeId();
				break;
			case 7:
				return $this->getPaypalButtonCode();
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
		$keys = PcPaypalProductPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getItemNumber(),
			$keys[2] => $this->getItemName(),
			$keys[3] => $this->getItemPrice(),
			$keys[4] => $this->getItemPriceCurrency(),
			$keys[5] => $this->getDiscountPercentage(),
			$keys[6] => $this->getSubscriptionTypeId(),
			$keys[7] => $this->getPaypalButtonCode(),
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
		$pos = PcPaypalProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setItemNumber($value);
				break;
			case 2:
				$this->setItemName($value);
				break;
			case 3:
				$this->setItemPrice($value);
				break;
			case 4:
				$this->setItemPriceCurrency($value);
				break;
			case 5:
				$this->setDiscountPercentage($value);
				break;
			case 6:
				$this->setSubscriptionTypeId($value);
				break;
			case 7:
				$this->setPaypalButtonCode($value);
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
		$keys = PcPaypalProductPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setItemNumber($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setItemName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setItemPrice($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setItemPriceCurrency($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDiscountPercentage($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSubscriptionTypeId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPaypalButtonCode($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PcPaypalProductPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcPaypalProductPeer::ID)) $criteria->add(PcPaypalProductPeer::ID, $this->id);
		if ($this->isColumnModified(PcPaypalProductPeer::ITEM_NUMBER)) $criteria->add(PcPaypalProductPeer::ITEM_NUMBER, $this->item_number);
		if ($this->isColumnModified(PcPaypalProductPeer::ITEM_NAME)) $criteria->add(PcPaypalProductPeer::ITEM_NAME, $this->item_name);
		if ($this->isColumnModified(PcPaypalProductPeer::ITEM_PRICE)) $criteria->add(PcPaypalProductPeer::ITEM_PRICE, $this->item_price);
		if ($this->isColumnModified(PcPaypalProductPeer::ITEM_PRICE_CURRENCY)) $criteria->add(PcPaypalProductPeer::ITEM_PRICE_CURRENCY, $this->item_price_currency);
		if ($this->isColumnModified(PcPaypalProductPeer::DISCOUNT_PERCENTAGE)) $criteria->add(PcPaypalProductPeer::DISCOUNT_PERCENTAGE, $this->discount_percentage);
		if ($this->isColumnModified(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID)) $criteria->add(PcPaypalProductPeer::SUBSCRIPTION_TYPE_ID, $this->subscription_type_id);
		if ($this->isColumnModified(PcPaypalProductPeer::PAYPAL_BUTTON_CODE)) $criteria->add(PcPaypalProductPeer::PAYPAL_BUTTON_CODE, $this->paypal_button_code);

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
		$criteria = new Criteria(PcPaypalProductPeer::DATABASE_NAME);

		$criteria->add(PcPaypalProductPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of PcPaypalProduct (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setId($this->id);

		$copyObj->setItemNumber($this->item_number);

		$copyObj->setItemName($this->item_name);

		$copyObj->setItemPrice($this->item_price);

		$copyObj->setItemPriceCurrency($this->item_price_currency);

		$copyObj->setDiscountPercentage($this->discount_percentage);

		$copyObj->setSubscriptionTypeId($this->subscription_type_id);

		$copyObj->setPaypalButtonCode($this->paypal_button_code);


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
	 * @return     PcPaypalProduct Clone of current object.
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
	 * @return     PcPaypalProductPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PcPaypalProductPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a PcSubscriptionType object.
	 *
	 * @param      PcSubscriptionType $v
	 * @return     PcPaypalProduct The current object (for fluent API support)
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
			$v->addPcPaypalProduct($this);
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
			   $this->aPcSubscriptionType->addPcPaypalProducts($this);
			 */
		}
		return $this->aPcSubscriptionType;
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
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BasePcPaypalProduct:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BasePcPaypalProduct::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BasePcPaypalProduct
