<?php
//Insert your correct info, or mad problems will arise.
$username = "root";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
  or die("<h1>FUCK. Set up the database, can't connect! Default username: root, Default password: (none)</h1>");
 $selected = mysql_select_db("wikilinks",$dbhandle) 
  or die("<h1>SHIT. Couldn't find the table 'wikilinks'. Upload Steve's .sql table for it.</h1>");
?>