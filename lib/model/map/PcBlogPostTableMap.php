<?php


/**
 * This class defines the structure of the 'pc_blog_post' table.
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
class PcBlogPostTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcBlogPostTableMap';

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
		$this->setName('pc_blog_post');
		$this->setPhpName('PcBlogPost');
		$this->setClassname('PcBlogPost');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'pc_user', 'ID', true, null, null);
		$this->addColumn('TITLE', 'Title', 'VARCHAR', true, 255, null);
		$this->addColumn('SLUG', 'Slug', 'VARCHAR', true, 255, null);
		$this->addColumn('CONTENT', 'Content', 'VARCHAR', false, null, null);
		$this->addColumn('ITALIAN_URL', 'ItalianUrl', 'VARCHAR', false, null, null);
		$this->addColumn('IS_REVIEWED', 'IsReviewed', 'BOOLEAN', false, null, false);
		$this->addColumn('IS_PUBLISHED', 'IsPublished', 'BOOLEAN', false, null, false);
		$this->addColumn('PUBLISHED_AT', 'PublishedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcUser', 'PcUser', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    $this->addRelation('PcBlogCategoriesPosts', 'PcBlogCategoriesPosts', RelationMap::ONE_TO_MANY, array('id' => 'post_id', ), null, null);
    $this->addRelation('PcBlogComment', 'PcBlogComment', RelationMap::ONE_TO_MANY, array('id' => 'post_id', ), null, null);
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

} // PcBlogPostTableMap
