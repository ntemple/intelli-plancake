<?php


/**
 * This class adds structure of 'pc_api_app' table to 'propel' DatabaseMap object.
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
class PcApiAppMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcApiAppMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcApiAppPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcApiAppPeer::TABLE_NAME);
		$tMap->setPhpName('PcApiApp');
		$tMap->setClassname('PcApiApp');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'SMALLINT', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 64);

		$tMap->addColumn('API_KEY', 'ApiKey', 'VARCHAR', true, 40);

		$tMap->addColumn('API_SECRET', 'ApiSecret', 'VARCHAR', true, 16);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', false, null);

		$tMap->addColumn('IS_LIMITED', 'IsLimited', 'BOOLEAN', false, null);

		$tMap->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, null);

	} // doBuild()

} // PcApiAppMapBuilder
