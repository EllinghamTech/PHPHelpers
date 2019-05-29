<?php
namespace EllinghamTech\Abstractions;

abstract class CountableIterator implements \Iterator
{
	/**
	 * Returns the total number of elements in the Iterator.
	 *
	 * Returns the total number of elements in the Iterator or
	 * NULL if the total number cannot be determined.
	 *
	 * @return int|null
	 */
	abstract public function count() : ?int;
}
