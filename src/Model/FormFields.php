<?php

namespace Cleanify\Model;

use Cleanify\Controller\SanitizeData;

require_once(realpath(dirname(__FILE__) . '/../..') . '/config/config.php');
/**
 * page class Controller
 */
class FormFields
{
    /**
     * purpose: to get form fields from database
     */
    public static function get()
    {
        $dbh = null;
        try {
            $dbh = self::dbConnect();
            return self::dbQuery($dbh);

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
    protected static function dbQuery($dbh)
    {
        if (empty($dbh)) {
           throw new Exception('Could not connect with database.');
        }

        $sql = 'SELECT field_name, field_value, input_type, filter_sanatize_type, required
            FROM submission_form_contents
            ORDER BY `order` ASC';

        try {
            $query= $dbh->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $dbh = null;

            return $result;

        } catch(Exception $e) {
            error_log("DB Query Error: " . $e->getMessage(), 3, "../errorLog.txt");
            throw new Exception("DB Error: $e->getMessage()");

        }

    }

    public static function writeFieldsToDb($fieldArray){
        $dbh = null;
        try {
            $dbh = self::dbConnect();
            return self::insertFieldsIntoDb($dbh, $fieldArray);

        } catch(Exception $e) {
            throw $e;
        }
    }

    protected static function insertFieldsIntoDb($dbh, $formData){
        if (empty($dbh)) {
            $errorLogPath = realpath(dirname(__FILE__) . '/../..') . '/config/errorLog.txt';
            error_log("DB Error: not connect with database. " .
                __METHOD__ .  " \n" . __LINE__, 3, $errorLogPath);
            throw new Exception('Could not connect with database.');
        }

        $sqlFields = array_keys($formData);
        $sqlFieldData = array_values($formData);

        if (count($sqlFields) !== count($sqlFieldData)) {
            throw new \Exception('Form Error: number of elements in form do not match.');
        }

        $numFields = count($sqlFieldData);

        try {
            SanitizeData::checkRequired($sqlFields, $sqlFieldData, $numFields);

        } catch(\Exception $e)  {
            throw $e;
        }

        $preparedValues = '?';
        for($i = 1; $i < $numFields; $i++) {
            $preparedValues .= ', ?';
        }

        //need string for SQL query field names
        $sqlFields = implode(', ', $sqlFields);

        try {
            $sql = "
                INSERT INTO submission_data ($sqlFields)
                VALUES ($preparedValues);
            ";

            $query = $dbh->prepare($sql);
            $pdoResult = $query->execute($sqlFieldData);
            $dbh = null;

            return $pdoResult;

        } catch(Exception $e) {
            throw Exception("DB Error: $e->getMessage()");

        }
    }
}
