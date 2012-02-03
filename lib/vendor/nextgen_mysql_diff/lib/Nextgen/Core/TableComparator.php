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

class Nextgen_Core_TableComparator extends Nextgen_Core_DatabaseComparator
{
    /*
     * @var string
     */
    private $tableName;

    /*
     * @param Nextgen_Core_Configuration $config
     * @param Nextgen_Core_Database $db1
     * @param Nextgen_Core_Database $db2
     * @param string $tableName
     */
    public function __construct($config, $db1, $db2, $tableName)
    {
        parent::__construct($config, $db1, $db2);
        $this->tableName = $tableName;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    public function getTransformations()
    {
        $transformations1 = $this->compareFields();
        $transformations2 = $this->comparePrimaryKeys();
        $transformations3 = $this->compareKeys();
        $transformations4 = $this->compareUniqueKeys();
        $transformations5 = $this->compareIndexes();
        $transformations6 = $this->compareConstraints();

        $transformations = array_merge($transformations1,
                                       $transformations2,
                                       $transformations3,
                                       $transformations4,
                                       $transformations5,
                                       $transformations6);

        return $transformations;
    }

    /*
     * @return array
     */
    protected function getPotentialNewFields()
    {
        $fieldsFromDb1 = $this->db1->getTable($this->tableName)->getFieldsNames();
        $fieldsFromDb2 = $this->db2->getTable($this->tableName)->getFieldsNames();
        return array_diff($fieldsFromDb2, $fieldsFromDb1);
    }

    /*
     * @return array
     */
    protected function getPotentialDeletedFields()
    {
        $fieldsFromDb1 = $this->db1->getTable($this->tableName)->getFieldsNames();
        $fieldsFromDb2 = $this->db2->getTable($this->tableName)->getFieldsNames();
        return array_diff($fieldsFromDb1, $fieldsFromDb2);
    }

    /*
     * @param array $potentialNewFields (array of strings)
     * @param array $potentialDeletedFields (array of strings)
     * @return array the keys are the old names, the value are the corresponding new names
     */
    protected function getRenamedFieldsMapping(array $potentialNewFields, array $potentialDeletedFields)
    {
      $renamedFieldsMapping = array();

      if (count($potentialNewFields) && count($potentialDeletedFields))
      {
        $deletedFields = $potentialDeletedFields;

        foreach($potentialNewFields as $potentialNewField)
        {
          if (!count($potentialDeletedFields))
          {
            break;
          }

          // array_values is to reset the keys
          $potentialRenamedFields = array_values($potentialDeletedFields);

          $questionChoices = array_merge(array('none of them'), $potentialRenamedFields); // @201004142017

          $question = "Please make your choice for answering this question \n";
          $question .= "Is {$this->tableName}.$potentialNewField a renamed version of:";
          $answer = Nextgen_Core_UserInteraction::askQuestionWithChoices($question, $questionChoices);

          // -1 because of the line @201004142017
          if (array_key_exists($answer-1, $potentialRenamedFields))
          {
            $renamedFieldsMapping[$potentialRenamedFields[$answer-1]] = $potentialNewField;
            Nextgen_Utils::removeElementFromArray($potentialRenamedFields[$answer-1], $potentialDeletedFields);
          }
        }
      }

      return $renamedFieldsMapping;
    }

    /*
     * Returns an array:
     * _ the first item will be an array containing all the fields really created (their names)
     * _ the second item will be an array containing all the fields really deleted  (their names)
     *
     * @param array $renamedFieldsMapping
     * @param array $potentialNewFields
     * @param array $potentialDeletedFields
     * @return array
     */
    protected function changeEntitiesBecauseOfRenamedFields(array $renamedFieldsMapping, array $potentialNewFields, array $potentialDeletedFields)
    {
      foreach ($renamedFieldsMapping as $key => $value)
      {
        Nextgen_Utils::removeElementFromArray($key, $potentialDeletedFields);
        Nextgen_Utils::removeElementFromArray($value, $potentialNewFields);
      }

      return array($potentialNewFields, $potentialDeletedFields);
    }

    /*
     * This will make the renamed fields to have the same name on both the databases
     * That is done only for convenience during the comparison of the fields in the two databases.
     *
     * @param array $renamedFieldsMapping
     * @return Nextgen_Core_Database
     */
    protected function getNewDb1TablesStructureBecauseOfRenamedFields(array $renamedFieldsMapping)
    {
      $newDb1 = clone $this->db1;
      foreach ($renamedFieldsMapping as $key => $value)
      {
        $newDb1->getTable($this->tableName)->renameTable($key, $value);
      }
      return $newDb1;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    protected function compareFields()
    {
        $transformations = array();

        /////////////////// comparing fields ///////////////////
        //
        // these two arrays are computed without taking any renaming into account.
        // we are going to do that soon
        $potentialNewFields = $this->getPotentialNewFields();
        $potentialDeletedFields = $this->getPotentialDeletedFields();

        $this->config->getLogger()->startSection("Table {$this->tableName}");

        $this->config->getLogger()->startSection('Potential new fields');
        $this->config->getLogger()->log(print_r($potentialNewFields, true));

        $this->config->getLogger()->startSection('Potential deleted fields');
        $this->config->getLogger()->log(print_r($potentialDeletedFields, true));

        $renamedFieldsMapping = array();
        if (! $this->config->isUserInteractionDisabled())
        {
            $renamedFieldsMapping = $this->getRenamedFieldsMapping($potentialNewFields, $potentialDeletedFields);
        }

        $this->config->getLogger()->startSection('Renamed fields mapping');
        $this->config->getLogger()->log(print_r($renamedFieldsMapping, true));

        list($newFields, $deletedFields) = $this->changeEntitiesBecauseOfRenamedFields($renamedFieldsMapping, $potentialNewFields, $potentialDeletedFields);

        $this->config->getLogger()->startSection('New fields');
        $this->config->getLogger()->log(print_r($newFields, true));

        $this->config->getLogger()->startSection('Deleted fields');
        $this->config->getLogger()->log(print_r($deletedFields, true));

        // this step can be counterintuitive. Please read the comment to this method
        $modifiedDb1 = $this->getNewDb1TablesStructureBecauseOfRenamedFields($renamedFieldsMapping);

        foreach ($renamedFieldsMapping as $key => $value)
        {
            $params = array('tableName' => $this->tableName, 'fieldOldName' => $key, 'fieldNewName' => $value);
            $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::RENAME_FIELD, $this->db1, $this->db2 , $params);
            $transformations[] = $transformation;
        }

        foreach ($newFields as $newField)
        {
            $params = array('tableName' => $this->tableName, 'fieldName' => $newField);
            $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_FIELD, $this->db1, $this->db2 , $params);
            $transformations[] = $transformation;
        }

        foreach ($deletedFields as $deleteField)
        {
            $params = array('tableName' => $this->tableName, 'fieldName' => $deleteField);
            $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DELETE_FIELD, $this->db1, $this->db2 , $params);
            $transformations[] = $transformation;
        }


