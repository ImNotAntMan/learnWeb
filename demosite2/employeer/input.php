<?php
    require "../util/dbconfig.php";
    $employeer_number = 2022011004;
    $employeer_name = "홍범도";
    $employeer_passwd = "1111";
    $employeer_department = "창고";
    $employeer_spot = "노예";
    $employeer_photo = "";
    $employeer_email = "test@test.net";
    $employeer_cellphone = "010-4444-4444";
    $i = 1;
    while($i < 714) {
    $stmt = $conn->prepare("INSERT INTO employeers(employeer_name, employeer_passwd, employeer_department, employeer_spot, employeer_cellphone, employeer_email, employeer_photo, employeer_number) VALUES(?, sha2(?,256), ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $employeer_name, $employeer_passwd, $employeer_department, $employeer_spot,$employeer_cellphone, $employeer_email, $employeer_photo, $employeer_number);
    $stmt->execute();
    $i++;
    $employeer_number++;
    }
    $conn->close();
    echo "<a href='employeer_list.php'>인덱스페이지로</a>";
?>
