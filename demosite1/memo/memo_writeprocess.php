<!-- 
  파일명 : memo_writeprocess.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  업데이트일자 : 2021-12-30 by 민재기
  
  기능: 
  create_memoForm.php 메모 입력화면에서 입력된 값을 받아, validation 후
  memo 테이블에 사용자 메모 데이터를 추가한다.
-->

<?php
  // db연결 준비
  // 출력용 메시지 등의 include 문제 때문에 
  // 연결준비는 여기에서 하지만
  // 실제 연결은 입력한 비밀번호와 확인용비밀번호가 일치할 때 진행
  require "../util/dbconfig.php";
  require "../util/loginchk.php";
  if (!$chk_login) {  // 로그인 상태가 아니라면
      echo "로그인 하세요";
      echo "<a href='../index.php'>처음으로</a>";
  } else {  
  // 데이터베이스 작업 전, 메모 쓰기화면으로 부터 값을 전달 받고
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }  
  
// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
$image_name = $name = $_FILES['fileToUpload']['name'];
$userid = $_POST['userid'];
$subject = $_POST['subject'];
$contents = $_POST['contents'];
 // 입력 처리를 위한 prepared sql 구성 및 bind
 $i = 0;
 while($i <= 60) {
$stmt = $conn->prepare("INSERT INTO memo(userid, subject, contents, images) VALUES(?, ?, ?, ?)");
//$stmt = $conn->prepare("INSERT INTO `memo`(`userid`, `subject`, `contents`) VALUES ('?','?','?')");
$stmt->bind_param("ssss", $userid, $subject, $contents, $image_name);
$stmt->execute();
$i++;
$subject = $_POST['subject']." ".$i;
$contents = $_POST['contents']." ".$i;
  }
// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

echo outmsg(COMMIT_CODE);
echo "<a href='./memo_list.php'>Confirm and Return to back.</a>";
  }
?>