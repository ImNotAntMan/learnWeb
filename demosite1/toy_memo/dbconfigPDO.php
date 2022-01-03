<?php
require_once "sysconfig.php"; // 시스템 관리를 위한 각종 환경 변수 및 메시지 처리
$servername = "toymemo";
$username = "toymemo";
$password = "toymemo";
$toyappname = 'toymemoproj';

try {
  $conn = new PDO("mysql:host=$servername;dbname=toymemo", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  if(DBG) echo outmsg(DBCONN_SUCCESS.$e->getMessage());
}
?>