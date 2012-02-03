<?php


/**
 * This class defines the structure of the 'pc_users_contexts' table.
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
class PcUsersContextsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcUsersContextsTableMap';

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
		$this->setName('pc_users_contexts');
		$this->setPhpName('PcUsersContexts');
		$this->setClassname('PcUsersContexts');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', true, null, null);
		$this->addColumn('CONTEXT', 'Context', 'VARCHAR', true, 31, null);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null, 0);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('PcTasksContexts', 'PcTasksContexts', RelationMap::ONE_TO_MANY, array('id' => 'users_contexts_id', ), 'CASCADE', null);
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
			'symfony_timestampable' => array('update_column' => 'updated_at', 'create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // PcUsersContextsTableMap
