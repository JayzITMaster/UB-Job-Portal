<?php

define("DBHOST", isset($_ENV["DBHOST"]) ? $_ENV["DBHOST"]: "127.0.0.1");
define("DBUSER", isset($_ENV["DBUSER"]) ? $_ENV["DBUSER"]: "root");
define("DBPWD", isset($_ENV["DBPWD"]) ? $_ENV["DBPWD"]: "");
define("DBNAME", isset($_ENV["DBNAME"]) ? $_ENV["DBNAME"]: "ub_job");
define('ENVIRONMENT', 'development');