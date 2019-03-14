<?php
namespace EllinghamTech\PaginationHelpers;

class PaginationHTML extends PaginationBase
{
	const FORM_TYPE_GET = 'get';
	const FORM_TYPE_POST = 'post';
	const FORM_TYPE_NONE = 'no-form';

	public $names = array(
		'previous' => 'Previous',
		'next' => 'Next',
		'first' => 'First',
		'last' => 'Last',
		'submit' => 'Go'
	);

	/**
	 * Returns a HTML List (li) containing links to the corresponding pages.
	 *
	 * @param int $maximumNumberOfItems The maximum number of items to list
	 * @param bool $withPrevious Show previous link
	 * @param bool $withNext Show next link
	 * @param bool $withFirst Show first link
	 * @param bool $withLast Show last link
	 * @param bool $reverseOrder If true, the order is reversed (e.g. last next 4 3 2 1 previous first)
	 * @param bool $hideInaccessibleNamedPages Hides named pages (e.g. Next, Previous) if the page is out of bounds
	 * @param string $pageParameterName The GET parameters name (usually p e.g. for ?p=2&...)
	 * @return string The HTML content
	 */
	public function getListHtml($maximumNumberOfItems=10, $withPrevious=true, $withNext=true, $withFirst=true, $withLast=true, $reverseOrder=false, $hideInaccessibleNamedPages=false, $pageParameterName='p')
	{
		// Build the list array
		$listItems = array();

		if($withFirst)
			$listItems[] = array(1, $this->names['first'], 'first');

		if($withPrevious)
			$listItems[] = array(($this->currentPage-1), $this->names['previous'], 'previous');

		$otherItems = $maximumNumberOfItems - 1; // Current page takes 1 item.

		if(($this->currentPage - $otherItems) < 1)
			$start = 1;
		else
			$start = ceil($this->currentPage - ($otherItems / 2));

		for($x=$start; $x<=($start + $otherItems) && $x <= $this->pages; $x++)
		{
			if($x == $this->currentPage)
				$listItems[] = array($x, $x, 'current');
			else
				$listItems[] = array($x, $x, null);
		}

		if($withNext)
			$listItems[] = array(($this->currentPage+1), $this->names['next'], 'next');

		if($withLast)
			$listItems[] = array($this->pages, $this->names['last'], 'last');

		if($reverseOrder)
			$listItems = array_reverse($listItems);

		// Return HTML
		return $this->getListHtmlFromListArray($listItems, $hideInaccessibleNamedPages, $pageParameterName);
	}

	/**
	 * Returns a HTML form containing a select list
	 *
	 * @param int|null $optionsMaximumNumberOfItems The maximum number of items to list if using an options field (null = no maxmimum)
	 * @param bool $withSubmit Display submit button
	 * @param bool $withFirst Show first link
	 * @param bool $withLast Show last link
	 * @param string $formType self::FORM_TYPE_GET, self::FORM_TYPE_POST, self::FORM_TYPE_NONE (no form)
	 * @param string $pageParameterName The GET/POST parameters name (usually p e.g. for ?p=2&...)
	 * @return string The HTML content
	 */
	public function getFormOptionsHtml($optionsMaximumNumberOfItems=20, $withSubmit=true, $withFirst=true, $withLast=true, $formType=self::FORM_TYPE_GET, $pageParameterName='p')
	{
		ob_start();

		// Because if $formType is not FORM_TYPE_GET or FORM_TYPE_POST and also not FORM_TYPE_NONE
		// then a </form> might be returned...
		if($formType != self::FORM_TYPE_NONE)
		{
			if ($formType == self::FORM_TYPE_GET)
				echo '<form method="get">';
			else if ($formType == self::FORM_TYPE_POST)
				echo '<form method="post">';
		}

		echo $this->getHtmlFormOptionsContents($optionsMaximumNumberOfItems, $withFirst, $withLast, htmlspecialchars($pageParameterName));

		if($withSubmit)
			echo '<input type="submit" name="', htmlspecialchars($this->names['submit']), '" />';

		if($formType != self::FORM_TYPE_NONE)
			echo '</form>';

		return ob_get_clean();
	}

