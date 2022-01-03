<!-- 
  파일명 : user_list.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  로그인 성공했을 때, success 메시지 간단히 출력하고...
  여기에서는 사용자 목록 리스팅 기능을 수행하도록 구성함.
-->
<?php
// db연결 준비
require "../util/dbconfig.php";

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
  <title>게시판 목록</title>
</head>

<body>
  <h1>게시판 목록</h1>
  <a href="../index.php">인덱스페이지로</a>
  <a href="board_write.php">쓰기</a>
  <?php
  $sql = "SELECT * FROM board order by registdate desc";
  $resultset = $conn->query($sql);

  if ($resultset->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>제목</th><th>작성자</th></tr>";
    // out data of each row
    while ($row = $resultset->fetch_assoc()) {
      echo "<tr><td>" . $row['boardid'] . "</td><td><a href='board_detailview.php?id=".$row['boardid']."'>" . $row['subject'] . "</td><td>" .$row['username']. "</td><td></a></td></tr>";
    }
    echo "</table>";
  }
  ?>
  <a href="../index.php">인덱스페이지로</a>
  <a href="board_write.php">쓰기</a>
</body>
<?php 
}else {
//  echo outmsg(LOGIN_NEED);
  echo "<table><tr><th>ID</th><th>제목</th><th>작성자</th><th>작업내용</th></tr>";
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>