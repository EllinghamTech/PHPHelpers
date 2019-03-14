<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../../src/EllinghamTech/AutoLoad.php');

try
{
	$session = new EllinghamTech\Session\NoLogin();

	if(is_object($session))
		echo 'passed';
}
catch(Exception $e)
{
	echo $e->getMessage();
}