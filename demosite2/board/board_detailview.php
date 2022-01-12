<!-- 
  파일명 : user_detailview.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  id를 GET방식으로 넘겨받아, 해당 id 레코드 정보를 검색,
  화면에 상세 정보를 뿌려준다.
-->
<?php
// db연결 준비
require "../util/dbconfig.php";
// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';
if($chk_login){
?>

<!DOCTYPE html>
<html lang="kr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <title>게시물 상세페이지</title>
</head>

<body>
  <h1>게시물 상세페이지</h1>
  <br>
  <?php
  $boardid = $_GET['id'];
  $employeer_name = $_SESSION['employeer_name'];
  $employeer_id = $_SESSION['employeer_id'];
  $sql = "SELECT * FROM board WHERE boardid = " . $boardid;
  $resultset = $conn->query($sql);
  if ($resultset->num_rows > 0) {
    echo "<table border=4><tr><th>ID</th><th>성명</th><th>제목</th><th>내용</th><th>등록일</th><th>수정</th><th>삭제</th></tr>";

    $row = $resultset->fetch_assoc();
    echo "<tr><td>" . $row['userid'] . "</td><td>" . $row['username'] . "</td><td>" . $row['subject'] . "</td><td width='50%'>" . $row['contents'] . "</td><td>" . $row['registdate'] . "</td>";
    // 글을 쓴 당자사만 글을 삭제, 수정
    if($employeer_id == $row['userid']) {
      echo "<td><a href='board_update.php?id=" . $row['boardid'] . "'>수정</a></td><td><a href='board_deleteprocess.php?id=" . $row['boardid'] . "'>삭제</a></td>";
    }
    echo "</tr>";
    echo "</table><br>";
    echo "답글 리스트";
    echo "<table border=1>";
    $sql = "SELECT * FROM board, boardreply WHERE board.boardid = boardreply.boardid and board.boardid = ". $boardid." order by boardreply.reply_registdate desc";
    echo "<h1>".$sql."</h1>";
    $resultset = $conn->query($sql);
    while ($row = $resultset->fetch_assoc()) {
      echo "<tr><td>" . $row['userid'] . "</td><td>" . $row['username'] . "</td><td>" . $row['reply_subject'] . "</td><td width='50%'>".$row['reply_contents']."</td><td>".$row['reply_registdate']."</td>";
      // 답글을 쓴 당사자만 삭제, 수정이 가능하게
      if($employeer_id == $row['employeer_id']) {
        echo "<td><a href='board_deletereply.php?id=".$row['replyid']."'>삭제</a><a href='board_modifyeply.php?id=".$row['replyid']."'>수정</a></td>";
      }
      echo "</tr><br>";
    }
  }
    echo "</table><br>";
  ?>
            <!-- 여기부터 답글 modal -->
            <div id='replyModal' class='modal'>
          <!-- 여기부터 로그인 form in modal -->
          <div class="modal-content">
            <span class="close">&times;</span>
            <form action="board_replyprocess.php" method="POST" class="loginbox">
              <input type="hidden" value="<?=$boardid?>" name="boardid">
              <input type="hidden" value="<?=$employeer_id?>" name="employeer_id">
              <label for="employeer_name"><b>성명</b></label><input type="text" name="employeer_name" value="<?=$employeer_name?>"/>
              <label for="subject"><b>제목 </label><input type="text" name="subject" placeholder="Enter subject" required />
              <label for="contents"><b>내용 </label><br><textarea name="contents" cols="65" rows="7" required /></textarea><br><br>
              <button type=submit>저장</button><br>
            </form>
             </div>
           </div>

  <a href="board_list.php">목록보기</a><button id='popup'>Comment</button>
</body>
<script src='../js/modal.js'></script>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>