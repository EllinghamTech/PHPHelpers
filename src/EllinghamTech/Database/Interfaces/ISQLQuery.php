<?php
namespace EllinghamTech\Database\Interfaces;

interface ISQLQuery
{
	public function __construct($parent, $query);
	public function bindValue($name, $value, $type='string');
	public function execute($values=null);
}