<!-- 
  파일명 : user_update.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-29
  업데이트일자 : 2021-12-29
  
  기능: 
  상세정보확인화면에서 수정을 클릭하였을 때 진행되는 코드
  전 단계에서 전달되 id 를 이용, 값을 수정한다. 
-->
<?php
// 연결 준비
require '../util/dbconfig.php';

// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';
if($chk_login){

// 수정할 레코드의 id값을 받아온다.
$boardid = $_GET['id'];
// 해당 id로 데이터를 검색하는 질의문 구성
$sql = "SELECT * FROM board WHERE boardid = " . $boardid;
// 해당 질의문 실행하여 결과 가져오기
$result = $conn->query($sql);
// 결과셋을 한 개의 행으로 처리하고,
// 필요로 하는 각 컬럼의 값을 얻어온다.
if ($result->num_rows > 0) {
  $row = $result->fetch_array();
  $boardid = $row['boardid'];
  $username = $row['username'];
  $subject = $row['subject'];
  $contents = $row['contents'];
} else {
  echo outmsg(INVALID_USER);
}
?>

<!DOCTYPE html>
<html lang="kr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>게시판 글 수정</title>
</head>

<body>
  <h1>게시판 글 수정</h1>
  <form action="board_updateprocess.php" method="POST">
    <input type="hidden" name="id" value="<?= $boardid ?>" />
    <label>사용자 이름 : </label><input type="text" name="username" value="<?=$username?>" readonly /><br>
    <label>제목 : </label><input type="text" name="subject" value="<?=$subject?>" /><br>
    <label>내용 : </label><input type="text" name="contents" value="<?=$contents?>" /><br>
    <br>
    <input type=submit value="저장">
  </form>
  <a href="board_list.php">목록보기</a>
</body>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>