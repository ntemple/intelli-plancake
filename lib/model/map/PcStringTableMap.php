<?php


/**
 * This class defines the structure of the 'pc_string' table.
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
class PcStringTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcStringTableMap';

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
		$this->setName('pc_string');
		$this->setPhpName('PcString');
		$this->setClassname('PcString');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'VARCHAR', true, 64, null);
		$this->addForeignKey('CATEGORY_ID', 'CategoryId', 'INTEGER', 'pc_string_category', 'ID', true, null, null);
		$this->addColumn('SORT_ORDER_IN_CATEGORY', 'SortOrderInCategory', 'INTEGER', true, null, null);
		$this->addColumn('MAX_LENGTH', 'MaxLength', 'INTEGER', true, null, 0);
		$this->addColumn('NOTE', 'Note', 'VARCHAR', false, 128, null);
		$this->addColumn('IS_ARCHIVED', 'IsArchived', 'BOOLEAN', true, null, false);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcStringCategory', 'PcStringCategory', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('PcTranslation', 'PcTranslation', RelationMap::ONE_TO_MANY, array('id' => 'string_id', ), 'CASCADE', null);
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
			'symfony_timestampable' => array('create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // PcStringTableMap
