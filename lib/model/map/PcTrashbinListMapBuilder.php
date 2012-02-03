<?php


/**
 * This class adds structure of 'pc_trashbin_list' table to 'propel' DatabaseMap object.
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
class PcTrashbinListMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTrashbinListMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcTrashbinListPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcTrashbinListPeer::TABLE_NAME);
		$tMap->setPhpName('PcTrashbinList');
		$tMap->setClassname('PcTrashbinList');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('CREATOR_ID', 'CreatorId', 'INTEGER', true, null);

		$tMap->addColumn('TITLE', 'Title', 'VARCHAR', true, 255);

		$tMap->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null);

		$tMap->addColumn('IS_HEADER', 'IsHeader', 'BOOLEAN', false, null);

		$tMap->addColumn('IS_INBOX', 'IsInbox', 'BOOLEAN', true, null);

		$tMap->addColumn('IS_TODO', 'IsTodo', 'BOOLEAN', true, null);

		$tMap->addColumn('MAX_TASKS_SORT_ORDER', 'MaxTasksSortOrder', 'SMALLINT', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('DELETED_AT', 'DeletedAt', 'INTEGER', false, 11);

	} // doBuild()

} // PcTrashbinListMapBuilder
