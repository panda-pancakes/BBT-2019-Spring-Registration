<?php
header("Content-Type: application/json");

include("database.php");

session_start();

$ret = new StdClass();

if (!isset($_GET["method"])) {
	$ret->errmsg = "Missing parameter: method";

} elseif ($_GET["method"] == "signup") {
	if (!isset($_POST["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (!isset($_POST["phone"])) {
		$ret->errmsg = "Missing parameter: phone";
		// check 

	}
	/* elseif (!isset($_POST["grade"])) {
		$ret->errmsg = "Missing parameter: grade";
		// check 

	} */elseif (!isset($_POST["college"])) {
		$ret->errmsg = "Missing parameter: college";
		// check 

	} //elseif (!isset($_POST["dorm"])) {
		//ret->errmsg = "Missing parameter: dorm";
		// check 

	//}
	 elseif (!isset($_POST["choiceOne"])) {
		$ret->errmsg = "Missing parameter: choiceOne";
		// check 

	} elseif (!isset($_POST["choiceTwo"])) {
		$ret->errmsg = "Missing parameter: choiceTwo";
		// check 

	} elseif (!isset($_POST["adjust"])) {
		$ret->errmsg = "Missing parameter: adjust";
		// check 

	} elseif (!isset($_POST["introduction"])) {
		$ret->errmsg = "Missing parameter: introduction";

	} else {
		$info = array(
			"name" => $_POST["name"],
			"phone" => $_POST["phone"],
			//"grade" => $_POST["grade"],
			"college" => $_POST["college"],
			//"dorm" => $_POST["dorm"],
			"choiceOne" => $_POST["choiceOne"],
			"choiceTwo" => $_POST["choiceTwo"],
			"adjust" => $_POST["adjust"],
			"introduction" => $_POST["introduction"],
		);

		$sta = signup($info, $_POST["cover"]);

		if ($sta == -1) {
			$ret->errmsg = "existed";
		} elseif ($sta == -2) {
			$ret->errmsg = "database issue";
		}
	}

} elseif ($_GET["method"] == "query") {
	if (!isset($_POST["name"])) {
		$ret->errmsg = "Missing parameter: name";

	} elseif (!isset($_POST["phone"])) {
		$ret->errmsg = "Missing parameter: phone";
		// check 
	} else {
		$sta = query($info);
		if ($sta == -2) {
			$ret->errmsg = "database issue";
		} else {
			$ret->exist = isset($sta->name);
			if ($ret->exist) {
				$ret->info = $sta->info;
			}
		}
	}
	
} elseif ($_GET["method"] == "admin_login") {

} elseif ($_GET["method"] == "admin_query") {

} else {
	$ret->errmsg = "Unspecified Method";
}

$ret->status = isset($ret->errmsg) ? "failed" : "ok";

echo json_encode($ret);