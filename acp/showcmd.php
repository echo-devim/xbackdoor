<?php
include('login.php');
define('allowed',true);
include('../db.php');
include('header.php');
?>
    <div id="main" class="content">
        <p>
            <h1>Commands</h1>
        </p>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            if ($res = $mysqli->query("SELECT * FROM functions;")) {
                $res->data_seek(0);
                while ($row = $res->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><a href="showcode.php?fid=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
                    <td><a href="insertcmd.php?n=<?php echo $row['name']; ?>&c=<?php echo urlencode($row['code']); ?>">Edit</a></td>
                    <td><a href="delete.php?id=<?php echo $row['id']; ?>&t=functions&p=showcmd.php">Delete</a>
                </td>
                <?php
                }
                $res->close();
            }
            ?>
        </table>
        <p>
            <input type="button" value="Insert a new command!" onclick="document.location.href='insertcmd.php';" />
        </p>
   </div>
</body>
</html>
<?php
$mysqli->close();
?>
