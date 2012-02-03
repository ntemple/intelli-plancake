<?php


/**
 * This class defines the structure of the 'pc_task' table.
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
class PcTaskTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTaskTableMap';

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
		$this->setName('pc_task');
		$this->setPhpName('PcTask');
		$this->setClassname('PcTask');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('LIST_ID', 'ListId', 'INTEGER', 'pc_list', 'ID', true, null, null);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 255, null);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null, 0);
		$this->addColumn('DUE_DATE', 'DueDate', 'DATE', false, null, null);
		$this->addColumn('DUE_TIME', 'DueTime', 'INTEGER', false, null, null);
		$this->addForeignKey('REPETITION_ID', 'RepetitionId', 'TINYINT', 'pc_repetition', 'ID', false, null, null);
		$this->addColumn('REPETITION_PARAM', 'RepetitionParam', 'TINYINT', false, null, 0);
		$this->addColumn('IS_STARRED', 'IsStarred', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_COMPLETED', 'IsCompleted', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_HEADER', 'IsHeader', 'BOOLEAN', true, null, false);
		$this->addColumn('IS_FROM_SYSTEM', 'IsFromSystem', 'BOOLEAN', true, null, false);
		$this->addColumn('SPECIAL_FLAG', 'SpecialFlag', 'TINYINT', false, null, null);
		$this->addColumn('NOTE', 'Note', 'VARCHAR', false, null, null);
		$this->addColumn('CONTEXTS', 'Contexts', 'VARCHAR', false, 31, '');
		$this->addColumn('CONTACT_ID', 'ContactId', 'INTEGER', false, null, null);
		$this->addColumn('COMPLETED_AT', 'CompletedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcList', 'PcList', RelationMap::MANY_TO_ONE, array('list_id' => 'id', ), null, null);
    $this->addRelation('PcRepetition', 'PcRepetition', RelationMap::MANY_TO_ONE, array('repetition_id' => 'id', ), null, null);
    $this->addRelation('PcDirtyTask', 'PcDirtyTask', RelationMap::ONE_TO_MANY, array('id' => 'task_id', ), null, null);
    $this->addRelation('PcTasksContexts', 'PcTasksContexts', RelationMap::ONE_TO_MANY, array('id' => 'task_id', ), 'CASCADE', null);
    $this->addRelation('PcGoogleCalendarEvent', 'PcGoogleCalendarEvent', RelationMap::ONE_TO_ONE, array('id' => 'task_id', ), 'CASCADE', null);
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

} // PcTaskTableMap
