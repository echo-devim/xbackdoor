<?php
    $PASSWORD = "change_me";
    if ($_POST['pass'] == $PASSWORD) {
        setcookie('admin',md5($PASSWORD),time()+(3600*24*30));
        header("Location: index.php");
    }
    if ($_COOKIE['admin'] != md5($PASSWORD)) {
        echo "<html><header><title>LOGIN</title></header><body>";
        echo "<form action='' method='POST'>Password: <input type='password' name='pass' /> <input type='submit' value='Login' />";
        exit("</body></html>");
    }
?>
