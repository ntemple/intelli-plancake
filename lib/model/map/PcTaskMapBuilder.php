<?php


/**
 * This class adds structure of 'pc_task' table to 'propel' DatabaseMap object.
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
class PcTaskMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTaskMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcTaskPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcTaskPeer::TABLE_NAME);
		$tMap->setPhpName('PcTask');
		$tMap->setClassname('PcTask');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('LIST_ID', 'ListId', 'INTEGER', 'pc_list', 'ID', true, null);

		$tMap->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 255);

		$tMap->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null);

		$tMap->addColumn('DUE_DATE', 'DueDate', 'DATE', false, null);

		$tMap->addColumn('DUE_TIME', 'DueTime', 'INTEGER', false, null);

		$tMap->addForeignKey('REPETITION_ID', 'RepetitionId', 'TINYINT', 'pc_repetition', 'ID', false, null);

		$tMap->addColumn('REPETITION_PARAM', 'RepetitionParam', 'TINYINT', false, null);

		$tMap->addColumn('IS_STARRED', 'IsStarred', 'BOOLEAN', false, null);

		$tMap->addColumn('IS_COMPLETED', 'IsCompleted', 'BOOLEAN', true, null);

		$tMap->addColumn('IS_HEADER', 'IsHeader', 'BOOLEAN', true, null);

		$tMap->addColumn('IS_FROM_SYSTEM', 'IsFromSystem', 'BOOLEAN', true, null);

		$tMap->addColumn('NOTE', 'Note', 'VARCHAR', false, null);

		$tMap->addColumn('CONTEXTS', 'Contexts', 'VARCHAR', false, 31);

		$tMap->addColumn('COMPLETED_AT', 'CompletedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null);

	} // doBuild()

} // PcTaskMapBuilder
