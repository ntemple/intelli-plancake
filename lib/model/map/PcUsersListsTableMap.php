<?php


/**
 * This class defines the structure of the 'pc_users_lists' table.
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
class PcUsersListsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcUsersListsTableMap';

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
		$this->setName('pc_users_lists');
		$this->setPhpName('PcUsersLists');
		$this->setClassname('PcUsersLists');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'pc_user', 'ID', true, null, null);
		$this->addForeignPrimaryKey('LIST_ID', 'ListId', 'INTEGER' , 'pc_list', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('PcList', 'PcList', RelationMap::MANY_TO_ONE, array('list_id' => 'id', ), null, null);
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

} // PcUsersListsTableMap
