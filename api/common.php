<?php
$functionRegistry = array();
$checkerRegistry = array();

function registerMethod($method, $func, $para) {
	$functionRegistry[$method] = array(
		'parameter' => $para,
		'function' => $func
	);
}

function registerChecker($name, $func) {
	$checkerRegistry[$name] = $func;
}

function process($method, $data) {
	$ret = new stdClass();
	
	if (!isset($_GET["method"])) {
		$ret->errcode = 400;
		$ret->errmsg = "Missing method";
		
	} elseif (!isset($functionRegistry[$_GET["method"]])) {
		$ret->errcode = 404;
		$ret->errmsg = "Unregistered method";	
		
	} else {
		$parameterList = $functionRegistry[$_GET["method"]]["parameter"];
		$targetFunction = $functionRegistry[$_GET["method"]]["function"];
		$argument = array();
		if (isset($parameterList["required"])) {
			foreach ($parameterList["required"] as $parameter) {
				if (!isset($data[$parameter])) {
					$ret->errcode = 400;
					$ret->errmsg = "Missing parameter: " . $parameter;	
				} else {
					$argument[$parameter] = $data[$parameter];
				}
			}
		}
		if (isset($parameterList["optional"])) {
			foreach ($parameterList["optional"] as $parameter) {
				if (isset($data[$parameter])) {
					$argument[$parameter] = $data[$parameter];
				}
			}
		}
		foreach ($argument as $arg => $value) {
			if (isset($checkerRegistry[$arg])) {		
				if (!$checkerRegistry[$arg]($value)) {
					$ret->errcode = 400;
					$ret->errmsg = "Illegal parameter: " . $arg;
				}
			}
		}
		if (!isset($ret->errcode)) {
			$ret = $targetFunction($argument);
		}
	}
	
	$ret->status = isset($ret->errcode) ? "failed" : "ok";
	
	return $ret;
}