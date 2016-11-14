<?php

namespace Forleven;

class Forleven
{
	/**
	 * This SDK version.
	 * @var string
	 */
    public static $sdkVersion = '0.1';

	/**
     * The base URL for the Forleven API.
     * @var string
     */
	public static $apiBase = 'http://api.forleven.com';

    /**
     * The client_id by Forleven APP.
     * @var string
     */
    public static $client_id = null;

    /**
     * The client_secret by Forleven APP.
     * @var string
     */
    public static $client_secret = null;

    /**
     * The access_token by Forleven Authorization
     * @var string
     */
    public static $accessToken = null;

    /**
     * The uri of application
     * @var string
     */
    public static $uri = null;

    public static $headers = [];

    public static function setHeaders() 
    {
        self::$headers = array(
            'Authorization' => 'Bearer ' . self::$accessToken
        );
    }
}