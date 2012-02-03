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

class Nextgen_OutputGenerator_StandardFile implements Nextgen_OutputGenerator_Interface
{
    /*
     * @var string
     */
    private $resource;

    /*
     * @var Nextgen_Core_Configuration
     */
    private $config;

    /*
     * @var Nextgen_Logger_Interface
     */
    private $logger;

    /*
     * @var array (of Nextgen_Core_Transformation)
     */
    private $transformations;

    public function __construct($resource, Nextgen_Core_Configuration $config)
    {
        $this->config = $config;
        $this->setOutputResource($resource);

        $this->logger = $config->getLogger();
    }

    /*
     * @var string $resource
     */
    public function setOutputResource($resource)
    {
      $this->resource = $resource;
    }

    /*
     * @param array $transformations
     */
    public function setTransformations(array $transformations)
    {
      $this->transformations = $transformations;
    }

    /*
     * return mixed
     */
    public function generateOutput()
    {
      $transformationsSql = array();

      foreach($this->transformations as $transformation)
      {
        $transformationsSql[] = $transformation->getSql();
      }

      $output = implode("\n\n", $transformationsSql);

      $output = "\n\nSET FOREIGN_KEY_CHECKS=0;\n\n" . $output . "\n\nSET FOREIGN_KEY_CHECKS=1;\n\n";

      file_put_contents($this->resource, $output);
    }
}