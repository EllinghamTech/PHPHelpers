<?php
namespace EllinghamTech\Exceptions\Data;

use EllinghamTech\Database\SQL\Wrapper;
use Throwable;

final class QueryFailed extends \Exception
{
	private $query_string = null;
	private $database_type = null;

	public function __construct(?string $query_string, ?Wrapper $wrapper=null, $message = '', $code = 0, Throwable $previous = null)
	{
		$this->query_string = $query_string;

		if($wrapper !== null)
		{
			$this->database_type = $wrapper->database_type;
		}

		parent::__construct($message, $code, $previous);
	}

	public function getQueryString() : ?string
	{
		return $this->query_string;
	}

	public function getDatabaseType() : ?string
	{
		return $this->database_type;
	}
};
