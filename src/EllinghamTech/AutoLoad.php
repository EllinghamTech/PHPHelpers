<?php
/**
 * Very simple custom autoloader.
 *
 * Just include this file and it will AutoLoad the classes
 * as necessary.
 *
 * @package EllinghamTech
 */


namespace EllinghamTech;

class AutoLoad
{
	/**
	 * If the class can be found, requires the file containing the class.
	 *
	 * This function exists to be within the EllinghamTech/ sources directory and
	 * exists className/Namespaces to match the file name.
	 *
	 * @param string $className Fully qualified namespace provided by sql_autoload function
	 */
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