<?php


/**
 * This class defines the structure of the 'pc_string_category' table.
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
class PcStringCategoryTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcStringCategoryTableMap';

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
		$this->setName('pc_string_category');
		$this->setPhpName('PcStringCategory');
		$this->setClassname('PcStringCategory');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 64, null);
		$this->addColumn('NOTE', 'Note', 'VARCHAR', false, 128, null);
		$this->addColumn('LINK', 'Link', 'VARCHAR', false, 128, null);
		$this->addColumn('IN_ACCOUNT', 'InAccount', 'BOOLEAN', true, null, false);
		$this->addColumn('IN_MISC', 'InMisc', 'BOOLEAN', true, null, false);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'INTEGER', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcString', 'PcString', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), 'CASCADE', null);
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

} // PcStringCategoryTableMap
