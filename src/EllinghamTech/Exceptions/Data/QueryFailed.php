<?php
namespace EllinghamTech\Exceptions\Data;

use Throwable;

class QueryFailed extends \Exception
{
	public $query_string = null;

	public function __construct($query_string, $message = '', $code = 0, Throwable $previous = null)
	{
		$this->query_string = $query_string;

		parent::__construct($message, $code, $previous);
	}
};
