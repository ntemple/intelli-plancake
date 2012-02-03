<?php


/**
 * This class defines the structure of the 'pc_repetition' table.
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
class PcRepetitionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcRepetitionTableMap';

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
		$this->setName('pc_repetition');
		$this->setPhpName('PcRepetition');
		$this->setClassname('PcRepetition');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'TINYINT', true, null, null);
		$this->addColumn('HUMAN_EXPRESSION', 'HumanExpression', 'VARCHAR', true, 63, null);
		$this->addColumn('COMPUTER_EXPRESSION', 'ComputerExpression', 'VARCHAR', true, 63, null);
		$this->addColumn('INITIAL_COMPUTER_EXPRESSION', 'InitialComputerExpression', 'VARCHAR', true, 63, null);
		$this->addColumn('SPECIAL', 'Special', 'VARCHAR', true, 16, null);
		$this->addColumn('NEEDS_PARAM', 'NeedsParam', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_PARAM_CARDINAL', 'IsParamCardinal', 'BOOLEAN', false, null, false);
		$this->addColumn('MIN_PARAM', 'MinParam', 'TINYINT', false, null, 0);
		$this->addColumn('MAX_PARAM', 'MaxParam', 'TINYINT', false, null, 0);
		$this->addColumn('SORT_ORDER', 'SortOrder', 'TINYINT', false, null, 0);
		$this->addColumn('HAS_DIVIDER_BELOW', 'HasDividerBelow', 'BOOLEAN', false, null, false);
		$this->addColumn('ICAL_RRULE', 'IcalRrule', 'VARCHAR', true, 63, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcTask', 'PcTask', RelationMap::ONE_TO_MANY, array('id' => 'repetition_id', ), null, null);
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

} // PcRepetitionTableMap
