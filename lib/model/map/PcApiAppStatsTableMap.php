<?php


/**
 * This class defines the structure of the 'pc_api_app_stats' table.
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
class PcApiAppStatsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcApiAppStatsTableMap';

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
		$this->setName('pc_api_app_stats');
		$this->setPhpName('PcApiAppStats');
		$this->setClassname('PcApiAppStats');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('API_APP_ID', 'ApiAppId', 'SMALLINT', 'pc_api_app', 'ID', false, null, null);
		$this->addColumn('NUMBER_OF_REQUESTS', 'NumberOfRequests', 'INTEGER', false, null, 0);
		$this->addColumn('BANDWIDTH', 'Bandwidth', 'INTEGER', false, null, 0);
		$this->addColumn('TODAY', 'Today', 'VARCHAR', false, 10, null);
		$this->addColumn('NUMBER_OF_REQUESTS_TODAY', 'NumberOfRequestsToday', 'INTEGER', false, null, 0);
		$this->addColumn('BANDWIDTH_TODAY', 'BandwidthToday', 'INTEGER', false, null, 0);
		$this->addColumn('LAST_HOUR', 'LastHour', 'INTEGER', false, 2, null);
		$this->addColumn('NUMBER_OF_REQUESTS_LAST_HOUR', 'NumberOfRequestsLastHour', 'SMALLINT', false, null, 0);
		$this->addColumn('BANDWIDTH_LAST_HOUR', 'BandwidthLastHour', 'INTEGER', false, null, 0);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcApiApp', 'PcApiApp', RelationMap::MANY_TO_ONE, array('api_app_id' => 'id', ), null, null);
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
		);
	} // getBehaviors()

} // PcApiAppStatsTableMap