	/**
	 * Returns a HTML form containing an input field
	 *
	 * @param bool $withSubmit Display submit button
	 * @param string $formType self::FORM_TYPE_GET, self::FORM_TYPE_POST, self::FORM_TYPE_NONE (no form)
	 * @param string $pageParameterName The GET/POST parameters name (usually p e.g. for ?p=2&...)
	 * @return string The HTML content
	 */
	public function getFormInputHtml($withSubmit=true, $formType=self::FORM_TYPE_GET, $pageParameterName='p')
	{
		ob_start();

		// Because if $formType is not FORM_TYPE_GET or FORM_TYPE_POST and also not FORM_TYPE_NONE
		// then a </form> might be returned...
		if($formType != self::FORM_TYPE_NONE)
		{
			if ($formType == self::FORM_TYPE_GET)
				echo '<form method="get">';
			else if ($formType == self::FORM_TYPE_POST)
				echo '<form method="post">';
		}

		echo $this->getHtmlFormInputContents(htmlspecialchars($pageParameterName));

		if($withSubmit)
			echo '<input type="submit" name="', htmlspecialchars($this->names['submit']), '" />';

		if($formType != self::FORM_TYPE_NONE)
			echo '</form>';

		return ob_get_clean();
	}

	/**
	 * Returns HTML for a HTML list based on a compatible array.
	 *
	 * @param array $listItems The compatible array
	 * @param bool $hideInaccessibleNamedPages Hides named pages (e.g. Next, Previous) if the page is out of bounds
	 * @param string $pageParameterName The GET parameters name (usually p e.g. for ?p=2&...)
	 * @return string The HTML content
	 */
	protected function getListHtmlFromListArray(array $listItems, $hideInaccessibleNamedPages=false, $pageParameterName='p')
	{
		ob_start();

		echo '<ul>';

		foreach($listItems as $itemArr)
		{
			if( ($itemArr[0] < 0 || $itemArr[0] > $this->pages) && $hideInaccessibleNamedPages )
				continue;

			if($itemArr[1] != null)
				echo '<li class="', $itemArr[2], '">';
			else
				echo '<li>';

			if($itemArr[0] == $this->currentPage)
				echo '<a href="?', $this->getQueryString($itemArr[0], $pageParameterName), '" class="current_page">', $itemArr[1], '</a>';
			else if($itemArr[0] > 0 && $itemArr[0] <= $this->pages)
				echo '<a href="?', $this->getQueryString($itemArr[0], $pageParameterName), '">', $itemArr[1], '</a>';
			else
				echo $itemArr[1];

			echo '</li>';
		}

		echo '</ul>';

		return ob_get_clean();
	}

	/**
	 * Returns the an input field
	 *
	 * @param string $pageParameterName The GET parameters name (usually p e.g. for ?p=2&...)
	 * @return string The HTML content
	 */
	protected function getHtmlFormInputContents($pageParameterName='p')
	{
		ob_start();

		if($this->pages != null)
			echo '<input type="number" name="', $pageParameterName, '" min="1" max="', $this->pages, '" value="', $this->currentPage, '" />';
		else
			echo '<input type="number" name="', $pageParameterName, '" min="1" value="', $this->currentPage, '" />';

		return ob_get_clean();
	}

	/**
	 * Returns a select field with options
	 *
	 * @param int|null $optionsMaximumNumberOfItems Maximum number of items (null = no maximum)
	 * @param bool $withFirst Show first link
	 * @param bool $withLast Show last link
	 * @param string $pageParameterName The GET parameters name (usually p e.g. for ?p=2&...)
	 * @return string The HTML content
	 */
	protected function getHtmlFormOptionsContents($optionsMaximumNumberOfItems=null, $withFirst=true, $withLast=true, $pageParameterName='p')
	{
		ob_start();

		echo '<select name="', $pageParameterName, '">';

		$start = 1;
		$max = $this->pages;

		if($optionsMaximumNumberOfItems != null)
		{
			$otherItems = $optionsMaximumNumberOfItems - 1; // Current page takes 1 item.

			if(($this->currentPage - $otherItems) < 1)
				$start = 1;
			else
				$start = ceil($this->currentPage - ($otherItems / 2));

			$max = floor($this->currentPage + ($otherItems / 2));
		}

		if($withFirst)
			echo '<option value="1">', $this->names['first'], '</option>';

		for($x=$start; $x<$max; $x++)
		{
			if($x == $this->currentPage)
				echo '<option value="', $x, '" selected>', $x, '</option>';
			else
				echo '<option value="', $x, '">', $x, '</option>';
		}

		if($withLast)
			echo '<option value="', $this->pages, '">', $this->names['last'], '</option>';

		echo '</select>';

		return ob_get_clean();
	}

	/**
	 * Returns the GET query string without affecting other parameters
	 *
	 * @param int|null $page Null the page from the query string
	 * @param string $pageParameterName The parameter name
	 * @return string The Query String
	 */
	protected function getQueryString($page=null, $pageParameterName='p')
	{
		// Generate GET query string
		$_arr = array();

		if(isset($_GET) && is_array($_GET))
			$_arr = $_GET;

		if($page != null)
			$_arr[$pageParameterName] = $page;
		else if(isset($_arr[$pageParameterName]))
			unset($_arr[$pageParameterName]);

		return http_build_query($_arr);
	}
};
