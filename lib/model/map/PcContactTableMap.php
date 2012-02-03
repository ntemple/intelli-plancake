<?php


/**
 * This class defines the structure of the 'pc_contact' table.
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
class PcContactTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcContactTableMap';

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
		$this->setName('pc_contact');
		$this->setPhpName('PcContact');
		$this->setClassname('PcContact');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 255, null);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, null, null);
		$this->addColumn('POSITION', 'Position', 'VARCHAR', false, 32, null);
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 255, null);
		$this->addColumn('PHONE', 'Phone', 'VARCHAR', false, 32, null);
		$this->addColumn('WEBSITE', 'Website', 'VARCHAR', false, 255, null);
		$this->addColumn('LINK', 'Link', 'VARCHAR', false, 255, null);
		$this->addColumn('TWITTER', 'Twitter', 'VARCHAR', false, 64, null);
		$this->addColumn('LANGUAGE', 'Language', 'VARCHAR', true, 2, null);
		$this->addForeignKey('COMPANY_ID', 'CompanyId', 'INTEGER', 'pc_contact_company', 'ID', false, null, null);
		$this->addForeignKey('CREATOR_ID', 'CreatorId', 'INTEGER', 'pc_user', 'ID', true, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('creator_id' => 'id', ), null, null);
    $this->addRelation('PcContactCompany', 'PcContactCompany', RelationMap::MANY_TO_ONE, array('company_id' => 'id', ), null, null);
    $this->addRelation('PcContactsTags', 'PcContactsTags', RelationMap::ONE_TO_MANY, array('id' => 'contact_id', ), null, null);
    $this->addRelation('PcContactNote', 'PcContactNote', RelationMap::ONE_TO_MANY, array('id' => 'contact_id', ), null, null);
    $this->addRelation('PcReview', 'PcReview', RelationMap::ONE_TO_MANY, array('id' => 'contact_id', ), null, null);
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

} // PcContactTableMap
