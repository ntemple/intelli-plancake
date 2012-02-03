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

class Nextgen_Core_Database
{
    /*
     * @var array of Nextgen_Core_Table
     */
    private $tables;

    /*
     * @var string
     */
    private $name;

    /*
     * @param string $name
     * @param array $tables(=null) - of Nextgen_Core_Table
     */
    public function __construct($name, $tables=null)
    {
        $this->setName($name);
        if ($tables)
        {
            $this->setTables($tables);
        }
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
     * @param array $tables (of Nextgen_Core_Table)
     */
    public function setTables($tables)
    {
        foreach($tables as $table)
        {
            $this->addTable($table);
        }
    }

    /*
     * @param Nextgen_Core_Table $table
     */
    public function addTable(Nextgen_Core_Table $table)
    {
        $this->tables[$table->getName()] = $table;
    }

    /*
     * @return array (of Nextgen_Core_Table)
     */
    public function getTables()
    {
        return $this->tables;
    }

    /*
     * @param string $tableName
     * @return Nextgen_Core_Table
     */
    public function getTable($tableName)
    {
        return $this->tables[$tableName];
    }

    /*
     * @param string $oldTableName
     * @param string $newTableName
     */
    public function renameTable($oldTableName, $newTableName)
    {
        $this->getTable($oldTableName)->setName($newTableName);

        // changing the key in the internal variable:
        // removing the element and inserting it back with a new key
        $tempTable = $this->getTable($oldTableName);
        Nextgen_Utils::removeElementFromArray($tempTable, $this->tables);
        $this->tables[$newTableName] = $tempTable;
    }

    /*
     * @return array of string
     */
    public function getTablesNames()
    {
        $tablesName = array();

        foreach($this->tables as $table)
        {
            $tablesName[] = $table->getName();
        }

        return $tablesName;
    }

    public function __clone()
    {
        foreach ($this as $key => $val) {
            if (is_object($val) || (is_array($val))) {
                $this->{$key} = unserialize(serialize($val));
            }
        }
    }
}