<?php


/**
 * This class defines the structure of the 'pc_bookkeeping_entry' table.
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
class PcBookkeepingEntryTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcBookkeepingEntryTableMap';

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
		$this->setName('pc_bookkeeping_entry');
		$this->setPhpName('PcBookkeepingEntry');
		$this->setClassname('PcBookkeepingEntry');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('TYPE_ID', 'TypeId', 'INTEGER', 'pc_bookkeeping_type', 'ID', true, null, null);
		$this->addForeignKey('CONTACT_ID', 'ContactId', 'INTEGER', 'pc_bookkeeping_contact', 'ID', false, null, null);
		$this->addColumn('AMOUNT', 'Amount', 'FLOAT', true, null, null);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', true, 255, null);
		$this->addColumn('DATE', 'Date', 'DATE', true, null, null);
		$this->addColumn('VAT', 'Vat', 'VARCHAR', false, 2, null);
		$this->addForeignKey('CATEGORY_ID', 'CategoryId', 'INTEGER', 'pc_bookkeeping_category', 'ID', true, null, null);
		$this->addForeignKey('PAYMENT_METHOD_ID', 'PaymentMethodId', 'INTEGER', 'pc_bookkeeping_payment_method', 'ID', true, null, null);
		$this->addColumn('REF_NUMBER', 'RefNumber', 'VARCHAR', false, 255, null);
		$this->addColumn('NEEDS_CLARIFICATION', 'NeedsClarification', 'BOOLEAN', true, null, false);
		$this->addColumn('QUESTION', 'Question', 'VARCHAR', false, 255, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcBookkeepingType', 'PcBookkeepingType', RelationMap::MANY_TO_ONE, array('type_id' => 'id', ), null, null);
    $this->addRelation('PcBookkeepingContact', 'PcBookkeepingContact', RelationMap::MANY_TO_ONE, array('contact_id' => 'id', ), null, null);
    $this->addRelation('PcBookkeepingCategory', 'PcBookkeepingCategory', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
    $this->addRelation('PcBookkeepingPaymentMethod', 'PcBookkeepingPaymentMethod', RelationMap::MANY_TO_ONE, array('payment_method_id' => 'id', ), null, null);
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

} // PcBookkeepingEntryTableMap
