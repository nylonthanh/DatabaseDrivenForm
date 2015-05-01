<?php

namespace Cleanify\Model;

require_once(realpath(dirname(__FILE__) . '/../..') . '/config/config.php');

/**
 * Class DbConnection
 * @package Cleanify\Model
 */
class DbConnection implements ConnectionInterface
{
    /**
     * @return \PDO
     * @throws \Exception
     */
    public function connect()
    {
        try {
            $dbh = new \PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $dbh;

        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage(), 3, "../errorLog.txt");
            throw new \Exception("DB Error: Connection failed: " . $e->getMessage());

        }

    }

}