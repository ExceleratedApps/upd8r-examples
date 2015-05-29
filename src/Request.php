<?php
namespace Upd8r;

use Guzzle\Http\Client;

include_once '../vendor/autoload.php';

class Request {

    private $key;

    private $url;

    public function __construct($key = '', $url = 'https://api.upd8rsocial.com', $version = 'v1')
    {
        $this->key     = $key;
        $this->url     = $url;
        $this->version = $version;
    }

    public function get($path = '', $params = [])
    {
        return $this->request($path, 'GET', $params);
    }

    public function post($path = '', $params = [])
    {
        return $this->request($path, 'post', $params);

    }

    private function request($path, $method = 'GET', $params)
    {
        $client = $this->buildClient();

        $request = null;

        $method = strtoupper($method);

        try
        {
            switch ($method)
            {
                case 'GET':

                    return $client->get(
                        $this->buildUrl() . $path . '?' . http_build_query($params)
                    )->setAuth($this->key)->send()->json();

                    break;
                case 'POST':

                    return $client->post($this->buildUrl() . $path,null,$params)->setAuth($this->key)
                        ->send()->json();

                    break;
            }

        } catch (RequestException $e)
        {
            return $e->getRequest();
        }

    }

    private function buildUrl()
    {
        return $this->url . '/' . $this->version;
    }

    private function buildClient()
    {
        return new Client($this->buildUrl());
    }

}