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

class Nextgen_Core_SimpleIterator implements Iterator
{
    protected $position = 0;
    protected $elements;

    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return $this->elements[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
        return $this->valid();
    }

    public function previous() {
        --$this->position;
    }

    public function valid() {
        return isset($this->elements[$this->position]);
    }
}
