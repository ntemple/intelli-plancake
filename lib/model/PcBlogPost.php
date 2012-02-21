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

class PcBlogPost extends BasePcBlogPost
{
    public function getCategories()
    {
        $postsCategoriesEntries = $this->getPcBlogCategoriesPostss();

        $categories = array();

        foreach ($postsCategoriesEntries as $postsCategoriesEntry)
        {
            $categories[] = $postsCategoriesEntry->getPcBlogCategory();
        }

        return $categories;
    }
    
    public function getCategoriesIds()
    {
        $categories = $this->getCategories();

        $categoriesIds = array();

        foreach ($categories as $category)
        {
            $categoriesIds[] = $category->getId();
        }

        return $categoriesIds;
    }    

    public function getYear()
    {
        return $this->getCreatedAt('Y');
    }
    
    public function getMonth()
    {
        return $this->getCreatedAt('m');
    }    
        
    public function getDay()
    {
        return $this->getCreatedAt('d');
    }

    public function getComments()
    {
        $c = new Criteria();
        $c->add(PcBlogCommentPeer::POST_ID, $this->getId());
        $c->addAscendingOrderByColumn(PcBlogCommentPeer::CREATED_AT);
        return PcBlogCommentPeer::doSelect($c);
    }
    
    public function save(PropelPDO $con = null)
    {
        if (! $this->getSlug())
        {
            $this->setSlug(PcUtils::slugifyWithUniqueness($this->getTitle(), PcBlogPostPeer::SLUG));
        }
        
        // check whether the Italian URL has got a leading 'http://'
        $italianUrl = $this->getItalianUrl();
        if ($italianUrl && (strpos($italianUrl, 'http:') === FALSE)) {
            $italianUrl = 'http://' . $italianUrl;
            $this->setItalianUrl($italianUrl);
        }
        
        parent::save($con);
    }   
}
