<?php


/**
 * This class defines the structure of the 'pc_user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PcUserTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcUserTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('pc_user');
		$this->setPhpName('PcUser');
		$this->setClassname('PcUser');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('USERNAME', 'Username', 'VARCHAR', true, 25, null);
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', true, 80, null);
		$this->addColumn('ENCRYPTED_PASSWORD', 'EncryptedPassword', 'VARCHAR', true, 40, null);
		$this->addColumn('SALT', 'Salt', 'VARCHAR', true, 12, null);
		$this->addColumn('DATE_FORMAT', 'DateFormat', 'TINYINT', false, null, 0);
		$this->addColumn('TIME_FORMAT', 'TimeFormat', 'TINYINT', false, null, 0);
		$this->addForeignKey('TIMEZONE_ID', 'TimezoneId', 'TINYINT', 'pc_timezone', 'ID', false, null, null);
		$this->addColumn('WEEK_START', 'WeekStart', 'TINYINT', false, null, 0);
		$this->addColumn('DST_ACTIVE', 'DstActive', 'BOOLEAN', false, null, false);
		$this->addColumn('AWAITING_ACTIVATION', 'AwaitingActivation', 'BOOLEAN', false, null, true);
		$this->addColumn('NEWSLETTER', 'Newsletter', 'BOOLEAN', false, null, false);
		$this->addColumn('FORUM_ID', 'ForumId', 'INTEGER', false, null, null);
		$this->addColumn('LAST_LOGIN', 'LastLogin', 'TIMESTAMP', false, null, null);
		$this->addColumn('LANGUAGE', 'Language', 'VARCHAR', false, 8, '');
		$this->addColumn('PREFERRED_LANGUAGE', 'PreferredLanguage', 'VARCHAR', false, 2, '');
		$this->addColumn('IP_ADDRESS', 'IpAddress', 'VARCHAR', false, 15, '');
		$this->addColumn('HAS_DESKTOP_APP_BEEN_LOADED', 'HasDesktopAppBeenLoaded', 'BOOLEAN', false, null, false);
		$this->addColumn('HAS_REQUESTED_FREE_TRIAL', 'HasRequestedFreeTrial', 'BOOLEAN', false, null, false);
		$this->addColumn('AVATAR_RANDOM_SUFFIX', 'AvatarRandomSuffix', 'VARCHAR', false, 32, '');
		$this->addColumn('REMINDERS_ACTIVE', 'RemindersActive', 'BOOLEAN', false, null, false);
		$this->addColumn('LATEST_BLOG_ACCESS', 'LatestBlogAccess', 'TIMESTAMP', false, null, null);
		$this->addColumn('LATEST_BACKUP_REQUEST', 'LatestBackupRequest', 'TIMESTAMP', false, null, null);
		$this->addColumn('LATEST_IMPORT_REQUEST', 'LatestImportRequest', 'TIMESTAMP', false, null, null);
		$this->addColumn('LATEST_BREAKING_NEWS_CLOSED', 'LatestBreakingNewsClosed', 'INTEGER', false, null, null);
		$this->addColumn('LAST_PROMOTIONAL_CODE_INSERTED', 'LastPromotionalCodeInserted', 'VARCHAR', true, 25, '');
		$this->addColumn('BLOCKED', 'Blocked', 'BOOLEAN', false, null, false);
		$this->addColumn('SESSION_ENTRY_POINT', 'SessionEntryPoint', 'VARCHAR', false, 128, '');
		$this->addColumn('SESSION_REFERRAL', 'SessionReferral', 'VARCHAR', false, 128, '');
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcTimezone', 'PcTimezone', RelationMap::MANY_TO_ONE, array('timezone_id' => 'id', ), null, null);
    $this->addRelation('PcRemembermeKey', 'PcRemembermeKey', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcDirtyTask', 'PcDirtyTask', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcFailedLogins', 'PcFailedLogins', RelationMap::ONE_TO_ONE, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcActivationToken', 'PcActivationToken', RelationMap::ONE_TO_ONE, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcPasswordResetToken', 'PcPasswordResetToken', RelationMap::ONE_TO_ONE, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcPlancakeEmailAddress', 'PcPlancakeEmailAddress', RelationMap::ONE_TO_ONE, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcList', 'PcList', RelationMap::ONE_TO_MANY, array('id' => 'creator_id', ), null, null);
    $this->addRelation('PcUsersLists', 'PcUsersLists', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcEmailChangeHistory', 'PcEmailChangeHistory', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcUsersContexts', 'PcUsersContexts', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcSupporter', 'PcSupporter', RelationMap::ONE_TO_ONE, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcBlogPost', 'PcBlogPost', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcBlogComment', 'PcBlogComment', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcApiApp', 'PcApiApp', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcApiToken', 'PcApiToken', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcNote', 'PcNote', RelationMap::ONE_TO_MANY, array('id' => 'creator_id', ), null, null);
    $this->addRelation('PcSubscription', 'PcSubscription', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcGoogleCalendar', 'PcGoogleCalendar', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcUserKey', 'PcUserKey', RelationMap::ONE_TO_ONE, array('id' => 'user_id', ), null, null);
    $this->addRelation('PcContact', 'PcContact', RelationMap::ONE_TO_MANY, array('id' => 'creator_id', ), null, null);
    $this->addRelation('PcContactTag', 'PcContactTag', RelationMap::ONE_TO_MANY, array('id' => 'creator_id', ), null, null);
    $this->addRelation('PcContactsTags', 'PcContactsTags', RelationMap::ONE_TO_MANY, array('id' => 'creator_id', ), null, null);
    $this->addRelation('PcContactNote', 'PcContactNote', RelationMap::ONE_TO_MANY, array('id' => 'creator_id', ), null, null);
    $this->addRelation('PcHideableHintsSetting', 'PcHideableHintsSetting', RelationMap::ONE_TO_ONE, array('id' => 'id', ), null, null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
			'symfony_timestampable' => array('create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // PcUserTableMap
