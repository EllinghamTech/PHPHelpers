<?php
namespace EllinghamTech;

class AutoLoad
{
	public static function load($className)
	{
		$className = explode('\\', $className);
		array_shift($className);
		$className = implode('/', $className);

		if (file_exists(__DIR__ .'/'.$className.'.php')) require(__DIR__ .'/'.$className.'.php');
		else if (file_exists($className.'.php')) require($className.'.php');
	}
}

spl_autoload_register(__NAMESPACE__.'\AutoLoad::load');