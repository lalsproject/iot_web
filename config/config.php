<?php 

$DB_SETTING = array(
	'HOST' => 'localhost', 
	'USERNAME' => 'root', 
	'PASSWORD' => 'ic@12345', 
	'DATABASE' => 'db_iot',
);

$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

$config['site_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['site_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['site_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);