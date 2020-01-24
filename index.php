<html>
<head>
    <title>CrypChat | R-Kamos</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/util.css" type="text/css">
    <link rel="icon" type="image/png" href="images/favicon.ico"/>

    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">

    <title>CrypChat | R-Kamos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body onload="showlogin(); update();" style="background-image: url('images/bg-01.jpg');">


<div id="whitebg"></div>
<div id="loginbox">
    <div class="limiter">
        <div class="wrap-login100">
                    <span class="login100-form-logo">
                        <img style="width:90%" src="images\wp_pp_logo.png" alt="">
                    </span>
            <span class="login100-form-title p-b-34 p-t-27">
                        CrypChat
                    </span>

            <div class="wrap-input100 validate-input" data-validate = "Kullanıcı adınızı girin">
                <input class="input100" id="cusername" type="text" name="username" placeholder="Kullanıcı Adı">
                <span class="focus-input100" data-placeholder="&#xf207;"></span>
            </div>
            <!--
            <div class="wrap-input100 validate-input" data-validate="Şifrenizi girin">
                <input class="input100" id="password" type="password" name="pass" placeholder="Şifre">
                <span class="focus-input100" data-placeholder="&#xf191;"></span>
            </div>
            -->

            <div>
                <select class="wrap-input100 comboBox" id="comboID">
                    <option value="1">Caesar</option>
                    <option value="2">AES</option>
                    <option value="3">DES</option>
                    <option value="4">Polybios</option>

                </select>
            </div>

            <div class="container-login100-form-btn">

                <button class="login100-form-btn" onclick="chooseusername()">
                    Giriş
                </button>

            </div>

        </div>
    </div>
</div>
<div class="header">
        <span>
            <img src="images/logo2.png" style="height: 50px; float: left; margin-left: 75px">
        </span>
    <span>
            <p class="headerP">CryptChat</p>
        </span>
</div>
<div class="msg-container">
    <div class="msg-area" id="msg-area" style="width: 80%; margin: auto; "></div>
    <div class="bottom">
        <input type="text" name="msginput" class="msginput" id="msginput" onkeydown="if (event.keyCode === 13) sendmsg()" value="" placeholder="Mesajınızı buraya girin...">
    </div>
</div>
</div>




<script type="text/javascript">

    var msginput = document.getElementById("msginput");
    var msgarea = document.getElementById("msg-area");
    var selectedAlgo = document.getElementById("comboID");



    function chooseusername() {
        var user = document.getElementById("cusername").value;
        var selectedAlg = document.getElementById("comboID").value;
        document.cookie="messengerUname=" + user;
        checkcookie()
    }

    function showlogin() {
        document.getElementById("whitebg").style.display = "inline-block";
        document.getElementById("loginbox").style.display = "inline-block";
    }

    function hideLogin() {
        document.getElementById("whitebg").style.display = "none";
        document.getElementById("loginbox").style.display = "none";
    }

    function checkcookie() {
        if (document.cookie.indexOf("messengerUname") === -1) {
            showlogin();
        } else {
            hideLogin();
        }
    }

    function getcookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    }

    function escapehtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function update() {
        var xmlhttp=new XMLHttpRequest();
        var username = getcookie("messengerUname");
        var output = "";

        var algorithm = selectedAlgo.options[selectedAlgo.selectedIndex].value;


        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var response = xmlhttp.responseText.split("\n")
                var rl = response.length
                var item = "";
                for (var i = 0; i < rl; i++) {
                    item = response[i].split("\\")
                    if (item[1] != undefined) {
                        if (item[0] == username) {
                            output += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + item[1] + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">" + item[0] + " - Tarafından gönderildi</div> </div>";
                        } else {
                            output += "<div class=\"msgc\"> <div class=\"msg\">" + item[1] + "</div> <div class=\"msgarr\"></div> <div class=\"msgsentby\">" + item[0] + " - Tarafından gönderildi</div> </div>";
                        }
                    }
                }

                msgarea.innerHTML = output;
                msgarea.scrollTop = msgarea.scrollHeight;

            }
        }
        xmlhttp.open("GET","get-messages.php?username=" + username + "&algorithm=" + algorithm,true);
        xmlhttp.send();
    }

    function sendmsg() {

        var message = msginput.value;
        var algorithm = selectedAlgo.options[selectedAlgo.selectedIndex].value;
        alert(algorithm + "  " + typeof algorithm);

        if (message != "") {
            // alert(msgarea.innerHTML)
            // alert(getcookie("messengerUname"))

            var username = getcookie("messengerUname");

            var xmlhttp=new XMLHttpRequest();

            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    message = escapehtml(message)
                    msgarea.innerHTML += "<div class=\"msgc\" style=\"margin-bottom: 30px;\"> <div class=\"msg msgfrom\">" + message + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">" + username + " - Tarafından gönderildi </div> </div>";
                    msginput.value = "";
                }
            }
            xmlhttp.open("GET","update-messages.php?username=" + username + "&message=" + message + "&algorithm=" + algorithm,true);
            xmlhttp.send();
        }
        msgarea.scrollTop = msgarea.scrollHeight;

    }

    setInterval(function(){ update() }, 2500);
</script>
</body>
</html>
