<!-- 
  파일명 : dbconfig.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  업데이트일자 : 2021-12-30 by 민재기
  
  기능: 
  DBMS 시스템에 접속하기 위한 기본 정보를 포함한다.
  상용 소프트웨어 제작시에는 DBMS별, 버전별 configuration 정보에 따라 
  동작하도록 구성하여야 한다.
-->
<?php
// 프로젝트 시작 전 toyappname을 정한다.
// oo_init_createdb에도 같은 이름으로 입력한다.
//============================
$toyappname = 'toymemoproj';
//============================

$dbservername = 'localhost'; // 개발 및 테스트 환경에서는 localhost를 전제로 한다.
$dbusername = 'demosite1';  // 현재 DBMS에 root계정을 이용하여 접속한다.
$dbpassword = 'demosite1';  // 현재 DBMS root 계정의 패스워드를 적는다.
$dbname = 'demosite1';

require_once "sysconfig.php"; // 시스템 관리를 위한 각종 환경 변수 및 메시지 처리

// 최초 작업시 dbconnection 설정 코드를 모든 코드에 분산 배치하였으나
// 애플리케이션 리스트럭처링하여 이곳에서 한번만 처리하도록 수정 조정함
// 2021-12-29 by swcodingschool
// get connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// check connection : 연결 확인, 오류가 있으면 메시지 출력 후 프로세스 종료
if($conn->connect_error) {
  echo outmsg(DBCONN_FAIL);
  die("연결실패 :".$conn->connect_error);
}else {
  if(DBG) echo outmsg(DBCONN_SUCCESS);
}

?>