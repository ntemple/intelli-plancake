<?php


/**
 * This class defines the structure of the 'pc_contacts_tags' table.
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
class PcContactsTagsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcContactsTagsTableMap';

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
		$this->setName('pc_contacts_tags');
		$this->setPhpName('PcContactsTags');
		$this->setClassname('PcContactsTags');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('CONTACT_ID', 'ContactId', 'INTEGER' , 'pc_contact', 'ID', true, null, null);
		$this->addForeignPrimaryKey('TAG_ID', 'TagId', 'INTEGER' , 'pc_contact_tag', 'ID', true, null, null);
		$this->addForeignKey('CREATOR_ID', 'CreatorId', 'INTEGER', 'pc_user', 'ID', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcContact', 'PcContact', RelationMap::MANY_TO_ONE, array('contact_id' => 'id', ), null, null);
    $this->addRelation('PcContactTag', 'PcContactTag', RelationMap::MANY_TO_ONE, array('tag_id' => 'id', ), null, null);
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('creator_id' => 'id', ), null, null);
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

} // PcContactsTagsTableMap
