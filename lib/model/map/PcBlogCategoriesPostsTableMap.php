<?php


/**
 * This class defines the structure of the 'pc_blog_categories_posts' table.
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
class PcBlogCategoriesPostsTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PcBlogCategoriesPostsTableMap';

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
		$this->setName('pc_blog_categories_posts');
		$this->setPhpName('PcBlogCategoriesPosts');
		$this->setClassname('PcBlogCategoriesPosts');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('POST_ID', 'PostId', 'INTEGER' , 'pc_blog_post', 'ID', true, null, null);
		$this->addForeignPrimaryKey('CATEGORY_ID', 'CategoryId', 'INTEGER' , 'pc_blog_category', 'ID', true, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('PcBlogPost', 'PcBlogPost', RelationMap::MANY_TO_ONE, array('post_id' => 'id', ), null, null);
    $this->addRelation('PcBlogCategory', 'PcBlogCategory', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
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

} // PcBlogCategoriesPostsTableMap
