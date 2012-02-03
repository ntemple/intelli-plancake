<?php


/**
 * This class adds structure of 'pc_paypal_product' table to 'propel' DatabaseMap object.
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
class PcPaypalProductMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcPaypalProductMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcPaypalProductPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcPaypalProductPeer::TABLE_NAME);
		$tMap->setPhpName('PcPaypalProduct');
		$tMap->setClassname('PcPaypalProduct');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('ITEM_NUMBER', 'ItemNumber', 'VARCHAR', true, 32);

		$tMap->addColumn('ITEM_NAME', 'ItemName', 'VARCHAR', true, 64);

		$tMap->addColumn('ITEM_PRICE', 'ItemPrice', 'VARCHAR', true, 16);

		$tMap->addColumn('ITEM_PRICE_CURRENCY', 'ItemPriceCurrency', 'VARCHAR', true, 5);

		$tMap->addForeignKey('SUBSCRIPTION_TYPE_ID', 'SubscriptionTypeId', 'TINYINT', 'pc_subscription_type', 'ID', true, null);

		$tMap->addColumn('PAYPAL_BUTTON_CODE', 'PaypalButtonCode', 'VARCHAR', true, 32);

	} // doBuild()

} // PcPaypalProductMapBuilder
