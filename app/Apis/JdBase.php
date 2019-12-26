<?php
namespace  App\Apis;

use GuzzleHttp\Client;

class JdBase
{
    public $params = [];
    public $client = null;

    public function __construct()
    {
        $this->resetParams();
        $this->client = new Client();
    }

    public function resetParams(){

    }

    public function genSign(){
        
    }
}