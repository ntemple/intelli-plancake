<?php


/**
 * This class defines the structure of the 'pc_subscription' table.
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
class PcSubscriptionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcSubscriptionTableMap';

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
		$this->setName('pc_subscription');
		$this->setPhpName('PcSubscription');
		$this->setClassname('PcSubscription');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', true, null, null);
		$this->addForeignKey('SUBSCRIPTION_TYPE_ID', 'SubscriptionTypeId', 'TINYINT', 'pc_subscription_type', 'ID', true, null, null);
		$this->addColumn('WAS_GIFT', 'WasGift', 'BOOLEAN', true, null, false);
		$this->addColumn('WAS_AUTOMATIC', 'WasAutomatic', 'BOOLEAN', true, null, false);
		$this->addColumn('PAYPAL_TRANSACTION_ID', 'PaypalTransactionId', 'VARCHAR', true, 64, '');
		$this->addColumn('IS_REFUNDED_OR_REVERSED', 'IsRefundedOrReversed', 'BOOLEAN', true, null, false);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcSubscriptionType', 'PcSubscriptionType', RelationMap::MANY_TO_ONE, array('subscription_type_id' => 'id', ), null, null);
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
			'symfony_timestampable' => array('create_column' => 'created_at', ),
		);
	} // getBehaviors()

} // PcSubscriptionTableMap
