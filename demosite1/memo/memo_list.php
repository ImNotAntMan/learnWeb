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
    <title>메모 리스트</title>
</head>
<body>
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
                echo $row['userid']."홍길동";
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
                <a href="../index.php">처음으로</a>
            </td>
        </tr>
    </table>
</body>
</html>
<?php } ?>
