<?php


/**
 * This class defines the structure of the 'pc_paypal_product' table.
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
class PcPaypalProductTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcPaypalProductTableMap';

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
		$this->setName('pc_paypal_product');
		$this->setPhpName('PcPaypalProduct');
		$this->setClassname('PcPaypalProduct');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('ITEM_NUMBER', 'ItemNumber', 'VARCHAR', true, 32, null);
		$this->addColumn('ITEM_NAME', 'ItemName', 'VARCHAR', true, 64, null);
		$this->addColumn('ITEM_PRICE', 'ItemPrice', 'VARCHAR', true, 16, null);
		$this->addColumn('ITEM_PRICE_CURRENCY', 'ItemPriceCurrency', 'VARCHAR', true, 5, null);
		$this->addColumn('DISCOUNT_PERCENTAGE', 'DiscountPercentage', 'INTEGER', false, null, null);
		$this->addForeignKey('SUBSCRIPTION_TYPE_ID', 'SubscriptionTypeId', 'TINYINT', 'pc_subscription_type', 'ID', true, null, null);
		$this->addColumn('PAYPAL_BUTTON_CODE', 'PaypalButtonCode', 'VARCHAR', true, 32, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcSubscriptionType', 'PcSubscriptionType', RelationMap::MANY_TO_ONE, array('subscription_type_id' => 'id', ), null, null);
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

} // PcPaypalProductTableMap
