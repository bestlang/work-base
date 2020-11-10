<?php
if(!function_exists('randomStr')) {
    function randomStr(){
        return time().'_'.rand(1,99999);
    }
}