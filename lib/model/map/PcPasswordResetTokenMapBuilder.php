<?php


/**
 * This class adds structure of 'pc_password_reset_token' table to 'propel' DatabaseMap object.
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
class PcPasswordResetTokenMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcPasswordResetTokenMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcPasswordResetTokenPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcPasswordResetTokenPeer::TABLE_NAME);
		$tMap->setPhpName('PcPasswordResetToken');
		$tMap->setClassname('PcPasswordResetToken');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'pc_user', 'ID', true, null);

		$tMap->addColumn('TOKEN', 'Token', 'VARCHAR', true, 16);

	} // doBuild()

} // PcPasswordResetTokenMapBuilder
