<?php
  session_start();
  if(isset($_SESSION['employeer_name'])) {
    $chk_login = TRUE;
  }else { 
    $chk_login = FALSE;
  }
?>