        /////////////////// checking for modified fields ///////////////////
        $fieldsIterator = new Nextgen_Core_TableFieldsIterator($this->db2, $this->tableName);

        $this->config->getLogger()->startSection('Modified fields');

        foreach ($fieldsIterator as $field)
        {
            $contentInDb2 = $field->getContent();

            if ($this->db1->getTable($this->tableName)->hasField($field->getName()))
            {
                if (in_array($field->getName(), $renamedFieldsMapping))
                {
                    // the 'rename' transformation "would contain" also the
                    // 'modification transformation'
                    continue;
                }

                $contentInDb1 = $this->db1->getTable($this->tableName)->getField($field->getName())->getContent();
                if ($contentInDb1 != $contentInDb2)
                {
                    $this->config->getLogger()->log($this->tableName);

                    $params = array('tableName' => $this->tableName, 'fieldName' => $field->getName());
                    $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::MODIFY_FIELD, $this->db1, $this->db2 , $params);
                    $transformations[] = $transformation;
                }
            }
        }


        /////////////////// checking for changes in the order of the fields ///////////////////
        $fieldIterator = new Nextgen_Core_TableFieldsIterator($this->db2, $this->tableName);

        $this->config->getLogger()->startSection('Change of the order');

        // getting a slighting different version of the two tables we are to compare:
        // they contain only the common fields
        $intersectedTable_db2WithDb1 = $this->db2->getTable($this->tableName)->getIntersectedVersion($this->db1->getTable($this->tableName));
        $intersectedTable_db1WithDb2 = $this->db1->getTable($this->tableName)->getIntersectedVersion($this->db2->getTable($this->tableName));

        do
        {
          $field = $fieldIterator->current();

          if ($intersectedTable_db2WithDb1->hasField($field->getName())) // I just need to check one of them
          {
            $precedingFieldDb2 = $intersectedTable_db2WithDb1->getPrecedingField($field->getName());
            $precedingFieldDb1 = $intersectedTable_db1WithDb2->getPrecedingField($field->getName());

            if ($precedingFieldDb1 &&
                $precedingFieldDb2 &&
                ($precedingFieldDb1->getName() != $precedingFieldDb2->getName()))
            {
              $params = array('tableName' => $this->tableName, 'fieldName' => $field->getName());
              $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ALTER_FIELD_POSITION, $this->db1, $this->db2 , $params);
              $transformations[] = $transformation;

              $this->config->getLogger()->log($this->tableName);

              // this is very important for not getting useless transformations at next steps
              $intersectedTable_db2WithDb1->removeField($field->getName());
              $intersectedTable_db1WithDb2->removeField($field->getName());
            }
          }

        } while ($fieldIterator->next());

        return $transformations;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    protected function comparePrimaryKeys()
    {
        // echo "{$this->tableName}\n";


        $transformations = array();

        $collection1 = is_object($this->db1->getTable($this->tableName)->getPrimaryKey()) ?
                       array('primary_key' => $this->db1->getTable($this->tableName)->getPrimaryKey()) :
                       array();

        $collection2 = is_object($this->db2->getTable($this->tableName)->getPrimaryKey()) ?
               array('primary_key' => $this->db2->getTable($this->tableName)->getPrimaryKey()) :
               array();

        list($newPrimaryKeys, $deletedPrimaryKeys, $changedPrimaryKeys) = $this->compareTableKeyCollections( $collection1, $collection2);

        $this->config->getLogger()->startSection("New primary keys for {$this->tableName}");
        $this->config->getLogger()->log($newPrimaryKeys);
        $this->config->getLogger()->startSection("Deleted primary keys for {$this->tableName}");
        $this->config->getLogger()->log($deletedPrimaryKeys);
        $this->config->getLogger()->startSection("Changed primary keys for {$this->tableName}");
        $this->config->getLogger()->log($changedPrimaryKeys);

        foreach($newPrimaryKeys as $newPrimaryKey)
        {
          $args = array('tableName' => $this->tableName);
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_PRIMARY_KEY, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        foreach($deletedPrimaryKeys as $deletedPrimaryKey)
        {
          $args = array('tableName' => $this->tableName);
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_PRIMARY_KEY, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
        }

        foreach($changedPrimaryKeys as $changedPrimaryKey)
        {
          $args = array('tableName' => $this->tableName);
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_PRIMARY_KEY, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_PRIMARY_KEY, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }
        return $transformations;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    protected function compareKeys()
    {
        $transformations = array();

        list($newKeys, $deletedKeys, $changedKeys) = $this->compareTableKeyCollections($this->db1->getTable($this->tableName)->getKeys(),
                                                     $this->db2->getTable($this->tableName)->getKeys());

        $this->config->getLogger()->startSection("New keys for {$this->tableName}");
        $this->config->getLogger()->log($newKeys);
        $this->config->getLogger()->startSection("Deleted keys for {$this->tableName}");
        $this->config->getLogger()->log($deletedKeys);
        $this->config->getLogger()->startSection("Changed keys for {$this->tableName}");
        $this->config->getLogger()->log($changedKeys);

        foreach($newKeys as $newKey)
        {
          $args = array('tableName' => $this->tableName, 'keyName' => $newKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_KEY, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        foreach($deletedKeys as $deletedKey)
        {
          $args = array('tableName' => $this->tableName, 'keyName' => $deletedKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_KEY, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
        }

        foreach($changedKeys as $changedKey)
        {
          $args = array('tableName' => $this->tableName, 'keyName' => $changedKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_KEY, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_KEY, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        return $transformations;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    protected function compareUniqueKeys()
    {
        $transformations = array();
        list($newKeys, $deletedKeys, $changedKeys) = $this->compareTableKeyCollections($this->db1->getTable($this->tableName)->getUniqueKeys(),
                                                     $this->db2->getTable($this->tableName)->getUniqueKeys());

        $this->config->getLogger()->startSection("New unique indexes for {$this->tableName}");
        $this->config->getLogger()->log($newKeys);
        $this->config->getLogger()->startSection("Deleted unique indexes for {$this->tableName}");
        $this->config->getLogger()->log($deletedKeys);
        $this->config->getLogger()->startSection("Changed unique indexes for {$this->tableName}");
        $this->config->getLogger()->log($changedKeys);

        foreach($newKeys as $newKey)
        {
          $args = array('tableName' => $this->tableName, 'uniqueKeyName' => $newKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_UNIQUE_KEY, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        foreach($deletedKeys as $deletedKey)
        {
          $args = array('tableName' => $this->tableName, 'uniqueKeyName' => $deletedKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_UNIQUE_KEY, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
        }

        foreach($changedKeys as $changedKey)
        {
          $args = array('tableName' => $this->tableName, 'uniqueKeyName' => $changedKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_UNIQUE_KEY, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_UNIQUE_KEY, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        return $transformations;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    protected function compareIndexes()
    {
        $transformations = array();

        list($newIndexes, $deletedIndexes, $changedIndexes) = $this->compareTableKeyCollections($this->db1->getTable($this->tableName)->getIndexes(),
                                                     $this->db2->getTable($this->tableName)->getIndexes());

        $this->config->getLogger()->startSection("New indexes for {$this->tableName}");
        $this->config->getLogger()->log($newIndexes);
        $this->config->getLogger()->startSection("Deleted indexes for {$this->tableName}");
        $this->config->getLogger()->log($deletedIndexes);
        $this->config->getLogger()->startSection("Changed indexes for {$this->tableName}");
        $this->config->getLogger()->log($changedIndexes);

        foreach($newIndexes as $newIndex)
        {
          $args = array('tableName' => $this->tableName, 'indexName' => $newIndex->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_INDEX, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        foreach($deletedIndexes as $deletedIndex)
        {
          $args = array('tableName' => $this->tableName, 'indexName' => $deletedIndex->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_INDEX, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
        }

        foreach($changedIndexes as $changedIndex)
        {
          $args = array('tableName' => $this->tableName, 'indexName' => $changedIndex->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_INDEX, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_INDEX, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        return $transformations;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    protected function compareConstraints()
    {
        $transformations = array();

        list($newKeys, $deletedKeys, $changedKeys) = $this->compareTableKeyCollections($this->db1->getTable($this->tableName)->getConstraints(),
                                                     $this->db2->getTable($this->tableName)->getConstraints());

        $this->config->getLogger()->startSection("New constraints for {$this->tableName}");
        $this->config->getLogger()->log($newKeys);
        $this->config->getLogger()->startSection("Deleted constraints for {$this->tableName}");
        $this->config->getLogger()->log($deletedKeys);
        $this->config->getLogger()->startSection("Changed constraints for {$this->tableName}");
        $this->config->getLogger()->log($changedKeys);

        foreach($newKeys as $newKey)
        {
          $args = array('tableName' => $this->tableName, 'constraintName' => $newKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_CONSTRAINT, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        foreach($deletedKeys as $deletedKey)
        {
          $args = array('tableName' => $this->tableName, 'constraintName' => $deletedKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_CONSTRAINT, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
        }

        foreach($changedKeys as $changedKey)
        {
          $args = array('tableName' => $this->tableName, 'constraintName' => $changedKey->getName());
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DROP_CONSTRAINT, $this->db1, $this->db2 , $args);
          $transformations[] = $transformation;
          $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_CONSTRAINT, $this->db1, $this->db2, $args);
          $transformations[] = $transformation;
        }

        return $transformations;
    }

    /*
     * Returns an array:
     * _ the first element is an array containing all the new keys from $targetCollection
     * _ the second element is an array containing all the deleted keys from $startCollection
     * _ the third element is an array containing all the changed keys from $targetCollection
     *
     * @param array $startCollection (array of Nextgen_Core_TableKey)
     * @param array $startCollection (array of Nextgen_Core_TableKey)
     * @return array
     */
    protected function compareTableKeyCollections(array $startCollection, array $targetCollection)
    {
       //print_r($startCollection);
       //print_r($targetCollection);

      $newKeys = array();
      $deletedKeys = array();
      $changedKeys = array();

      $startCollectionKeyNames = array();
      $targetCollectionKeyNames = array();

      foreach ($startCollection as $key => $value)
      {
        $startCollectionKeyNames[] = $key;
      }

      foreach ($targetCollection as $key => $value)
      {
        $targetCollectionKeyNames[] = $key;
      }

      $newKeyNames = array_diff($targetCollectionKeyNames, $startCollectionKeyNames);
      $deletedKeyNames = array_diff($startCollectionKeyNames, $targetCollectionKeyNames);

      foreach($newKeyNames as $name)
      {
        $newKeys[] = $targetCollection[$name];
      }

      foreach($deletedKeyNames as $name)
      {
        $deletedKeys[] = $startCollection[$name];
      }

      // looking for changed keys
      foreach($startCollection as $key => $value)
      {
        if (isset($targetCollection[$key]))
        {
          $targetValue = $targetCollection[$key];
          if ($value != $targetValue)
          {
            $changedKeys[] = $targetCollection[$key];
          }
        }
      }

      return array($newKeys, $deletedKeys, $changedKeys);
    }
}