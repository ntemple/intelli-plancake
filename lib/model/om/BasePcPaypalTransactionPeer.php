<?php

/**
 * Base static class for performing query and update operations on the 'pc_paypal_transaction' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcPaypalTransactionPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'pc_paypal_transaction';

	/** the related Propel class for this table */
	const OM_CLASS = 'PcPaypalTransaction';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.PcPaypalTransaction';

	/** the related TableMap class for this table */
	const TM_CLASS = 'PcPaypalTransactionTableMap';
	
	/** The total number of columns. */
	const NUM_COLUMNS = 16;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the ID field */
	const ID = 'pc_paypal_transaction.ID';

	/** the column name for the ITEM_NUMBER field */
	const ITEM_NUMBER = 'pc_paypal_transaction.ITEM_NUMBER';

	/** the column name for the ITEM_NAME field */
	const ITEM_NAME = 'pc_paypal_transaction.ITEM_NAME';

	/** the column name for the CUSTOM_FIELD field */
	const CUSTOM_FIELD = 'pc_paypal_transaction.CUSTOM_FIELD';

	/** the column name for the PAYMENT_STATUS field */
	const PAYMENT_STATUS = 'pc_paypal_transaction.PAYMENT_STATUS';

	/** the column name for the PAYMENT_AMOUNT field */
	const PAYMENT_AMOUNT = 'pc_paypal_transaction.PAYMENT_AMOUNT';

	/** the column name for the PAYMENT_CURRENCY field */
	const PAYMENT_CURRENCY = 'pc_paypal_transaction.PAYMENT_CURRENCY';

	/** the column name for the TRANSACTION_ID field */
	const TRANSACTION_ID = 'pc_paypal_transaction.TRANSACTION_ID';

	/** the column name for the PARENT_TRANSACTION_ID field */
	const PARENT_TRANSACTION_ID = 'pc_paypal_transaction.PARENT_TRANSACTION_ID';

	/** the column name for the RECEIVER_EMAIL field */
	const RECEIVER_EMAIL = 'pc_paypal_transaction.RECEIVER_EMAIL';

	/** the column name for the RESIDENCE_COUNTRY field */
	const RESIDENCE_COUNTRY = 'pc_paypal_transaction.RESIDENCE_COUNTRY';

	/** the column name for the PAYER_EMAIL field */
	const PAYER_EMAIL = 'pc_paypal_transaction.PAYER_EMAIL';

	/** the column name for the PAYMENT_DATE field */
	const PAYMENT_DATE = 'pc_paypal_transaction.PAYMENT_DATE';

	/** the column name for the ERROR field */
	const ERROR = 'pc_paypal_transaction.ERROR';

	/** the column name for the RAW_DATA field */
	const RAW_DATA = 'pc_paypal_transaction.RAW_DATA';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'pc_paypal_transaction.CREATED_AT';

	/**
	 * An identiy map to hold any loaded instances of PcPaypalTransaction objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array PcPaypalTransaction[]
	 */
	public static $instances = array();


	// symfony behavior
	
	/**
	 * Indicates whether the current model includes I18N.
	 */
	const IS_I18N = false;

	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ItemNumber', 'ItemName', 'CustomField', 'PaymentStatus', 'PaymentAmount', 'PaymentCurrency', 'TransactionId', 'ParentTransactionId', 'ReceiverEmail', 'ResidenceCountry', 'PayerEmail', 'PaymentDate', 'Error', 'RawData', 'CreatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'itemNumber', 'itemName', 'customField', 'paymentStatus', 'paymentAmount', 'paymentCurrency', 'transactionId', 'parentTransactionId', 'receiverEmail', 'residenceCountry', 'payerEmail', 'paymentDate', 'error', 'rawData', 'createdAt', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::ITEM_NUMBER, self::ITEM_NAME, self::CUSTOM_FIELD, self::PAYMENT_STATUS, self::PAYMENT_AMOUNT, self::PAYMENT_CURRENCY, self::TRANSACTION_ID, self::PARENT_TRANSACTION_ID, self::RECEIVER_EMAIL, self::RESIDENCE_COUNTRY, self::PAYER_EMAIL, self::PAYMENT_DATE, self::ERROR, self::RAW_DATA, self::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'item_number', 'item_name', 'custom_field', 'payment_status', 'payment_amount', 'payment_currency', 'transaction_id', 'parent_transaction_id', 'receiver_email', 'residence_country', 'payer_email', 'payment_date', 'error', 'raw_data', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ItemNumber' => 1, 'ItemName' => 2, 'CustomField' => 3, 'PaymentStatus' => 4, 'PaymentAmount' => 5, 'PaymentCurrency' => 6, 'TransactionId' => 7, 'ParentTransactionId' => 8, 'ReceiverEmail' => 9, 'ResidenceCountry' => 10, 'PayerEmail' => 11, 'PaymentDate' => 12, 'Error' => 13, 'RawData' => 14, 'CreatedAt' => 15, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'itemNumber' => 1, 'itemName' => 2, 'customField' => 3, 'paymentStatus' => 4, 'paymentAmount' => 5, 'paymentCurrency' => 6, 'transactionId' => 7, 'parentTransactionId' => 8, 'receiverEmail' => 9, 'residenceCountry' => 10, 'payerEmail' => 11, 'paymentDate' => 12, 'error' => 13, 'rawData' => 14, 'createdAt' => 15, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::ITEM_NUMBER => 1, self::ITEM_NAME => 2, self::CUSTOM_FIELD => 3, self::PAYMENT_STATUS => 4, self::PAYMENT_AMOUNT => 5, self::PAYMENT_CURRENCY => 6, self::TRANSACTION_ID => 7, self::PARENT_TRANSACTION_ID => 8, self::RECEIVER_EMAIL => 9, self::RESIDENCE_COUNTRY => 10, self::PAYER_EMAIL => 11, self::PAYMENT_DATE => 12, self::ERROR => 13, self::RAW_DATA => 14, self::CREATED_AT => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'item_number' => 1, 'item_name' => 2, 'custom_field' => 3, 'payment_status' => 4, 'payment_amount' => 5, 'payment_currency' => 6, 'transaction_id' => 7, 'parent_transaction_id' => 8, 'receiver_email' => 9, 'residence_country' => 10, 'payer_email' => 11, 'payment_date' => 12, 'error' => 13, 'raw_data' => 14, 'created_at' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. PcPaypalTransactionPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PcPaypalTransactionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{
		$criteria->addSelectColumn(PcPaypalTransactionPeer::ID);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::ITEM_NUMBER);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::ITEM_NAME);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::CUSTOM_FIELD);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::PAYMENT_STATUS);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::PAYMENT_AMOUNT);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::PAYMENT_CURRENCY);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::TRANSACTION_ID);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::PARENT_TRANSACTION_ID);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::RECEIVER_EMAIL);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::RESIDENCE_COUNTRY);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::PAYER_EMAIL);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::PAYMENT_DATE);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::ERROR);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::RAW_DATA);
		$criteria->addSelectColumn(PcPaypalTransactionPeer::CREATED_AT);
	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(PcPaypalTransactionPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			PcPaypalTransactionPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcPaypalTransactionPeer', $criteria, $con);
		}

		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     PcPaypalTransaction
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PcPaypalTransactionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return PcPaypalTransactionPeer::populateObjects(PcPaypalTransactionPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			PcPaypalTransactionPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcPaypalTransactionPeer', $criteria, $con);
		}


		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      PcPaypalTransaction $value A PcPaypalTransaction object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(PcPaypalTransaction $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A PcPaypalTransaction object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof PcPaypalTransaction) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or PcPaypalTransaction object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     PcPaypalTransaction Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Method to invalidate the instance pool of all tables related to pc_paypal_transaction
	 * by a foreign key with ON DELETE CASCADE
	 */
	public static function clearRelatedInstancePool()
	{
	}

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol] === null) {
			return null;
		}
		return (string) $row[$startcol];
	}

	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = PcPaypalTransactionPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = PcPaypalTransactionPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = PcPaypalTransactionPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				PcPaypalTransactionPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}
	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * Add a TableMap instance to the database for this peer class.
	 */
	public static function buildTableMap()
	{
	  $dbMap = Propel::getDatabaseMap(BasePcPaypalTransactionPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BasePcPaypalTransactionPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new PcPaypalTransactionTableMap());
	  }
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * If $withPrefix is true, the returned path
	 * uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @param      boolean  Whether or not to return the path wit hthe class name 
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass($withPrefix = true)
	{
		return $withPrefix ? PcPaypalTransactionPeer::CLASS_DEFAULT : PcPaypalTransactionPeer::OM_CLASS;
	}

	/**
	 * Method perform an INSERT on the database, given a PcPaypalTransaction or Criteria object.
	 *
	 * @param      mixed $values Criteria or PcPaypalTransaction object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcPaypalTransactionPeer:doInsert:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BasePcPaypalTransactionPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from PcPaypalTransaction object
		}

		if ($criteria->containsKey(PcPaypalTransactionPeer::ID) && $criteria->keyContainsValue(PcPaypalTransactionPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.PcPaypalTransactionPeer::ID.')');
		}


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcPaypalTransactionPeer:doInsert:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BasePcPaypalTransactionPeer', $values, $con, $pk);
    }

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a PcPaypalTransaction or Criteria object.
	 *
	 * @param      mixed $values Criteria or PcPaypalTransaction object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcPaypalTransactionPeer:doUpdate:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BasePcPaypalTransactionPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(PcPaypalTransactionPeer::ID);
			$selectCriteria->add(PcPaypalTransactionPeer::ID, $criteria->remove(PcPaypalTransactionPeer::ID), $comparison);

		} else { // $values is PcPaypalTransaction object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);

    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcPaypalTransactionPeer:doUpdate:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BasePcPaypalTransactionPeer', $values, $con, $ret);
    }

    return $ret;
	}

	/**
	 * Method to DELETE all rows from the pc_paypal_transaction table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(PcPaypalTransactionPeer::TABLE_NAME, $con);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			PcPaypalTransactionPeer::clearInstancePool();
			PcPaypalTransactionPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a PcPaypalTransaction or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or PcPaypalTransaction object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			PcPaypalTransactionPeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof PcPaypalTransaction) { // it's a model object
			// invalidate the cache for this single object
			PcPaypalTransactionPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PcPaypalTransactionPeer::ID, (array) $values, Criteria::IN);
			// invalidate the cache for this object(s)
			foreach ((array) $values as $singleval) {
				PcPaypalTransactionPeer::removeInstanceFromPool($singleval);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			PcPaypalTransactionPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given PcPaypalTransaction object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      PcPaypalTransaction $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(PcPaypalTransaction $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PcPaypalTransactionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PcPaypalTransactionPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(PcPaypalTransactionPeer::DATABASE_NAME, PcPaypalTransactionPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     PcPaypalTransaction
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = PcPaypalTransactionPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(PcPaypalTransactionPeer::DATABASE_NAME);
		$criteria->add(PcPaypalTransactionPeer::ID, $pk);

		$v = PcPaypalTransactionPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(PcPaypalTransactionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(PcPaypalTransactionPeer::DATABASE_NAME);
			$criteria->add(PcPaypalTransactionPeer::ID, $pks, Criteria::IN);
			$objs = PcPaypalTransactionPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

	// symfony behavior
	
	/**
	 * Returns an array of arrays that contain columns in each unique index.
	 *
	 * @return array
	 */
	static public function getUniqueColumnNames()
	{
	  return array();
	}

	// symfony_behaviors behavior
	
	/**
	 * Returns the name of the hook to call from inside the supplied method.
	 *
	 * @param string $method The calling method
	 *
	 * @return string A hook name for {@link sfMixer}
	 *
	 * @throws LogicException If the method name is not recognized
	 */
	static private function getMixerPreSelectHook($method)
	{
	  if (preg_match('/^do(Select|Count)(Join(All(Except)?)?|Stmt)?/', $method, $match))
	  {
	    return sprintf('BasePcPaypalTransactionPeer:%s:%1$s', 'Count' == $match[1] ? 'doCount' : $match[0]);
	  }
	
	  throw new LogicException(sprintf('Unrecognized function "%s"', $method));
	}

} // BasePcPaypalTransactionPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePcPaypalTransactionPeer::buildTableMap();

