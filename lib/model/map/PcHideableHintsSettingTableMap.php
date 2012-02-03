<?php


/**
 * This class defines the structure of the 'pc_hideable_hints_setting' table.
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
class PcHideableHintsSettingTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcHideableHintsSettingTableMap';

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
		$this->setName('pc_hideable_hints_setting');
		$this->setPhpName('PcHideableHintsSetting');
		$this->setClassname('PcHideableHintsSetting');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ID', 'Id', 'INTEGER' , 'pc_user', 'ID', true, null, null);
		$this->addColumn('INBOX', 'Inbox', 'BOOLEAN', true, null, false);
		$this->addColumn('TODO', 'Todo', 'BOOLEAN', true, null, false);
		$this->addColumn('COMPLETED', 'Completed', 'BOOLEAN', true, null, false);
		$this->addColumn('QUOTE', 'Quote', 'BOOLEAN', true, null, false);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('id' => 'id', ), null, null);
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

} // PcHideableHintsSettingTableMap
