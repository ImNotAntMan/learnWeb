<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>toy project 1st</title>
</head>

<body>
  <h1>사원 등록</h1>
  <form action="employeer_registprocess.php" method="POST"  enctype="multipart/form-data">
    <label>사원 번호 : </label><input type="text" name="employeer_number" required /><br>
    <label>성명 : </label><input type="text" name="employeer_name" required /><br>
    <label>passwd : </label><input type="password" name="employeer_passwd" required /><br>
    <label>passwd : </label><input type="password" name="employeer_cpasswd" required /><br>
    <label>부서 : </label><input type="text" name="employeer_department" required /><br>
    <label>직위 : </label><input type="text" name="employeer_spot" required /><br>
    <label>전화번호 : </label><input type="text" name="employeer_cellphone" placeholder="셀폰번호를 010-1234-1234 형식으로 입력해주세요." required /><br>
    <label>E-Mail : </label><input type="text" name="employeer_email" placeholder="이메일 주소를 이메일 주소 형식에 맞게 입력해주세요." required /><br>
    <label>사진 : </label><input type="file" name="fileToUpload" id="fileToUpload"><br>
    <br>
    <input type=submit value="저장">
    <input type=reset value="리셋">
  </form>
</body>

</html>