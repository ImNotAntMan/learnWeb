<!-- 
  파일명 : oo_user_updateprocess.php
  파일명 : memo_modifyprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  업데이트일자 : 2021-12-30 by 민재기
  
  기능: 
  memo_modify.php 메모 수정 화면에서 입력된 값을 받아, 
  memo 테이블에 수정된 데이터를 업데이트 한다.
-->

<?php
  // db연결 준비
  require "../util/dbconfig.php";
  require "../util/loginchk.php";
  if (!$chk_login) {  // 로그인 상태가 아니라면
      echo "로그인 하세요";
      echo "<a href='../index.php'>처음으로</a>";
  } else {

    function stmtupdate($i, $subject, $contents, $memoid) {
    if($i == 0) {   // 제목, 내용 변경
        $stmt = $conn->prepare("UPDATE memo SET subject = ?, SET contents = ?  WHERE memoid = ?" );
        $stmt->bind_param("sss", $subject, $contents, $memoid);
    } else if ($i == 1) {   // 내용 변경
        $stmt = $conn->prepare("UPDATE memo SET contents = ? WHERE memoid = ?" );
        $stmt->bind_param("ss", $contents, $memoid);
    } else if ($i == 2) {   // 제목 변경
        echo $subject;
        echo $contents;
        echo $memoid;
        $stmt = $conn->prepare("UPDATE memo SET subject = ? WHERE memoid = ?");
        $stmt->bind_param("ss", $subject, $memoid);
    } else {

    }
    $stmt->execute();
  }

  function stmtinsert($userid, $memoid, $registdate, $originalsubject, $originalcontents, $msg) {
        $stmt = $conn->prepare("INSERT INTO memoupdate(userid, memoid, modifydate, subject, contents, modify) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $userid, $memoid, $registdate, $originalsubject, $originalcontents, $msg);
        $stmt->execute();    
  }

  // 데이터베이스 작업 전, 메모 수정 화면으로 부터 값을 전달 받고
  $memoid = $_POST['memoid'];
  $userid = $_POST['userid'];
  $subject = $_POST['subject'];
  $contents = $_POST['contents'];
  $registdate = date("Y-m-d H:i:s");
  
  // 현재의 데이터를 받아 온다. 
  $sql = "select * from memo where memoid=".$memoid." order by registdate desc";
  $resultset = $conn->query($sql);
  if($resultset->num_rows > 0) {
        $row = $resultset->fetch_assoc();
        $originalsubject = $row['subject'];
        $originalcontents = $row['contents'];
}

  // 두 값을 비교하여 수정 사항이 어떤건지 알아내자.
  if(($subject != $originalsubject) && ($contents != $originalcontents)) {
        $msg = "제목, 내용 변경";
        $stmt = $conn->prepare("UPDATE memo SET subject = ?, contents = ? WHERE memoid = ?");
        $stmt->bind_param("sss", $subject, $contents, $memoid);
        $stmt->execute();    
        $stmt = $conn->prepare("INSERT INTO memoupdate(userid, memoid, modifydate, subject, contents, modify) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $userid, $memoid, $registdate, $originalsubject, $originalcontents, $msg);
        $stmt->execute();    

    } else if (($subject == $originalsubject) && ($contents != $originalcontents)) {
        $msg = "내용 변경";
        $stmt = $conn->prepare("UPDATE memo SET contents = ? WHERE memoid = ?");
        $stmt->bind_param("ss", $contents, $memoid);
        $stmt->execute();    
        $stmt = $conn->prepare("INSERT INTO memoupdate(userid, memoid, modifydate, subject, contents, modify) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $userid, $memoid, $registdate, $originalsubject, $originalcontents, $msg);
        $stmt->execute();    
  } else if(($subject != $originalsubject) && ($contents == $originalcontents)) {
        $msg = "제목 변경";
        $stmt = $conn->prepare("UPDATE memo SET subject = ? WHERE memoid = ?");
        $stmt->bind_param("ss", $subject, $memoid);
        $stmt->execute();    
        $stmt = $conn->prepare("INSERT INTO memoupdate(userid, memoid, modifydate, subject, contents, modify) VALUES(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $userid, $memoid, $registdate, $originalsubject, $originalcontents, $msg);
        $stmt->execute();    
// $i = 2; // 제목 변경
    //     stmtupdate($i, $subject, $contents, $memoid);
        //  stmtinsert($userid, $memoid, $registdate, $originalsubject, $originalcontents, $msg);

  } else {
        $msg = "뭘 하실려구??";
        echo "<script>alert('".$msg."')</script>";
  }

  // 데이터베이스 연결 인터페이스 리소스를 반납한다.
  $conn->close();

  // 프로세스 플로우를 인덱스 페이지로 돌려준다.
  header('Location: memo_list.php?userid='.$userid.'&memoid='.$memoid);
}
?>