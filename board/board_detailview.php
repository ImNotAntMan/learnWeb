<!-- 
  파일명 : user_detailview.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  id를 GET방식으로 넘겨받아, 해당 id 레코드 정보를 검색,
  화면에 상세 정보를 뿌려준다.
-->
<?php
// db연결 준비
require "../util/dbconfig.php";
$userid = $_GET['id'];
// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';
if($chk_login){
?>

<!DOCTYPE html>
<html lang="kr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>게시물 상세페이지</title>
</head>

<body>
  <h1>게시물 상세페이지</h1>
  <br>
  <?php

  $boardid = $_GET['id'];

  $sql = "SELECT * FROM board WHERE boardid = " . $boardid;
  $resultset = $conn->query($sql);

  if ($resultset->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>성명</th><th>제목</th><th>내용</th><th>등록일</th><th>수정</th><th>삭제</th></tr>";

    $row = $resultset->fetch_assoc();
    echo "<tr><td>" . $row['userid'] . "</td><td>" . $row['username'] . "</td><td>" . $row['subject'] . "</td><td width='50%'>" . $row['contents'] . "</td><td>" . $row['registdate'] . "</td><td><a href='board_update.php?id=" . $row['boardid'] . "'>수정</a></td><td><a href='board_deleteprocess.php?id=" . $row['boardid'] . "'>삭제</a></td></tr>";
    echo "</table>";
  }
  ?>
  <br>
  <a href="board_list.php">목록보기</a><a href="board_update.php?id=<?= $boardid ?>">수정</a>
</body>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>