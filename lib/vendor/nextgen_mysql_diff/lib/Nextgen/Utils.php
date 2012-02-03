<?php

/***********************************************************************************
* NextGen MySQL Diff                                                              *
* Open-Source Project by Daniele Occhipinti (owner of plancake.com)               *
* =============================================================================== *
* Software by:                plancake.com team                                   *
* Copyright 2009-2010 by:     Daniele Occhipinti (owner of plancake.com)          *
* Support, News, Updates at:  http://projects.plancake.com/nextgen_mysql_diff.php *
***********************************************************************************
* This program is free software; you may redistribute it and/or modify it under   *
* the terms of the provided license as published by Daniele Occhipinti.           *
*                                                                                 *
* This program is distributed in the hope that it is and will be useful, but      *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY    *
* or FITNESS FOR A PARTICULAR PURPOSE.                                            *
*                                                                                 *
* See the "license.txt" file for details of the Plancake license.                 *
**********************************************************************************/

class Nextgen_Utils
{
    /*
     * @param mixed $element - the element to remove
     * @param array &$array
     */
    public static function removeElementFromArray($element, &$array)
    {
      foreach($array as $key => $value)
      {
        if ($array[$key] == $element)
        {
          unset($array[$key]);
        }
      }
    }

    /*
     * @param mixed $key - the key to remove
     * @param array &$array
     */
    public static function removeElementFromArrayByKey($key, &$array)
    {
      foreach($array as $k => $v)
      {
        if ($key == $k)
        {
          unset($array[$key]);
        }
      }
    }
}