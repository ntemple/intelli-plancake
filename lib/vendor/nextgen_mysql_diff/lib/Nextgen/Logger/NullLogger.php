<?php

class Nextgen_Logger_NullLogger extends Nextgen_Logger_FileLogger
{
    public function __construct(Nextgen_Core_Configuration $config)
    {
        $this->config = $config;
        $this->outputFilePath = '/dev/null';
    }
}