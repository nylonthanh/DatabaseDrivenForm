<?php

namespace Cleanify\Controller;

class SanitizeData
{
    /**
     * This will check if the subject passed in is the type anticipated
     * @param $subject
     * @param $type
     * @return boolean
     */
    public static function checkType($subject, $type)
    {
        $execute = "is_$type";
        $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';

        if (!function_exists($execute)) {
            error_log("INTEGRITY ERROR: \$_POST does not match anticipated type, $type. " .
                __METHOD__ .  " \n" . __LINE__, 3, $errorLogPath);

            throw new \Exception(
                "INTEGRITY ERROR: \$_POST does not match anticipated type, $type. " .
                __METHOD__ .  " \n Line: " . __LINE__
            );

        }

        return($execute($subject));

    }

    public static function checkRequired(){
        return true;
    }
}