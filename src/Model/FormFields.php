<?php

namespace Cleanify\Model;

/**
 * Class FormFields
 * @package Cleanify\Model
 */
class FormFields
{
    protected $dbConnection;

    public function __construct ($dbConnection){
        $this->dbConnection = $dbConnection;

    }

    /**
     * purpose: to get form field(s) from database
     * returns all if no arguments, otherwise will return according to the field passed in
     * @return mixed
     * @throws \Exception
     * @todo: add caching
     */
    public function get($fieldName = null)
    {
        try {
            $_fieldName = filter_var($fieldName, FILTER_SANITIZE_STRING);

        } catch(\Exception $e) {
            throw new \Exception('Sorry! Only accepting single fields or empty.');

        }

        if (empty($_fieldName)) {
            try {
                return $this->getAllFields();


            } catch(\Exception $e) {
                throw $e;

            }
        }

        try {
            return $this->getField($_fieldName);

        } catch(\Exception $e) {
            throw $e;

        }

    }

    /**
     * @param $fieldArray
     * @return mixed
     * @throws \Exception
     */
    public function writeFields($fieldArray)
    {
        try {
            return $this->insertFieldsIntoDb($fieldArray);

        } catch(\Exception $e) {
            throw $e;

        }

    }

    /**
     * @param $field
     * @return mixed
     * @throws \Exception
     */
    protected function getField($field, $orderBy = 'order', $orderByValue = 'ASC')
    {
        if (empty($this->dbConnection)) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
            error_log("DB Connection Error: " . " \n" . __METHOD__ .  " \n Line: " .
                __LINE__, 3, $errorLogPath);
            throw new \Exception('Could not connect with database.');
        }

        $sql = "SELECT $field
        FROM " . DB_FORM_TABLE . "
        ORDER BY `$orderBy` $orderByValue;";

        try {
            return $this->selectQuery($sql);

        } catch(\Exception $e) {
            throw $e;

        }

    }
    /**
     * @param $dbConnection
     * @return mixed
     * @throws \Exception
     */
    protected function getAllFields($orderBy = 'order', $orderByValue = 'ASC')
    {
        if (empty($this->dbConnection)) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
            error_log("DB Connection Error: " . " \n" . __METHOD__ .  " \n Line: " .
                __LINE__, 3, $errorLogPath);
           throw new \Exception('Could not connect with database.');
        }

        try {
            $dbFieldNames = $this->getDbFieldNames();

        } catch (\Exception $e) {
            throw $e;

        }

        $sql = "SELECT $dbFieldNames
            FROM " . DB_FORM_TABLE . "
            ORDER BY `$orderBy` $orderByValue;";

        try {
            return $this->selectQuery($sql);

        } catch(\Exception $e) {
            throw $e;

        }

    }

    /**
     * returns array of column names
     * getting all the field names to build the form
     * @param $dbConnection
     * @return mixed
     * @throws \Exception
     */
    protected function getDbFieldNames(){
        if (empty($this->dbConnection)) {
            throw new \Exception('Could not connect with database.');
        }

        $query = '
            SELECT `COLUMN_NAME`
            FROM `INFORMATION_SCHEMA`.`COLUMNS`
            WHERE `TABLE_SCHEMA` = \'' .  DB_NAME . '\'
            AND `TABLE_NAME`= \'' . DB_FORM_TABLE . '\';
        ';

        try {
            $columnArray = $this->selectQuery($query);

        } catch(\Exception $e) {
            throw $e;

        }

        $columnName = '';
        foreach ($columnArray as $columnIndex => $columnValue) {
           foreach($columnValue as $fieldName => $fieldValue) {
                if ($fieldName === 'COLUMN_NAME') {
                    $columnName .=  ' `'. htmlentities($fieldValue) . "`,";
                }
           }
        }

        return trim($columnName, ' ,');

    }

    /**
     * does the DB insert of form data
     * @param $dbConnection
     * @param $formData
     * @return mixed
     * @throws \Exception
     */
    protected function insertFieldsIntoDb($formData)
    {
        if (empty($this->dbConnection)) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
            error_log("DB Error: not connect with database. " .
                __METHOD__ .  " \n" . __LINE__, 3, $errorLogPath);
            throw new \Exception('Could not connect with database.');
        }

        //parse form data
        $sqlFields = array_keys($formData);
        $sqlFieldData = array_values($formData);

        if (count($sqlFields) !== count($sqlFieldData)) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
            error_log("Form Integrity Error: " . " \n" . __METHOD__ .  " \n Line: " .
                __LINE__, 3, $errorLogPath);
            throw new \Exception('Form Error: number of elements in form do not match.');
        }

        $numFields = count($sqlFieldData);

        $preparedValues = $this->pdoPrepParams($numFields);

        //string required for SQL query field names
        $sqlFields = implode(', ', $sqlFields);

        date_default_timezone_set('UTC');

        //store 'added' field is a timestamp in UTC when this is executed
        try {
            $sql = "
                INSERT INTO " . DB_FORM_DATA . "($sqlFields, added)
                VALUES ($preparedValues, ?);
            ";

            $query = $this->dbConnection->prepare($sql);
            array_push($sqlFieldData, time());
            $pdoResult = $query->execute($sqlFieldData);

            return $pdoResult;

        } catch(\Exception $e) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
            error_log("DB Insert Error: " . $e->getMessage() . " \n" . __METHOD__ .  " \n Line: " .
                __LINE__, 3, $errorLogPath);
            throw new \Exception("DB Error: $e->getMessage()");

        }

    }

    /**
     * method meant to save some code / reuse
     * @param $dbh
     * @param $query
     * @return mixed
     * @throws \Exception
     */
    protected function selectQuery($sqlQuery)
    {
        try {
            $query = $this->dbConnection->prepare($sqlQuery);
            $query->execute();
            $result = $query->fetchAll();

            return $result;

        } catch (\Exception $e) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
                error_log("DB Query Error: " . $e->getMessage() . " \n" . __METHOD__ .  " \n Line: " .
                    __LINE__, 3, $errorLogPath);
            throw new \Exception("DB Error: $e->getMessage()");

        }

    }

    /**
     * @param $numFields
     * @return string
     */
    protected function pdoPrepParams($numFields)
    {
        $preparedValues = '?';
        for ($i = 1; $i < $numFields; $i++) {
            $preparedValues .= ', ?';
        }

        return $preparedValues;
    }

}
