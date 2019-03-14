<?php
namespace EllinghamTech\Session;

/**
 * Basic session class with no database and no
 * login capabilities.
 *
 * Basic session class with no database and no login
 * capabilities.  Used to handle a simple session such
 * as passing error messages around without the need
 * for a database or user accounts.
 **/
class SingleUse implements IBasicSession
{
	public $session;

	public function __construct()
	{
		$this->session = array();

		if (ini_get('session.use_cookies'))
		{
			$params = session_get_cookie_params();

			if(isset($_COOKIE[session_name()]))
			{
				@session_start();
				$this->session = $_SESSION;
				$_SESSION = null;
				@session_destroy();

				setcookie(session_name(), '', time() - 42000,
					$params['path'], $params['domain'],
					$params['secure'], $params['httponly']
				);
			}
		}
	}

	public function setSessionMessage($name, $value)
	{
		@session_start();
		$_SESSION['msg'][$name][] = $value;
		return true;
	}

	public function getSessionMessages($name)
	{
		return (isset($this->session['msg'][$name]) ? $this->session['msg'][$name] : null);
	}

	public function checkSessionMessages($name)
	{
		return (isset($this->session['msg'][$name]) ? true : false);
	}

	public function clearSessionMessages($name)
	{
		if(isset($this->session['msg'][$name]))
			unset($this->session['msg'][$name]);
	}

	public function clearAllSessionMessages()
	{
		if(isset($this->session['msg']))
			unset($this->session['msg']);
	}
}