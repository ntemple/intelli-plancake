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
?>

<div class="standardContent" id="articleSubmissionPage">
    <h2>Guest article submission</h2>

    <?php if($submitted): ?>
        <div class="pc_confirmationMessage">
            Thanks for submitting your article. We are going to review it soon and let you know.
        </div>
    <?php endif ?>

    <p>Thanks for considering writing an article for the Plancake Blog. <br />
    We are so looking forward to receiving your articles.</p>

    <p>
    Some important legal stuff:
    <ul>
        <li>the article you submit has to be original</li>
        <li>the article cannot be published anywhere else without our permission</li>
        <li>once published on the Plancake blog, the article is considered as property of Danyuki Software Limited (trading as Plancake)</li>
        <li>Plancake Terms and Conditions (in particular the paragraph about <em>User Contributions</em>) apply </li>
    </ul>
    </p>

    <p>
    How it works:
    <ul>
        <li>you can submit an article on one or more of these topics:
            <ul>
                <li>getting things done</li>
                <li>productivity</li>
                <li>organization</li>
                <li>put first things first (AKA: don't let urgent stuff get in the way of important stuff)</li>
                <li>relevant book review</li>
                <li>other very interesting topics covered in the <em>7 Habits</em> books</li>
            </ul>
        </li>
        <li>if we approve your article (based on its quality and relevance), that will be publish on the Plancake blog</li>
        <li>in order to be approved, the article shouldn't be a sale pitch but a very interesting piece of work
        that other users will be happy to read</li>
        <li>you can also send us a short bio with a link to your blog or company website (the article must not have any link)</li>
        <li>if we approve your article, you will win a one-year subscription to the Supporter Account (for you or a friend of yours)</li>
        <li>before you start to write, it would be a good idea to <a href="/contact?re=article">contact us</a> to tell us briefly what you would like to write about</li>
    </ul>
    </p>

      <p>
          <form enctype="multipart/form-data" action="<?php echo url_for('user/submitArticle') ?>" method="post" >
            <p>
              <table>
                <?php echo $form ?>
              </table>
            </p>

            <p>
            <input type="submit" name="upload" value="Submit" />
            </p>
          </form>
      </p>

</div>
