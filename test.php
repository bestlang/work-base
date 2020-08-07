<?php
$hex = '0xf123456789';
if(substr($hex, 0, 2) === '0x'){
    $hex = substr($hex, 2);
}
echo $hex;