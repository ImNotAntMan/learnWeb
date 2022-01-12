<link rel="stylesheet" href="./css/memo.css">
<?php
require "./util/dbconfig.php";
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
    echo $total_records."<br>";
    echo "total_no_of_pages:".ceil($total_records / $total_records_per_page);
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 1;
    if($total_records_per_page > $total_no_of_pages) {
        $total_records_per_page = $total_no_of_pages;
    }
    // 여기까지 pagination용 추가
    //=================================================
?>
    <br><br><br><br><br><br><br><br>
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

    <li 
    <?php if($page_no * $total_records_per_page >= $total_no_of_pages){
    echo "class='disabled'";
    } 
    ?>>
    <a 
    <?php if($page_no < $total_no_of_pages) {
    echo "href='?page_no=$next_page'";
    } 
    ?>>Next</a>
    </li>

    <?php if($page_no < $total_no_of_pages){
    echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
    } ?>
    </ul>
