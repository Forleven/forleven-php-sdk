<?php

namespace Forleven\Core\Http\Client;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use Forleven\Forleven;
use Forleven\Core\Pagination\Pagination as Pagination;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client = null;

    function __construct()
    {
        $this->client = new Guzzle();
    }

    private function url($endpoint = null)
    {
        $apiUrl = Forleven::$apiBase;

        if(!is_null($endpoint))
        {
            $apiUrl .= $endpoint;
        }

        return $apiUrl;
    }

    private function request($method, $endpoint, array $params = [])
    {
        try 
        {
            $response = $this->client->request($method, $endpoint, $params);
        }
        catch (ClientException $e)
        {
            $response = $e->getResponse();
        }

        return $response;
    }

    public function get($endpoint, array $params = array(), array $headers = array())
    {
        $url = $this->url($endpoint);

        $payload = array(
            'headers' => []
        );

        if(is_array(Forleven::$headers) && !empty(Forleven::$headers))
        {
            $payload['headers'] = array_merge($payload['headers'], Forleven::$headers);
        }

        if(is_array($headers) && !empty($headers))
        {
            $payload['headers'] = array_merge($payload['headers'], $headers);
        }

        if(is_array($params) && !empty($params))
        {
            $payload['query'] = $params;
        }

        if(property_exists($this, 'pagination') && $this->pagination instanceof Pagination)
        {
            if(is_array($payload['query']) && !empty($payload['query']))
            {
                $payload['query']['page'] = $this->pagination->numPage;
            }
            else
            {
                $payload['query'] = array(
                    'page' => $this->pagination->numPage
                );
            }
        }

        return $this->request('GET', $url, $payload);
    }

    public function post($endpoint, array $params = array(), array $headers = array())
    {
        $url = $this->url($endpoint);

        $payload = array(
            'headers' => []
        );

        if(is_array(Forleven::$headers) && !empty(Forleven::$headers))
        {
            $payload['headers'] = array_merge($payload['headers'], Forleven::$headers);
        }

        if(is_array($headers) && !empty($headers))
        {
            $payload['headers'] = array_merge($payload['headers'], $headers);
        }

        if(is_array($params) && !empty($params))
        {
            $payload['form_params'] = $params;
        }

        return $this->request('POST', $url, $payload);
    }

    public function setFields(Array $request)
    {
        $fields = get_object_vars($this);

        foreach ($fields as $key => $value)
        {
            if(!in_array($key, ['client', 'exist'])
            && in_array($key, array_keys($request)))
            {
                $this->$key = $request[$key];
            }
        }
    }
}