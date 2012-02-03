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

/*
 * This class deals directly with these transformations:
 * _ add table
 * _ delete table
 * _ rename table
 *
 * It deals with all the table transformations by using NextGen_Core_TablesComparator
 *
 */

class Nextgen_Core_DatabaseComparator
{
    /*
     * @var Nextgen_Core_Configuration
     */
    protected $config;

    /*
     * @var Nextgen_Core_Database
     */
    protected $db1;

    /*
     * @var Nextgen_Core_Database
     */
    protected $db2;

    /*
     * @param Nextgen_Core_Configuration $config
     * @param Nextgen_Core_Database $db1
     * @param Nextgen_Core_Database $db2
     */
    public function __construct($config, $db1, $db2)
    {
        $this->config = $config;
        $this->setDb1($db1);
        $this->setDb2($db2);
    }

    /*
     * @param Nextgen_Core_Database $db1
     */
    public function setDb1($db1)
    {
        $this->db1 = $db1;
    }

    /*
     * @param Nextgen_Core_Database $db2
     */
    public function setDb2($db2)
    {
        $this->db2 = $db2;
    }

    /*
     * @return array of Nextgen_Core_Transformation
     */
    public function getTransformations()
    {
        // these two arrays are computed without taking any renaming into account.
        // we are going to do that soon
        $potentialNewTables = $this->getPotentialNewTables();
        $potentialDeletedTables = $this->getPotentialDeletedTables();

        $this->config->getLogger()->startSection('Potential new tables');
        $this->config->getLogger()->log(print_r($potentialNewTables, true));

        $this->config->getLogger()->startSection('Potential deleted tables');
        $this->config->getLogger()->log(print_r($potentialDeletedTables, true));


        $renamedTablesMapping = array();
        if (! $this->config->isUserInteractionDisabled())
        {
            $renamedTablesMapping = $this->getRenamedTablesMapping($potentialNewTables, $potentialDeletedTables);
        }

        $this->config->getLogger()->startSection('Renamed tables mapping');
        $this->config->getLogger()->log(print_r($renamedTablesMapping, true));

        list($newTables, $deletedTables) = $this->changeEntitiesBecauseOfRenamedTables($renamedTablesMapping, $potentialNewTables, $potentialDeletedTables);

        $this->config->getLogger()->startSection('New tables');
        $this->config->getLogger()->log(print_r($newTables, true));

        $this->config->getLogger()->startSection('Deleted tables');
        $this->config->getLogger()->log(print_r($deletedTables, true));

        // this step can be counterintuitive. Please read the comment to this method
        $modifiedDb1 = $this->getNewDb1StructureBecauseOfRenamedTables($renamedTablesMapping);

        $transformations = array();

        foreach ($newTables as $newTable)
        {
            $params = array('tableName' => $newTable);
            $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::ADD_TABLE, $this->db1, $this->db2 , $params);
            $transformations[] = $transformation;
        }

        foreach ($deletedTables as $deleteTable)
        {
            $params = array('tableName' => $deleteTable);
            $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::DELETE_TABLE, $this->db1, $this->db2 , $params);
            $transformations[] = $transformation;
        }

        foreach ($renamedTablesMapping as $key => $value)
        {
            $params = array('tableOldName' => $key, 'tableNewName' => $value);
            $transformation = Nextgen_Core_Transformation::getInstance(Nextgen_Core_Transformation::RENAME_TABLE, $this->db1, $this->db2 , $params);
            $transformations[] = $transformation;
        }

        $tablesComparator = new Nextgen_Core_TablesComparator($this->config, $modifiedDb1, $this->db2);
        $tablesTransformations = $tablesComparator->getTransformations();

        $transformations = array_merge($transformations, $tablesTransformations);

        return $transformations;
    }

    /*
     * @return array
     */
    private function getPotentialNewTables()
    {
        $tablesFromDb1 = $this->db1->getTablesNames();
        $tablesFromDb2 = $this->db2->getTablesNames();
        return array_diff($tablesFromDb2, $tablesFromDb1);
    }

    /*
     * @return array
     */
    private function getPotentialDeletedTables()
    {
        $tablesFromDb1 = $this->db1->getTablesNames();
        $tablesFromDb2 = $this->db2->getTablesNames();
        return array_diff($tablesFromDb1, $tablesFromDb2);
    }

    /*
     * @param array $potentialNewTables (array of strings)
     * @param array $potentialDeletedTables (array of strings)
     * @return array the keys are the old names, the value are the corresponding new names
     */
    private function getRenamedTablesMapping(array $potentialNewTables, array $potentialDeletedTables)
    {
      $renamedTablesMapping = array();

      if (count($potentialNewTables) && count($potentialDeletedTables))
      {
        $deletedTables = $potentialDeletedTables;

        foreach($potentialNewTables as $potentialNewTable)
        {
          if (!count($potentialDeletedTables))
          {
            break;
          }

          $potentialRenamedTablesWithScore = array();
          foreach($potentialDeletedTables as $potentialDeletedTable)
          {
            $score = $this->db2->getTable($potentialNewTable)->getSimilarityScore($this->db1->getTable($potentialDeletedTable));
            $potentialRenamedTablesWithScore[$score] = $potentialDeletedTable;
          }
          ksort($potentialRenamedTablesWithScore);

          $potentialRenamedTablesSorted = array_values($potentialRenamedTablesWithScore);
          $questionChoices = array_merge(array('none of them'), $potentialRenamedTablesSorted); // @201004142017

          $question = "Please make your choice for answering this question \n";
          $question .= "Is $potentialNewTable a renamed version of:";
          $answer = Nextgen_Core_UserInteraction::askQuestionWithChoices($question, $questionChoices);

          // -1 because of the line @201004142017
          if (array_key_exists($answer-1, $potentialRenamedTablesSorted))
          {
            $renamedTablesMapping[$potentialRenamedTablesSorted[$answer-1]] = $potentialNewTable;
            Nextgen_Utils::removeElementFromArray($potentialRenamedTablesSorted[$answer-1], $potentialDeletedTables);
          }
        }
      }

      return $renamedTablesMapping;
    }

    /*
     * Returns an array:
     * _ the first item will be an array containing all the tables really created (their names)
     * _ the second item will be an array containing all the tables really deleted  (their names)
     *
     * @param array $renamedTablesMapping
     * @param array $potentialNewTables
     * @param array $potentialDeletedTables
     * @return array
     */
    private function changeEntitiesBecauseOfRenamedTables(array $renamedTablesMapping, array $potentialNewTables, array $potentialDeletedTables)
    {
      foreach ($renamedTablesMapping as $key => $value)
      {
        Nextgen_Utils::removeElementFromArray($key, $potentialDeletedTables);
        Nextgen_Utils::removeElementFromArray($value, $potentialNewTables);
      }

      return array($potentialNewTables, $potentialDeletedTables);
    }

    /*
     * This will make the renamed tables to have the same name on both the databases
     * That is done only for convenience during the comparison of the tables in the two databases.
     *
     * @param array $renamedTablesMapping
     * @return Nextgen_Core_Database
     */
    private function getNewDb1StructureBecauseOfRenamedTables(array $renamedTablesMapping)
    {
      $newDb1 = $this->db1;
      foreach ($renamedTablesMapping as $key => $value)
      {
        $newDb1->renameTable($key, $value);
      }
      return $newDb1;
    }
}