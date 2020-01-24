<?php
$db = new mysqli("localhost", "root", "", "deneme");

if ($db->connect_error) {
	die("Sorry, there was a problem connecting to our database.");
}

$username = stripslashes(htmlspecialchars($_GET['username']));
$selectedAlgo = stripslashes(htmlspecialchars($_GET['algorithm']));



if ($selectedAlgo == "1"){
    $result = $db->prepare("SELECT * FROM caesar");
}
elseif ($selectedAlgo == "2") {
    $result = $db->prepare("SELECT * FROM aes");
}
elseif ($selectedAlgo == "3") {
    $result = $db->prepare("SELECT * FROM des");
}
elseif ($selectedAlgo == "4") {
    $result = $db->prepare("SELECT * FROM polybios");
}


$result->bind_param("s", $username);
$result->execute();

$result = $result->get_result();
while ($r = $result->fetch_row()) {
	echo $r[1];
	echo "\\";
    if ($selectedAlgo == "1"){
        $r[2] = caesarDec($r[2], 3);
    }
elseif ($selectedAlgo == "2") {
    $r[2] = aesDec($r[2]);
}
elseif ($selectedAlgo == "3") {
    $r[2] = aesDec($r[2]);
}
elseif ($selectedAlgo == "4") {
    $r[2] = polybiosDec($r[2]);
}

    echo $r[2];
	echo "\n";
}

function caesarDec($str, $offset) {
    $decrypted_text = "";
    $offset = $offset % 26;
    if($offset < 0) {
        $offset += 26;
    }
    $i = 0;
    while($i < strlen($str)) {
        $c = $str{$i};
        if(($c >= "A") && ($c <= 'Z')) {
            if((ord($c) - $offset) < ord("A")) {
                $decrypted_text .= chr(ord($c) - $offset + 26);
            } else {
                $decrypted_text .= chr(ord($c) - $offset);
            }
        } else {
            $decrypted_text .= " ";
        }
        $i++;
    }
    return $decrypted_text;
}

function aesDec($str){
    $key = "keybuguclubir32bitaesanahtariKey";
    $c = base64_decode($str);
    $ivlen = openssl_cipher_iv_length($cipher="aes-192-cfb");
    $iv = substr($c, 0, $ivlen);
    $ciphertext_raw = substr($c, $ivlen);
    $decText = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);

    return $decText;
}



function desDec($str){

}

function polybiosDec($str){
    $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','ä','ö','ü','ß');
    $polybios  = array('11','12','13','14','15','21','22','23','24','25','31','32','33','34','35','41','42','43','44','45','51','52','53','00','54','55','61','63','62','64');
    $output  = str_ireplace($polybios, $alphabet, $str);

    return($output);
}

?>




