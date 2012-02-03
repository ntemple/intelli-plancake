<?php

/**
 * Base static class for performing query and update operations on the 'pc_archived_task' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcArchivedTaskPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'pc_archived_task';

	/** the related Propel class for this table */
	const OM_CLASS = 'PcArchivedTask';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.PcArchivedTask';

	/** the related TableMap class for this table */
	const TM_CLASS = 'PcArchivedTaskTableMap';
	
	/** The total number of columns. */
	const NUM_COLUMNS = 18;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the ID field */
	const ID = 'pc_archived_task.ID';

	/** the column name for the LIST_ID field */
	const LIST_ID = 'pc_archived_task.LIST_ID';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'pc_archived_task.DESCRIPTION';

	/** the column name for the SORT_ORDER field */
	const SORT_ORDER = 'pc_archived_task.SORT_ORDER';

	/** the column name for the DUE_DATE field */
	const DUE_DATE = 'pc_archived_task.DUE_DATE';

	/** the column name for the DUE_TIME field */
	const DUE_TIME = 'pc_archived_task.DUE_TIME';

	/** the column name for the REPETITION_ID field */
	const REPETITION_ID = 'pc_archived_task.REPETITION_ID';

	/** the column name for the REPETITION_PARAM field */
	const REPETITION_PARAM = 'pc_archived_task.REPETITION_PARAM';

	/** the column name for the IS_STARRED field */
	const IS_STARRED = 'pc_archived_task.IS_STARRED';

	/** the column name for the IS_COMPLETED field */
	const IS_COMPLETED = 'pc_archived_task.IS_COMPLETED';

	/** the column name for the IS_HEADER field */
	const IS_HEADER = 'pc_archived_task.IS_HEADER';

	/** the column name for the IS_FROM_SYSTEM field */
	const IS_FROM_SYSTEM = 'pc_archived_task.IS_FROM_SYSTEM';

	/** the column name for the SPECIAL_FLAG field */
	const SPECIAL_FLAG = 'pc_archived_task.SPECIAL_FLAG';

	/** the column name for the NOTE field */
	const NOTE = 'pc_archived_task.NOTE';

	/** the column name for the CONTEXTS field */
	const CONTEXTS = 'pc_archived_task.CONTEXTS';

	/** the column name for the COMPLETED_AT field */
	const COMPLETED_AT = 'pc_archived_task.COMPLETED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'pc_archived_task.UPDATED_AT';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'pc_archived_task.CREATED_AT';

	/**
	 * An identiy map to hold any loaded instances of PcArchivedTask objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array PcArchivedTask[]
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
		BasePeer::TYPE_PHPNAME => array ('Id', 'ListId', 'Description', 'SortOrder', 'DueDate', 'DueTime', 'RepetitionId', 'RepetitionParam', 'IsStarred', 'IsCompleted', 'IsHeader', 'IsFromSystem', 'SpecialFlag', 'Note', 'Contexts', 'CompletedAt', 'UpdatedAt', 'CreatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'listId', 'description', 'sortOrder', 'dueDate', 'dueTime', 'repetitionId', 'repetitionParam', 'isStarred', 'isCompleted', 'isHeader', 'isFromSystem', 'specialFlag', 'note', 'contexts', 'completedAt', 'updatedAt', 'createdAt', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::LIST_ID, self::DESCRIPTION, self::SORT_ORDER, self::DUE_DATE, self::DUE_TIME, self::REPETITION_ID, self::REPETITION_PARAM, self::IS_STARRED, self::IS_COMPLETED, self::IS_HEADER, self::IS_FROM_SYSTEM, self::SPECIAL_FLAG, self::NOTE, self::CONTEXTS, self::COMPLETED_AT, self::UPDATED_AT, self::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'list_id', 'description', 'sort_order', 'due_date', 'due_time', 'repetition_id', 'repetition_param', 'is_starred', 'is_completed', 'is_header', 'is_from_system', 'special_flag', 'note', 'contexts', 'completed_at', 'updated_at', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ListId' => 1, 'Description' => 2, 'SortOrder' => 3, 'DueDate' => 4, 'DueTime' => 5, 'RepetitionId' => 6, 'RepetitionParam' => 7, 'IsStarred' => 8, 'IsCompleted' => 9, 'IsHeader' => 10, 'IsFromSystem' => 11, 'SpecialFlag' => 12, 'Note' => 13, 'Contexts' => 14, 'CompletedAt' => 15, 'UpdatedAt' => 16, 'CreatedAt' => 17, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'listId' => 1, 'description' => 2, 'sortOrder' => 3, 'dueDate' => 4, 'dueTime' => 5, 'repetitionId' => 6, 'repetitionParam' => 7, 'isStarred' => 8, 'isCompleted' => 9, 'isHeader' => 10, 'isFromSystem' => 11, 'specialFlag' => 12, 'note' => 13, 'contexts' => 14, 'completedAt' => 15, 'updatedAt' => 16, 'createdAt' => 17, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::LIST_ID => 1, self::DESCRIPTION => 2, self::SORT_ORDER => 3, self::DUE_DATE => 4, self::DUE_TIME => 5, self::REPETITION_ID => 6, self::REPETITION_PARAM => 7, self::IS_STARRED => 8, self::IS_COMPLETED => 9, self::IS_HEADER => 10, self::IS_FROM_SYSTEM => 11, self::SPECIAL_FLAG => 12, self::NOTE => 13, self::CONTEXTS => 14, self::COMPLETED_AT => 15, self::UPDATED_AT => 16, self::CREATED_AT => 17, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'list_id' => 1, 'description' => 2, 'sort_order' => 3, 'due_date' => 4, 'due_time' => 5, 'repetition_id' => 6, 'repetition_param' => 7, 'is_starred' => 8, 'is_completed' => 9, 'is_header' => 10, 'is_from_system' => 11, 'special_flag' => 12, 'note' => 13, 'contexts' => 14, 'completed_at' => 15, 'updated_at' => 16, 'created_at' => 17, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
	 * @param      string $column The column name for current table. (i.e. PcArchivedTaskPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PcArchivedTaskPeer::TABLE_NAME.'.', $alias.'.', $column);
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
		$criteria->addSelectColumn(PcArchivedTaskPeer::ID);
		$criteria->addSelectColumn(PcArchivedTaskPeer::LIST_ID);
		$criteria->addSelectColumn(PcArchivedTaskPeer::DESCRIPTION);
		$criteria->addSelectColumn(PcArchivedTaskPeer::SORT_ORDER);
		$criteria->addSelectColumn(PcArchivedTaskPeer::DUE_DATE);
		$criteria->addSelectColumn(PcArchivedTaskPeer::DUE_TIME);
		$criteria->addSelectColumn(PcArchivedTaskPeer::REPETITION_ID);
		$criteria->addSelectColumn(PcArchivedTaskPeer::REPETITION_PARAM);
		$criteria->addSelectColumn(PcArchivedTaskPeer::IS_STARRED);
		$criteria->addSelectColumn(PcArchivedTaskPeer::IS_COMPLETED);
		$criteria->addSelectColumn(PcArchivedTaskPeer::IS_HEADER);
		$criteria->addSelectColumn(PcArchivedTaskPeer::IS_FROM_SYSTEM);
		$criteria->addSelectColumn(PcArchivedTaskPeer::SPECIAL_FLAG);
		$criteria->addSelectColumn(PcArchivedTaskPeer::NOTE);
		$criteria->addSelectColumn(PcArchivedTaskPeer::CONTEXTS);
		$criteria->addSelectColumn(PcArchivedTaskPeer::COMPLETED_AT);
		$criteria->addSelectColumn(PcArchivedTaskPeer::UPDATED_AT);
		$criteria->addSelectColumn(PcArchivedTaskPeer::CREATED_AT);
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
		$criteria->setPrimaryTableName(PcArchivedTaskPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			PcArchivedTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcArchivedTaskPeer', $criteria, $con);
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
	 * @return     PcArchivedTask
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PcArchivedTaskPeer::doSelect($critcopy, $con);
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
		return PcArchivedTaskPeer::populateObjects(PcArchivedTaskPeer::doSelectStmt($criteria, $con));
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
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			PcArchivedTaskPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcArchivedTaskPeer', $criteria, $con);
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
	 * @param      PcArchivedTask $value A PcArchivedTask object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(PcArchivedTask $obj, $key = null)
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
	 * @param      mixed $value A PcArchivedTask object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof PcArchivedTask) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or PcArchivedTask object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	 * @return     PcArchivedTask Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
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
	 * Method to invalidate the instance pool of all tables related to pc_archived_task
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
		$cls = PcArchivedTaskPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = PcArchivedTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = PcArchivedTaskPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				PcArchivedTaskPeer::addInstanceToPool($obj, $key);
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
	  $dbMap = Propel::getDatabaseMap(BasePcArchivedTaskPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BasePcArchivedTaskPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new PcArchivedTaskTableMap());
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
		return $withPrefix ? PcArchivedTaskPeer::CLASS_DEFAULT : PcArchivedTaskPeer::OM_CLASS;
	}

	/**
	 * Method perform an INSERT on the database, given a PcArchivedTask or Criteria object.
	 *
	 * @param      mixed $values Criteria or PcArchivedTask object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcArchivedTaskPeer:doInsert:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BasePcArchivedTaskPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from PcArchivedTask object
		}

		if ($criteria->containsKey(PcArchivedTaskPeer::ID) && $criteria->keyContainsValue(PcArchivedTaskPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.PcArchivedTaskPeer::ID.')');
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
    foreach (sfMixer::getCallables('BasePcArchivedTaskPeer:doInsert:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BasePcArchivedTaskPeer', $values, $con, $pk);
    }

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a PcArchivedTask or Criteria object.
	 *
	 * @param      mixed $values Criteria or PcArchivedTask object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcArchivedTaskPeer:doUpdate:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BasePcArchivedTaskPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(PcArchivedTaskPeer::ID);
			$selectCriteria->add(PcArchivedTaskPeer::ID, $criteria->remove(PcArchivedTaskPeer::ID), $comparison);

		} else { // $values is PcArchivedTask object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);

    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcArchivedTaskPeer:doUpdate:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BasePcArchivedTaskPeer', $values, $con, $ret);
    }

    return $ret;
	}

	/**
	 * Method to DELETE all rows from the pc_archived_task table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(PcArchivedTaskPeer::TABLE_NAME, $con);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			PcArchivedTaskPeer::clearInstancePool();
			PcArchivedTaskPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a PcArchivedTask or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or PcArchivedTask object or primary key or array of primary keys
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
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			PcArchivedTaskPeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof PcArchivedTask) { // it's a model object
			// invalidate the cache for this single object
			PcArchivedTaskPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PcArchivedTaskPeer::ID, (array) $values, Criteria::IN);
			// invalidate the cache for this object(s)
			foreach ((array) $values as $singleval) {
				PcArchivedTaskPeer::removeInstanceFromPool($singleval);
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
			PcArchivedTaskPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given PcArchivedTask object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      PcArchivedTask $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(PcArchivedTask $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PcArchivedTaskPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PcArchivedTaskPeer::TABLE_NAME);

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

		return BasePeer::doValidate(PcArchivedTaskPeer::DATABASE_NAME, PcArchivedTaskPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     PcArchivedTask
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = PcArchivedTaskPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(PcArchivedTaskPeer::DATABASE_NAME);
		$criteria->add(PcArchivedTaskPeer::ID, $pk);

		$v = PcArchivedTaskPeer::doSelect($criteria, $con);

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
			$con = Propel::getConnection(PcArchivedTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(PcArchivedTaskPeer::DATABASE_NAME);
			$criteria->add(PcArchivedTaskPeer::ID, $pks, Criteria::IN);
			$objs = PcArchivedTaskPeer::doSelect($criteria, $con);
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
	    return sprintf('BasePcArchivedTaskPeer:%s:%1$s', 'Count' == $match[1] ? 'doCount' : $match[0]);
	  }
	
	  throw new LogicException(sprintf('Unrecognized function "%s"', $method));
	}

} // BasePcArchivedTaskPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePcArchivedTaskPeer::buildTableMap();

