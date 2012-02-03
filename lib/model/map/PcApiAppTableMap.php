<?php


/**
 * This class defines the structure of the 'pc_api_app' table.
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
class PcApiAppTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcApiAppTableMap';

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
		$this->setName('pc_api_app');
		$this->setPhpName('PcApiApp');
		$this->setClassname('PcApiApp');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'SMALLINT', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 64, null);
		$this->addColumn('API_KEY', 'ApiKey', 'VARCHAR', true, 40, null);
		$this->addColumn('API_SECRET', 'ApiSecret', 'VARCHAR', true, 16, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', false, null, null);
		$this->addColumn('IS_LIMITED', 'IsLimited', 'BOOLEAN', false, null, false);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 255, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('PcApiAppStats', 'PcApiAppStats', RelationMap::ONE_TO_MANY, array('id' => 'api_app_id', ), null, null);
    $this->addRelation('PcApiToken', 'PcApiToken', RelationMap::ONE_TO_MANY, array('id' => 'api_app_id', ), null, null);
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

} // PcApiAppTableMap
