#! /usr/bin/php

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

    include_once(dirname(__FILE__) . '/lib/Nextgen/Core/Engine.php');
    $nextGen = new Nextgen_Core_Engine();

    // create the parser
    $parser = new Console_CommandLine(array(
        'description' => 'NextGen is an advanced MySQL diff tool.',
        'version'     => '1.0.0'
    ));

    // add an option to make the program verbose
    $parser->addOption(
        'verbose',
        array(
            'short_name'  => '-v',
            'long_name'   => '--verbose',
            'action'      => 'StoreTrue',
            'description' => 'turn on verbose output'
        )
    );

    $parser->addOption(
        'ignore_tables_regexp',
        array(
            'short_name'  => '-i',
            'long_name'   => '--ignore-tables-regexp',
            'description' => 'specify a regular expression for tables you want to ignore',
            'action'      => 'StoreString',
            'default'     => ''
        )
    );

    $parser->addOption(
        'disable_user_interaction',
        array(
            'short_name'  => '-u',
            'long_name'   => '--disable-user-interaction',
            'description' => 'disable the user interaction',
            'action'      => 'StoreTrue',
            'default'     => ''
        )
    );

    $parser->addOption(
        'answers',
        array(
            'short_name'  => '-a',
            'long_name'   => '--answers',
            'description' => 'the list of answers for the user interaction - they must be comma-separated, ie:  2,0,3',
            'action'      => 'StoreString',
            'default'     => ''
        )
    );

    $parser->addOption(
        'enable_log',
        array(
            'short_name'  => '-e',
            'long_name'   => '--enable-log',
            'description' => 'whether to enable log (if you enable it, you need to pass the parser as well)',
            'action'      => 'StoreTrue',
            'default'     => ''
        )
    );

    $parser->addOption(
        'logger',
        array(
            'short_name'  => '-l',
            'long_name'   => '--logger',
            'description' => 'the logger to use',
            'action'      => 'StoreString',
            'default'     => ''
        )
    );

    // add the files argument, the user can specify one or several files
    $parser->addArgument(
        'input_handler_1',
        array(
            'description' => 'The handler to use for the first input'
        )
    );

    $parser->addArgument(
        'input_resource_1',
        array(
            'description' => 'The string to identify the first input (the format depends on the handler)'
        )
    );

    $parser->addArgument(
        'input_handler_2',
        array(
            'description' => 'The handler to use for the second input'
        )
    );

    $parser->addArgument(
        'input_resource_2',
        array(
            'description' => 'The string to identify the second input (the format depends on the handler)'
        )
    );

    $parser->addArgument(
        'output_generator',
        array(
            'description' => 'The generator for the output the output'
        )
    );

    $parser->addArgument(
        'output_resource',
        array(
            'description' => 'The string to identify where to place the output, usually a file name (depends on the handler)'
        )
    );

    // run the parser
    try {
        $result = $parser->parse();


        $options = $result->options;
        $args = $result->args;

        $config = array(
            'input_handler_1' => $args['input_handler_1'],
            'input_resource_1' => $args['input_resource_1'],
            'input_handler_2' => $args['input_handler_2'],
            'input_resource_2' => $args['input_resource_2'],
            'output_generator' => $args['output_generator'],
            'output_resource' => $args['output_resource'],
            'ignore_tables_regexp' => $options['ignore_tables_regexp'],
            'disable_user_interaction' => $options['disable_user_interaction'],
            'answers' => $options['answers'],
            'enable_log' => $options['enable_log'],
            'logger' => $options['logger'],
          );

        $nextGenConfig = new Nextgen_Core_Configuration($config);
        $nextGen->setConfiguration($nextGenConfig);
        $nextGen->doDiff();
    } catch (Exception $exc) {
        $parser->displayError($exc->getMessage());
    }

?>