<?php


/**
 * This class defines the structure of the 'pc_trashbin_task' table.
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
class PcTrashbinTaskTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTrashbinTaskTableMap';

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
		$this->setName('pc_trashbin_task');
		$this->setPhpName('PcTrashbinTask');
		$this->setClassname('PcTrashbinTask');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('LIST_ID', 'ListId', 'INTEGER', true, null, null);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 255, null);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null, 0);
		$this->addColumn('DUE_DATE', 'DueDate', 'DATE', false, null, null);
		$this->addColumn('REPETITION_ID', 'RepetitionId', 'TINYINT', false, null, null);
		$this->addColumn('REPETITION_PARAM', 'RepetitionParam', 'TINYINT', false, null, 0);
		$this->addColumn('IS_COMPLETED', 'IsCompleted', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_HEADER', 'IsHeader', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_FROM_SYSTEM', 'IsFromSystem', 'BOOLEAN', false, null, false);
		$this->addColumn('NOTE', 'Note', 'VARCHAR', false, null, null);
		$this->addColumn('CONTEXTS', 'Contexts', 'VARCHAR', false, 31, '');
		$this->addColumn('CONTACT_ID', 'ContactId', 'INTEGER', false, null, null);
		$this->addColumn('COMPLETED_AT', 'CompletedAt', 'TIMESTAMP', false, null, null);
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

} // PcTrashbinTaskTableMap
