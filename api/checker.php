<?php
registerChecker("name", function($var) {
	return !preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $var);
});

registerChecker("tel", function($var) {
	return is_numeric($var) && $var[0] == 1 && strlen($var) == 11;
});

registerChecker("sex", function($var) {
 	return $var === "M" or $var === "F";
});

registerChecker("department", function($var) {
 	return is_numeric($var) && $var >= 1 && $var <= 21;
});

registerChecker("alternative", function($var) {
 	return is_numeric($var) && $var >= 0 && $var <= 21;
});

registerChecker("college", function($var) {
 	return is_numeric($var) && $var >= 1 && $var <= 28;
});

registerChecker("dorm", function($var){
 	return ($var[0] == 'C' || $var[0] == 'c') && strlen($var) >= 5 && strlen($var) <= 9;
});

registerChecker("adjustment", function($var) {
 	return $var === true || $var === false;
});
