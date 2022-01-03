<!-- 
  파일명 : board_writeprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  board_write.php 화면에서 입력된 값을 받아, validation 후
  board 테이블에 데이터를 추가한다.
-->

<?php
// db연결 준비
// 출력용 메시지 등의 include 문제 때문에 
// 연결준비는 여기에서 하지만
// 실제 연결은 입력한 비밀번호와 확인용비밀번호가 일치할 때 진행
require "../util/dbconfig.php";

// 데이터베이스 작업 전, 회원가입화면으로 부터 값을 전달 받고
$username = $_POST['username'];
$userid = $_POST['userid'];
$subject = $_POST['subject'];
$contents = $_POST['contents'];

$regist_err = FALSE; // 등록 과정중 오류 발생하였음을 체크함
$err_msg = "";
$i = 1;
while($i < 10) {
$subject = $subject." ".$i;
$contents = (string)$i." ".$contents;
$stmt = $conn->prepare("INSERT INTO board(userid,username,subject,contents) VALUES(?, ?, ?, ?)");
$stmt->bind_param("ssss", $userid, $username, $subject, $contents);
$stmt->execute();
$i++;
}
$conn->close();

// 등록 과정 중 오류가 발생하였으면 앞서.. 오류 내용 메시지를 확인하고
// 등록 화면으로 다시 돌아간다.
if ($regist_err) {
  echo "<a href='../board/board_list.php'>Confirm and Return to registform.</a>";
} else {
  echo outmsg(COMMIT_CODE);
  echo "<a href='board_list.php'>Confirm and Return to index.</a>";
}
?>