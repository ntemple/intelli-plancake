<?php


/**
 * This class adds structure of 'pc_api_token' table to 'propel' DatabaseMap object.
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
class PcApiTokenMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcApiTokenMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcApiTokenPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcApiTokenPeer::TABLE_NAME);
		$tMap->setPhpName('PcApiToken');
		$tMap->setClassname('PcApiToken');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('TOKEN', 'Token', 'VARCHAR', true, 41);

		$tMap->addForeignKey('API_APP_ID', 'ApiAppId', 'SMALLINT', 'pc_api_app', 'ID', true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', false, null);

		$tMap->addColumn('EXPIRY_TIMESTAMP', 'ExpiryTimestamp', 'INTEGER', false, 11);

	} // doBuild()

} // PcApiTokenMapBuilder
