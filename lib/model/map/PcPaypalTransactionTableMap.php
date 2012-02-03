<?php


/**
 * This class defines the structure of the 'pc_paypal_transaction' table.
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
class PcPaypalTransactionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcPaypalTransactionTableMap';

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
		$this->setName('pc_paypal_transaction');
		$this->setPhpName('PcPaypalTransaction');
		$this->setClassname('PcPaypalTransaction');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('ITEM_NUMBER', 'ItemNumber', 'VARCHAR', true, 32, '');
		$this->addColumn('ITEM_NAME', 'ItemName', 'VARCHAR', false, 64, '');
		$this->addColumn('CUSTOM_FIELD', 'CustomField', 'VARCHAR', true, 127, '');
		$this->addColumn('PAYMENT_STATUS', 'PaymentStatus', 'VARCHAR', true, 32, '');
		$this->addColumn('PAYMENT_AMOUNT', 'PaymentAmount', 'VARCHAR', true, 16, '');
		$this->addColumn('PAYMENT_CURRENCY', 'PaymentCurrency', 'VARCHAR', true, 5, '');
		$this->addColumn('TRANSACTION_ID', 'TransactionId', 'VARCHAR', true, 64, '');
		$this->addColumn('PARENT_TRANSACTION_ID', 'ParentTransactionId', 'VARCHAR', false, 64, '');
		$this->addColumn('RECEIVER_EMAIL', 'ReceiverEmail', 'VARCHAR', true, 127, '');
		$this->addColumn('RESIDENCE_COUNTRY', 'ResidenceCountry', 'VARCHAR', false, 8, '');
		$this->addColumn('PAYER_EMAIL', 'PayerEmail', 'VARCHAR', true, 127, '');
		$this->addColumn('PAYMENT_DATE', 'PaymentDate', 'VARCHAR', true, 32, '');
		$this->addColumn('ERROR', 'Error', 'TINYINT', false, null, 0);
		$this->addColumn('RAW_DATA', 'RawData', 'VARCHAR', true, null, null);
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

} // PcPaypalTransactionTableMap
