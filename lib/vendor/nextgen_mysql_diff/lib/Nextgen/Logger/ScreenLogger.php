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

class Nextgen_Logger_ScreenLogger implements Nextgen_Logger_Interface
{
    /*
     * @var Nextgen_Core_Configuration
     */
    private $config;

    public function __construct(Nextgen_Core_Configuration $config)
    {
        $this->config = $config;
    }

    /*
     * @param string $resource - the absolute path for the input file
     */
    public function log($message)
    {
        if (is_array($message))
        {
            echo print_r($message, true);
        }

        echo "$message \n";
    }
    
    public function insertBreak()
    {
        echo "\n";
    }

    /*
     * @param string $resource - the absolute path for the input file
     * @param string $marker (='>>>>> ')
     */
    public function startSection($message, $marker='>>>>> ')
    {
        $this->insertBreak();
        $this->log($message);
    }
}