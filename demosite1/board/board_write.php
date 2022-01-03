<?php
// db연결 준비
require "../util/dbconfig.php";

// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
if($chk_login){
?>
<!DOCTYPE html>
<html lang="kr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>게시판 작성 화면</title>
</head>

<body>
  <h1>게시판 작성 화면</h1>
  <form action="board_multi_input_writeprocess.php" method="POST">
    <input type="hidden" name="userid" value="<?=$userid?>">
    <label>사용자 아이디 : </label><input type="text" name="username" placeholder="영숫자 8글자 이상으로 입력해주세요." value="<?= $username ?>" readonly /><br>
    <label>제목 : </label><input type="text" name="subject" placeholder="제목을 입력해주세요." required /><br>
    <label>내용 : </label><input type="text" name="contents" placeholder="내용을 입력해주세요." required /><br>
    <label>E-Mail : </label><input type="text" name="email" placeholder="이메일 주소를 이메일 주소 형식에 맞게 입력해주세요." required /><br>
    <br>
    <input type=submit value="저장">
  </form>
</body>
<?php 
}else {
//  echo outmsg(LOGIN_NEED);
  echo "<table><tr><th>ID</th><th>제목</th><th>작성자</th><th>작업내용</th></tr>";
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>