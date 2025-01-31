<?php
/*
This file is part of Novetus, but unlike the rest of the program where it is under the MIT license, 
this file is under the GPL 3.0 license.

Novetus's query.php is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Novetus's query.php is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Novetus's query.php.  If not, see <https://www.gnu.org/licenses/>.
*/

//NOVETUS MASTER SERVER QUERY CODE

//server name
$name = $_GET["name"];
//server ip
$ip = $_GET["ip"];
//server port
$port = $_GET["port"];
//client name
$client = $_GET["client"];
//online status
$online = $_GET["online"];

//strings
$deleteentry = 1;
$status = "Offline";

//ONLY the $name and $client arguments will show up in the master server!
$file = 'serverlist.txt';
$text = base64_encode(base64_encode($name).'|'.base64_encode($ip).'|'.base64_encode($port).'|'.base64_encode($client))."\r\n";

if ($online == 1)
{
	$deleteentry = 0;
	
	foreach(file($file) as $line)
	{
		if (strpos($line, $text) !== false)
		{
			$file_contents = file_get_contents($file);
			$contents = str_replace($line, '', $file_contents);
			file_put_contents($file, $contents);
		}
	}
	
	file_put_contents($file, $text, FILE_APPEND);
	
	$status = "Online";
}

if ($deleteentry == 1)
{
	foreach(file($file) as $line) 
	{
		if (strpos($line, $text) !== false)
		{
			$file_contents = file_get_contents($file);
			$contents = str_replace($line, '', $file_contents);
			file_put_contents($file, $contents);
		}
	}
}

// Display the server info to browsers.
echo "" . htmlspecialchars($name) . ".<br>A " . htmlspecialchars($client) . " server.<br>Server Status: " . htmlspecialchars($status) . "";
?>