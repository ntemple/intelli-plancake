<?php


/**
 * This class defines the structure of the 'pc_trashbin_list' table.
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
class PcTrashbinListTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTrashbinListTableMap';

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
		$this->setName('pc_trashbin_list');
		$this->setPhpName('PcTrashbinList');
		$this->setClassname('PcTrashbinList');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('CREATOR_ID', 'CreatorId', 'INTEGER', true, null, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null, 0);
		$this->addColumn('IS_HEADER', 'IsHeader', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_INBOX', 'IsInbox', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_TODO', 'IsTodo', 'BOOLEAN', true, null, false);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('DELETED_AT', 'DeletedAt', 'INTEGER', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
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

} // PcTrashbinListTableMap
