<?php


/**
 * This class adds structure of 'pc_paypal_transaction' table to 'propel' DatabaseMap object.
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
class PcPaypalTransactionMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcPaypalTransactionMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcPaypalTransactionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcPaypalTransactionPeer::TABLE_NAME);
		$tMap->setPhpName('PcPaypalTransaction');
		$tMap->setClassname('PcPaypalTransaction');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('ITEM_NUMBER', 'ItemNumber', 'VARCHAR', true, 32);

		$tMap->addColumn('ITEM_NAME', 'ItemName', 'VARCHAR', false, 64);

		$tMap->addColumn('CUSTOM_FIELD', 'CustomField', 'VARCHAR', true, 127);

		$tMap->addColumn('PAYMENT_STATUS', 'PaymentStatus', 'VARCHAR', true, 32);

		$tMap->addColumn('PAYMENT_AMOUNT', 'PaymentAmount', 'VARCHAR', true, 16);

		$tMap->addColumn('PAYMENT_CURRENCY', 'PaymentCurrency', 'VARCHAR', true, 5);

		$tMap->addColumn('TRANSACTION_ID', 'TransactionId', 'VARCHAR', true, 64);

		$tMap->addColumn('PARENT_TRANSACTION_ID', 'ParentTransactionId', 'VARCHAR', false, 64);

		$tMap->addColumn('RECEIVER_EMAIL', 'ReceiverEmail', 'VARCHAR', true, 127);

		$tMap->addColumn('RESIDENCE_COUNTRY', 'ResidenceCountry', 'VARCHAR', false, 8);

		$tMap->addColumn('PAYER_EMAIL', 'PayerEmail', 'VARCHAR', true, 127);

		$tMap->addColumn('PAYMENT_DATE', 'PaymentDate', 'VARCHAR', true, 32);

		$tMap->addColumn('ERROR', 'Error', 'TINYINT', false, null);

		$tMap->addColumn('RAW_DATA', 'RawData', 'VARCHAR', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PcPaypalTransactionMapBuilder
