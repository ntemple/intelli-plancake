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

class Nextgen_Core_TablesComparator extends Nextgen_Core_DatabaseComparator
{
    /*
     * @param Nextgen_Core_Configuration $config
     * @param Nextgen_Core_Database $db1
     * @param Nextgen_Core_Database $db2
     */
    public function __construct($config, $db1, $db2)
    {
        parent::__construct($config, $db1, $db2);
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    public function getTransformations()
    {
        $changedTables = $this->getChangedTables();

        $transformations = array();

        foreach ($changedTables as $changedTable)
        {
            $tableComparator = new Nextgen_Core_TableComparator($this->config, $this->db1, $this->db2, $changedTable);
            $tableTransformation = $tableComparator->getTransformations();
            $transformations = array_merge($transformations, $tableTransformation);
        }

        return $transformations;
    }

    /*
     * @return array of string
     */
    private function getChangedTables()
    {
        $tablesFromDb1 = $this->db1->getTables();
        $tablesFromDb2 = $this->db2->getTables();

        $tablesFromDb1Hash = array();
        foreach ($tablesFromDb1 as $table)
        {
            $hash = md5($table->getContent());
            $tablesFromDb1Hash[$hash] = $table->getName();
        }

        $tablesFromDb2Hash = array();
        foreach ($tablesFromDb2 as $table)
        {
            $hash = md5($table->getContent());
            $tablesFromDb2Hash[$hash] = $table->getName();
        }

        $tablesFromDb2Hash = array_intersect($tablesFromDb2Hash, $tablesFromDb1Hash);
        $tablesFromDb1Hash = array_intersect($tablesFromDb1Hash, $tablesFromDb2Hash);

        $tablesFromDb1Hash = array_flip($tablesFromDb1Hash);
        $tablesFromDb2Hash = array_flip($tablesFromDb2Hash);

        $changedTables = array_keys(array_diff($tablesFromDb1Hash, $tablesFromDb2Hash));

        return $changedTables;
    }
}