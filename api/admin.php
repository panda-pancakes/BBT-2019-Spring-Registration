<?php
require_once("database.php");

function onAdminLogin($arg) {
	$ret = new stdClass();
	
	$status = admin_login($arg["department"], $arg["password"]);

	if ($status >= 0) {
		$_SESSION["department"] = $arg["department"];
		$_SESSION["permission"] = $status;
		$ret->errcode = 0;
	} elseif ($status == -2) {
		$ret->errcode = 500;
		$ret->errmsg = "Database issue";
	} else {
		$ret->errcode = 403;
		$ret->errmsg = "Either this account doesn't exist or the password is incorrect.";
	}
	
	return $ret;
}

function onAdminQuery($arg) {
	$ret = new stdClass();
	
	if (isset($_SESSION["permission"])) {
		$ret->permission = $_SESSION['permission'];
		$ret->data = admin_query($_SESSION["permission"]);
		$ret->sum = count((array)$ret->data);
		
	} else {
		$ret->errcode = 401;
		$ret->errmsg = "Please login first";
	}
	
	return $ret;
}

function onChangeQuery($arg){
	$ret = new stdClass();

	if(isset($_GET["value"])){
		$ret->data = change_department($_GET["value"]);
		$ret->sum = count((array)$ret->data);
	} else {
		$ret->errcode = 403;
		$ret->errmsg = "The department isn't exist.";
	};
}

registerMethod("admin_login", "onAdminLogin", array(
	"required" => array("department", "password")
));

registerMethod("admin_query", "onAdminQuery", array(
	"optional" => array("department")
));

registerMethod("change_department", "onChangeQuery",array(
	"optional" => array("department")
));

/*
} elseif ($_GET["method"] == "admin_login") {
	if (empty($_POST["department"])) {
		$ret->errmsg = "Missing parameter: department";
	} elseif (empty($_POST["password"])) {
		$ret->errmsg = "Missing parameter: password";
	} elseif (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $_POST['department'])) {
		$ret->errmsg = "It's not allowed to use special characters in username.";
	} else {
	}
} elseif ($_GET["method"] == "admin_query") {
	if (isset($_SESSION["permission"])) {
		$ret->permission = $_SESSION['permission'];
		$ret->data = admin_query($_SESSION["permission"]);
		$ret->sum = count((array)$ret->data);
	} else {
		$ret->errcode = -1;
		$ret->errmsg = "Please login first";
	}
} elseif ($_GET['method'] == "change_department") {
	if (!isset($_GET['value'])) {
		$ret->errmsg = "Please select the department.";
	} elseif ($_GET['value'] == 666) {
		$ret->data = admin_query($_SESSION["permission"]);
		$ret->sum = count((array)$ret->data);
	} else {
		$ret->data = change_department($_GET['value']);
		$ret->sum = count((array)$ret->data);
	}
} else {
	$ret->errcode = -1;
	$ret->errmsg = "Unspecified Method";
}

$ret->status = isset($ret->errmsg) ? "failed" : "ok";

echo json_encode($ret);
*/
