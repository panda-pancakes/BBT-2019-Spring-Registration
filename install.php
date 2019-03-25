<?php
require_once("config.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($con->connect_error) {
	echo("<b>Failed to access database: </b>" . $con->connect_error);

} else {
	$con->query("CREATE TABLE `" . DB_NAME . "`.`application` ( `name` VARCHAR(20) NOT NULL , `sex` CHAR NOT NULL , `tel` VARCHAR(15) NOT NULL , `grade` INT NOT NULL , `college` INT NOT NULL , `dorm` VARCHAR(10) NULL , `department` INT NOT NULL , `alternative` INT NULL , `adjustment` VARCHAR(2) NOT NULL , `introduction` VARCHAR(255) NULL , `timestamp` TIMESTAMP NOT NULL , `information` VARCHAR(255) NULL , `note` VARCHAR(255) NULL ) ENGINE = InnoDB CHARSET=utf8;");

	$con->query("CREATE TABLE `" . DB_NAME . "`.`admin` ( `username` VARCHAR NOT NULL , `password` VARCHAR NOT NULL , `permission` INT NOT NULL ) ENGINE = InnoDB;");

	/* TO-DO: 建立默认的管理员账号 */

	echo("<b>done.</b>");
}
