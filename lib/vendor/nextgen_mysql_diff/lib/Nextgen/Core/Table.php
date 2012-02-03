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

class Nextgen_Core_Table
{
    /*
     * @var array of Nextgen_Core_TableField
     */
    private $fields;

    /*
     * @var string
     */
    private $name;

    /*
     * @var string
     */
    private $engine;

    /*
     * @var string
     */
    private $collation;

    /*
     * @var Nextgen_Core_TableKey
     */
    private $primaryKey;

    /*
     * @var array (of Nextgen_Core_TableKey)
     */
    private $uniqueKeys;

    /*
     * @var array (of Nextgen_Core_TableKey)
     */
    private $keys;

    /*
     * @var array (of Nextgen_Core_TableKey)
     */
    private $indexes;

    /*
     * @var array (of Nextgen_Core_TableKey)
     */
    private $constraints;

    /*
     * @var string
     */
    private $content;

    /*
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->primaryKey = null;
        $this->uniqueKeys = array();
        $this->keys = array();
        $this->indexes = array();
        $this->constraints = array();
    }

    public function getName()
    {
        return $this->name;
    }

    /*
     * @param string $name
     */
    public function setName($name)
    {
        if ($this->name != $name)  // we are changing the name
        {
            if ($content = $this->getContent())
            {
                $newContent = str_replace("`{$this->name}`", "`$name`", $content);
                $this->setContent($newContent);
            }
        }

        $this->name = $name;
    }

    /*
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /*
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /*
     * @param Nextgen_Core_TableKey $primaryKey
     */
    public function setPrimaryKey(Nextgen_Core_TableKey $primaryKey)
    {
      $this->primaryKey = $primaryKey;
    }

    /*
     * @return Nextgen_Core_TableKey
     */
    public function getPrimaryKey()
    {
      return $this->primaryKey;
    }

    /*
     * @param Nextgen_Core_TableField $tableField
     */
    public function addField(Nextgen_Core_TableField $tableField)
    {
        $fieldName = $tableField->getName();
        $this->fields[$fieldName] = $tableField;
    }

    public function getEngine()
    {
        return $this->engine;
    }

    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    public function getCollation()
    {
        return $this->collation;
    }

    public function setCollation($collation)
    {
        $this->collation = $collation;
    }

    public function addUniqueKey(Nextgen_Core_TableKey $uniqueKey)
    {
        $uniqueKeyName = $uniqueKey->getName();
        $this->uniqueKeys[$uniqueKeyName] = $uniqueKey;
    }

    public function addKey(Nextgen_Core_TableKey $key)
    {
        $keyName = $key->getName();
        $this->keys[$keyName] = $key;
    }

    public function addIndex(Nextgen_Core_TableKey $index)
    {
        $indexName = $index->getName();
        $this->indexes[$indexName] = $index;
    }

    public function addConstraint(Nextgen_Core_TableKey $constraint)
    {
        $constraintName = $constraint->getName();
        $this->constraints[$constraintName] = $constraint;
    }

    /*
     * @param string $name
     * @return Nextgen_Core_Key
     */
    public function getUniqueKey($name)
    {
      return array_key_exists($name, $this->uniqueKeys) ? $this->uniqueKeys[$name] : NULL;
    }

    /*
     * @param string $name
     * @return Nextgen_Core_Key
     */
    public function getKey($name)
    {
      return array_key_exists($name, $this->keys) ? $this->keys[$name] : NULL;
    }

    /*
     * @param string $name
     * @return Nextgen_Core_Key
     */
    public function getIndex($name)
    {
      return array_key_exists($name, $this->indexes) ? $this->indexes[$name] : NULL;
    }

    /*
     * @param string $name
     * @return Nextgen_Core_Key
     */
    public function getConstraint($name)
    {
      return array_key_exists($name, $this->constraints) ? $this->constraints[$name] : NULL;
    }

