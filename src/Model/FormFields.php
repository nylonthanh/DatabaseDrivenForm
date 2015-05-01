<?php

namespace Cleanify\Model;

/**
 * Class FormFields
 * @package Cleanify\Model
 */
class FormFields
{
    protected $dbConnection;

    public function __construct (ConnectionInterface $dbConnection){
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

        if ($_fieldName === null) {
            try {
                return $this->getAllFields($this->dbConnection);

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
     * @param $field
     * @return mixed
     * @throws \Exception
     */
    protected function getField($field)
    {
        if (empty($this->dbConnection)) {
            throw new \Exception('Could not connect with database.');
        }

        $sql = "SELECT $field
        FROM " . DB_FORM_TABLE . "
        ORDER BY `order` ASC";

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
    protected function getAllFields($dbConnection, $orderBy = 'order', $orderByValue = 'ASC')
    {
        if (empty($dbConnection)) {
           throw new \Exception('Could not connect with database.');
        }

        try {
            $dbFieldNames = $this->getDbFieldNames();

        } catch (\Exception $e) {
            throw $e;

        }

        $sql = "SELECT $dbFieldNames
            FROM " . DB_FORM_TABLE . "
            ORDER BY `$orderBy` $orderByValue";

        try {
            return $this->selectQuery($sql);

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
     * @TODO refactor out methods, simplify
     */
    protected function insertFieldsIntoDb($formData)
    {
        if (empty($this->dbConnection)) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
            error_log("DB Error: not connect with database. " .
                __METHOD__ .  " \n" . __LINE__, 3, $errorLogPath);
            throw new \Exception('Could not connect with database.');
        }

        $sqlFields = array_keys($formData);
        $sqlFieldData = array_values($formData);

        if (count($sqlFields) !== count($sqlFieldData)) {
            throw new \Exception('Form Error: number of elements in form do not match.');
        }

        $numFields = count($sqlFieldData);

        $preparedValues = '?';
        for($i = 1; $i < $numFields; $i++) {
            $preparedValues .= ', ?';
        }

        //need string for SQL query field names
        $sqlFields = implode(', ', $sqlFields);

        date_default_timezone_set('UTC');

        //added field is a timestamp in UTC when this is executed
        try {
            $sql = "
                INSERT INTO " . DB_FORM_DATA . "($sqlFields, added)
                VALUES ($preparedValues, ?);
            ";

            $query = $this->dbConnection->prepare($sql);
            array_push($sqlFieldData, time());
            $pdoResult = $query->execute($sqlFieldData);
            $this->dbConnection = null;

            return $pdoResult;

        } catch(\Exception $e) {
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
    protected function selectQuery($query)
    {
        try {
            $query = $this->dbConnection->prepare($query);
            $query->execute();
            $result = $query->fetchAll();
            $this->dbConnection = null;

            return $result;

        } catch (\Exception $e) {
            error_log("DB Query Error: " . $e->getMessage(), 3, "../errorLog.txt");
            throw new \Exception("DB Error: $e->getMessage()");

        }

    }

}
