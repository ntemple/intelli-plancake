<?php


/**
 * This class defines the structure of the 'pc_api_token' table.
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
class PcApiTokenTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcApiTokenTableMap';

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
		$this->setName('pc_api_token');
		$this->setPhpName('PcApiToken');
		$this->setClassname('PcApiToken');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('TOKEN', 'Token', 'VARCHAR', true, 41, null);
		$this->addForeignKey('API_APP_ID', 'ApiAppId', 'SMALLINT', 'pc_api_app', 'ID', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', false, null, null);
		$this->addColumn('EXPIRY_TIMESTAMP', 'ExpiryTimestamp', 'INTEGER', false, 11, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcApiApp', 'PcApiApp', RelationMap::MANY_TO_ONE, array('api_app_id' => 'id', ), null, null);
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
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

} // PcApiTokenTableMap
