<!-- 
  파일명 : oo_user_regist_process.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  oo_user_registform.html 회원가입화면에서 입력된 값을 받아, validation 후
  users 테이블에 사용자 가입 데이터를 추가한다.
-->

<?php
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
if ($_FILES["fileToUpload"]["size"] > 10000000) {
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

// db연결 준비
// 출력용 메시지 등의 include 문제 때문에 
// 연결준비는 여기에서 하지만
// 실제 연결은 입력한 비밀번호와 확인용비밀번호가 일치할 때 진행
require "../util/dbconfig.php";

// 데이터베이스 작업 전, 회원가입화면으로 부터 값을 전달 받고
$employeer_name = $_POST['employeer_name'];
$employeer_number = $_POST['employeer_number'];
$employeer_passwd = $_POST['employeer_passwd'];
$employeer_cpasswd = $_POST['employeer_cpasswd'];
$employeer_department = $_POST['employeer_department'];
$employeer_spot = $_POST['employeer_spot'];
$employeer_cellphone = $_POST['employeer_cellphone'];
$employeer_email = $_POST['employeer_email'];
$employeer_photo = $_FILES['fileToUpload']['name'];

$regist_err = FALSE; // 등록 과정중 오류 발생하였음을 체크함
$err_msg = "";
// validation 작업 수행
// 단계 1. 비밀번호와 확인용 비밀번호 일치 여부 확인하여
// 일치하지 않을 경우 등록 폼으로 다시 이동
if ($employeer_passwd != $employeer_cpasswd) {  // password & cpassword is differenct
  // 비밀번호와 확인용 비밀번호 불일치는 반드시 메시징 처리하여야 함
  // if(DBG)  생략으로 수정하고, 메시지의 정확한 확인을 위해 
  // 오류발생플래그 활성화!!하고 폼화면으로 이동은 코드 마지막 부분에서
  // 조건문으로 처리토록 수정함. 2021-12-29 by swcodingschool
  echo outmsg(DIFF_PASSWD);
  $regist_err = TRUE;
  // header('Location: oo_user_registform.html');
} else {
  // 일치할 경우 등록 처리를 위한 절차 진행
  // 단계 2. 정규식 적용,FORM VALIDATION 작업 진행
  // 계정 구성 조건 정규식 적용... 사용자 계정 검증
  // 비밀번호 구성 조건 정규식 적용... 비밀번호 검증
  // 전화번호 구성 조건 정규식 적용... 전화번호 검증
  // 이메일 구성 조건 정규식 적용... 이메일 검증
  // 위 검증 과정 중 1이라도 위배될 경우 return to back

  // 검증을 모두 패스한 경우에만... 여기에 도달
  // 이제야 비로소 데이터베이스 연결 설정!!

  // 동일 아이디 존재 여부 확인을 위한 질의 구성
  // prepared 로 동일 아이디 체크는 일단 보류... 
  // $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
  // $stmt->bind_param("s", $username);
  // $stmt->execute();
  // $result = $stmt->get_result();
  // $row = mysqli_fetch_array($result);
  // if(!empty($row['username']) && ($row['username'] == $username)){
  //   echo outmsg(EXIST_USERNAME);
  //   header('Location: oo_user_registform.html');
  // }

  // 동일 아이디 존재 여부 확인을 위한 질의 구성
  $sql = "SELECT employeer_number FROM employeers WHERE employeer_number = '" . $employeer_number . "'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo outmsg(EXIST_USERNAME);
    $regist_err = TRUE;
  } else {
    // 입력 처리를 위한 prepared sql 구성 및 bind
    $stmt = $conn->prepare("INSERT INTO employeers(employeer_name, employeer_passwd, employeer_department, employeer_spot, employeer_cellphone, employeer_email, employeer_photo, employeer_number) VALUES(?, sha2(?,256), ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $employeer_name, $employeer_passwd, $employeer_department, $employeer_spot,$employeer_cellphone, $employeer_email, $employeer_photo, $employeer_number);
    $stmt->execute();
  }
}
// 데이터베이스 연결 인터페이스 리소스를 반납한다.
$conn->close();

// 등록 과정 중 오류가 발생하였으면 앞서.. 오류 내용 메시지를 확인하고
// 등록 화면으로 다시 돌아간다.
if ($regist_err) {
  // header('Location: oo_user_registform.html');
  echo "<a href='../employeer/employeer_regist.php'>Confirm and Return to registform.</a>";
} else {
  // 그렇지 않으면
  // 프로세스 플로우를 인덱스 페이지로 돌려준다.
  // header('Location: index.php');
  // 작업 실행 단계별 메시지 확인을 위해 Confrim and return to back하도록 수정함!!
  // 백그라운드로 처리되도록 할 경우 위의 원 코드로 대체 할 것!!
  echo outmsg(COMMIT_CODE);
  echo "<a href='employeer_list.php'>Confirm and Return to list.</a>";
}
?>