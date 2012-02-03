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

class Nextgen_InputHandler_PropelSchema implements Nextgen_InputHandler_Interface
{
    private $resource;

    /*
     * @var Nextgen_Core_Configuration
     */
    private $config;

    /*
     * @var int
     */
    private static $inputNumber = 0;

    /*
     * @var array  contains the content of the resource
     */
    private $lines;

    /*
     * @var SimpleXMLElement 
     */
    private $XMLContent;

    /*
     * @var Nextgen_Logger_Interface
     */
    private $logger;

    public function __construct($resource, Nextgen_Core_Configuration $config)
    {
        $this->config = $config;
        $this->setInputResource($resource);

        $this->logger = $config->getLogger();
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
        self::$inputNumber++;
        $database = new Nextgen_Core_Database('input' . self::$inputNumber);
        $database->setTables($this->getTables());
        return $database;
    }

    /*
     * @returns array of Nextgen_Core_Table
     */
    private function getTables()
    {
      $tables = array();

      $createTableRegExp = '!^[ |\t]*CREATE TABLE `([^`]+)`$!';
      $tableFieldRegExp = '!^[ |\t]*`([^`]+)` (.+)(,)?$!';
      $primaryKeysRegExp = '!^[ |\t]*PRIMARY KEY \(([^)]+)\)(,)?$!';
      $databaseEngineRegExp = '!^\)Type=([^)]+);$!';
      $uniqueKeyRegExp = '!^[ |\t]*UNIQUE KEY `([^`]+)` \((.+)\).*(,)?$!';
      $keyRegExp = '!^[ |\t]*KEY `([^`]+)` *\((.+)\).*(,)?$!';
      $indexRegExp = '!^[ |\t]*INDEX `([^`]+)` \((.+)\).*(,)?$!';
      $constraintRegExp1 = '!^[ |\t]*CONSTRAINT (`([^`]+)`)(,)?$!';
      $constraintRegExp2 = '!^[ |\t]*(FOREIGN KEY \(`([^`]+)`\))(,)?$!';
      $constraintRegExp3 = '!^[ |\t]*(REFERENCES `([^)]+)` \(`([^`]+)`\))(,)?$!';
      $constraintRegExp4 = '!^[ |\t]*(ON .+)(,)?$!';

      $fileIterator = new Nextgen_Core_FileIterator($this->resource);

      $rawTableContentArray = array();

      foreach ($fileIterator as $line)
      {
        if (preg_match($createTableRegExp, $line, $matches))
        {
          // start of the table declaration
          $tableName = $matches[1];
          $table = new Nextgen_Core_Table($tableName);
          $rawTableContentArray = array();
          //$rawTableContentArray = array();
          $this->logger->insertBreak();
          $this->logger->log("Creating table --$tableName--");
        }
        else if (preg_match($tableFieldRegExp, $line, $matches))
        {
          // new table field
          $fieldName = $matches[1];
          $fieldContent = self::prepareLine($matches[2]);
          $tableField = new Nextgen_Core_TableField($fieldName);
          $tableField->setContent($fieldContent);
          $table->addField($tableField);
          $this->logger->log("Adding field --$fieldName-- (--$fieldContent--)");
        }
        else if (preg_match($primaryKeysRegExp, $line, $matches))
        {
          $primaryKeyContent = self::prepareLine($matches[1]);
          $primaryKey = new Nextgen_Core_TableKey('primary_key', $primaryKeyContent);
          $table->setPrimaryKey($primaryKey);
          $this->logger->log("Adding primary key --$primaryKeyContent--");
        }
        else if (preg_match($uniqueKeyRegExp, $line, $matches))
        {
          $uniqueKeyName = $matches[1];
          $uniqueKeyValue = $matches[2];
          $uniqueKey = new Nextgen_Core_TableKey($uniqueKeyName, $uniqueKeyValue);
          $table->addUniqueKey($uniqueKey);
          $this->logger->log("Adding unique key --$uniqueKeyName-- whose content is --$uniqueKeyValue--");
        }
        else if (preg_match($keyRegExp, $line, $matches))
        {
          $keyName = $matches[1];
          $keyValue = $matches[2];
          $key = new Nextgen_Core_TableKey($keyName, $keyValue);
          $table->addKey($key);
          $this->logger->log("Adding key --$keyName-- whose content is --$keyValue--");
        }
        else if (preg_match($indexRegExp, $line, $matches))
        {

          $indexName = $matches[1];
          $indexValue = $matches[2];
          $index = new Nextgen_Core_TableKey($indexName, $indexValue);
          $table->addIndex($index);
          $this->logger->log("Adding index --$indexName-- whose content is --$indexValue--");
        }
        else if (preg_match($constraintRegExp1, $line, $matches))
        {
          $constraintName = $matches[2];

          $constraintContent = $matches[1];

          $fileIterator->next();
          $line2 = $fileIterator->current();
          preg_match($constraintRegExp2, $line2, $matches);
          $constraintContent .= ' ' . $matches[1];
          $constraintForeignKey = $matches[2];
          $line .= "\n" . $line2;

          $fileIterator->next();
          $line3 = $fileIterator->current();
          preg_match($constraintRegExp3, $line3, $matches);
          $constraintContent .= ' ' . $matches[1];
          $constraintReferencedTable = $matches[2];
          $constraintReferencedField = $matches[3];
          $line .= "\n" . $line3;
          do
          {
              $foundExtraClause = false;
              $fileIterator->next();
              $line4 = $fileIterator->current();
              if(preg_match($constraintRegExp4, $line4, $matches))
              {
                  $constraintContent .= ' ' . $matches[1];
                  $line .= "\n" . $line4;
                  $foundExtraClause = true;
              }
              else
              {
                $fileIterator->previous();
              }
          } while($foundExtraClause);

          //$constraint = new Nextgen_Core_TableConstraint($constraintName, $constraintForeignKey, $constraintContent, $constraintReferencedTable, $constraintReferencedField);
          $constraint = new Nextgen_Core_TableKey($constraintName, $constraintContent);
          $table->addConstraint($constraint);
          
          $this->logger->log("Adding constraint --$constraintName-- whose foreign key is --$constraintForeignKey--
                  and referenced table is --$constraintReferencedTable--
                  and referenced field is --$constraintReferencedField--
                  and content is --$constraintContent--");
        }
        else if (preg_match($databaseEngineRegExp, $line, $matches))
        {
          // end of the table declaration
          $engine = $matches[1];
          $table->setEngine($engine);
          $rawTableContentArray[] = $line;
          $rawContent = implode("\n", $rawTableContentArray);
          $table->setContent($rawContent);
          $tables[] = $table;
          $this->logger->log("Setting engine --$engine--");
          $this->logger->log("Closing table");
        }

        $rawTableContentArray[] = $line;
      }
      return $tables;
    }

    private static function prepareLine($line)
    {
        $line = trim($line);
        // removing trailing comma, if any
        $trailingComma = (substr($line, -1) == ',');
        if ($trailingComma)
        {
          $line = substr($line, 0, -1);
        }
        return $line;
    }
}