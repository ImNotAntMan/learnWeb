<!-- 
  파일명 : app_initiate.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  업데이트일자 : 2021-12-30 by 민재기
  
  기능: 
  데이터베이스에 사용자 등록을 위한 users 테이블을 생성한다.
  이 코드는 납품시 최초 1 회 실행하며, 현재 버전은 백업에 대한 고려는 하지 않았다.

  테이블 구성 : 
  CREATE TABLE `toymembership`.`users` ( `id` INT(6) NOT NULL AUTO_INCREMENT , `username` VARCHAR(20) UNIQUE NOT NULL COMMENT 'user account' , `passwd` VARCHAR(256) NOT NULL COMMENT 'user password' , `cellphone` VARCHAR(13) NOT NULL COMMENT 'phone number' , `email` VARCHAR(50) NOT NULL COMMENT 'mail address' , `registdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration date' , `lastdate` DATETIME NULL COMMENT 'last login date' , `status` INT NULL DEFAULT '0' COMMENT 'activity status' , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'users registration table';
-->

<?php
  require "../util/dbconfig.php";

  // create connection
  // get connection 하는 코드를 adbconfig로 이동하며... 
  // 아래 코드는 일단 코멘트 처리함. 2021-12-29 by swcodingschool
  //================  여기부터 ============================================
  // $conn = new mysqli($dbservername, $dbusername, $dbpassword,$dbname);

  // // check connection : 연결 확인, 
  // // 연결 중 오류 발생시 메시지 출력 후 프로세스 종료
  // if($conn->connect_error) {
  //   echo outmsg(DBCONN_FAIL);
  //   die("연결실패 :".$conn->connect_error);
  // }else {
  //   if(DBG) echo outmsg(DBCONN_SUCCESS);
  // }
  //================  여기까지 ============================================

  // 기존 테이블이 있으면 삭제하고 새롭게 생성하도록 질의 구성
  // 질의 실행과 동시에 실행 결과에 따라 메시지 출력
  // $sql = "DROP TABLE IF EXISTS users";
  // if($conn->query($sql) == TRUE){
  //   if(DBG) echo outmsg(DROPTBL_SUCCESS);
  // }
  $sql = "DROP TABLE IF EXISTS board";
  if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(DROPTBL_SUCCESS);
  }
  if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
    }else{
        echo outmsg(CREATETBL_FAIL);
    }
    
  $sql = "CREATE TABLE `board` (
     `boardid` INT(6) NOT NULL AUTO_INCREMENT , 
     `userid` INT(6) NOT NULL COMMENT 'user id' , 
     `username` VARCHAR(46) NOT NULL COMMENT 'user name' , 
     `subject` VARCHAR(256) NOT NULL COMMENT 'user subject' , 
     `contents` text NOT NULL COMMENT 'user contents' , 
     `registdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration date' ,  
     PRIMARY KEY (`boardid`)
     ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'users board table';";

    if($conn->query($sql) == TRUE){
        if(DBG) echo outmsg(CREATETBL_SUCCESS);
    }else{
        echo outmsg(CREATETBL_FAIL);
    }
    
    $sql = "CREATE TABLE `boardreply` (
    `replyid` INT(6) NOT NULL AUTO_INCREMENT , 
    `boardid` INT(6) NOT NULL COMMENT 'user id' , 
    `employeer_id` VARCHAR(46) NOT NULL COMMENT 'user name' , 
    `employeer_name` VARCHAR(50) NOT NULL COMMENT 'user name' , 
     `reply_subject` VARCHAR(256) NOT NULL COMMENT 'user subject' , 
     `reply_contents` text NOT NULL COMMENT 'user contents' , 
     `reply_registdate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'registration date' ,  
     PRIMARY KEY (`replyid`)
     ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'users reply board table';";
  
  //위 질의를 실행하고 실행결과에 따라 성공/실패 메시지 출력
  if($conn->query($sql) == TRUE){
    if(DBG) echo outmsg(CREATETBL_SUCCESS);
  }else{
    echo outmsg(CREATETBL_FAIL);
  }

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

// 프로세스 플로우를 인덱스 페이지로 돌려준다.
// header('Location: index.php');
// 작업 실행 단계별 메시지 확인을 위해 Confrim and return to back하도록 수정함!!
// 백그라운드로 처리되도록 할 경우 위 코드로 대체 할 것!!
echo "<a href='../board_list.php'>Confirm and Return to back</a>";
?>
