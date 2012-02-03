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

class Nextgen_Core_Engine
{
    /*
     * @var Nextgen_Core_Configuration
     */
    private $config;
    
    public function __construct(Nextgen_Core_Configuration $config = null)
    {
        spl_autoload_register(array('self', 'autoloader'));

        if ($config)
        {
            $this->setConfiguration($config);
        }
    }

    public function setConfiguration(Nextgen_Core_Configuration $config)
    {
        $this->config = $config;
    }

    public function doDiff()
    {
        $ignoreTablesRegexp = $this->config->getIgnoreTablesRegexp();
        $inputHandler1 = $this->config->getInputHandler1();
        $inputHandler2 = $this->config->getInputHandler2();

        $this->config->getLogger()->insertBreak();
        $this->config->getLogger()->log('Starting parsing input 1');
        $this->config->getLogger()->insertBreak();
        $db1 = $inputHandler1->getDatabase();

        $this->config->getLogger()->insertBreak();
        $this->config->getLogger()->log('Starting parsing input 2');
        $this->config->getLogger()->insertBreak();
        $db2 = $inputHandler2->getDatabase();

        $dbComparator = new Nextgen_Core_DatabaseComparator($this->config, $db1, $db2);
        $transformations = $dbComparator->getTransformations();

        $outputGenerator = $this->config->getOutputGenerator();
        $outputGenerator->setTransformations($transformations);

        $output = $outputGenerator->generateOutput();

        echo $output;
    }

    public static function autoloader($classname)
    {
        $inclusionRelativePath = '';

        if (preg_match('!Console_.*!', $classname))
        {
            $classPath = str_replace('_', '/', $classname);
            $inclusionRelativePath = 'lib/vendor/Console_CommandLine/' . $classPath . '.php';
        }
        else if (preg_match('!Nextgen_.*!', $classname))
        {
            $classPath = str_replace('_', '/', $classname);
            $inclusionRelativePath = 'lib/' . $classPath . '.php';
        }

        $projectRootDirectory = realpath(dirname(__FILE__) . '/../../..');

        // looking for the class in the local directories first
        $filepathForInclusion = $projectRootDirectory . '/local/' . $inclusionRelativePath;
        if (!is_file($filepathForInclusion))
        {
            $filepathForInclusion = $projectRootDirectory . '/' . $inclusionRelativePath;
            if (!is_file($filepathForInclusion))
            {
                throw new Exception("Couldn't load $classname - searched for it in $filepathForInclusion");
            }
        }

        include($filepathForInclusion);
    }
}