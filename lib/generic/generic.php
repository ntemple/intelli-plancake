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
 * @param string $assetType
 * @param string $indexFilepath
 * @param boolean $addLeadingSlash (=false) add leading slash to all returned filenames
 * @param string &$firstOriginalInclusion
 * @return array of strings
 */
function getAssetsFilenamesFromIndexFile($assetType, $indexFileContent, $addLeadingSlash=false, &$firstOriginalInclusion=null)
{
    $assetTypeCapital = strtoupper($assetType);
    
    preg_match("/<!-- START: {$assetTypeCapital} -->(.*)<!-- END: {$assetTypeCapital} -->/msU", $indexFileContent, $matches);
    
    $linesString = $matches[1];
    
    $files = array();
   
    $inclusions = explode("\n", $linesString);
    
    foreach ($inclusions as $k => $line)
    {
        if (preg_match("/\"\/(.*\.{$assetType})\"/", $line, $matches))
        {
            $files[] = ($addLeadingSlash ? '/' : '') . $matches[1];
        }
        else
        {
            unset($inclusions[$k]);
        }
    }
    
    $firstOriginalInclusion = $inclusions[1]; // returned by reference

    return $files;    
}