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

class Nextgen_Core_Transformations_AddUniqueKey extends Nextgen_Core_Transformation
{
    /*
     * @var string $tableName
     */
    private $tableName;

    /*
     * @var string $uniqueKeyName
     */
    private $uniqueKeyName;

    /*
     * @param array $params
     */
    public function __construct(array $params)
    {
      $this->mandatoryParams = array('tableName', 'uniqueKeyName');
      $this->validateParams($params);

      $this->tableName = $params['tableName'];
      $this->uniqueKeyName = $params['uniqueKeyName'];
    }

    /*
     * @return string
     */
    public function getSql()
    {
        $uniqueKeyContent = self::$db2->getTable($this->tableName)->getUniqueKey($this->uniqueKeyName)->getValue();
        return "ALTER TABLE `{$this->tableName}` ADD UNIQUE `{$this->uniqueKeyName}` ($uniqueKeyContent);";
    }
}