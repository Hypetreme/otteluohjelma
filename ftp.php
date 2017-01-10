<?php

// connect to FTP server
$ftp_server = "84.34.147.50";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
// login
if (@ftp_login($ftp_conn, "appstudios", "1GbUlFzL"))
  {
  echo "FTP Connection established.<br>";
  }
else
  {
  echo "Couldn't establish a FTP connection.<br>";
  }
ftp_pasv($ftp_conn, true);
?>