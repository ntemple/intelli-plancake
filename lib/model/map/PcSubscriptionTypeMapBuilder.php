<?php


/**
 * This class adds structure of 'pc_subscription_type' table to 'propel' DatabaseMap object.
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
class PcSubscriptionTypeMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcSubscriptionTypeMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcSubscriptionTypePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcSubscriptionTypePeer::TABLE_NAME);
		$tMap->setPhpName('PcSubscriptionType');
		$tMap->setClassname('PcSubscriptionType');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'TINYINT', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 32);

		$tMap->addColumn('EXPIRATION_TIME_EXPRESSION', 'ExpirationTimeExpression', 'VARCHAR', true, 32);

	} // doBuild()

} // PcSubscriptionTypeMapBuilder
