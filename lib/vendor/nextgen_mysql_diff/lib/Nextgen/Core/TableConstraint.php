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

class Nextgen_Core_TableConstraint
{
    /*
     * @var string
     */
    private $name;

    /*
     * @var string
     */
    private $foreignKey;

    /*
     * The whole content of the field, as it is parsed from the input resource
     *
     * @var string
     */
    private $content;

    /*
     * @var string
     */
    private $referencedTable;

    /*
     * @var string
     */
    private $referencedField;

    /*
     * @param string $name
     * @param string $content
     * @param string $foreignKey
     */
    public function __construct($name, $foreignKey, $content, $referencedTable, $referencedField)
    {
        $this->name = $name;
        $this->content = $content;
        $this->foreignKey = $foreignKey;
        $this->referenceTable = $referenceTable;
        $this->referencedField = $referencedField;
    }

    public function getName()
    {
        return $this->name;
    }

    /*
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /*
     * @return string
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /*
     * @return string
     */
    public function getRefencedTable()
    {
        return $this->referencedTable;
    }

    /*
     * @return string
     */
    public function getReferencedField()
    {
        return $this->referencedField;
    }
}
