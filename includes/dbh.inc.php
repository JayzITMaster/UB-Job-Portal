<?php

include_once "env.inc.php";
include_once "logger.inc.php";

class SQLHandler extends Logger{
    public $sqlDB;
    public $log;

    function __construct() {
        $this->log = New Logger();
        // Initialize the database connection
        try {
            $this->sqlDB = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);
            if ($this->sqlDB->connect_errno) {
                $this->error("Error connecting to MySQL. ERROR: [" . $this->sqlDB->connect_error . "]");
                $this->sqlDB = null;
            }else{
                $this->info(__METHOD__ . " database connected");
            }
        } catch (Exception $e) {
            $this->error("Error initializing database connection: " . $e->getMessage());
            $this->sqlDB = null;
        }
    }

    function __destruct() {
        if ($this->sqlDB !== null) {
            $this->sqlDB->close();
        }
    }
}