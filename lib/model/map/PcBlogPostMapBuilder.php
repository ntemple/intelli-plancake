<?php


/**
 * This class adds structure of 'pc_blog_post' table to 'propel' DatabaseMap object.
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
class PcBlogPostMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcBlogPostMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(PcBlogPostPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcBlogPostPeer::TABLE_NAME);
		$tMap->setPhpName('PcBlogPost');
		$tMap->setClassname('PcBlogPost');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', true, null);

		$tMap->addColumn('TITLE', 'Title', 'VARCHAR', true, 255);

		$tMap->addColumn('SLUG', 'Slug', 'VARCHAR', true, 255);

		$tMap->addColumn('CONTENT', 'Content', 'VARCHAR', false, null);

		$tMap->addColumn('FORUMURL', 'Forumurl', 'VARCHAR', true, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // PcBlogPostMapBuilder
