<!-- 
  파일명 : index.php
  최초작업자 : swcodingschool
  최초작성일자 : 2022-1-3
  업데이트일자 : 2022-1-3
  
  기능: 
  demosite1 프로젝트 폴더의 최상위 index 파일로써,
  하위 app 폴더를 연결하는 역할을 한다.
-->
<!--
  session 관리 목적 추가
-->
<?php
require_once './util/sysconfig.php';
require_once './util/loginchk.php';
?>

<!DOCTYPE html>
<html lang="kr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Membership Management</title>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <!-- Logo, Memga menu's, Introduction Video link, and Login Button -->
  <header>
    <div class="headeritem"><a href="/index.php">logo</a></div>
    <div class="headeritem">megamenu1</div>
    <div class="headeritem">megamenu2</div>
    <div class="loginlink">
    <?php
      if (!$chk_login) {  // 로그인 상태가 아니라면
      ?>
        <button id='trglgnModal'>login</button>
        <!-- 여기부터 login modal -->
        <div id='lgnModal' class='modal'>
          <!-- 여기부터 로그인 form in modal -->
          <div class="modal-content">
            <span class="close">&times;</span>
            <form action="./employeer/employeer_loginprocess.php" method="POST" class="loginbox">
              <label for="employeer_number"><b>사원번호</b></label><input type="text" name="employeer_number" placeholder="employeer_number" required />
              <label for="passwd"><b>Password </label><input type="password" name="employeer_passwd" placeholder="Enter Password" required />
              <button type=submit>Login</button><br>
              <label>
                <input type="checkbox" value="yes" name="chkbox">Remember me
              </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="./employeer/employeer_regist.php">사원정보 입력</a>
            </form>
            
          </div>
          <!-- 여기까지 로그인 form in modal -->
        </div>
        <!-- 여기까지 login modal -->
      <?php 
      } else {
        echo $_SESSION['employeer_name']; ?>
        <button><a href="./employeer/employeer_logout.php">logout</a></button>
      <?php
      }// end of if(!$chk_login)
    ?>
    </div><!-- end of class="loginlink" -->
  </header>
  <!-- -->
  <nav>
    <ul>
      <li><a href="./employeer/employeer_list.php">사원정보</a></li>
      <li><a href="./board/board_list.php">게시판</a></li>
      <li>Blog</li>
      
    </ul>
  </nav>
  <!-- -->
  <main>
  </main>
  <footer>
  </footer>
  <script src='./js/login.js'></script>
</body>

</html>