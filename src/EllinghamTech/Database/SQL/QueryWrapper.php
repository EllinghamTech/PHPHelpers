<?php
namespace EllinghamTech\Database\SQL;

use EllinghamTech\Exceptions\Data\QueryFailed;

final class QueryWrapper
{
	/** @var Wrapper The Ellingham Wrapper Object */
	protected $wrapper;
	/** @var \PDO PDO Object */
	protected $pdo;
	/** @var string The query string */
	protected $query;
	/** @var array The inputs */
	protected $inputs;
	/** @var \PDOStatement PDO Statement object */
	protected $pdo_stmt;

	/**
	 * Sets up the instance
	 * @param Wrapper $parent The Wrapper object
	 * @param string $query The query string
	 *
	 * @throws QueryFailed QueryFailed if the QueryWrapper could not prepare the query
	 */
	public function __construct(Wrapper $parent, string $query)
	{
		$this->wrapper = $parent;
		$this->pdo = $parent->getDBLink();
		$this->query = $query;
		$this->pdo_stmt = $this->pdo->prepare($query);

		if($this->pdo_stmt === null)
			throw new QueryFailed($query, $this->wrapper,'Statement is NULL, possibly a query syntax error');

		if(is_bool($this->pdo_stmt))
			throw new QueryFailed($query, $this->wrapper, 'Statement is BOOL, possibly a query syntax error');
	}

	/**
	 * Binds a value to the query
	 * @param string|int $name Name/number of value to bind
	 * @param string $value Value to bind
	 * @param string $type Type of value (string, int)
	 *
	 * @return bool True on Success
	 **/
	public function bindValue(string $name, $value, string $type='string') : bool
	{
		if($type == 'int') $type = \PDO::PARAM_INT;
		else $type = \PDO::PARAM_STR;

		return $this->pdo_stmt->bindValue($name, $value, $type);
	}

	/**
	 * Executes the query
	 * @param string|int|array Binds the values to the query
	 * @return ResultWrapper Returns the query result
	 *
	 * @throws QueryFailed
	 */
	public function execute($values=null) : ResultWrapper
	{
		$insert_id = null;

		if($values === null) $success = $this->pdo_stmt->execute();
		else if(!is_array($values)) $success = $this->pdo_stmt->execute(array($values));
		else $success = $this->pdo_stmt->execute($values);

		if(!$success)
			throw new QueryFailed($this->query, $this->wrapper,'Database query failed: '.json_encode($this->pdo_stmt->errorInfo()));

		$insert_id = $this->pdo->lastInsertId();

		return new ResultWrapper($this->pdo_stmt, $success, $insert_id);
	}
}
