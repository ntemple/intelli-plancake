<?php


/**
 * This class adds structure of 'pc_subscription' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PcSubscriptionMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcSubscriptionMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(PcSubscriptionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcSubscriptionPeer::TABLE_NAME);
		$tMap->setPhpName('PcSubscription');
		$tMap->setClassname('PcSubscription');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', true, null);

		$tMap->addForeignKey('SUBSCRIPTION_TYPE_ID', 'SubscriptionTypeId', 'TINYINT', 'pc_subscription_type', 'ID', true, null);

		$tMap->addColumn('WAS_GIFT', 'WasGift', 'BOOLEAN', true, null);

		$tMap->addColumn('WAS_AUTOMATIC', 'WasAutomatic', 'BOOLEAN', true, null);

		$tMap->addColumn('PAYPAL_TRANSACTION_ID', 'PaypalTransactionId', 'VARCHAR', true, 64);

		$tMap->addColumn('IS_REFUNDED_OR_REVERSED', 'IsRefundedOrReversed', 'BOOLEAN', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PcSubscriptionMapBuilder
