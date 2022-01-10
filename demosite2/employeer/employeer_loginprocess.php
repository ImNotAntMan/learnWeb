<!-- 
  파일명 : user_loginprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  user_login.php 로그인 화면에서 입력된 값을 받아 
  유저명과 비밀번호를 확인, 등록된 사용자임을 확인한다.
-->

<?php
// 여기부터는 로그인 성공시 세션관리를 위한 코드 추가
session_start();
// db연결 준비
require_once "../util/dbconfig.php";

// 데이터베이스 작업 전, 로그인 화면으로 부터 값을 전달 받고
//$username = $_POST['username'];
//$passwd = $_POST['passwd'];
$employeer_number = $_REQUEST['employeer_number'];
$employeer_passwd = $_REQUEST['employeer_passwd'];
// 세션관리를 위하여 클라이언트 정보 수집
//$userip = get_client_ip();
$userip = "192.168.100.44";
// 사용자 계정 존재 여부 확인을 위한 질의 구성
$stmt = $conn->prepare("SELECT * FROM employeers WHERE employeer_number = ? and employeer_passwd = sha2(?,256)");
$stmt->bind_param("ss", $employeer_number, $employeer_passwd);

$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_array($result);

if (!empty($row['employeer_number'])) {
  echo outmsg(LOGIN_SUCCESS);
  // 여기부터 로그인 성공시 세션관리를 위한 추가 코드
  //session_start();
  echo outmsg('SESSION_CREATE');
  //echo outmsg($userip);
  if(isset($_REQUEST['chkbox'])){
    $a = setcookie('employeer_number', $employeer_number, time() + 60);
    $b = setcookie('employeer_passwd', $employeer_passwd, time() + 60);
  }
  $_SESSION['employeer_number'] = $employeer_number;
  $_SESSION['employeer_name'] = $row['employeer_name'];
  $_SESSION['employeer_id'] =  $row['employeer_id'];
  $_SESSION['userip'] = $userip;
  // 여기까지 로그인 성공시 세션관리를 위한 추가 코드
  $conn->close();
  //header('Location: user_list.php');
  echo "<a href='employeer_list.php'>목록보기</a>";
} else {
  echo outmsg(LOGIN_FAIL);
  $conn->close();
  //header('Location: index.php');
  echo "<a href='../index.php'>index 페이지로</a>";
}


?>