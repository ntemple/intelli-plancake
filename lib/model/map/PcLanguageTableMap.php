<?php


/**
 * This class defines the structure of the 'pc_language' table.
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
class PcLanguageTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcLanguageTableMap';

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
		$this->setName('pc_language');
		$this->setPhpName('PcLanguage');
		$this->setClassname('PcLanguage');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'CHAR', true, 2, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 32, null);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'SMALLINT', false, null, 1);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcTranslation', 'PcTranslation', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), 'CASCADE', null);
    $this->addRelation('PcTranslator', 'PcTranslator', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), 'CASCADE', null);
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

} // PcLanguageTableMap
