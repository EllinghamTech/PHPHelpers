<?php
namespace EllinghamTech\Recaptcha;

/**
 * A quick wrapper for Google Recaptcha
 **/
class RecaptchaV2
{
	/**
	 * @var string Google Recaptcha Key
	 */
	private $key;

	/**
	 * @var string Google Recaptcha Secret
	 */
	private $secret;

	/**
	 * @var int Request timeout to ensure we don't wait forever for google
	 */
	public $timeout = 2;

	/**
	 * @var int Connection timeout to ensure we don't wait forever for google
	 */
	public $connectionTimeout = 2;

	/**
	 * RecaptchaV2 constructor.
	 *
	 * @param string $key Google Recaptcha Key
	 * @param string $secret Google Recaptcha Secret
	 */
	public function __construct($key, $secret)
	{
		$this->key = $key;
		$this->secret = $secret;

		return true;
	}

	/**
	 * Returns the HTML header stuff for Recaptcha
	 *
	 * @return string
	 */
	public function recaptcha_header()
	{
		return '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
	}

	/**
	 * Returns the HTML for the recaptcha box
	 *
	 * @return string
	 */
	public function recaptcha_v2()
	{
		return '<div class="g-recaptcha" data-sitekey="'.$this->key.'"></div>';
	}

	/**
	 * Tests to see if the request is verified by
	 * Recaptcha as not a robot.
	 *
	 * @return bool Verified?
	 */
	public function verify()
	{
		if(isset($_POST['g-recaptcha-response']))
			$response = $_POST['g-recaptcha-response'];
		else if(isset($_GET['g-recaptcha-response']))
			$response = $_GET['g-recaptcha-response'];
		else
			return false;

		$post_data = array(
			'secret' => $this->secret,
			'response' => $response,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		);

		$verify = curl_init();

		curl_setopt($verify, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
		curl_setopt($verify, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($verify, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($post_data));
		curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($verify);
		$result = json_decode($result);

		$curl_errno = curl_errno($verify);

		if($curl_errno > 0) return true;
		return (bool)$result->success;
	}
}