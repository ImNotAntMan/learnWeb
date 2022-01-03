<?php
require "dbconfig.php";
$memoid = $_GET['memoid'];
$subject = "없네?";
$contents = "없어?";
$registdate = "웅?";
echo $memoid;
$sql = "SELECT * FROM toymemo WHERE memoid=".$memoid;
$resultset = $conn->query($sql);
if($resultset->num_rows > 0) {
    $row = $resultset->fetch_assoc();
    $userid = $row['userid'];
    $subject = $row['subject'];
    $contents = $row['contents'];
    $registdate = $row['registdate'];
}
?>

<!DOCTYPE html>
<html lang="kr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>toy project 1st</title>
</head>
<body>
  <h1>메모 보기</h1>
  <form action="memo_modifyprocess.php" method="POST">
  <input type="hidden" value="<?=$userid?>" name="userid">
  <input type="hidden" value="<?=$memoid?>" name="memoid">
    <label>생성일 : </label><input maxlength="140" type="text" name="registdate" value="<?=$registdate?>" readonly/><br>
    <label>제목 : </label><input type="text" name="subject" value="<?=$subject?>"/><br>
    <label>내용 : </label><input type="textbox" name="contents" value="<?=$contents?>" /><br>
    <br>
    <a href="index.php">취소</a>
    <input type=submit value="저장">
  </form>
 </body>
</html>