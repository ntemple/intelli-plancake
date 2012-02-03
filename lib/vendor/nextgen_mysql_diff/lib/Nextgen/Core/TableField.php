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

class Nextgen_Core_TableField
{
    /*
     * @var string
     */
    private $name;

    /*
     * @var string
     */
    private $type;

    /*
     * @var bool
     */
    private $isNull;

    /*
     * @var string
     */
    private $default;

    /*
     * @var bool
     */
    private $isAutoIncrement;

    /*
     * The whole content of the field, as it is parsed from the input resource
     *
     * @var string
     */
    private $content;

    /*
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /*
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /*
     * Returns the whole field (without the field name)
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /*
     * Sets the whole field (without the field name)
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /*
     * Either sets or returns the $isNull property
     *
     * @param bool $isNull (=null)
     */
    public function isNull($isNull = null)
    {
        if (! $isNull)
        {
            return $this->isNull;
        }
        $this->isNull = $isNull;
    }

    /*
     * Either sets or returns the $isAutoIncrement property
     *
     * @param bool $isAutoIncrement (=null)
     */
    public function isAutoIncrement($isAutoIncrement)
    {
        if (! $isAutoIncrement)
        {
            return $this->isAutoIncrement;
        }
        $this->isAutoIncrement = $isAutoIncrement;
    }

    /*
     * @param string
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
