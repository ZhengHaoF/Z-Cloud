<?php
// RSA加密数据
//$data = $_POST['data'];
function RSA_encryption($pwd,$time)
{
    $data=json_encode(array("pwd"=>$pwd,"time"=>$time));
    ini_set('error_reporting', -1);
    ini_set('display_errors', -1);
    header('Content-Type: text/html; charset=utf-8');
    $public_key = file_get_contents("./rsa_public_key.pem");
    $pu_key = openssl_pkey_get_public($public_key);
    $encrypted = '';
    openssl_public_encrypt($data, $encrypted, $pu_key);//公钥加密
    $encrypted = urlencode(base64_encode($encrypted));// base64传输
    return $encrypted;
}
