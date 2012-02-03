<?php


/**
 * This class defines the structure of the 'pc_translation' table.
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
class PcTranslationTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTranslationTableMap';

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
		$this->setName('pc_translation');
		$this->setPhpName('PcTranslation');
		$this->setClassname('PcTranslation');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('LANGUAGE_ID', 'LanguageId', 'CHAR' , 'pc_language', 'ID', true, 2, null);
		$this->addForeignPrimaryKey('STRING_ID', 'StringId', 'VARCHAR' , 'pc_string', 'ID', true, 64, null);
		$this->addColumn('STRING', 'String', 'VARCHAR', true, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcLanguage', 'PcLanguage', RelationMap::MANY_TO_ONE, array('language_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('PcString', 'PcString', RelationMap::MANY_TO_ONE, array('string_id' => 'id', ), 'CASCADE', null);
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
			'symfony_timestampable' => array('update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // PcTranslationTableMap
