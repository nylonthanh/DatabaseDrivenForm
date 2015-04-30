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

    /**
     * @return bool
     * @todo: build this out!
     */
    public static function checkRequiredAndNotEmpty($data, $dataType)
    {
        if ($dataType !== 'array') {
            throw new \Exception('Form submission error: Failed Type comparison; Expecting type array.');

        }

        try {
            return array_walk($data, function(&$data, $index)
            {
                return (self::isRequired($index) && !empty($data));
            });

        } catch(\Exception $e) {
            throw $e;

        }

    }

    /**
     * check if fieldName has a required field
     * @param $fieldName
     * @returns bool
     * @throws \Cleanify\Model\Exception
     */
    public static function isRequired($fieldName)
    {
        $fieldNameArray = \Cleanify\Model\FormFields::get();


    }
}