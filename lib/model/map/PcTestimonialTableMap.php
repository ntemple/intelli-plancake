<?php


/**
 * This class defines the structure of the 'pc_testimonial' table.
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
class PcTestimonialTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcTestimonialTableMap';

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
		$this->setName('pc_testimonial');
		$this->setPhpName('PcTestimonial');
		$this->setClassname('PcTestimonial');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addPrimaryKey('USER_ID', 'UserId', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 256, null);
		$this->addColumn('JOB_POSITION', 'JobPosition', 'VARCHAR', true, 256, null);
		$this->addColumn('COMPANY', 'Company', 'VARCHAR', false, 256, null);
		$this->addColumn('CITY', 'City', 'VARCHAR', true, 256, null);
		$this->addColumn('COUNTRY', 'Country', 'VARCHAR', true, 256, null);
		$this->addColumn('COMMENT', 'Comment', 'VARCHAR', true, null, null);
		$this->addColumn('PHOTO_LINK', 'PhotoLink', 'VARCHAR', true, 256, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
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

} // PcTestimonialTableMap
