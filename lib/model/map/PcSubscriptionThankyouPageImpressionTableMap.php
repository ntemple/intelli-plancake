<?php


/**
 * This class defines the structure of the 'pc_subscription_thankyou_page_impression' table.
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
class PcSubscriptionThankyouPageImpressionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcSubscriptionThankyouPageImpressionTableMap';

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
		$this->setName('pc_subscription_thankyou_page_impression');
		$this->setPhpName('PcSubscriptionThankyouPageImpression');
		$this->setClassname('PcSubscriptionThankyouPageImpression');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('USER_ID', 'UserId', 'INTEGER', false, null, null);
		$this->addColumn('USERNAME', 'Username', 'VARCHAR', true, 25, '');
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', true, 80, null);
		$this->addColumn('VIEWED_AT', 'ViewedAt', 'TIMESTAMP', true, null, null);
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
		);
	} // getBehaviors()

} // PcSubscriptionThankyouPageImpressionTableMap
