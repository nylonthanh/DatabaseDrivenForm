<?php

namespace Cleanify\Controller;

use Cleanify\Model as Model;

class SanitizeData
{
    protected $formFieldsObject;

    public function __construct()
    {
        //the formFieldObject is dependent on a db connection
        $this->$formFieldObject = new Model\FormFields((new Model\DbConnection())->connection());

    }

    /**
     * This will check if the subject passed in is the type anticipated
     * @param $subject
     * @param $type
     * @return boolean
     */
    public function checkType($subject, $type)
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
     * checks for tampering for the $_POST obj
     * @param $data payload, form POST values
     * @param $dataType
     * @throws \Exception
     */
    public function checkRequiredAndNotEmpty($data, $dataType)
    {
        if ($dataType !== 'array') {
            throw new \Exception('Form submission error: Failed Type comparison; Expecting type array.');

        }

        try {
            $allFieldNamesArray = $this->$formFieldObject->get();
            array_walk($data, function(&$data, $index, $allFieldNamesArray)
            {
                if ($this->isRequired($index, $allFieldNamesArray) && empty($data)) {
                    (new Page('error', "Form Error: required field(s) not completed, including: $index."));

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
    public function isRequired($fieldName,  $allFieldNamesArray)
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