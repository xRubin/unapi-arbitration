<?php

namespace unapi\arbitration\kad;

class Client extends \GuzzleHttp\Client
{
    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config['base_uri'] = 'https://kad.arbitr.ru/';
        $config['cookies'] = true;
        $config['verify'] = false;

        parent::__construct($config);
    }
}