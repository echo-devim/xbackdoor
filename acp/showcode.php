<?php
include('login.php');
define('allowed',true);
include('../db.php');
include('header.php');
$fid = (int) $_GET['fid'];
?>
<style>
/**
 * Tomorrow Night theme
 *
 * @author Chris Kempson
 * @author skim
 * @version 1.0.0
 */
pre {
    background-color: #1d1f21;
    overflow-y:auto;
    word-wrap: break-word;
    margin: 0px;
    padding: 20px;
    color: #c5c8c6;
    font-size: 14px;
    text-align:left;
}

pre, code {
    font-family: 'Monaco', courier, monospace;
}

pre .comment {
    color: #969896;
}

pre .variable.global, pre .variable.class, pre .variable.instance {
    color: #cc6666; /* red */
}

pre .constant.numeric, pre .constant.language, pre .constant.hex-color, pre .keyword.unit {
    color: #de935f; /* orange */
}

pre .constant, pre .entity, pre .entity.class, pre .support {
    color: #f0c674; /* yellow */
}

pre .constant.symbol, pre .string {
    color: #b5bd68; /* green */
}

pre .entity.function, pre .support.css-property, pre .selector {
    color: #81a2be; /* blue */
}

pre .keyword, pre .storage {
    color: #b294bb; /* purple */
}
</style>
    <script src="rainbow-custom.min.js"></script>
    <div id="main" class="content">
        <?php
        if ($res = $mysqli->query("SELECT code FROM functions WHERE id='".$fid."';")) {
                $res->data_seek(0);
                $row = $res->fetch_assoc();
                ?>
                <div style="margin-top:40px;border:4px solid #1d5f71">
                    <pre><code data-language="javascript"><?php echo htmlentities($row['code']); ?></code></pre>
                </div>
                <?php
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
