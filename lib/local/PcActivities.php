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

class PcActivities
{
  const USER_REGISTRATION = 1;
  const FORUM_POST = 2;
  const NEW_LIST = 3;
  const NEW_TASK = 4;
  const TASK_DONE = 5;
  const SVN_COMMIT = 6;

  /*
   * Returns an array with the latest community activities on the site.
   * The activity can be one of these:
   * _ user registration
   * _ post in the forum
   * _ new list
   * _ new task
   *
   * @param int $numberOfActivities
   * @return array (keys: created_at (ie. 2010-02-21 22:59:50) and type)
   */
  public static function getLatestCommunityActivities($numberOfActivities)
  {
    $forumTablesPrefix = sfConfig::get('app_forum_tablePrefix');
    $connection = Propel::getConnection();

    $forumUnion = '';
    if(sfConfig::get('app_forum_enabled'))
    {
        $forumUnion = "
               UNION

              (SELECT FROM_UNIXTIME(fp.posted) AS created_at, " . self::FORUM_POST . " AS type
              FROM {$forumTablesPrefix}posts fp
              ORDER BY fp.posted DESC
              LIMIT 0,2)";
    }

    $query = "(SELECT pu.created_at AS created_at, " . self::USER_REGISTRATION . " AS type
              FROM pc_user pu
              ORDER BY pu.created_at DESC
              LIMIT 0,2)

              UNION

              (SELECT pl.created_at AS created_at, " . self::NEW_LIST . " AS type
              FROM pc_list pl
              ORDER BY pl.created_at DESC
              LIMIT 0,2)

              UNION

              (SELECT pt.created_at AS created_at, " . self::NEW_TASK . " AS type
              FROM pc_task pt
              ORDER BY pt.created_at DESC
              LIMIT 0,2)

              UNION

              (SELECT pt.completed_at AS created_at, " . self::TASK_DONE . " AS type
              FROM pc_task pt
              ORDER BY pt.completed_at DESC
              LIMIT 0,2)

              $forumUnion

              ORDER BY created_at DESC
              LIMIT " . (int)$numberOfActivities;

    $statement = $connection->prepare($query);
    $statement->execute();
    $resultset = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $resultset;
  }

  /*
   * Returns an array with the latest development activity details.
   * The activity can be one of these:
   * _ SVN commit
   *
   * N.B.: it works with a work-around because we have some problems
   * to run SVN command as the Apache user.
   * The original, well-done code is commented
   *
   * @return array (keys: created_at as a unix_timestamp and type)
   */
  public static function getLatestDevelopmentActivity()
  {
/*
    $svnRepositoryUrl = sfConfig::get('app_site_svnRepositoryUrl');
    $timestamp = 0;

    if ($svnRepositoryUrl)
    {
        if (sfConfig::get('app_site_svnInstalledOnTheServer'))
        {
            $filesystem = new sfFilesystem();
            $command = "svn info $svnRepositoryUrl | grep 'Last Changed Date:'";
            $svnLatestCommitLine = $filesystem->sh($command);
            // that variable will be something like this:
            // Last Changed Date: 2010-02-21 16:29:01 +0000 (Sun, 21 Feb 2010)
            $regExp = '!Last Changed Date: (\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}).*!';
            preg_match($regExp, $svnLatestCommitLine, $matches);

            $svnLatestCommitLine = $matches[1];
            // that variable will be something like this:
            // 2010-02-21 16:29:01

            $timestamp = strtotime($svnLatestCommitLine);
        }
    }
*/

    $filePaths = glob('/var/svn/plancake_*/db');
    $maxMtime = 0;
    foreach($filePaths as $filepath)
    {
        $stats = stat($filepath);
        $mtime = $stats['mtime'];
        if ($mtime > $maxMtime)
        {
            $maxMtime = $mtime;
        }
    }

    $timestamp = $maxMtime;

    return array('created_at' => $timestamp, 'type' => self::SVN_COMMIT);
  }
}
