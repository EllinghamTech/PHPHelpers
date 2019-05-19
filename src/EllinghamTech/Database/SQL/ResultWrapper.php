<?php
namespace EllinghamTech\Database\SQL;

final class ResultWrapper
{
	/** @var \PDOStatement Result */
	protected $result;

	/** @var bool Query Success */
	protected $success;

	/** @var int After an insert query, this holds the value of the primary key using auto increment */
	protected $insert_id;

	/**
	 * Set-up the instance
	 *
	 * @param \PDOStatement $pdo_result The PDO Statement object
	 * @param bool|null $success
	 * @param mixed $insert_id
	 */
	public function __construct(\PDOStatement $pdo_result, ?bool $success=null, $insert_id=null)
	{
		$this->result = $pdo_result;
		$this->success = $success;
		$this->insert_id = $insert_id;
	}

	/**
	 * Returns the number of rows affected
	 *
	 * @return int
	 */
	public function numRows() : int
	{
		return $this->result->rowCount();
	}

	/**
	 * Fetches the next row and returns it as associative array.
	 *
	 * @return array|null
	 */
	public function fetchArray() : ?array
	{
		$arr = $this->result->fetch(\PDO::FETCH_ASSOC);

		if(!is_array($arr)) return null;

		return $arr;
	}

	/**
	 * Fetches the next row and returns it as an object.
	 *
	 * Fetches the next row and returns it as an object.  If a class name
	 * is specified, the object returned will be an instance of the specified
	 * class populated with data from columns matching property names.
	 *
	 * Protected and private properties are affected just like public properties.
	 *
	 * The constructor is called AFTER properties have been set.
	 *
	 * Will return NULL on failure.
	 *
	 * @param string $class_name
	 * @param array $constructor_args
	 *
	 * @return object|null
	 */
	public function fetchObject(string $class_name = 'stdClass', array $constructor_args = array())
	{
		$obj = $this->result->fetchObject($class_name, $constructor_args);

		if($obj === false) return null;
		else return $obj;
	}

	/**
	 * Returns error details
	 *
	 * @return array
	 */
	public function errorInfo() : array
	{
		return $this->result->errorInfo();
	}

	/**
	 * Returns true if this instance represents a successful query.
	 *
	 * @return bool
	 */
	public function isSuccess() : bool
	{
		return (bool)$this->success;
	}

	/**
	 * Retrieves the insert ID if this result has one.  Otherwise null.
	 *
	 * @return int|null
	 */
	public function insertId() : ?int
	{
		return $this->insert_id;
	}
}
