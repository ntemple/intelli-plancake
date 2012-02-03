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

foreach (glob('tests/*', GLOB_ONLYDIR) as $testCategoryPath)
{
  $testCategoryName = end(explode("/", $testCategoryPath));

  printMessage("Category $testCategoryName", 1);

  foreach(glob("$testCategoryPath/*", GLOB_ONLYDIR) as $testSuitePath)
  {
    $testSuiteName = end(explode("/", $testSuitePath));
    printMessage("Test suite $testSuiteName", 2);

    $input1Filename = "$testSuitePath/input1";
    $input2Filename = "$testSuitePath/input2";

    foreach(glob("$testSuitePath/command*") as $commandPath)
    {
      $commandName = end(explode("/", $commandPath));
      printMessage("", 3);
      printMessage("Command $commandName", 3);

      preg_match('!command_([0-9])+!', $commandName, $matches);
      $commandIndex = $matches[1];

      $correspondingCorrectOutputFilename = $testSuitePath . '/output_' . $commandIndex;

      $command = file_get_contents($commandPath);
      $temporaryOutputFile = $correspondingCorrectOutputFilename . '_temp';

      // getting the command to run
      $command = str_replace('[INPUT1]', $input1Filename, $command);
      $command = str_replace('[INPUT2]', $input2Filename, $command);
      $command = str_replace('[OUTPUT]', $temporaryOutputFile, $command);
      $command = str_replace("\n", '', $command);
      printMessage("Running command $command", 3);

      exec($command);

      $correctOutput = str_replace(array("\n", ' '), '', file_get_contents($correspondingCorrectOutputFilename));
      $temporaryOutput = str_replace(array("\n", ' '), '', file_get_contents($temporaryOutputFile));

      if ( $correctOutput == $temporaryOutput )
      {
        printMessage('OK', 3);
      }
      else
      {
        printMessage('Test failed!', 3);
        printMessage('Expected output: ', 3);
        printMessage(file_get_contents($correspondingCorrectOutputFilename), 3);
        printMessage('Actual output: ', 3);
        printMessage(file_get_contents($temporaryOutputFile), 3);
      }

      unlink($temporaryOutputFile);
    }
  }
}

/*
 * @param string $message
 * @param int $level
 */
function printMessage($message, $level)
{
  $levelIndicator = str_pad('', $level, '>');

  echo "$levelIndicator $message \n";
}