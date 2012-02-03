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

class Nextgen_Core_Transformations_RenameTable extends Nextgen_Core_Transformation
{
    /*
     * @var string $tableOldName
     */
    private $tableOldName;

    /*
     * @var string $tableNewName
     */
    private $tableNewName;

    /*
     * @param array $params
     */
    public function __construct(array $params)
    {
      $this->mandatoryParams = array('tableOldName', 'tableNewName');
      $this->validateParams($params);

      $this->tableOldName = $params['tableOldName'];
      $this->tableNewName = $params['tableNewName'];
    }

    /*
     * @return string
     */
    public function getSql()
    {
        return "RENAME TABLE `{$this->tableOldName}` TO `{$this->tableNewName}`;";
    }
}