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
  <title>사원정보 상세페이지</title>
</head>

<body>
  <h1>사원정보 상세페이지</h1>
  <br>
  <?php
  $employeer_id = $_GET['employeer_id'];

  $sql = "SELECT * FROM employeers WHERE employeer_id = " . $employeer_id;
  $resultset = $conn->query($sql);

  if ($resultset->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>USERNAME</th><th>CellPhone</th><th>E-Mail</th><th>입사일</th><th>Last Login</th><th>Status</th><th>수정</th><th>삭제</th></tr>";

    $row = $resultset->fetch_assoc();
    echo "<tr><td>" . $row['employeer_id'] . "</td><td>" . $row['employeer_number'] . "</td><td>" . $row['employeer_cellphone'] . "</td><td>" . $row['employeer_email'] . "</td><td>" . $row['employeer_registdate'] . "</td><td>" . $row['employeer_lastdate'] . "</td><td>" . $row['status'] . "</td><td><a href='employeer_update.php?employeer_id=" . $row['employeer_id'] . "'>수정</a></td><td><a href='employeer_deleteprocess.php?employeer_id=" . $row['employeer_id'] . "'>삭제</a></td></tr>";
    echo "</table>";
  }
  ?>
  <table border="1" width="800">
    <tr>
        <td rowspan"5" width = "85" height="113">
            <img alt"사진" src="uploads/<?=$row['employeer_photo']?>" width =85 height="113">
        </td>
        <th colspan="9" height="50"><font size="5"> 사원 정보 상세</font></th>
    </tr>
    <tr>
        <th rowspan="3" width = "85" height = "70" bgcolor="D5D5D5"> <img src="uploads/<?=$row['employeer_photo']?>" width="85" height="113"></th>
    </tr>
    <tr align="center">
        <th colspan = "2" bgcolor="D5D5D5">한글</th>
        <td width="90"><?=$row['employeer_name']?></td>
        <th bgcolor="D5D5D5" align="center">부서 및 직위</th>
        <th colspan="2" width = "80" bgcolor="D5D5D5">E-mail</th>
    </tr>

    <tr>
        <th colspan = "2" bgcolor="D5D5D5"> 사번</th>
        <td><?=$row['employeer_number']?></td>
        <td><?=$row['employeer_department']?> / <?=$row['employeer_spot']?></td>
        <td colspan="2"><?=$row['employeer_email']?></td>
    </tr>
    <tr>
        <th colspan="2" width="50" bgcolor="D5D5D5">연락처</th>
        <td colspan="2"><?=$row['employeer_cellphone']?></td>
        <th colspan="2" width = "50" bgcolor="D5D5D5">긴급 연락처(핸드폰)</th>
        <td colspan="2"></td>
    </tr>
    <tr>
        <th bgcolor="D5D5D5">현주소</th>
        <td colspan="8"></td>
    </tr>
    </table>
    <table border="1">
    <tr>
        <th colspan="6" width="790" bgcolor="D5D5D5"> 학력사항</th>
    </tr>
<tr>
<th bgcolor = "D5D5D5"> 학위과정</th>
<th bgcolor = "D5D5D5"> 기간</th>
<th bgcolor = "D5D5D5"> 학교명</th>
<th bgcolor = "D5D5D5"> 전공</th>
<th bgcolor = "D5D5D5"> 수료</th>
<th bgcolor = "D5D5D5"> 졸업</th>
</tr>
<tr>
<td></td>
<td align ="center">~</td> 
<td></td> 
<td></td>
<td></td>
<td></td>
</tr>
<tr>
    <td></td>
    <td align="center">~</td>
    <td align="right">대학교</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <td></td>
    <td align = "center">~</td>
    <td align = "right">대학원</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<tr>
    <th colspan = "6" bgcolor = "D5D5D5"> 전공경력사항</th>
</tr>
<tr>
    <th width="180" bgcolor="D5D5D5" >근무연월</th>
    <th width="200" bgcolor="D5D5D5"> 기간</th>
    <th width="100" bgcolor="D5D5D5" >근무처</th>
    <th width="100" bgcolor="D5D5D5"> 직위</th>
    <th colspan = "2" width  = "70" bgcolor="D5D5D5"> 자격증</th>
</tr>
<tr>
    <td align="center"> 년 &nbsp; &nbsp; &nbsp;개월</td>
    <td align="center"> ~</td>
    <td></td>
    <td></td>
    <td colspan ="2"></td>
</tr>
<tr>
    <td align="center"> 년 &nbsp;&nbsp;&nbsp;   개월</td>
    <td align="center"> ~ </td>
    <td></td>
    <td></td>
    <td colspan = "2"></td>
</tr>
<tr>
    <td align="center">년&nbsp;&nbsp;&nbsp;개월</td>
    <td align="center">~</td>
    <td></td>
    <td></td>
    <td colspan = "2"></td>
</tr>
<tr>
<td align ="center">년 &nbsp;&nbsp;&nbsp;개월</td>
<td align = "center">~</td>
<td></td>
<td></td>
<td colspan = "2"></td>
</tr>
<tr>
    <th bgcolor ="D5D5D5"> 참고사항</th>
    <td colspan="5"></td>
</tr>
</tr>
</table>
  <?php

  ?>
  <br>
  <a href="employeer_list.php">목록보기</a>
</body>
<?php 
}else {
  echo outmsg(LOGIN_NEED);
  echo "<a href='employeer_list.php'>리스트페이지로</a>";
}
?>
</html>