<?php
require_once("../config.php");

function query($info) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
	if ($con->connect_error) {
		return -2;
	}

	$sql = "select name, phone, info from Attendee where name = ? && phone = ?";

	$ret = new StdClass();

	$con->prepare($sql);
	$stmt->bind_param("ss", $info->name, $info->phone);
	$stmt->execute();
	$stmt->bind_result($ret->name, $ret->phone, $ret->info);
	$stmt->fetch();
	$stmt->close();
	$con->close();

	return $ret;
}

function signup($info, $cover) {
	$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if ($con->connect_error) {
		return -2;
	}

	$q = query($info);

	if (isset($q->name)) {
		if ($cover) {
			$sql1 = "update Attendee set grade = ?, college = ?, dorm = ?, ChoiceOne = ?, ChoiceTwo = ?, adjust = ?, introduction = ? where name = ? && phone = ?";
			$stmt1 = $con->prepare();
			$stmt1->bind_param("sssssssss", $info->grade, $info->college, $info->dorm, $info->ChoiceOne, $info->ChoiceTwo, $info->adjust, $info->introduction, $info->name, $info->phone);
			$stmt1->execute();
			$stmt1->close();
		} else {
			$con->close();
			return -1;
		}
	} else {
		$sql1 = "insert into Attendee (name, phone, grade, college, dorm, ChoiceOne, ChoiceTwo, adjust, introduction) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt1 = $con->prepare();
		$stmt1->bind_param("sssssssss", $info->name, $info->grade, $info->college, $info->dorm, $info->ChoiceOne, $info->ChoiceTwo, $info->adjust, $info->introduction);
		$stmt1->execute();
		$stmt1->close();
	}
	$con->close();

	// TODO: check if success

	return 0;
}
?>