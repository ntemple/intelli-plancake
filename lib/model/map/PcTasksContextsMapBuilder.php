<?php


/**
 * This class adds structure of 'pc_tasks_contexts' table to 'propel' DatabaseMap object.
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
class PcTasksContextsMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTasksContextsMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcTasksContextsPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcTasksContextsPeer::TABLE_NAME);
		$tMap->setPhpName('PcTasksContexts');
		$tMap->setClassname('PcTasksContexts');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('TASK_ID', 'TaskId', 'INTEGER', 'pc_task', 'ID', true, null);

		$tMap->addForeignKey('USERS_CONTEXTS_ID', 'UsersContextsId', 'INTEGER', 'pc_users_contexts', 'ID', true, null);

	} // doBuild()

} // PcTasksContextsMapBuilder
