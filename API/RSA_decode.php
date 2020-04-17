<?php
//RSA解密
function RSA_decode($encrypted){
    ini_set('error_reporting', -1);
    ini_set('display_errors', -1);

    header('Content-Type: text/html; charset=utf-8');

    $private_key = file_get_contents("./rsa_private_key.pem");
    $public_key = file_get_contents("./rsa_public_key.pem");

    $pi_key =  openssl_pkey_get_private($private_key);// 可用返回资源id
    $pu_key = openssl_pkey_get_public($public_key);
// 解密数据
//$encrypted = $_POST['data'];
//$decrypted = '';
//$encrypted = "QmcK3JFOc8cuyi7viSapPWfcNp32++jz5pNOc6VhlBHgmwwI3Cj7ENMzVxicPJ3HHdb6hTHBvF5Dd4hGs28vtaBXsFqX7pNJeJ4cl2NsL4HFxdin/BuavW/kIprCBLG3hZW2hO0MWiwGQtSJA5KTbOHNnom1mr+pBP0S5Qq/SUM=";
    openssl_private_decrypt(base64_decode(urldecode($encrypted)), $decrypted, $pi_key);//私钥解密
    return $decrypted;
}