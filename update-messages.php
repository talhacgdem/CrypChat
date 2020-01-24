<?php
$db = new mysqli("localhost", "root", "", "deneme");

if ($db->connect_error) {
    die("Sorry, there was a problem connecting to our database.");
}

$username = stripslashes(htmlspecialchars($_GET['username']));
$message = stripslashes(htmlspecialchars($_GET['message']));
$algorithm = stripslashes(htmlspecialchars($_GET['algorithm']));


if ($message == "" || $username == "") {
    die();
}

if ($algorithm == "1"){
    $message = caesarEn($message, 3);
    $result = $db->prepare("INSERT INTO caesar VALUES('',?,?)");
}
elseif ($algorithm == "2") {
    $message = aesEn($message);
    $result = $db->prepare("INSERT INTO aes VALUES('',?,?)");
}
elseif ($algorithm == "3") {
    $message = aesEn($message);
    $result = $db->prepare("INSERT INTO des VALUES('',?,?)");
}
elseif ($algorithm == "4") {
    $message = polybiosEn($message);
    $result = $db->prepare("INSERT INTO polybios VALUES('',?,?)");
}






$result->bind_param("ss", $username, $message);
$result->execute();

function caesarEn($str, $offset) {
    $encrypted_text = "";
    $offset = $offset % 26;
    if($offset < 0) {
        $offset += 26;
    }
    $i = 0;
    while($i < strlen($str)) {
        $c = strtoupper($str{$i});
        if(($c >= "A") && ($c <= 'Z')) {
            if((ord($c) + $offset) > ord("Z")) {
                $encrypted_text .= chr(ord($c) + $offset - 26);
            } else {
                $encrypted_text .= chr(ord($c) + $offset);
            }
        } else {
            $encrypted_text .= " ";
        }
        $i++;
    }
    return $encrypted_text;
}

function aesEn($plaintext){


    $key = "keybuguclubir32bitaesanahtariKey";

    $ivlen = openssl_cipher_iv_length($cipher="aes-192-cfb");
//Generate Random IV
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);

    $ciphertext = base64_encode( $iv.$ciphertext_raw );
    return $ciphertext;
}

function desEn($str)
{

}

function polybiosEn($str){
    $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','ä','ö','ü','ß');
    $polybios  = array('11','12','13','14','15','21','22','23','24','25','31','32','33','34','35','41','42','43','44','45','51','52','53','00','54','55','61','63','62','64');
    $output  = str_ireplace($alphabet, $polybios, $str);

    return($output);
}