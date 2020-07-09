<?php
namespace Bestlang\Laracms\Http\Controllers;


class OrderController
{
    public function index()
    {
        return view('laracms::dark.order.order');
    }
}