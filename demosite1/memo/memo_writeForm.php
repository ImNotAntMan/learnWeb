<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if (!$chk_login) {  // 로그인 상태가 아니라면
    echo "로그인 하세요";
    echo "<a href='../index.php'>처음으로</a>";
} else {
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
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
  <h1>메모 작성</h1>
  <form action="memo_writeprocess.php" method="POST">
    <input type="hidden" value="<?=$userid?>" name="userid">
    <label>사용자 아이디 : </label><input maxlength="140" type="text" name="username" value="<?=$username?>" /><br>
    <label>제목 : </label><input type="text" name="subject" placeholder=" 1글자 이상으로 입력해주세요." required /><br>
    <label>내용 : </label><input type="text" name="contents" placeholder="메모 내용을 입력해 주세요." /><br>
    <br>
    <input type=submit value="저장">
    <input type=reset value="리셋">
  </form>
</body>
</html>
<?php } ?>