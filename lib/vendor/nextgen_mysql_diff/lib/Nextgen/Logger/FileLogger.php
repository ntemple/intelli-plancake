<?php

class Nextgen_Logger_FileLogger implements Nextgen_Logger_Interface
{
    /*
     * @var Nextgen_Core_Configuration
     */
    private $config;

    /*
     * @var boolean
     */
    static private $initialized = false;

    /*
     * @var string
     */
    protected $outputFilePath;

    public function __construct(Nextgen_Core_Configuration $config)
    {
        $this->config = $config;

        $this->outputFilePath = $config->getOutputResource() . '.log';
        
        // truncating the file
        if (! self::$initialized)
        {
          file_put_contents($this->outputFilePath, '');
          self::$initialized = true;
        }
    }

    /*
     * @param string $resource - the absolute path for the input file
     */
    public function log($message)
    {
        if (is_array($message))
        {
            $message = print_r($message, true);
        }

        file_put_contents($this->outputFilePath, $message . "\n", FILE_APPEND);
    }
    
    public function insertBreak()
    {
        file_put_contents($this->outputFilePath, "\n", FILE_APPEND);
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