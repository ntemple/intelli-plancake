<?php


/**
 * This class defines the structure of the 'pc_google_calendar' table.
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
class PcGoogleCalendarTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcGoogleCalendarTableMap';

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
		$this->setName('pc_google_calendar');
		$this->setPhpName('PcGoogleCalendar');
		$this->setClassname('PcGoogleCalendar');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', true, null, null);
		$this->addColumn('CALENDAR_URL', 'CalendarUrl', 'VARCHAR', false, 255, '');
		$this->addColumn('SESSION_TOKEN', 'SessionToken', 'VARCHAR', true, 64, '');
		$this->addColumn('EMAIL_ADDRESS', 'EmailAddress', 'VARCHAR', true, 123, '');
		$this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_SYNCING', 'IsSyncing', 'BOOLEAN', false, null, false);
		$this->addColumn('LATEST_SYNC_START_TIMESTAMP', 'LatestSyncStartTimestamp', 'INTEGER', false, null, null);
		$this->addColumn('LATEST_SYNC_END_TIMESTAMP', 'LatestSyncEndTimestamp', 'INTEGER', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
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
			'symfony_timestampable' => array('update_column' => 'updated_at', 'create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // PcGoogleCalendarTableMap
