<?php

namespace Cleanify\Model;
require_once '../../config/config.php';
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
        //return get data from db
        //connect to db
        $dbh = '';
        try {
            $dbh = self::dbConnect();
            return self::dbQuery($dbh);

        } catch(Exception $e) {
            throw new Exception('DB Error: unable to connect: ' . $e->getMessage());
        }

    }

    protected function dbConnect()
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
    protected function dbQuery($dbh)
    {
        if (empty($dbh)) {
           throw new Exception('Could not connect with database.');
        }

        try {
            $query= $dbh->prepare("
            SELECT field_name, field_value, input_type, filter_sanatize_type, required
            FROM submission_form_contents
            ORDER BY `order` ASC;
        ");
            $query->execute();
            $result = $query->fetchAll();
            $dbh = null;

            return $result;

        } catch(Exception $e) {
            throw new Exception("DB Error: $e->getMessage()");

        }

    }
}
