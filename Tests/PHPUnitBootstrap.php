<?php
namespace EllinghamTech;

require('../config.php');

class TestsAutoLoad
{
	public static function load($className)
	{
		$className = str_replace('\\', '/', $className);
		$filename = '../../'.$className.'.php';

		if (file_exists($filename)) require($filename);
	}
}

spl_autoload_register(__NAMESPACE__.'\TestsAutoLoad::load');