<?php

/*************************************************************************************
* ===================================================================================*
* Software by: Danyuki Software Limited                                              *
* This file is part of Plancake.                                                     *
*                                                                                    *
* Copyright 2009-2010-2011-2012 by:     Danyuki Software Limited                          *
* Support, News, Updates at:  http://www.plancake.com                                *
* Licensed under the AGPL version 3 license.                                         *                                                       *
* Danyuki Software Limited is registered in England and Wales (Company No. 07554549) *
**************************************************************************************
* Plancake is distributed in the hope that it will be useful,                        *
* but WITHOUT ANY WARRANTY; without even the implied warranty of                     *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                      *
* GNU Affero General Public License for more details.                                *
*                                                                                    *
* You should have received a copy of the GNU Affero General Public License           *
* along with this program.  If not, see <http://www.gnu.org/licenses/>.              *
*                                                                                    *
**************************************************************************************/

/**
 * Packs a new release to make it ready to be downloaded by users
 *
 * @package    symfony
 * @subpackage task
 * @version    SVN: $Id: sfProjectDeployTask.class.php 10956 2008-08-19 15:20:48Z fabien $
 */
class sfMigrationTo190Task extends sfBaseMigrationTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    parent::configure();

    $this->aliases = array('migration-to-190');
    $this->name = 'migration-to-190';
    $this->briefDescription = 'Migration to 1.9.0';

    $this->detailedDescription = <<<EOF
Migration to 1.9.0.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function executeTask($env, $arguments = array(), $options = array())
  {
    $sql = "SELECT ft.id AS id,
                   ft.subject as title,
                   ft.posted as posted
            FROM forum_topics AS ft
            WHERE ft.forum_id=3
            ORDER BY ft.posted ASC";

    $connection = Propel::getConnection();
    $statement = $connection->prepare($sql);
    $statement->execute();
    while($resultset = $statement->fetch(PDO::FETCH_ASSOC))
    {
        $id = $resultset['id'];
        $title = $resultset['title'];


        $sql2 = "SELECT message AS description
                FROM forum_posts
                WHERE topic_id=$id
                ORDER BY posted DESC
                LIMIT 0,1";
        $connection2 = Propel::getConnection();
        $statement2 = $connection2->prepare($sql2);
        $statement2->execute();
        $resultset2 = $statement2->fetch(PDO::FETCH_ASSOC);
        $description = nl2br($resultset2['description']);

        $description = preg_replace('!\[url[^]]*\]([^\[]*)\[/url\]!', '<a href="\1">\1</a>', $description);

        $createdAt = date('Y-m-d H:i:s', $resultset['posted']);
        $forumUrl = "http://www.plancake.com/forums/topic/$id/" . PcUtils::slugify($title);
        
        $blogPost = new PcBlogPost();
        $blogPost->setTitle($title)
                 ->setContent($description)
                 ->setCreatedAt($createdAt)
                 ->setUserId(4)
                 ->setSlug(PcUtils::slugify($title))
                 ->setForumUrl($forumUrl)
                 ->save();

        $blogPostCategory = new PcBlogCategoriesPosts();
        $blogPostCategory->setPostId($blogPost->getId())
                         ->setCategoryId(1)
                         ->save();

        if (strpos($title, "Plancake will be down for scheduled maintenance of server") !== FALSE)
        {
            $blogPostCategory = new PcBlogCategoriesPosts();
            $blogPostCategory->setPostId($blogPost->getId())
                             ->setCategoryId(4)
                             ->save();
        }
    }

    echo "\nDone migration to 1.9.0 \n\n";
  }
}
