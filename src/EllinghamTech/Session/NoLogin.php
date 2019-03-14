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
class NoLogin implements IBasicSession
{
	public function __construct()
	{
		@session_start();
	}

	public function setSessionMessage($name, $value)
	{
		@session_start();
		$_SESSION['msg'][$name][] = $value;
		return true;
	}

	public function getSessionMessages($name)
	{
		return (isset($_SESSION['msg'][$name]) ? $_SESSION['msg'][$name] : null);
	}

	public function checkSessionMessages($name)
	{
		return (isset($_SESSION['msg'][$name]) ? true : false);
	}

	public function clearSessionMessages($name)
	{
		if(isset($_SESSION['msg'][$name]))
			unset($_SESSION['msg'][$name]);
	}

	public function clearAllSessionMessages()
	{
		if(isset($_SESSION['msg']))
			unset($_SESSION['msg']);
	}
}