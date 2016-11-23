<?php

namespace Forleven\OAuth;

use GuzzleHttp\Client as Guzzle;
use Forleven\Forleven;
use Forleven\Core\Http\Client\Client as HttpClient;

class OAuth extends HttpClient
{
	private $client_id;
	private $client_secret;
	private $access_token;
	private $redirect_uri;
	private $headers = [];

	function __construct($client_id, $client_secret)
	{
		parent::__construct();

		if (!$client_id || empty($client_id))
		{
			throw new \Exception("Need to be set client_id");
		}

		if (!$client_secret || empty($client_secret))
		{
			throw new \Exception("Need to be set client_id");
		}

		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->uri = $_SERVER['HTTP_HOST'];
	}

	private function validateApplication()
	{
		$query = array(
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
		);

		$header = array(
			'Authorization' => 'Bearer ' . $this->access_token
		);

		$request = $this->post('/oauth/authorization_application', $query, $header);
		$response = (array)json_decode($request->getBody(), true);

		if($request->getStatusCode() == 200)
		{
			return true;
		}

		throw new \Exception($response['error']);
	}

	public function setAccessToken($token)
	{
		$this->access_token = $token;
		$validate_application = $this->validateApplication();

		if($validate_application)
		{
			Forleven::$client_id = $this->client_id;
			Forleven::$client_secret = $this->client_secret;
			Forleven::$accessToken = $this->access_token;

			Forleven::$uri = $this->uri;

			Forleven::setHeaders();
		}
	}

	public function getAccessToken($authorize_code)
	{
		$query = array(
			'authorize_code'	=> $authorize_code,
			'client_id'			=> $this->client_id,
			'client_secret'		=> $this->client_secret,
		);

		$endpoint = '/oauth/oauth_token';
		$request = $this->post($endpoint, $query);
		$response = (array)json_decode($request->getBody(), true);

		if(array_key_exists('error', $response))
		{
			return $response['error'];
		}

		return $response;
	}

	public function getAuthotizationUrl()
	{
		$query = array(
			'client_id'		=> $this->client_id,
			'uri'			=> $this->uri,
		);
		$url = Forleven::$apiBase . '/oauth/authorize?' . http_build_query($query);
		return $url;
	}
}