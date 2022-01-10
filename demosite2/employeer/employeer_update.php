<!-- 
  파일명 : user_update.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-29
  업데이트일자 : 2021-12-29
  
  기능: 
  상세정보확인화면에서 수정을 클릭하였을 때 진행되는 코드
  전 단계에서 전달되 id 를 이용, 값을 수정한다. 
-->
<?php
// 연결 준비
require '../util/dbconfig.php';

// 로그인한 상태일 때만 이 페이지 내용을 확인할 수 있다.
require_once '../util/loginchk.php';
if($chk_login){

// 수정할 레코드의 id값을 받아온다.
$employeer_id = $_GET['employeer_id'];
// 해당 id로 데이터를 검색하는 질의문 구성
$sql = "SELECT * FROM employeers WHERE employeer_id = " . $employeer_id;
// 해당 질의문 실행하여 결과 가져오기
$result = $conn->query($sql);
// 결과셋을 한 개의 행으로 처리하고,
// 필요로 하는 각 컬럼의 값을 얻어온다.
if ($result->num_rows > 0) {
  $row = $result->fetch_array();
  $employeer_name = $row['employeer_name'];
  $employeer_number = $row['employeer_number'];
  $employeer_passwd = $row['employeer_passwd'];
  $employeer_department = $row['employeer_department'];
  $employeer_spot = $row['employeer_spot'];
  $employeer_cellphone = $row['employeer_cellphone'];
  $employeer_email = $row['employeer_email'];
  $employeer_photo = $row['employeer_photo'];
} else {
  echo outmsg(INVALID_USER);
}
?>

<!DOCTYPE html>
<html lang="kr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>사원 정보 수정</title>
</head>

<body>
  <h1>사원 정보 수정</h1>
  <form action="employeer_updateprocess.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="employeer_id" value="<?= $employeer_id ?>" />
    <br>
    <table border="1" width="800">
    <tr>
        <td rowspan"5" width = "85" height="113">
            <img alt"사진" src="uploads/<?=$row['employeer_photo']?>" width =85 height="113">
        </td>
        <th colspan="9" height="50"><font size="5"> 사원 정보 수정</font></th>
    </tr>
    <tr>
        <th rowspan="3" width = "85" height = "70" bgcolor="D5D5D5"> 성명</th>
    </tr>
    <tr align="center">
        <th colspan = "2" bgcolor="D5D5D5">한글</th>
        <td width="90"><input type="text" name="employeer_name" value="<?=$row['employeer_name']?>"></td>
        <th bgcolor="D5D5D5" align="center">부서 및 직위</th>
        <th colspan="2" width = "80" bgcolor="D5D5D5">E-mail</th>
    </tr>

    <tr>
        <th colspan = "2" bgcolor="D5D5D5"> 사번</th>
        <td><input type="text" name="employeer_number" value="<?=$row['employeer_number']?>"></td>
        <td><input type="text" name="employeer_department" value="<?=$row['employeer_department']?>"><input type="text" name="employeer_spot" value="<?=$row['employeer_spot']?>"></td>
        <td colspan="2"><input type="text" name="employeer_email" value="<?=$row['employeer_email']?>"></td>
    </tr>
    <tr>
        <th colspan="2" width="50" bgcolor="D5D5D5">연락처</th>
        <td colspan="2"><input type="text" name="employeer_cellphone" value="<?=$row['employeer_cellphone']?>"></td>
        <th colspan="2" width = "50" bgcolor="D5D5D5">긴급 연락처(핸드폰)</th>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="D5D5D5">현주소</th>
        <td colspan="8"></td>
    </tr>
    </table>
    <input type=submit value="저장">

  </form>
  <a href="employeer_list.php">목록보기</a>
</body>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='../index.php'>인덱스페이지로</a>";
}
?>
</html>