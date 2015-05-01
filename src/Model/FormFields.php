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
     * purpose: to get form fields from database
     * @return mixed
     * @throws \Exception
     * @todo: add caching
     */
    public function get($fieldName = null)
    {
        try {
            return $this->getAllFields($this->dbConnection);

        } catch(\Exception $e) {
            throw $e;

        }

    }

    /**
     * @param $dbConnection
     * @return mixed
     * @throws \Exception
     */
    protected function getAllFields($dbConnection)
    {
        if (empty($dbConnection)) {
           throw new \Exception('Could not connect with database.');
        }

        try {
            $dbFieldNames = self::getDbFieldNames($dbConnection);

        } catch (\Exception $e) {
            throw $e;

        }

        $sql = "SELECT $dbFieldNames
            FROM " . DB_FORM_TABLE . "
            ORDER BY `order` ASC";

        try {
            return self::selectQuery($dbConnection, $sql);

        } catch(\Exception $e) {
            throw $e;

        }

    }

    protected static function getField($field)
    {
        if (empty($dbh)) {
            throw new \Exception('Could not connect with database.');
        }

        $sql = "SELECT $field
        FROM " . DB_FORM_TABLE . "
        ORDER BY `order` ASC";

        try {
            return self::selectQuery($dbh, $sql);

        } catch(\Exception $e) {
            throw $e;

        }

    }

    /**
     * @param $fieldArray
     * @return mixed
     * @throws \Exception
     */
    public static function writeFields($fieldArray)
    {
        $dbh = null;
        try {
            $dbh = self::dbConnect();
            return self::insertFieldsIntoDb($dbh, $fieldArray);

        } catch(\Exception $e) {
            throw $e;
        }

    }

    /**
     * returns array of column names
     * intended for getting all the field names to build the form
     * @param $dbh
     * @return mixed
     * @throws \Exception
     */
    protected static function getDbFieldNames($dbh){
        if (empty($dbh)) {
            throw new \Exception('Could not connect with database.');
        }

        $query = '
            SELECT `COLUMN_NAME`
            FROM `INFORMATION_SCHEMA`.`COLUMNS`
            WHERE `TABLE_SCHEMA` = \'' .  DB_NAME . '\'
            AND `TABLE_NAME`= \'' . DB_FORM_TABLE . '\';
        ';

        try {
            $columnArray = self::selectQuery($dbh, $query);

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
     * @param $dbh
     * @param $formData
     * @return mixed
     * @throws \Exception
     * @TODO refactor out methods, simplify
     */
    protected static function insertFieldsIntoDb($dbh, $formData)
    {
        if (empty($dbh)) {
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

        try {
            $sql = "
                INSERT INTO " . DB_FORM_DATA . "($sqlFields, added)
                VALUES ($preparedValues, ?);
            ";

            $query = $dbh->prepare($sql);
            array_push($sqlFieldData, time());
            $pdoResult = $query->execute($sqlFieldData);
            $dbh = null;

            return $pdoResult;

        } catch(\Exception $e) {
            throw new \Exception("DB Error: $e->getMessage()");

        }

    }

    /**
     * method meant to save some code / reuse
     * @param $dbh
     * @param $sql
     * @return mixed
     * @throws \Exception
     */
    protected static function selectQuery($dbh, $sql)
    {
        try {
            $query = $dbh->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $dbh = null;

            return $result;

        } catch (\Exception $e) {
            error_log("DB Query Error: " . $e->getMessage(), 3, "../errorLog.txt");
            throw new \Exception("DB Error: $e->getMessage()");

        }

    }

}
