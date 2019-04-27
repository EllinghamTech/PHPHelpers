<?php
namespace EllinghamTech\Templating;

/**
 * Allows the easier use of templates on a site
 **/
class Template
{
	/**
	 * @var string Contains page content
	 */
	public $content = null;

	/**
	 * @var string Page title
	 */
	public $title = null;

	/**
	 * @var string Site Name, appended to title
	 */
	public $siteName = null;

	/**
	 * @var string Separator between title and siteName
	 */
	public $titleSeparator = '-';

	/**
	 * @var array Array of HTML meta tags
	 */
	protected $meta = array();

	/**
	 * @var array Array of additional HTML headers
	 */
	protected $headers = array();

	/**
	 * @var array Page Breadcrumb array( array(LOCATION, NAME, optional ICON) )
	 */
	public $breadcrumb = array();

	/**
	 * Template constructor.
	 *
	 * @param string $siteName Site Name
	 * @param string $titleSeparator Title Separator
	 */
	public function __construct(?string $siteName=null, string $titleSeparator='-')
	{
		if($siteName != null)
			$this->siteName = $siteName;

		$this->titleSeparator = $titleSeparator;
	}

	/**
	 * Sets a meta data field
	 * @param string $name Name of the Meta data field
	 * @param string $value Value of the Meta data field
	 * @return bool True on success
	 **/
	public function setMeta(string $name, string $value) : void
	{
		$this->meta[$name] = $value;
	}

	/**
	 * Creates and returns the page title from inputted variables
	 **/
	public function getTitle() : string
	{
		if($this->siteName != null)
			return (strlen($this->title) > 0 ? $this->title.' '.$this->titleSeparator.' ' : '').$this->siteName;
		else
			return $this->title;
	}

	/**
	 * Returns the set HTML headers
	 **/
	function htmlHeaders() : string
	{
		$return = '';

		for($x=0, $c=count($this->headers); $x<$c; $x++)
		{
			$return = $this->headers[$x]."\n";
		}

		return $return;
	}

	/**
	 * Sets a HTML header
	 *
	 * @param string $header The HTML header to add
	 */
	function setHtmlHeader(string $header) : void
	{
		$this->headers[] = $header;
	}
};
