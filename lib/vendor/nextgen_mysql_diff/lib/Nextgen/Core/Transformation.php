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

abstract class Nextgen_Core_Transformation
{
    /* This constants are used to build the name of the classes */
    const ADD_TABLE = 'AddTable';
    const DELETE_TABLE = 'DeleteTable';
    const RENAME_TABLE = 'RenameTable';
    const ADD_FIELD = 'AddField';
    const DELETE_FIELD = 'DeleteField';
    const RENAME_FIELD = 'RenameField';
    const MODIFY_FIELD = 'ModifyField';
    const ALTER_FIELD_POSITION = 'AlterFieldPosition';
    const ADD_PRIMARY_KEY = 'AddPrimaryKey';
    const DROP_PRIMARY_KEY = 'DropPrimaryKey';
    const ADD_KEY = 'AddKey';
    const DROP_KEY = 'DropKey';
    const ADD_UNIQUE_KEY = 'AddUniqueKey';
    const DROP_UNIQUE_KEY = 'DropUniqueKey';
    const ADD_INDEX = 'AddIndex';
    const DROP_INDEX = 'DropIndex';
    const ADD_CONSTRAINT = 'AddConstraint';
    const DROP_CONSTRAINT = 'DropConstraint';

    /*
     * @var array $mandatoryParams
     */
    protected $mandatoryParams;

    /*
     * @var Nextgen_Core_Database $db1
     */
    protected static $db1;

    /*
     * @var Nextgen_Core_Database $db2
     */
    protected static $db2;

    abstract public function __construct(array $params);

    /*
     * @param string $type - it has to be one of the class constants declared at the top
     * @param array $params
     * @param Nextgen_Core_Database $db1
     * @param Nextgen_Core_Database $db2
     */
    public static function getInstance($type, Nextgen_Core_Database $db1, Nextgen_Core_Database $db2, array $params)
    {
      self::$db1 = $db1;
      self::$db2 = $db2;
      $className = __CLASS__ . 's_' . $type;
      return new $className($params);
    }

    /*
     * @param array $params
     */
    protected function validateParams(array $params)
    {
        foreach($this->mandatoryParams as $mandatoryParam)
        {
            if(! array_key_exists($mandatoryParam, $params))
            {
                throw new InvalidArgumentException("Param $mandatoryParam is needed.");
            }
        }
    }

    /*
     * @return string
     */
    abstract public function getSql();
}