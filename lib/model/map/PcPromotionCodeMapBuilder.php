<?php


/**
 * This class adds structure of 'pc_promotion_code' table to 'propel' DatabaseMap object.
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
class PcPromotionCodeMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcPromotionCodeMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcPromotionCodePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcPromotionCodePeer::TABLE_NAME);
		$tMap->setPhpName('PcPromotionCode');
		$tMap->setClassname('PcPromotionCode');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'VARCHAR', true, 10);

		$tMap->addColumn('DISCOUNT_PERCENTAGE', 'DiscountPercentage', 'INTEGER', true, 2);

		$tMap->addColumn('EXPIRY_DATE', 'ExpiryDate', 'TIMESTAMP', true, null);

		$tMap->addColumn('PAYPAL_BUTTON_CODE', 'PaypalButtonCode', 'VARCHAR', true, 16);

	} // doBuild()

} // PcPromotionCodeMapBuilder
