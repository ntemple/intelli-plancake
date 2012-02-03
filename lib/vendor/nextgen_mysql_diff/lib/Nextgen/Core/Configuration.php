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

class Nextgen_Core_Configuration
{
    /*
     * @var string
     */
    private $inputHandler1name;

    /*
     * @var string
     */
    private $inputHandler2name;

    /*
     * @var string
     */
    private $outputGeneratorName;

    /*
     * @var bool
     */
    private $ignoreTablesRegexp;

    /*
     * @var bool
     */
    private $enableLog;

    /*
     * @var bool
     */
    private $disableUserInteraction;

    /*
     * @var string
     */
    private $logger = '';

    /*
     * @var string
     */
    private $inputResource1 = '';

    /*
     * @var string
     */
    private $inputResource2 = '';

    /*
     * @var string
     */
    private $outputResource = '';
    

    public function __construct(array $config)
    {
        $this->setParameters($config);
    }

    private function setParameters(array $config)
    {
        // checking we have all the mandatary fields
        $mandatoryConfigParams = array('input_handler_1',
                                  'input_resource_1',
                                 'input_handler_2',
                                 'input_resource_2',
                                 'output_generator',
                                 'output_resource');

        foreach ($mandatoryConfigParams as $mandatoryConfigParam)
        {
            if (!array_key_exists($mandatoryConfigParam, $config))
            {
                throw new Exception("The mandatory configuration field $mandatoryConfigParam is missing.");
            }
        }

        if ($config['enable_log'] && !$config['logger'])
        {
          throw new Exception("You need to specify the logger to use");
        }


        // @todo - creating of output class
        $this->inputHandler1name = $config['input_handler_1'];
        $this->inputHandler2name = $config['input_handler_2'];
        $this->outputGeneratorName = $config['output_generator'];

        $this->inputResource1 = $config['input_resource_1'];
        $this->inputResource2 = $config['input_resource_2'];
        $this->outputResource = $config['output_resource'];

        $this->ignoreTablesRegexp = $config['ignore_tables_regexp'];

        $this->enableLog = $config['enable_log'];
        $this->logger = $config['logger'];

        $this->disableUserInteraction = false;
        if ( isset($config['disable_user_interaction']) && $config['disable_user_interaction'] )
        {
          $this->disableUserInteraction = true;
        }
        if ( isset($config['answers']) && (strlen($config['answers']) > 0) )
        {
          Nextgen_Core_UserInteraction::setAnswers(explode(',', $config['answers']));
        }
    }

    /*
     * @return string
     */
    public function getInputResource1()
    {
      return $this->inputResource1;
    }

    /*
     * @return string
     */
    public function getInputResource2()
    {
      return $this->inputResource2;
    }

    /*
     * @return string
     */
    public function getOutputResource()
    {
      return $this->outputResource;
    }

    /*
     * @returns NextGen_InputHandler_Interface
     */
    public function getInputHandler1()
    {
        $inputHandler1ClassName = 'Nextgen_InputHandler_' . $this->inputHandler1name;
        if (!class_exists($inputHandler1ClassName))
        {
            throw new Exception("The class $inputHandler1ClassName does not exist.");
        }
        return new $inputHandler1ClassName($this->inputResource1, $this);
    }

    /*
     * @returns NextGen_InputHandler_Interface
     */
    public function getInputHandler2()
    {
        $inputHandler2ClassName = 'Nextgen_InputHandler_' . $this->inputHandler2name;
        if (!class_exists($inputHandler2ClassName))
        {
            throw new Exception("The class $inputHandler1ClassName does not exist.");
        }
        return new $inputHandler2ClassName($this->inputResource2, $this);
    }

    /*
     * @return Nextgen_Logger_Interface
     */
    public function getLogger()
    {
      $logger = strlen($this->logger)>0 ? $this->logger : 'NullLogger';
      $loggerClass = 'Nextgen_Logger_' . $logger;
      return new $loggerClass($this);
    }

    /*
     * @return Nextgen_OutputHandler_Interface
     */
    public function getOutputGenerator()
    {
      $outputGeneratorClass = 'Nextgen_OutputGenerator_' . $this->outputGeneratorName;
      return new $outputGeneratorClass($this->outputResource, $this);
    }

    /*
     * @returns string
     */
    public function getIgnoreTablesRegexp()
    {
        return $this->ignoreTablesRegexp;
    }

    public function isUserInteractionDisabled()
    {
        return $this->disableUserInteraction;
    }
}