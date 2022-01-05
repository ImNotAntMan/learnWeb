<!-- 
  파일명 : oo_user_deleteprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  id를 GET 패러미터로 받아 삭제처리한다.
-->
<?php
  // db연결 준비
  require "./dbconfig.php";

  // create connection
  // get connection 하는 코드를 adbconfig로 이동하며... 
  // 아래 코드는 일단 코멘트 처리함. 2021-12-29 by swcodingschool
  //================  여기부터 ============================================
  // $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

  // // check connection : 연결 확인, 오류가 있으면 메시지 출력 후 프로세스 정료
  
  // if($conn->connect_error) {
  //   echo outmsg(DBCONN_FAIL);
  //   die("연결실패 :".$conn->connect_error);
  // }else {
  //   if(DBG) echo outmsg(DBCONN_SUCCESS);
  // }
  //================  여기부터 ============================================
  
  $memoid = $_GET['memoid'];

  $sql = "DELETE FROM memo WHERE memoid=".$memoid;

  if($conn->query($sql) == TRUE) {
    echo outmsg(DELETE_SUCCESS);
  }else {
    echo outmsg(DELETE_FAIL);
  }

  $sql = "DELETE FROM memoupdate WHERE memoid=".$memoid;

  if($conn->query($sql) == TRUE) {
    echo outmsg(DELETE_SUCCESS);
  }else {
    echo outmsg(DELETE_FAIL);
  }

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

  // 프로세스 플로우를 사용자 목록 페이지로 돌려준다.
  header('Location: index.php');
?>