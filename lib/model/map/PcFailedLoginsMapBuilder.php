<?php


/**
 * This class adds structure of 'pc_failed_logins' table to 'propel' DatabaseMap object.
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
class PcFailedLoginsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcFailedLoginsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcFailedLoginsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcFailedLoginsPeer::TABLE_NAME);
		$tMap->setPhpName('PcFailedLogins');
		$tMap->setClassname('PcFailedLogins');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'pc_user', 'ID', true, null);

		$tMap->addColumn('TIMES', 'Times', 'TINYINT', true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PcFailedLoginsMapBuilder
