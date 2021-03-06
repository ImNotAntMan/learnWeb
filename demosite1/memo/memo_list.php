<link rel="stylesheet" href="./css/memo.css">
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
    <link rel="stylesheet" href="/css/memo.css">
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
  $total_records_per_page = 12;

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
    <h1>메모 리스트</h1>
    <div class="search">
      <form action="memo_search.php" method="POST">
       <select name="category" id="category">
         <option value="search_subject">제목</option>
         <option value="search_contents">내용</option>
       </select>
       <input type="text" name="search">
       <input type="submit" value="검색">
      </form>
    </div>
    <div class="contents">
        <?php
           $sql = "SELECT * FROM memo where userid=".$userid." order by registdate desc limit ".$offset.", ".$total_records_per_page;
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
             <div class="contents_deep">
              <label for="subject"><b>제목: <?=$row['subject']?></b></label><br>
              <?php if($row['images']) { ?>
              <a href="image_view.php?src=<?=$row['images']?>" target="_blank"><img src="uploads/<?=$row['images']?>" width="300" height="300"></a>
              <?php } else  {?>  
              <?php } ?>
              <label for="passwd"><b>내용: <?=$row['contents']?></b></label><br>
              <label for="registdate"><b>등록일: <?=$row['registdate']?></b></label><br>
              <label for="modifydate"><b>수정일: <?=$modifydate?></b></label><br></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="memo_modify.php?memoid=<?=$row['memoid']?>">수정&nbsp;&nbsp;</a><a href="memo_modifylist.php?memoid=<?=$row['memoid']?>">수정이력</a>
            </div>
            <?php } ?>
    </div>
       <?php
            }
        }
        ?>
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
  // 등차수열의 일반항 an = 초기값 + (수량 -1)*차이
  //여기서 리스트의 초기값은 1, 총수량(묶음)은 ceil(page_no/$total)records_per_page), 
  // 차이는 total_records_per_page
  // for 문을 돌리려면 초기값(start_number)과, 마지막값(end_number)을 알아야 한다.
  //나는 12페이지씩 나오게 했으므로 1-12, 13-24, 25-36...가 각 페이지의 처음이다.
  //레코드 갯수가 337개이므로 12개로 나누면 total_no_of_page=29, 이것을 12개씩 묶으니 3묶음
  //a1 = 1 + (1 - 1)*12 = start_number 1
  //a2 = 1 + (2 - 1)*12 = start_number 13
  //a3 = 1 + (3 - 1)*12 = start_number 25
  //end_number1 = start_number + 12 = 13 틀림 따라서 -1을 줘야함.
  //end_number1 = 1 + 12 - 1 = 12 1~12
  //end_number2 = 13 + 12 - 1 = 24 13~24
  //end_number3 = 25 + 12 - 1 = 36 그러나 총페이지수가 29이므로 end_number3=29 가 되는 if문 필요.
    $start_number = (ceil($page_no / $total_records_per_page) - 1) * $total_records_per_page + 1;
    $end_number = $start_number + $total_records_per_page - 1;
    if($end_number >= $total_no_of_pages) {
        $end_number = $total_no_of_pages;
    }
	for ($counter = $start_number; $counter <= $end_number; $counter++){
	  if ($counter == $page_no) {
	    echo "<li class='active'><a>$counter</a></li>";	
	  }else{
      echo "<li><a href='?page_no=$counter'>$counter</a></li>";
    }
  }
?>

  <li <?php if($page_no * $total_records_per_page >= $total_no_of_pages){
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
      <li><a href="memo_list.php">MemoApp</a></li>
      <li><a href="../board/board_list.php">게시판<br></a></li>
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
