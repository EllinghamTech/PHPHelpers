<?php
namespace EllinghamTech\Database\MySQL;

use \EllinghamTech\Database\Interfaces\ISQLTransactions;

class Wrapper implements ISQLTransactions
{
	/** @var \PDO Database Object */
	public $db_link = null;
	/** @var string Last Query Performed */
	protected $last_query;

	public function init($host, $user, $pass, $databaseName)
	{
		$this->establishConnection($host, $user, $pass, $databaseName);
	}

	public function establishConnection($host, $user, $pass, $databaseName)
	{
		if($this->db_link != null) return;

		$dsn = 'mysql:dbname='.$databaseName.';host='.$host;

		try
		{
			$this->db_link = new \PDO($dsn, $user, $pass);
		}
		catch(\PDOException $e)
		{
			$this->db_link = null;
			throw new \Exception("Failed to load database connection: ".$e->getMessage());
		}
	}

	/**
	 * Uses an existing PDO connection instead of creating
	 * a new connection to the database.
	 *
	 * @param \PDO $pdoObject An existing PDO connection
	 */
	public function useExistingConnection(\PDO $pdoObject)
	{
		$this->db_link = $pdoObject;
	}

	public function prepare($query_string)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return new QueryWrapper($this, $query_string);
	}

	public function performQuery($query_string, $inputs = null)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		$res = new QueryWrapper($this, $query_string);
		return $res->execute($inputs);
	}

	public function transaction_begin()
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->beginTransaction();
	}

	public function transaction_rollback()
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->rollBack();
	}

	public function transaction_commit()
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->commit();
	}

	public function transaction_savepointCreate($name)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->query('SAVEPOINT '.$name);
	}

	public function transaction_savepointRollback($name)
	{
		if($this->db_link == null) throw new \Exception('Not connected to database');
		return $this->db_link->query('ROLLBACK TO '.$name);
	}

	/**
	 * Returns the Database Link.  Null if it has not been set.
	 *
	 * @return \PDO|null
	 */
	public function getDBLink()
	{
		return $this->db_link;
	}
}