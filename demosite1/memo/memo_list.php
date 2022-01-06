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
<?php
// ===========================================
  // 여기부터 pagination용 추가
  // 1. 페이지를 $_GET을 이용하여 전달 받는다. 없으면 현재 $page = 1이다.
  if(isset($_GET['page_no']) && $_GET['page_no']!="") {
    $page_no = $_GET['page_no'];
  } else {
    $page_no = 1;
  }

  // 2. 페이지당 보여줄 리스트 갯수값을 정한다.
  $total_records_per_page = 9;

  // 3. OFFSET을 계산하고 앞/뒤 페이지 등의 변수를 설정한다.
  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;
  $adjacents = 2;

  // 4. 전체 페이지 수를 계산한다.
  $sql = "SELECT COUNT(*) AS total_records FROM memo";
  $resultset = $conn->query($sql);
  $result = mysqli_fetch_array($resultset);
  $total_records = $result['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1;
  // 여기까지 pagination용 추가
  //=================================================
  // 다음은 pagination을 위해 기존 코드 수정
  // $sql = "SELECT * FROM memo";
  $sql = "SELECT * FROM memo LIMIT ".$offset.", ".$total_records_per_page;
  $resultset = $conn->query($sql);

?>
    <div>
    <h1>메모 리스트</h1>
    <table border=1>
        <tr>
        <th>제목</th><th>생성일<br>최종수정일</th><th>사용자이름</th><th></th><th></th>
        </tr>
        <?php
           $sql = "SELECT * FROM memo where userid=".$userid." order by registdate desc limit                                                                       ".$offset.", ".$total_records_per_page;
           echo $sql;
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
    <ul class="pagination">
  <?php if($page_no > 1){
  echo "<li><a href='?page_no=1'>First Page</a></li>";
  } ?>
      
  <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
  <a <?php if($page_no > 1){
  echo "href='?page_no=$previous_page'";
  } ?>>Previous</a>
  </li>
<?php
  
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                }
        }
?>

  <li <?php if($page_no >= $total_no_of_pages){
  echo "class='disabled'";
  } ?>>
  <a <?php if($page_no < $total_no_of_pages) {
  echo "href='?page_no=$next_page'";
  } ?>>Next</a>
  </li>

  <?php if($page_no < $total_no_of_pages){
  echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
  } ?>
  </ul>
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
