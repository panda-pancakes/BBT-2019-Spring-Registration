<?php
require_once("config.php");

$con = new mysqli('localhost', 'root', '', 'registration');
if ($con->connect_error) {
	echo("<b>Failed to access database: </b>" . $con->connect_error);

} else {
	$con->query("CREATE TABLE `" . DB_NAME . "`.`application` ( `name` TEXT NOT NULL , `sex` CHAR NOT NULL , `tel` TEXT NOT NULL , `grade` INT NOT NULL , `college` INT NOT NULL , `dorm` TEXT NULL , `department` INT NOT NULL , `alternative` INT NULL , `adjustment` BOOLEAN NOT NULL , `introduction` TEXT NULL , `timestamp` TIMESTAMP NOT NULL , `information` TEXT NULL , `note` TEXT NULL ) ENGINE = InnoDB;");

	$con->query("CREATE TABLE `" . DB_NAME . "`.`admin` ( `username` TEXT NOT NULL , `password` TEXT NOT NULL , `permission` INT NOT NULL ) ENGINE = InnoDB;");

	/* TO-DO: 建立默认的管理员账号 */

	echo("<b>done.</b>");
}
