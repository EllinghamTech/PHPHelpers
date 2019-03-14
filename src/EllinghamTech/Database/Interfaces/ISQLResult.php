<?php
namespace EllinghamTech\Database\Interfaces;

interface ISQLResult
{
	public function __construct($pdo_result, $success=null, $insert_id=null);
	public function numRows();
	public function fetchArray();
	public function errorInfo();
	public function isSuccess();
	public function insertId();
}