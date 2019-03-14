<?php
/**
 * Created by PhpStorm.
 * User: kieranyoungman
 * Date: 2019-03-09
 * Time: 18:51
 */

namespace Pagination;

use EllinghamTech\PaginationHelpers\PaginationBase;
use PHPUnit\Framework\TestCase;

class PaginationBaseTest extends TestCase
{
	public function test_setExpectsRangeExceptionNegativeNumber()
	{
		$this->expectException(\RangeException::class);

		$pagination = new PaginationBase();
		$pagination->set('perPage', -1);
	}

	public function test_setExpectsInvalidArgumentExceptionFloat()
	{
		$this->expectException(\InvalidArgumentException::class);

		$pagination = new PaginationBase();
		$pagination->set('perPage', 0.5);
	}

	public function test_setExpectsInvalidArgumentException()
	{
		$this->expectException(\InvalidArgumentException::class);

		$pagination = new PaginationBase();
		$pagination->set('does_not_exist', 0);
	}

	public function test_getOffsetForPage()
	{
		$pagination = new PaginationBase();
		$pagination->set('total', 100);
		$pagination->set('currentPage', 2);

		$this->assertSame(20, $pagination->getOffsetForPage());
	}

	public function test_getOffsetForPageExpectsInvalidArgumentException()
	{
		$this->expectException(\InvalidArgumentException::class);

		$pagination = new PaginationBase();
		$pagination->set('total', 100);
		$pagination->getOffsetForPage(0.5);
	}

	public function test_getOffsetForPageExpectsRangeException()
	{
		$this->expectException(\RangeException::class);

		$pagination = new PaginationBase();
		$pagination->set('total', 100);
		$pagination->getOffsetForPage(-1);
	}

	public function test_calculateTotalPages()
	{
		$pagination = new PaginationBase();

		$this->assertSame(10, $pagination->calculateTotalPages(200, 20));
	}

	public function test_calculateTotalPagesExpectsRangeException_total()
	{
		$this->expectException(\RangeException::class);

		$pagination = new PaginationBase();
		$pagination->calculateTotalPages(-1, 20);
	}

	public function test_calculateTotalPagesExpectsRangeException_perPage()
	{
		$this->expectException(\RangeException::class);

		$pagination = new PaginationBase();
		$pagination->calculateTotalPages(200, -1);
	}

	public function test_calculateTotalPagesExpectsInvalidArgumentException_total()
	{
		$this->expectException(\InvalidArgumentException::class);

		$pagination = new PaginationBase();
		$pagination->calculateTotalPages(0.5, 20);
	}

	public function test_calculateTotalPagesExpectsInvalidArgumentException_perPage()
	{
		$this->expectException(\InvalidArgumentException::class);

		$pagination = new PaginationBase();
		$pagination->calculateTotalPages(200, 1.5);
	}

	public function test_getOffsetString()
	{
		$pagination = new PaginationBase();
		$pagination->set('total', 100);
		$pagination->set('currentPage', 2);
		$pagination->set('perPage', 20);

		$this->assertSame('LIMIT 20 OFFSET 20', $pagination->getOffsetString('sql'));
	}
}
