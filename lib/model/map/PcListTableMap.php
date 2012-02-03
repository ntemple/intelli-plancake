<?php


/**
 * This class defines the structure of the 'pc_list' table.
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
class PcListTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcListTableMap';

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
		$this->setName('pc_list');
		$this->setPhpName('PcList');
		$this->setClassname('PcList');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('CREATOR_ID', 'CreatorId', 'INTEGER', 'pc_user', 'ID', true, null, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null, 0);
		$this->addColumn('IS_HEADER', 'IsHeader', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_INBOX', 'IsInbox', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_TODO', 'IsTodo', 'BOOLEAN', true, null, false);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('creator_id' => 'id', ), null, null);
    $this->addRelation('PcTask', 'PcTask', RelationMap::ONE_TO_MANY, array('id' => 'list_id', ), null, null);
    $this->addRelation('PcUsersLists', 'PcUsersLists', RelationMap::ONE_TO_MANY, array('id' => 'list_id', ), null, null);
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

} // PcListTableMap
