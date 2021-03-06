<?php


/**
 * This class defines the structure of the 'pc_tasks_contexts' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PcTasksContextsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTasksContextsTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('pc_tasks_contexts');
		$this->setPhpName('PcTasksContexts');
		$this->setClassname('PcTasksContexts');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('TASK_ID', 'TaskId', 'INTEGER', 'pc_task', 'ID', true, null, null);
		$this->addForeignKey('USERS_CONTEXTS_ID', 'UsersContextsId', 'INTEGER', 'pc_users_contexts', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUsersContexts', 'PcUsersContexts', RelationMap::MANY_TO_ONE, array('users_contexts_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('PcTask', 'PcTask', RelationMap::MANY_TO_ONE, array('task_id' => 'id', ), 'CASCADE', null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // PcTasksContextsTableMap
