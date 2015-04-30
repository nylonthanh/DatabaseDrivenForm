<?php

namespace Cleanify\Model;

use Cleanify\Controller\SanitizeData;

require_once(realpath(dirname(__FILE__) . '/../..') . '/config/config.php');
/**
 * page class Controller
 * @todo: refactor methods to be more reusable - get getall, etc
 */
class FormFields
{
    /**
     * purpose: to get form fields from database
     * @return mixed
     * @throws \Exception
     * @todo: add caching
     */
    public static function get($fieldName = null)
    {
//        if ($cached) {
//            return $cached;
//        }

        $dbh = null;
        try {
            $dbh = self::dbConnect();
            return self::getAllFields($dbh);

        } catch(\Exception $e) {
            throw $e;
        }

    }

    protected static function dbConnect()
    {
        try {
            $dbh = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $dbh;

        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage(), 3, "../errorLog.txt");
            throw new Exception("DB Error: Connection failed: " . $e->getMessage());
        }

    }

    /**
     * @param $dbh
     * @return mixed
     * @throws Exception
     */
    protected static function getAllFields($dbh)
    {
        if (empty($dbh)) {
           throw new Exception('Could not connect with database.');
        }

        try {
            $dbFieldNames = self::getDbFieldNames($dbh);

        } catch (\Exception $e) {
            throw $e;

        }

        $sql = "SELECT $dbFieldNames
            FROM " . DB_FORM_TABLE . "
            ORDER BY `order` ASC";

        try {
            return self::selectQuery($dbh, $sql);

        } catch(Exception $e) {
            throw $e;

        }

    }

    protected static function getField($field)
    {
        if (empty($dbh)) {
            throw new Exception('Could not connect with database.');
        }

        $sql = "SELECT $field
        FROM " . DB_FORM_TABLE . "
        ORDER BY `order` ASC";

        try {
            return self::selectQuery($dbh, $sql);

        } catch(Exception $e) {
            throw $e;

        }

    }

    /**
     * @param $fieldArray
     * @return mixed
     * @throws \Exception
     * @todo make protected and have a controller make it callable
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
                    $columnName .= " `$fieldValue`,";
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

        } catch(Exception $e) {
            throw new \Exception("DB Error: $e->getMessage()");

        }
    }

    /**
     * method meant to save some code / reuse
     * @param $dbh
     * @param $sql
     * @return mixed
     * @throws Exception
     */
    protected static function selectQuery($dbh, $sql)
    {
        try {
            $query = $dbh->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $dbh = null;

            return $result;

        } catch (Exception $e) {
            error_log("DB Query Error: " . $e->getMessage(), 3, "../errorLog.txt");
            throw new Exception("DB Error: $e->getMessage()");

        }
    }
}
