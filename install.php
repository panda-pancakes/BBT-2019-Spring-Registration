<?php
require_once("config.php");

$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($con->connect_error) {
	echo("<b>Failed to access database: </b>" . $con->connect_error);

} else {
	$con->query("CREATE TABLE `" . DB_NAME . "`.`Attendee` ( `name` TEXT NOT NULL , `phone` TEXT NOT NULL , `grade` INT NOT NULL , `college` INT NOT NULL , `dorm` TEXT NOT NULL , `ChoiceOne` INT NOT NULL , `ChoiceTwo` INT NOT NULL , `adjust` BOOLEAN NOT NULL , `introduction` TEXT NOT NULL , `info` TEXT NOT NULL , `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB;");

	$con->close();

	echo("<b>done.</b>");
}
