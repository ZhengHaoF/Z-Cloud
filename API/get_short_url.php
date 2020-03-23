<?php
//网址缩短模块，已废弃
/*
function get_short_url($long_url){  //网址缩短
    $api_url = "http://suo.im/api.htm"; //API接口
    $key = "5e783354b1b63c03083e72e5@b542bd21991b027f5d010f4601041a18"; //你的API用户KEY
    $url = $api_url . "?url=" . $long_url . "&key=" . $key;//Get拼接
    echo file_get_contents($url); //get请求
}
//接口二
    $long_url = "https://api.d5.nz/apidetail/16.html";
    $api_url = "https://api.d5.nz/api/dwz/tcn.php"; //API接口
    $url = $api_url . "?url=" . $long_url;
    echo file_get_contents($url); //get请求

//接口三
    $api_url = "http://api.ft12.com/api.php"; //API接口
    $key = "p9DDz7CxRol87MR5gZ@ddd"; //你的API用户KEY
    $url = $api_url . "?url=" . $long_url . "&apikey=" . $key;//Get拼接
    echo file_get_contents($url); //get请求