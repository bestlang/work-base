<?php
namespace App\Pay\Contracts;

interface ILogHandler
{
    public function write($msg);

}