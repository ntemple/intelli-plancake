<?php


/**
 * This class adds structure of 'pc_api_app_stats' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PcApiAppStatsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcApiAppStatsMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(PcApiAppStatsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcApiAppStatsPeer::TABLE_NAME);
		$tMap->setPhpName('PcApiAppStats');
		$tMap->setClassname('PcApiAppStats');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('API_APP_ID', 'ApiAppId', 'SMALLINT', 'pc_api_app', 'ID', false, null);

		$tMap->addColumn('NUMBER_OF_REQUESTS', 'NumberOfRequests', 'INTEGER', false, null);

		$tMap->addColumn('BANDWIDTH', 'Bandwidth', 'INTEGER', false, null);

		$tMap->addColumn('TODAY', 'Today', 'VARCHAR', false, 10);

		$tMap->addColumn('NUMBER_OF_REQUESTS_TODAY', 'NumberOfRequestsToday', 'INTEGER', false, null);

		$tMap->addColumn('BANDWIDTH_TODAY', 'BandwidthToday', 'INTEGER', false, null);

		$tMap->addColumn('LAST_HOUR', 'LastHour', 'INTEGER', false, 2);

		$tMap->addColumn('NUMBER_OF_REQUESTS_LAST_HOUR', 'NumberOfRequestsLastHour', 'SMALLINT', false, null);

		$tMap->addColumn('BANDWIDTH_LAST_HOUR', 'BandwidthLastHour', 'INTEGER', false, null);

	} // doBuild()

} // PcApiAppStatsMapBuilder
