<?php


/**
 * This class adds structure of 'pc_repetition' table to 'propel' DatabaseMap object.
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
class PcRepetitionMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcRepetitionMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcRepetitionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcRepetitionPeer::TABLE_NAME);
		$tMap->setPhpName('PcRepetition');
		$tMap->setClassname('PcRepetition');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'TINYINT', true, null);

		$tMap->addColumn('HUMAN_EXPRESSION', 'HumanExpression', 'VARCHAR', true, 63);

		$tMap->addColumn('COMPUTER_EXPRESSION', 'ComputerExpression', 'VARCHAR', true, 63);

		$tMap->addColumn('SPECIAL', 'Special', 'VARCHAR', true, 16);

		$tMap->addColumn('NEEDS_PARAM', 'NeedsParam', 'BOOLEAN', false, null);

		$tMap->addColumn('IS_PARAM_CARDINAL', 'IsParamCardinal', 'BOOLEAN', false, null);

		$tMap->addColumn('MIN_PARAM', 'MinParam', 'TINYINT', false, null);

		$tMap->addColumn('MAX_PARAM', 'MaxParam', 'TINYINT', false, null);

		$tMap->addColumn('SORT_ORDER', 'SortOrder', 'TINYINT', false, null);

		$tMap->addColumn('HAS_DIVIDER_BELOW', 'HasDividerBelow', 'BOOLEAN', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PcRepetitionMapBuilder
