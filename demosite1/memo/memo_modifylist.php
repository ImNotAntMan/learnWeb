<?php
require "../util/dbconfig.php";
require "../util/loginchk.php";
if (!$chk_login) {  // 로그인 상태가 아니라면
    echo "로그인 하세요";
    echo "<a href='../index.php'>처음으로</a>";
} else {
$subject = "테스트";
$content = "테스트";
$datestream = date("Y-m-d", time());
$username = $_SESSION['username'];
$userid = $_SESSION['userid'];
$memoid = $_GET['memoid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메모 수정 이력</title>
</head>
<body>
    <h1>메모 수정 이력 리스트입니다.</h1>
    <h3>제목을 누르면 내용을 볼 수 있습니다.</h3>
    <table>
        <tr>
        <th>제목</th><th>생성일<br>최종수정일</th><th>변경유형</th><th></th><th></th><th></th>
        </tr>
        <?php
        //    $sql = "SELECT * FROM memoupdate where memoid=".$memoid;
           $sql = "SELECT memoupdate.memoid, memoupdate.userid,memoupdate.modifyid, memoupdate.subject, memoupdate.contents, memoupdate.modifydate, memoupdate.modify, memo.registdate FROM memo INNER JOIN memoupdate ON memo.memoid = memoupdate.memoid WHERE memoupdate.memoid=".$memoid." ORDER BY modifydate DESC;";

           $resultset = $conn->query($sql);
           if($resultset->num_rows > 0) {
            while( $row = $resultset->fetch_assoc() ) {
                $subject = $row['subject'];
                $modifydate = $row['modifydate'];
                $modify = $row['modify'];
                $memoid = $row['memoid'];
                $userid = $row['userid'];
                $modifyid = $row['modifyid'];
                echo "<tr>";
                echo "<td>";
                echo "<a href='memo_updateview.php?memoid=".$memoid."&userid=".$userid."&modifyid=".$modifyid."'>";
                echo $subject;
                echo "</a>";
                echo "</td>";
                echo "<td>";
                echo $modifydate."<br>";
                echo "</td>";
                echo "<td>";
                echo $modify;
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "</tr>";
             }
            }  else {
                echo "<tr>";
                echo "<td>";
                echo "";
                echo "</td>";
                echo "<td>";
                echo "<br>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>";
                echo "";
                echo "</td>";
                echo "<td>";
                echo "수정 이력이 없습니다.<br>";
                echo "</td>";
                echo "<td>";
                echo "";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "<td>";
                echo "</td>";
                echo "</tr>";

             }
        ?>
    </table>
    <table>
        <tr>
            <td>
                <a href="memo_writeForm.php">새로운 메모 작성</a>
                <a href="memo_list.php">리스트로 돌아가기</a>
            </td>
        </tr>
    </table>

</body>
</html>
<?php } ?>