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
     * @param $data payload, form POST values
     * @param $dataType
     * @throws \Exception
     */
    public static function checkRequiredAndNotEmpty($data, $dataType)
    {
        if ($dataType !== 'array') {
            throw new \Exception('Form submission error: Failed Type comparison; Expecting type array.');

        }

        try {
            $allFieldNamesArray = \Cleanify\Model\FormFields::get();
            array_walk($data, function(&$data, $index, $allFieldNamesArray)
            {
                if (self::isRequired($index, $allFieldNamesArray) && empty($data)) {
                    (new \Cleanify\Controller\Page('error', "Form Error: required field(s) not completed, including: $index."));

                }
            }, $allFieldNamesArray);

        } catch(\Exception $e) {
            throw $e;

        }

    }

    /**
     * check if fieldName has a required field
     * @param $fieldName
     * @param $allFieldNamesArray
     * @throws \Exception
     */
    public static function isRequired($fieldName,  $allFieldNamesArray)
    {
        foreach($allFieldNamesArray as $fieldIndex => $value) {
                foreach($value as $key => $field) {
                    if ($key === 'field_name' && $field === $fieldName) {
                        return $value['required'];

                    }
                }
        }

        return false;

    }

}