<?php
namespace EllinghamTech\Session;

interface IBasicSession
{
	/**
	 * Set a session message
	 *
	 * @param string $name The name of the message
	 * @param string $value The value of the message
	 * @return bool True on success
	 */
	public function setSessionMessage(string $name, string $value) : bool;

	/**
	 * Gets session messages for a $name
	 *
	 * @param string $name Message name
	 * @return array|null
	 */
	public function getSessionMessages(string $name) : ?array;

	/**
	 * Checks if any session messages exist for a $name
	 *
	 * @param string $name Message name
	 * @return bool True if exists, false otherwise
	 */
	public function checkSessionMessages(string $name) : bool;

	/**
	 * Clears session messages for a $name
	 *
	 * @param string $name Message name
	 * @return void
	 */
	public function clearSessionMessages(string $name) : void;

	/**
	 * Clears all session messages
	 *
	 * @return void
	 */
	public function clearAllSessionMessages() : void;
}
