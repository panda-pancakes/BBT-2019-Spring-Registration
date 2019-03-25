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