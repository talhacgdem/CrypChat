<?php
$db = new mysqli("localhost", "root", "", "deneme");

if ($db->connect_error) {
	die("Sorry, there was a problem connecting to our database.");
}

$username = stripslashes(htmlspecialchars($_GET['username']));

$result = $db->prepare("SELECT * FROM messages");
$result->bind_param("s", $username);
$result->execute();

$result = $result->get_result();
while ($r = $result->fetch_row()) {
	echo $r[1];
	echo "\\";
	echo decrypt($r[2],3);
	echo "\n";
}

function decrypt($str, $offset) {
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
?>


