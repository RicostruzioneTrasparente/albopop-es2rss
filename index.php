<?php

# Constants
define('PARAM_FORMAT', 'format');
define('DEFAULT_FORMAT', 'rss');
define('PARAM_SEARCH', 'q');
define('DEFAULT_SEARCH', '');
define('PARAM_SOURCE', 'source');
define('DEFAULT_SOURCE', '');
define('PARAM_FILTER', 'filter');
define('DEFAULT_FILTER', '');
define('PARAM_FROM', 'from');
define('DEFAULT_FROM', 0);
define('PARAM_SIZE', 'size');
define('DEFAULT_SIZE', 25);

# Customization by GET params
$format = isset($_GET[PARAM_FORMAT]) ? $_GET[PARAM_FORMAT] : DEFAULT_FORMAT;
$search = isset($_GET[PARAM_SEARCH]) ? $_GET[PARAM_SEARCH] : DEFAULT_SEARCH;
$source = isset($_GET[PARAM_SOURCE]) ? $_GET[PARAM_SOURCE] : DEFAULT_SOURCE;
$filter = isset($_GET[PARAM_FILTER]) ? $_GET[PARAM_FILTER] : DEFAULT_FILTER;
$from = (isset($_GET[PARAM_FROM]) and is_numeric($_GET[PARAM_FROM])) ? (int)$_GET[PARAM_FROM] : DEFAULT_FROM;
$size = (isset($_GET[PARAM_SIZE]) and is_numeric($_GET[PARAM_SIZE])) ? (int)$_GET[PARAM_SIZE] : DEFAULT_SIZE;

require __DIR__ . '/fromes.inc.php';

switch($format) {
	case 'json':
		require __DIR__ . '/tojson.inc.php';
		header('Content-type: application/json');
		echo toJson(fromEs($search,$filter,$source,$from,$size));
		break;
	case 'rss':
	default:
		require __DIR__ . '/torss.inc.php';
		header('Content-type: application/rss+xml');
		echo toRss(fromEs($search,$filter,$source,$from,$size),$filter);
		break;
}

?>
