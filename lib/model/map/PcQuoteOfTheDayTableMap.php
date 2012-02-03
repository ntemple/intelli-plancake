<?php


/**
 * This class defines the structure of the 'pc_quote_of_the_day' table.
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
class PcQuoteOfTheDayTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcQuoteOfTheDayTableMap';

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
		$this->setName('pc_quote_of_the_day');
		$this->setPhpName('PcQuoteOfTheDay');
		$this->setClassname('PcQuoteOfTheDay');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('QUOTE', 'Quote', 'VARCHAR', true, 512, '');
		$this->addColumn('QUOTE_IN_ITALIAN', 'QuoteInItalian', 'VARCHAR', false, 512, '');
		$this->addColumn('QUOTE_AUTHOR', 'QuoteAuthor', 'VARCHAR', true, 64, '');
		$this->addColumn('QUOTE_AUTHOR_IN_ITALIAN', 'QuoteAuthorInItalian', 'VARCHAR', false, 64, '');
		$this->addColumn('IS_TIP', 'IsTip', 'BOOLEAN', false, null, false);
		$this->addColumn('SHOWN_ON', 'ShownOn', 'INTEGER', false, null, null);
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

} // PcQuoteOfTheDayTableMap
