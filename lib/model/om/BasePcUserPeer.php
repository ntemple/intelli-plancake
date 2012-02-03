<?php

/**
 * Base static class for performing query and update operations on the 'pc_user' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BasePcUserPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'propel';

	/** the table name for this class */
	const TABLE_NAME = 'pc_user';

	/** the related Propel class for this table */
	const OM_CLASS = 'PcUser';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'lib.model.PcUser';

	/** the related TableMap class for this table */
	const TM_CLASS = 'PcUserTableMap';
	
	/** The total number of columns. */
	const NUM_COLUMNS = 30;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** the column name for the ID field */
	const ID = 'pc_user.ID';

	/** the column name for the USERNAME field */
	const USERNAME = 'pc_user.USERNAME';

	/** the column name for the EMAIL field */
	const EMAIL = 'pc_user.EMAIL';

	/** the column name for the ENCRYPTED_PASSWORD field */
	const ENCRYPTED_PASSWORD = 'pc_user.ENCRYPTED_PASSWORD';

	/** the column name for the SALT field */
	const SALT = 'pc_user.SALT';

	/** the column name for the DATE_FORMAT field */
	const DATE_FORMAT = 'pc_user.DATE_FORMAT';

	/** the column name for the TIME_FORMAT field */
	const TIME_FORMAT = 'pc_user.TIME_FORMAT';

	/** the column name for the TIMEZONE_ID field */
	const TIMEZONE_ID = 'pc_user.TIMEZONE_ID';

	/** the column name for the WEEK_START field */
	const WEEK_START = 'pc_user.WEEK_START';

	/** the column name for the DST_ACTIVE field */
	const DST_ACTIVE = 'pc_user.DST_ACTIVE';

	/** the column name for the REMEMBERME_KEY field */
	const REMEMBERME_KEY = 'pc_user.REMEMBERME_KEY';

	/** the column name for the AWAITING_ACTIVATION field */
	const AWAITING_ACTIVATION = 'pc_user.AWAITING_ACTIVATION';

	/** the column name for the NEWSLETTER field */
	const NEWSLETTER = 'pc_user.NEWSLETTER';

	/** the column name for the FORUM_ID field */
	const FORUM_ID = 'pc_user.FORUM_ID';

	/** the column name for the LAST_LOGIN field */
	const LAST_LOGIN = 'pc_user.LAST_LOGIN';

	/** the column name for the LANGUAGE field */
	const LANGUAGE = 'pc_user.LANGUAGE';

	/** the column name for the PREFERRED_LANGUAGE field */
	const PREFERRED_LANGUAGE = 'pc_user.PREFERRED_LANGUAGE';

	/** the column name for the IP_ADDRESS field */
	const IP_ADDRESS = 'pc_user.IP_ADDRESS';

	/** the column name for the HAS_DESKTOP_APP_BEEN_LOADED field */
	const HAS_DESKTOP_APP_BEEN_LOADED = 'pc_user.HAS_DESKTOP_APP_BEEN_LOADED';

	/** the column name for the HAS_REQUESTED_FREE_TRIAL field */
	const HAS_REQUESTED_FREE_TRIAL = 'pc_user.HAS_REQUESTED_FREE_TRIAL';

	/** the column name for the AVATAR_RANDOM_SUFFIX field */
	const AVATAR_RANDOM_SUFFIX = 'pc_user.AVATAR_RANDOM_SUFFIX';

	/** the column name for the REMINDERS_ACTIVE field */
	const REMINDERS_ACTIVE = 'pc_user.REMINDERS_ACTIVE';

	/** the column name for the LATEST_BLOG_ACCESS field */
	const LATEST_BLOG_ACCESS = 'pc_user.LATEST_BLOG_ACCESS';

	/** the column name for the LATEST_BACKUP_REQUEST field */
	const LATEST_BACKUP_REQUEST = 'pc_user.LATEST_BACKUP_REQUEST';

	/** the column name for the LATEST_IMPORT_REQUEST field */
	const LATEST_IMPORT_REQUEST = 'pc_user.LATEST_IMPORT_REQUEST';

	/** the column name for the LATEST_BREAKING_NEWS_CLOSED field */
	const LATEST_BREAKING_NEWS_CLOSED = 'pc_user.LATEST_BREAKING_NEWS_CLOSED';

	/** the column name for the LAST_PROMOTIONAL_CODE_INSERTED field */
	const LAST_PROMOTIONAL_CODE_INSERTED = 'pc_user.LAST_PROMOTIONAL_CODE_INSERTED';

	/** the column name for the SESSION_ENTRY_POINT field */
	const SESSION_ENTRY_POINT = 'pc_user.SESSION_ENTRY_POINT';

	/** the column name for the SESSION_REFERRAL field */
	const SESSION_REFERRAL = 'pc_user.SESSION_REFERRAL';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'pc_user.CREATED_AT';

	/**
	 * An identiy map to hold any loaded instances of PcUser objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array PcUser[]
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
		BasePeer::TYPE_PHPNAME => array ('Id', 'Username', 'Email', 'EncryptedPassword', 'Salt', 'DateFormat', 'TimeFormat', 'TimezoneId', 'WeekStart', 'DstActive', 'RemembermeKey', 'AwaitingActivation', 'Newsletter', 'ForumId', 'LastLogin', 'Language', 'PreferredLanguage', 'IpAddress', 'HasDesktopAppBeenLoaded', 'HasRequestedFreeTrial', 'AvatarRandomSuffix', 'RemindersActive', 'LatestBlogAccess', 'LatestBackupRequest', 'LatestImportRequest', 'LatestBreakingNewsClosed', 'LastPromotionalCodeInserted', 'SessionEntryPoint', 'SessionReferral', 'CreatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'username', 'email', 'encryptedPassword', 'salt', 'dateFormat', 'timeFormat', 'timezoneId', 'weekStart', 'dstActive', 'remembermeKey', 'awaitingActivation', 'newsletter', 'forumId', 'lastLogin', 'language', 'preferredLanguage', 'ipAddress', 'hasDesktopAppBeenLoaded', 'hasRequestedFreeTrial', 'avatarRandomSuffix', 'remindersActive', 'latestBlogAccess', 'latestBackupRequest', 'latestImportRequest', 'latestBreakingNewsClosed', 'lastPromotionalCodeInserted', 'sessionEntryPoint', 'sessionReferral', 'createdAt', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::USERNAME, self::EMAIL, self::ENCRYPTED_PASSWORD, self::SALT, self::DATE_FORMAT, self::TIME_FORMAT, self::TIMEZONE_ID, self::WEEK_START, self::DST_ACTIVE, self::REMEMBERME_KEY, self::AWAITING_ACTIVATION, self::NEWSLETTER, self::FORUM_ID, self::LAST_LOGIN, self::LANGUAGE, self::PREFERRED_LANGUAGE, self::IP_ADDRESS, self::HAS_DESKTOP_APP_BEEN_LOADED, self::HAS_REQUESTED_FREE_TRIAL, self::AVATAR_RANDOM_SUFFIX, self::REMINDERS_ACTIVE, self::LATEST_BLOG_ACCESS, self::LATEST_BACKUP_REQUEST, self::LATEST_IMPORT_REQUEST, self::LATEST_BREAKING_NEWS_CLOSED, self::LAST_PROMOTIONAL_CODE_INSERTED, self::SESSION_ENTRY_POINT, self::SESSION_REFERRAL, self::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'username', 'email', 'encrypted_password', 'salt', 'date_format', 'time_format', 'timezone_id', 'week_start', 'dst_active', 'rememberme_key', 'awaiting_activation', 'newsletter', 'forum_id', 'last_login', 'language', 'preferred_language', 'ip_address', 'has_desktop_app_been_loaded', 'has_requested_free_trial', 'avatar_random_suffix', 'reminders_active', 'latest_blog_access', 'latest_backup_request', 'latest_import_request', 'latest_breaking_news_closed', 'last_promotional_code_inserted', 'session_entry_point', 'session_referral', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Username' => 1, 'Email' => 2, 'EncryptedPassword' => 3, 'Salt' => 4, 'DateFormat' => 5, 'TimeFormat' => 6, 'TimezoneId' => 7, 'WeekStart' => 8, 'DstActive' => 9, 'RemembermeKey' => 10, 'AwaitingActivation' => 11, 'Newsletter' => 12, 'ForumId' => 13, 'LastLogin' => 14, 'Language' => 15, 'PreferredLanguage' => 16, 'IpAddress' => 17, 'HasDesktopAppBeenLoaded' => 18, 'HasRequestedFreeTrial' => 19, 'AvatarRandomSuffix' => 20, 'RemindersActive' => 21, 'LatestBlogAccess' => 22, 'LatestBackupRequest' => 23, 'LatestImportRequest' => 24, 'LatestBreakingNewsClosed' => 25, 'LastPromotionalCodeInserted' => 26, 'SessionEntryPoint' => 27, 'SessionReferral' => 28, 'CreatedAt' => 29, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'username' => 1, 'email' => 2, 'encryptedPassword' => 3, 'salt' => 4, 'dateFormat' => 5, 'timeFormat' => 6, 'timezoneId' => 7, 'weekStart' => 8, 'dstActive' => 9, 'remembermeKey' => 10, 'awaitingActivation' => 11, 'newsletter' => 12, 'forumId' => 13, 'lastLogin' => 14, 'language' => 15, 'preferredLanguage' => 16, 'ipAddress' => 17, 'hasDesktopAppBeenLoaded' => 18, 'hasRequestedFreeTrial' => 19, 'avatarRandomSuffix' => 20, 'remindersActive' => 21, 'latestBlogAccess' => 22, 'latestBackupRequest' => 23, 'latestImportRequest' => 24, 'latestBreakingNewsClosed' => 25, 'lastPromotionalCodeInserted' => 26, 'sessionEntryPoint' => 27, 'sessionReferral' => 28, 'createdAt' => 29, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::USERNAME => 1, self::EMAIL => 2, self::ENCRYPTED_PASSWORD => 3, self::SALT => 4, self::DATE_FORMAT => 5, self::TIME_FORMAT => 6, self::TIMEZONE_ID => 7, self::WEEK_START => 8, self::DST_ACTIVE => 9, self::REMEMBERME_KEY => 10, self::AWAITING_ACTIVATION => 11, self::NEWSLETTER => 12, self::FORUM_ID => 13, self::LAST_LOGIN => 14, self::LANGUAGE => 15, self::PREFERRED_LANGUAGE => 16, self::IP_ADDRESS => 17, self::HAS_DESKTOP_APP_BEEN_LOADED => 18, self::HAS_REQUESTED_FREE_TRIAL => 19, self::AVATAR_RANDOM_SUFFIX => 20, self::REMINDERS_ACTIVE => 21, self::LATEST_BLOG_ACCESS => 22, self::LATEST_BACKUP_REQUEST => 23, self::LATEST_IMPORT_REQUEST => 24, self::LATEST_BREAKING_NEWS_CLOSED => 25, self::LAST_PROMOTIONAL_CODE_INSERTED => 26, self::SESSION_ENTRY_POINT => 27, self::SESSION_REFERRAL => 28, self::CREATED_AT => 29, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'username' => 1, 'email' => 2, 'encrypted_password' => 3, 'salt' => 4, 'date_format' => 5, 'time_format' => 6, 'timezone_id' => 7, 'week_start' => 8, 'dst_active' => 9, 'rememberme_key' => 10, 'awaiting_activation' => 11, 'newsletter' => 12, 'forum_id' => 13, 'last_login' => 14, 'language' => 15, 'preferred_language' => 16, 'ip_address' => 17, 'has_desktop_app_been_loaded' => 18, 'has_requested_free_trial' => 19, 'avatar_random_suffix' => 20, 'reminders_active' => 21, 'latest_blog_access' => 22, 'latest_backup_request' => 23, 'latest_import_request' => 24, 'latest_breaking_news_closed' => 25, 'last_promotional_code_inserted' => 26, 'session_entry_point' => 27, 'session_referral' => 28, 'created_at' => 29, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, )
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
	 * @param      string $column The column name for current table. (i.e. PcUserPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(PcUserPeer::TABLE_NAME.'.', $alias.'.', $column);
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
		$criteria->addSelectColumn(PcUserPeer::ID);
		$criteria->addSelectColumn(PcUserPeer::USERNAME);
		$criteria->addSelectColumn(PcUserPeer::EMAIL);
		$criteria->addSelectColumn(PcUserPeer::ENCRYPTED_PASSWORD);
		$criteria->addSelectColumn(PcUserPeer::SALT);
		$criteria->addSelectColumn(PcUserPeer::DATE_FORMAT);
		$criteria->addSelectColumn(PcUserPeer::TIME_FORMAT);
		$criteria->addSelectColumn(PcUserPeer::TIMEZONE_ID);
		$criteria->addSelectColumn(PcUserPeer::WEEK_START);
		$criteria->addSelectColumn(PcUserPeer::DST_ACTIVE);
		$criteria->addSelectColumn(PcUserPeer::REMEMBERME_KEY);
		$criteria->addSelectColumn(PcUserPeer::AWAITING_ACTIVATION);
		$criteria->addSelectColumn(PcUserPeer::NEWSLETTER);
		$criteria->addSelectColumn(PcUserPeer::FORUM_ID);
		$criteria->addSelectColumn(PcUserPeer::LAST_LOGIN);
		$criteria->addSelectColumn(PcUserPeer::LANGUAGE);
		$criteria->addSelectColumn(PcUserPeer::PREFERRED_LANGUAGE);
		$criteria->addSelectColumn(PcUserPeer::IP_ADDRESS);
		$criteria->addSelectColumn(PcUserPeer::HAS_DESKTOP_APP_BEEN_LOADED);
		$criteria->addSelectColumn(PcUserPeer::HAS_REQUESTED_FREE_TRIAL);
		$criteria->addSelectColumn(PcUserPeer::AVATAR_RANDOM_SUFFIX);
		$criteria->addSelectColumn(PcUserPeer::REMINDERS_ACTIVE);
		$criteria->addSelectColumn(PcUserPeer::LATEST_BLOG_ACCESS);
		$criteria->addSelectColumn(PcUserPeer::LATEST_BACKUP_REQUEST);
		$criteria->addSelectColumn(PcUserPeer::LATEST_IMPORT_REQUEST);
		$criteria->addSelectColumn(PcUserPeer::LATEST_BREAKING_NEWS_CLOSED);
		$criteria->addSelectColumn(PcUserPeer::LAST_PROMOTIONAL_CODE_INSERTED);
		$criteria->addSelectColumn(PcUserPeer::SESSION_ENTRY_POINT);
		$criteria->addSelectColumn(PcUserPeer::SESSION_REFERRAL);
		$criteria->addSelectColumn(PcUserPeer::CREATED_AT);
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
		$criteria->setPrimaryTableName(PcUserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			PcUserPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcUserPeer', $criteria, $con);
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
	 * @return     PcUser
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = PcUserPeer::doSelect($critcopy, $con);
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
		return PcUserPeer::populateObjects(PcUserPeer::doSelectStmt($criteria, $con));
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
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			PcUserPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);
		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcUserPeer', $criteria, $con);
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
	 * @param      PcUser $value A PcUser object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool(PcUser $obj, $key = null)
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
	 * @param      mixed $value A PcUser object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof PcUser) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or PcUser object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	 * @return     PcUser Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
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
	 * Method to invalidate the instance pool of all tables related to pc_user
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
		$cls = PcUserPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = PcUserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = PcUserPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				PcUserPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining the related PcTimezone table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinPcTimezone(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(PcUserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			PcUserPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(PcUserPeer::TIMEZONE_ID, PcTimezonePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcUserPeer', $criteria, $con);
		}

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
	 * Selects a collection of PcUser objects pre-filled with their PcTimezone objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of PcUser objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinPcTimezone(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		PcUserPeer::addSelectColumns($criteria);
		$startcol = (PcUserPeer::NUM_COLUMNS - PcUserPeer::NUM_LAZY_LOAD_COLUMNS);
		PcTimezonePeer::addSelectColumns($criteria);

		$criteria->addJoin(PcUserPeer::TIMEZONE_ID, PcTimezonePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcUserPeer', $criteria, $con);
		}

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = PcUserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = PcUserPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = PcUserPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				PcUserPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = PcTimezonePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = PcTimezonePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = PcTimezonePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					PcTimezonePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded
				
				// Add the $obj1 (PcUser) to $obj2 (PcTimezone)
				$obj2->addPcUser($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(PcUserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			PcUserPeer::addSelectColumns($criteria);
		}
		
		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		
		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(PcUserPeer::TIMEZONE_ID, PcTimezonePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcUserPeer', $criteria, $con);
		}

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
	 * Selects a collection of PcUser objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of PcUser objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		PcUserPeer::addSelectColumns($criteria);
		$startcol2 = (PcUserPeer::NUM_COLUMNS - PcUserPeer::NUM_LAZY_LOAD_COLUMNS);

		PcTimezonePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + (PcTimezonePeer::NUM_COLUMNS - PcTimezonePeer::NUM_LAZY_LOAD_COLUMNS);

		$criteria->addJoin(PcUserPeer::TIMEZONE_ID, PcTimezonePeer::ID, $join_behavior);

		// symfony_behaviors behavior
		foreach (sfMixer::getCallables(self::getMixerPreSelectHook(__FUNCTION__)) as $sf_hook)
		{
		  call_user_func($sf_hook, 'BasePcUserPeer', $criteria, $con);
		}

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = PcUserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = PcUserPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://propel.phpdb.org/trac/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = PcUserPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				PcUserPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

			// Add objects for joined PcTimezone rows

			$key2 = PcTimezonePeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = PcTimezonePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = PcTimezonePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					PcTimezonePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 loaded

				// Add the $obj1 (PcUser) to the collection in $obj2 (PcTimezone)
				$obj2->addPcUser($obj1);
			} // if joined row not null

			$results[] = $obj1;
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
	  $dbMap = Propel::getDatabaseMap(BasePcUserPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BasePcUserPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new PcUserTableMap());
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
		return $withPrefix ? PcUserPeer::CLASS_DEFAULT : PcUserPeer::OM_CLASS;
	}

	/**
	 * Method perform an INSERT on the database, given a PcUser or Criteria object.
	 *
	 * @param      mixed $values Criteria or PcUser object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcUserPeer:doInsert:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BasePcUserPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from PcUser object
		}

		if ($criteria->containsKey(PcUserPeer::ID) && $criteria->keyContainsValue(PcUserPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.PcUserPeer::ID.')');
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
    foreach (sfMixer::getCallables('BasePcUserPeer:doInsert:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BasePcUserPeer', $values, $con, $pk);
    }

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a PcUser or Criteria object.
	 *
	 * @param      mixed $values Criteria or PcUser object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcUserPeer:doUpdate:pre') as $sf_hook)
    {
      if (false !== $sf_hook_retval = call_user_func($sf_hook, 'BasePcUserPeer', $values, $con))
      {
        return $sf_hook_retval;
      }
    }

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(PcUserPeer::ID);
			$selectCriteria->add(PcUserPeer::ID, $criteria->remove(PcUserPeer::ID), $comparison);

		} else { // $values is PcUser object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);

    // symfony_behaviors behavior
    foreach (sfMixer::getCallables('BasePcUserPeer:doUpdate:post') as $sf_hook)
    {
      call_user_func($sf_hook, 'BasePcUserPeer', $values, $con, $ret);
    }

    return $ret;
	}

	/**
	 * Method to DELETE all rows from the pc_user table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(PcUserPeer::TABLE_NAME, $con);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			PcUserPeer::clearInstancePool();
			PcUserPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a PcUser or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or PcUser object or primary key or array of primary keys
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
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			PcUserPeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof PcUser) { // it's a model object
			// invalidate the cache for this single object
			PcUserPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PcUserPeer::ID, (array) $values, Criteria::IN);
			// invalidate the cache for this object(s)
			foreach ((array) $values as $singleval) {
				PcUserPeer::removeInstanceFromPool($singleval);
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
			PcUserPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given PcUser object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      PcUser $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(PcUser $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PcUserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PcUserPeer::TABLE_NAME);

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

		return BasePeer::doValidate(PcUserPeer::DATABASE_NAME, PcUserPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     PcUser
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = PcUserPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
		$criteria->add(PcUserPeer::ID, $pk);

		$v = PcUserPeer::doSelect($criteria, $con);

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
			$con = Propel::getConnection(PcUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(PcUserPeer::DATABASE_NAME);
			$criteria->add(PcUserPeer::ID, $pks, Criteria::IN);
			$objs = PcUserPeer::doSelect($criteria, $con);
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
	  return array(array('email'), array('rememberme_key'));
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
	    return sprintf('BasePcUserPeer:%s:%1$s', 'Count' == $match[1] ? 'doCount' : $match[0]);
	  }
	
	  throw new LogicException(sprintf('Unrecognized function "%s"', $method));
	}

} // BasePcUserPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePcUserPeer::buildTableMap();

