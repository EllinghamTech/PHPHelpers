<?php
require('../../src/EllinghamTech/AutoLoad.php');
require('../config.php');

$database = new EllinghamTech\Database\SQL\Wrapper();
try
{
	$database->MySQLConnect(ELLINGHAM_DB_HOST, ELLINGHAM_DB_USER, ELLINGHAM_DB_PASS, ELLINGHAM_DB_NAME);
}
catch (Exception $e)
{
	die($e->getMessage());
}

// Create debug_keystore table
$sql = 'CREATE TABLE IF NOT EXISTS debug_keystore (`key` VARCHAR(100) PRIMARY KEY, `value` VARCHAR(100))';

try
{
	$database->performQuery($sql);
}
catch(Exception $e)
{
	die('FAILED TO CREATE debug_keystore TABLE: '.$e->getMessage());
}

echo 'Success';