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

class Nextgen_Core_TableKey
{
    /*
     * @var string
     */
    private $name;

    /*
     * @var string
     */
    private $value;

    /*
     * @param string $name
     */
    public function __construct($name, $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    /*
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /*
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /*
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /*
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
