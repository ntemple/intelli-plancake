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

class Nextgen_Core_UserInteraction
{
    /*
     * @var array (of strings)
     */
    static protected $answers;
    
    /*
     * @var integer
     */
    static protected $answerIndex = 0;

    /*
     * @return string
     */
    protected function getNextAnswer()
    {
        return self::$answers[self::$answerIndex];
        self::$answerIndex++;
    }

    /*
     * @param string $questions
     * @return string - the answer
     */
    public static function askQuestion($question)
    {
        if (count(self::$answers))
        {
            return self::getNextAnswer();
        }

        echo "\n $question \n";

        $handle = fopen ("php://stdin","r");
        $answer = trim(fgets($handle));
        fclose($handle);

        return $answer;
    }

    /*
     * @param string $questions
     * @param array $choices
     * @return string - the answer
     */
    public static function askQuestionWithChoices($question, array $choices)
    {
        $question = "\n $question \n";

        foreach($choices as $index => $choice)
        {
            $question .= "($index) $choice \n";
        }

        do
        {
            $answer = self::askQuestion($question);
        } while(!array_key_exists($answer, $choices));

        return $answer;
    }

    /*
     * @param array $answers
     */
    public static function setAnswers(array $answers)
    {
        self::$answers = $answers;
    }
}