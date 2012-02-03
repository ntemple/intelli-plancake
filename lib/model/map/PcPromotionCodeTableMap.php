<?php


/**
 * This class defines the structure of the 'pc_promotion_code' table.
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
class PcPromotionCodeTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcPromotionCodeTableMap';

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
		$this->setName('pc_promotion_code');
		$this->setPhpName('PcPromotionCode');
		$this->setClassname('PcPromotionCode');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('CODE', 'Code', 'VARCHAR', true, 25, '');
		$this->addColumn('DISCOUNT_PERCENTAGE', 'DiscountPercentage', 'INTEGER', true, 2, null);
		$this->addColumn('EXPIRY_DATE', 'ExpiryDate', 'DATE', true, null, null);
		$this->addColumn('ONLY_FOR_NEW_CUSTOMERS', 'OnlyForNewCustomers', 'BOOLEAN', true, null, false);
		$this->addColumn('USES_COUNT', 'UsesCount', 'INTEGER', true, null, 0);
		$this->addColumn('MAX_USES', 'MaxUses', 'INTEGER', true, null, null);
		$this->addColumn('NOTE', 'Note', 'VARCHAR', false, 512, '');
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
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
			'symfony_timestampable' => array('create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // PcPromotionCodeTableMap
