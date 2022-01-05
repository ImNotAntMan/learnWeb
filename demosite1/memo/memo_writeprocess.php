<!-- 
  파일명 : memo_writeprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  업데이트일자 : 2021-12-30 by 민재기
  
  기능: 
  create_memoForm.html 메모 입력화면에서 입력된 값을 받아, validation 후
  toymemo 테이블에 사용자 메모 데이터를 추가한다.
-->

<?php
  // db연결 준비
  // 출력용 메시지 등의 include 문제 때문에 
  // 연결준비는 여기에서 하지만
  // 실제 연결은 입력한 비밀번호와 확인용비밀번호가 일치할 때 진행
  require "../util/dbconfig.php";
  require "../util/loginchk.php";
  if (!$chk_login) {  // 로그인 상태가 아니라면
      echo "로그인 하세요";
      echo "<a href='../index.php'>처음으로</a>";
  } else {  
  // 데이터베이스 작업 전, 메모 쓰기화면으로 부터 값을 전달 받고
 $userid = $_POST['userid'];
 $subject = $_POST['subject'];
 $contents = $_POST['contents'];
 // 입력 처리를 위한 prepared sql 구성 및 bind
$stmt = $conn->prepare("INSERT INTO memo(userid, subject, contents) VALUES(?, ?, ?)");
//$stmt = $conn->prepare("INSERT INTO `memo`(`userid`, `subject`, `contents`) VALUES ('?','?','?')");
$stmt->bind_param("sss", $userid, $subject, $contents);
$stmt->execute();

// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

echo outmsg(COMMIT_CODE);
echo "<a href='./memo_list.php'>Confirm and Return to back.</a>";
  }
?>