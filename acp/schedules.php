<?php
include('login.php');
define('allowed',true);
include('../db.php');
include('header.php');
$uid = (int) $_GET['uid'];
?>
    <div class="content">
        <p>
            <h1>Scheduled Commands</h1>
        </p>
        <table>
            <tr>
                <th>User ID (<a href="#" ctitle="Identify a user in a certain site" class="tooltip">?</a>)</th>
                <th>Command Name</th>
                <th>Date</th>
                <th>Executed</th>
                <th>Response Date</th>
                <th>Response</th>
                <th></th>
            </tr>
            <?php
            if ($res = $mysqli->query("SELECT schedules.id as sid, schedules.*,functions.* FROM schedules, functions WHERE (uid=".$uid." OR ".$uid."=0) AND functions.id=schedules.fid;")) {
                $res->data_seek(0);
                while ($row = $res->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['uid']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['executed']; ?></td>
                    <td><?php echo $row['responsedate']; ?></td>
                    <td><div><?php echo htmlspecialchars(urldecode($row['response'])); ?></div></td>
                    <td><a href="delete.php?id=<?php echo $row['sid']; ?>&t=schedules&p=schedules.php?uid=<?php echo $uid ?>">Delete</a>
                </td>
                <?php
                }
                $res->close();
            }
            ?>
        </table>
        <p>
            <input type="button" value="Schedule a new command!" onclick="document.location.href='sendcmd.php?uid=<?php echo $uid ?>';" />
        </p>
   </div>
</body>
</html>
<?php
$mysqli->close();
?>
