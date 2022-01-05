<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if (!$chk_login) {  // 로그인 상태가 아니라면
    echo "로그인 하세요";
    echo "<a href='../index.php'>처음으로</a>";
} else {
$modifyid = $_GET['modifyid'];
$memoid = $_GET['memoid'];
$userid = $_GET['userid'];
$subject = "없네?";
$contents = "없어?";
$registdate = "웅?";
$sql = "SELECT * FROM memo WHERE memoid=".$memoid;
$resultset = $conn->query($sql);
if($resultset->num_rows > 0) {
    $row = $resultset->fetch_assoc();
    $memoid = $row['memoid'];
    $subject = $row['subject'];
    $contents = $row['contents'];
    $registdate = $row['registdate'];
}
$sqlupdate = "select modifydate, subject, contents, modify from memoupdate where modifyid=".$modifyid;
$modifyset = $conn->query($sqlupdate);
if($resultset->num_rows > 0) {
    $row = $modifyset->fetch_assoc();
    $modifydate = $row['modifydate'];
    $subjectupdate = $row['subject'];
    $contentsupdate = $row['contents'];
    $modify = $row['modify'];
}
$conn->close();
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
    <input type="hidden" value="1" name="userid">
    <label>생성일 : </label><input type="text" name="registdate" value="<?=$registdate?>" /><br>
    <label>수정일 : </label><input maxlength="140" type="text" name="registdate" value="<?=$modifydate?>" /><br>
    <label>변경내역 : </label><input maxlength="140" type="text" name="registdate" value="<?=$modify?>" /><br>
    <label>현재제목 : </label><input type="text" name="subject" value="<?=$subject?>"/><label>수정전제목 : </label><input type="text" name="subject" value="<?=$subjectupdate?>"/><br>
    <label>현재내용 : </label><input type="textbox" name="contents" value="<?=$contents?>" /><label>수정전내용 : </label><input type="textbox" name="contents" value="<?=$contentsupdate?>" /><br>
    <br>
    <a href="memo_modify.php?memoid=<?=$memoid?>">수정</a>
    <a href="memo_list.php">리스트</a>
    <a href="memo_modifyupdate.php?memoid=<?=$memoid?>">바꾸기</a>
    <a href="memo_delete.php?memoid=<?=$memoid?>">삭제</a>
 </body>
</html>
<?php } ?>