    /*
     * @return array (of Nextgen_Core_TableKey)
     */
    public function getUniqueKeys()
    {
        return $this->uniqueKeys;
    }

    /*
     * @return array (of Nextgen_Core_TableKey)
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /*
     * @return array (of Nextgen_Core_TableKey)
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /*
     * @return array (of Nextgen_Core_TableConstraint)
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /*
     * @return integer - the total number of fields
     */
    public function getFieldsCount()
    {
        return count($this->fields);
    }

    /*
     * @return array of string
     */
    public function getFieldsNames()
    {
        $fieldsName = array();
        foreach($this->fields as $field)
        {
            $fieldsName[] = $field->getName();
        }
        return $fieldsName;
    }

    /*
     * @param Nextgen_Core_Table $otherTable - the table to score against
     * @return int (from 0 to 100) - 100 if all the fields names are the same
     */
    public function getSimilarityScore(Nextgen_Core_Table $otherTable)
    {
        $totalNumberOfFields = $this->getFieldsCount() + $otherTable->getFieldsCount();

        $fieldsNames = $this->getFieldsNames();
        $otherFieldsNames = $otherTable->getFieldsNames();

        $intersectionCount = count(array_intersect($fieldsNames, $otherFieldsNames));

        return ($intersectionCount/$totalNumberOfFields)* 2 * 100;
    }

    /*
     * @param string $fieldName
     * @return Nextgen_Core_TableField
     */
    public function getField($fieldName)
    {
        return $this->fields[$fieldName];
    }

    /*
     * @return array of Nextgen_Core_TableField
     */
    public function getFields()
    {
        return $this->fields;
    }

    /*
     * @return boolean
     */
    public function hasField($fieldName)
    {
        return array_key_exists($fieldName, $this->fields);
    }

    /*
     * @param string $oldFieldName
     * @param string $newFieldName
     */
    public function renameTable($oldFieldName, $newFieldName)
    {
        $this->getField($oldFieldName)->setName($newFieldName);

        // changing the key in the internal variable:
        // removing the element and inserting it back with a new key
        $tempField = $this->getField($oldFieldName);
        Nextgen_Utils::removeElementFromArray($tempField, $this->fields);
        $this->fields[$newFieldName] = $tempField;
    }

    /*
     * @param string $fieldName
     * @return string
     */
    public function getAfterStatementForField($fieldName)
    {
        $ret = '';

        if($precedingField = $this->getPrecedingField($fieldName))
        {
            $ret = "AFTER `{$precedingField->getName()}`";
        }

        return $ret;
    }

    /*
     * @param string $fieldName
     * @return Nextgen_Core_TableField|NULL - null if the element is the first of the table
     */
    public function getPrecedingField($fieldName)
    {
        $position = 0;

        foreach ($this->getFields() as $field)
        {
            if ($field->getName() == $fieldName)
            {
                break;
            }
            $position++;
        }

        if (! $position)
        {
            return NULL;
        }
        else
        {
            $fieldsWithAutoIncrementKey = array_values($this->getFields());
            return $fieldsWithAutoIncrementKey[$position-1];
        }
    }

    /*
     * Returns a modified version of the table, where only the fields
     * existing also in $t are kept
     *
     * @param Nextgen_Core_Table $t - another table
     * @return Nextgen_Core_Table
     */
    public function getIntersectedVersion(Nextgen_Core_Table $t)
    {
      $intersectedTable = clone $this;

      $theseFields = $intersectedTable->getFieldsNames();
      $otherFields = $t->getFieldsNames();

      $extraFields = array_diff($theseFields, $otherFields);

      foreach ($extraFields as $extraField)
      {
        $intersectedTable->removeField($extraField);
      }

      return $intersectedTable;
    }

    /*
     * @param string $fieldName
     */
    public function removeField($fieldName)
    {
      Nextgen_Utils::removeElementFromArrayByKey($fieldName, $this->fields);
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