<?php
$db = new mysqli("localhost", "root", "", "deneme");

if ($db->connect_error) {
    die("Sorry, there was a problem connecting to our database.");
}

$username = stripslashes(htmlspecialchars($_GET['username']));
$message = stripslashes(htmlspecialchars($_GET['message']));
$algo = stripslashes(htmlspecialchars($_GET['algo']));

if ($message == "" || $username == "" || $algo == "") {
    die();
}

if ($algo == "1"){
    $message = encrypt($message, 3);
}
elseif ($algo == "2") {
    // code...
}
elseif ($algo == "3") {
    // code...
}
elseif ($algo == "4") {
    // code...
}
elseif ($algo == "5") {
    // code...
}




$result = $db->prepare("INSERT INTO messages VALUES('',?,?)");
$result->bind_param("ss", $username, $message);
$result->execute();

function encrypt($str, $offset) {
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
