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

interface Nextgen_OutputGenerator_Interface
{
    /*
     * @param string $outputResource
     * @param Nextgen_Core_Configuration $config
     */
    public function __construct($outputResource, Nextgen_Core_Configuration $config);

    /*
     * @param string $resource
     */
    public function setOutputResource($resource);

    /*
     * @param array $transformations
     */
    public function setTransformations(array $transformations);

    /*
     * return mixed
     */
    public function generateOutput();
}