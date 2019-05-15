<?php

namespace JeroenOnline\ShopsUnitedLaravel;

use GuzzleHttp\Client;
use JeroenOnline\ShopsUnitedLaravel\Modules\Accounts;
use JeroenOnline\ShopsUnitedLaravel\Modules\Shipments;

class ShopsUnitedLaravel
{
    protected $url;
    protected $query;
    protected $callableUrl;
    protected $method = 'GET';
    protected $params = [];

    public function __construct()
    {
        $this->client = new Client(['verify' => config('shops-united-laravel.verify-ssl')]);

        $this->baseUrl = 'https://login.shops-united.nl/api/';
    }

    public function accounts()
    {
        return new Accounts();
    }

    public function shipments()
    {
        return new Shipments();
    }

    protected function call()
    {
        $request = $this->client->request($this->method, $this->callableUrl.$this->query, [
            'form_params' => $this->params,
        ]);

        return json_decode($request
            ->getBody()
            ->getContents(), true);
    }

    protected function setGetUrl($url = null)
    {
        $this->method = 'GET';
        $this->callableUrl = $this->baseUrl.$url;

        return $this;
    }

    public function setPostUrl($url)
    {
        $this->method = 'POST';
        $this->callableUrl = $this->baseUrl.$url;

        return $this;
    }

    public function setDeleteUrl($url)
    {
        $this->method = 'DELETE';
        $this->callableUrl = $this->baseUrl.$url;

        return $this;
    }

    protected function addQuery(array $array)
    {
        $this->query = '?'.http_build_query($array);

        return $this;
    }

    protected function setParams(array $array)
    {
        $this->params = $array;

        return $this;
    }
}
