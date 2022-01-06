<?php
$datestream = date("Y-m-d", time());
require "../util/dbconfig.php";
require "../util/loginchk.php";
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
if (!$chk_login) {  // 로그인 상태가 아니라면
    echo "로그인 하세요";
    echo "<a href='../index.php'>처음으로</a>";
} else {
?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>메모 리스트</title>
</head>
<body>
<header>
    <div class="headeritem"><a href="/index.php">logo</logo></div>
    <div class="headeritem">megamenu1</div>
    <div class="headeritem">megamenu2</div>
    <div class="loginlink"><?=$_SESSION['username']?><button><a href="./membership/user_logout.php">logout</a></button>
</div>
</header>
    <div>
    <h1>메모 리스트</h1>
    <table border=1>
        <tr>
        <th>제목</th><th>생성일<br>최종수정일</th><th>사용자이름</th><th></th><th></th>
        </tr>
        <?php
           $sql = "SELECT * FROM memo where userid=".$userid." order by registdate desc";
           //$sql = "SELECT memoupdate.subject, toymemoupdate.contents, toymemoupdate.modifydate, toymemoupdate.modify, toymemo.registdate FROM toymemo INNER JOIN toymemoupdate ON toymemo.memoid = toymemoupdate.memoid WHERE toymemoupdate.memoid=".$memoid." ORDER BY modifydate DESC;" ;
           $resultset = $conn->query($sql);

           if($resultset->num_rows > 0) {
            while($row = $resultset->fetch_assoc()) {
                $sqlupdate = "select modifydate from memoupdate where memoid=".$row['memoid']." order by modifydate desc";
                $modifyset = $conn->query($sqlupdate);
                if($modifyset -> num_rows > 0) {
                    $rowmodify = $modifyset->fetch_assoc();
                    $modifydate = $rowmodify['modifydate'];
                } else {
                    $modifydate = "수정이력없음.";
                }
        ?>
             <div class="contents">
              <label for="subject"><b>제목: <?=$row['subject']?></b></label><br>
              <label for="passwd"><b>내용: <?=$row['contents']?></b></label><br>
              <label for="registdate"><b>등록일: <?=$row['registdate']?></b></label><br>
              <label for="modifydate"><b>수정일: <?=$modifydate?></b></label><br></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
          </div>
          <a href="memo_writeForm.php" color="blue">새로운 메모 작성</a>
                <a href="/index.php">처음으로</a>
            </div>

        <?php
                echo "<tr>";
                echo "<td>";
                echo "<a href='memo_view.php?memoid=".$row['memoid']."&userid=".$row['userid']."'>";
                echo $row['subject'];
                echo "</a>";
                echo "</td>";
                echo "<td>";
                echo $row['registdate']."<br>";
                echo $modifydate;
                echo "</td>";
                echo "<td>";
                echo $username;
                echo "</td>";
                echo "<td>";
                echo "<a href='memo_modify.php?memoid=".$row['memoid']."'>수정</a>";
                echo "</td>";
                echo "<td>";
                echo "<a href='memo_delete.php?memoid=".$row['memoid']."'>삭제</a>";
                echo "</td>";
                if($modifyset -> num_rows > 0) {
                    echo "<td>";
                    echo "<a href='memo_modifylist.php?memoid=".$row['memoid']."'>수정이력</a>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        }
        ?>
    </table>
    <table>
        <tr>
            <td>
                <a href="memo_writeForm.php">새로운 메모 작성</a>
                <a href="/index.php">처음으로</a>
            </td>
        </tr>
    </table>
    </div>
    <nav>
    <ul>
      <li><a href="/memo/memo_list.php">MemoApp</a></li>
      <li><a href="/board/board_list.php">게시판<br></a></li>
      <li>Blog</li>
      
    </ul>
  </nav>
  <!-- -->
  <main>
  </main>
  <footer><br>발이에요
  </footer>
  <script src='../js/login.js'></script>

</body>
</html>
<?php } ?>
