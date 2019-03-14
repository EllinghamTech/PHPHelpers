<?php
namespace EllinghamTech\PaginationHelpers;

class PaginationBase
{
	/**
	 * @var int|null Total number of results
	 */
	protected $total = null;

	/**
	 * @var int Number of results per page
	 */
	protected $perPage = 20;

	/**
	 * @var int The current page
	 */
	protected $currentPage = 1;

	/**
	 * @var int Total number of pages
	 */
	protected $pages = 0;

	/**
	 * __set magic method for $total, $perPage, $currentPage and $pages to enforce
	 * types.
	 *
	 * Usage: Magic methods can be called implicitly:
	 * $pagination = new PaginationBase();
	 * $pagination->total = 10; // PHP will use __set.  EXCEPTIONS MAY BE THROWN.
	 *
	 * @param string $name
	 * @param int $value MUST BE a positive integer
	 *
	 * @throws \InvalidArgumentException If $value is not an integer or $name is invalid
	 * @throws \RangeException If the value is not positive
	 */
	public function __set($name, $value)
	{
		if(!is_int($value)) throw new \InvalidArgumentException('Value must be an integer');
		if($value < 0) throw new \RangeException('Value must be positive');

		switch($name)
		{
			case 'total':
			{
				$this->total = $value;

				if($this->perPage != null)
					$this->pages = (int)ceil($this->total / $this->perPage);

				return;
			}
			case 'perPage':
			{
				$this->perPage = $value;

				if($this->total != null)
					$this->pages = (int)ceil($this->total / $this->perPage);

				return;
			}
			case 'currentPage':
				$this->currentPage = $value;
				return;
			case 'pages':
				$this->pages = $value;
				return;
			default:
				throw new \InvalidArgumentException('Invalid name');
		}
	}

	/**
	 * Set method for total, perPage, currentPage and pages enforcing types.
	 *
	 * Usage:
	 * $pagination = new PaginationBase();
	 * $pagination->set('total', 10);
	 *
	 * @param string $name
	 * @param int $value MUST BE a positive integer
	 *
	 * @throws \InvalidArgumentException If $value is not an integer or $name is invalid
	 * @throws \RangeException If the value is not positive
	 */
	public function set($name, $value)
	{
		$this->__set($name, $value);
	}

	/**
	 * Gets the offset for the current page.
	 *
	 * @param int|null $currentPage The current page (if null uses $currentPage property)
	 * @return bool|int The offset for the page, false on failure
	 *
	 * @throws \InvalidArgumentException $currentPage is not an integer (or null)
	 * @throws \RangeException $currentPage is negative
	 */
	public function getOffsetForPage($currentPage=null)
	{
		if($currentPage == null)
			$currentPage = $this->currentPage;

		if(!is_int($currentPage)) throw new \InvalidArgumentException('Current page must be an integer');
		if($currentPage < 0) throw new \RangeException('Current page must be positive');

		$currentPage--;

		return $currentPage * $this->perPage;
	}

	/**
	 * Calculates the total number of pages.
	 *
	 * @param int|null $total The total number of results (if null uses $total property)
	 * @param int|null $perPage The total number of results per page (if null uses $perPage property)
	 * @return bool|int The total number of pages, false on failure
	 *
	 * @throws \InvalidArgumentException If total or perPage is not an integer
	 * @throws \RangeException If total or perPage is negative
	 */
	public function calculateTotalPages($total=null, $perPage=null)
	{
		if($total == null)
		{
			if($this->total == null) return false;

			$total = $this->total;
		}

		if(!is_int($total)) throw new \InvalidArgumentException('Total must be an integer');
		if($total < 0) throw new \RangeException('Total must be positive');

		if($perPage == null)
		{
			if($this->perPage == null) return false;

			$perPage = $this->perPage;
		}

		if(!is_int($perPage)) throw new \InvalidArgumentException('Per Page must be an integer');
		if($perPage < 0) throw new \RangeException('Per Page must be positive');

		return (int)ceil($total / $perPage);
	}

	/**
	 * Returns the partial SQL query (LIMIT part).
	 *
	 * @param string $type The SQL type (future use?)
	 * @return bool|string The partial SQL query, false on failure
	 */
	public function getOffsetString($type = 'sql')
	{
		$offset = $this->getOffsetForPage();

		if($offset == false) return false;

		switch($type)
		{
			case 'sql':
			case 'mysql':
				return 'LIMIT '.$this->perPage.' OFFSET '.$offset;
		}

		return false;
	}
};