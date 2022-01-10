<!-- 
  파일명 : employeer_list.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  업데이트일자 : 2022-01-10 by 민재기
  
  기능: 
  로그인 성공했을 때, success 메시지 간단히 출력하고...
  여기에서는 사용자 목록 리스팅 기능을 수행하도록 구성함.
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
  <link rel="stylesheet" href="/css/employeer.css">
  <title>사원 목록</title>
</head>

<body>
  <h1>사원 명단</h1>
  <br><br>
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
  // $employeer_name = $_GET['employeer_name'];
  // $employeer_number = $_GET['employeer_number'] ;
   if(!isset($_POST['employeer_name'], $_POST['employeer_number'])) {
    $sql = "SELECT COUNT(*) AS total_records FROM employeers";  
    echo $sql;
  } else {
    if($_POST['category'] == "employeer_name") {
      $search_value = $_POST['search_value'];
      $search_sql = " where employeer_name like '%".$search_value."%'";
      $sql = "SELECT COUNT(*) AS total_records FROM employeers".$search_sql;
      echo $sql;
    } else {
      $search_value = $_POST['search_value'];
      $search_sql = " where employeer_number like '%".$search_value."%'";
      $sql = "SELECT COUNT(*) AS total_records FROM employeers".$search_sql;
      echo $sql;
    }
  }
  $resultset = $conn->query($sql);
  $result = mysqli_fetch_array($resultset);
  $total_records = $result['total_records'];
  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1;
  // 여기까지 pagination용 추가
  //=================================================
  // 다음은 pagination을 위해 기존 코드 수정
  $employeer_id = $_SESSION['employeer_id'];
  $sql = "SELECT * FROM employeers where employeer_id=".$employeer_id." LIMIT ".$offset.", ".$total_records_per_page;
  $resultset = $conn->query($sql);
  if ($resultset->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>USERNAME</th><th>작업내용</th></tr>";
    // out data of each row
    while ($row = $resultset->fetch_assoc()) {
      echo "<tr><td>" . $row['employeer_number'] . "</td><td>" . $row['employeer_name'] . "</td><td><a href='employeer_detailview.php?employeer_id=" . $row['employeer_id'] . "'>상세정보확인</a></td></tr>";
    }
    echo "</table>";
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
      <div class="search">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
       <select name="category" id="category">
         <option value="employeer_name">이름</option>
         <option value="employeer_number">사번</option>
       </select>
       <input type="text" name="search_value">
       <input type="submit" value="검색">
      </form>
    </div>

  <a href="../index.php">인덱스페이지로</a>
</body>
<?php 
} else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>