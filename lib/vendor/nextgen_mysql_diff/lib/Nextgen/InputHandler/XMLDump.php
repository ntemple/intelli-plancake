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

class Nextgen_InputHandler_XMLDump implements Nextgen_InputHandler_Interface
{
    private $resource;

    /*
     * @var Nextgen_Core_Configuration
     */
    private $config;

    /*
     * @var SimpleXMLElement 
     */
    private $XMLContent;

    public function __construct($resource, Nextgen_Core_Configuration $config)
    {
        throw new Exception('The XMLDump InputHandler has been discontinued.');

        $this->config = $config;
        $this->setInputResource($resource);

        $this->XMLContent = new SimpleXMLElement(file_get_contents($resource));
        if (! $this->XMLContent)
        {
            throw new Exception("Couldn't parse the file $resource");
        }
    }

    /*
     * @param string $resource - the absolute path for the input file
     */
    public function setInputResource($resource)
    {
        if (!is_file($resource))
        {
            throw new Exception("Couldn't open the file $resource");
        }

        $this->resource = $resource;
    }

    /*
     * @returns Nextgen_Core_Database
     */
    public function getDatabase()
    {
        $databaseName = $this->XMLContent->database['name'];
        return new Nextgen_Core_Database($databaseName);
    }

    /*
     * @returns array of Nextgen_Core_Table
     */
    public function getTables()
    {
        $tables = array();

        foreach($this->XMLContent->database->children() as $t)
        {
            $table = new Nextgen_Core_Table($t['name']);

            foreach($t->children() as $tp)
            {
                $typeOfProperty = $tp->getName();

                switch($typeOfProperty)
                {
                    case 'field':
                        $tableField = new Nextgen_Core_TableField($tp['Field']);

                        $tableField->setType($tp['Type']);

                        $tableField->isNull($tp['Null'] == 'YES');

                        $tableField->setDefault($tp['Default']);

                        $tableField->isAutoIncrement($tp['Extra'] == 'auto_increment');

                        $table->addField($tableField);
                        break;

                    case 'key':
                        break;

                    case 'options':
                        $table->setEngine($tp['Engine']);
                        $table->setCollation($tp['Collation']);
                        break;
                }

                /*
                if ($tp->field)
                {
                    echo "\nOK\n";
                }
                else
                {
                    echo "\nNO\n";
                }
                 */
            }


            $tables[] = $table;
        }
    }

}