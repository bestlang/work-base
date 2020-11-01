<?php

namespace BestLang\WxPay\Pay\Contracts;


interface OrderInterface
{
    public function getOrderNo();
    public function getName();
    public function getMoney();
    public function getId();
    public function getOrderByOrderNo($order_no);

}