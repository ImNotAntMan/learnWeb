<!-- 
  파일명 : asysconfig.php
  최초작업자 : swcodingschool
  최초작성일자 : 2021-12-28
  업데이트일자 : 2021-12-28
  
  기능: 
  시스템 환경 설정 변수
  시스템내 각 코드들이 메시지 출력을 좀더 단순하게 하도록 메시지 내용을 정의하고
  메시지출력용 함수를 정의함.
  이 코드는 adbconfig를 통해 단 한번만 include 되도록 하여야 
  const의 중복 정의로 인한 오류를 피할 수 있다.
-->

<?php
// 개발단계 디버그 모드 
  const DBG = TRUE;  // 개발 중 DBG 모드일 때 TRUE, 운영 시 FALSE로 토글시킨다

  // 메시지 출력을 위한 const 선언
  // 메시지 출력시 뉴라인 처리
  const NEWLINE = '<br>'; 

  // 시스템 초기화시 사용 메시지
  const DBCONN_SUCCESS = '데이터베이스 연결에 성공하였습니다.';
  const DBCONN_FAIL = '데이터베이스 연결에 실패하였습니다.\n초기화 작업을 종료합니다.';
  const DROPDB_SUCCESS = '기존 데이터베이스를 성공적으로 삭제하였습니다.';
  const DROPDB_FAIL = '기존 데이터베이스 삭제에 실패하였습니다.';
  const DROPUSER_SUCCESS = '기존 애플리케이션용 계정을 성공적으로 삭제하였습니다.';
  const DROPUSER_FAIL = '기존 애플리케이션용 계정 삭제에 실패하였습니다.';
  const CREATEDB_SUCCESS = '데이터베이스를 성공적으로 생성하였습니다.';
  const CREATEDB_FAIL = '데이터베이스 생성에 실패하였습니다.';
  const CREATEUSER_SUCCESS = '애플리케이션용 계정을 성공적으로 생성하였습니다.';
  const CREATEUSER_FAIL = '애플리케이션용 계정 생성에 실패하였습니다.';
  const LIMITRSC_SUCCESS = '리소스 제한을 성공적으로 처리하였습니다.';
  const LIMITRSC_FAIL = '리소스 제한을 처리에 실패하였습니다.';
  const GRANTUSER_SUCCESS = '데이터베이스에 대한 권한부여에 성공하였습니다.';
  const GRANTUSER_FAIL = '데이터베이스에 대한 권한부여에 실패하였습니다.';
  const CREATETBL_SUCCESS = '테이블을 성공적으로 생성하였습니다.';
  const CREATETBL_FAIL = '테이블 생성에 실패하였습니다.';
  const DROPTBL_SUCCESS = '기존 테이블을 성공적으로 삭제하였습니다.';
  const DROPTBL_FAIL = '기존 테이블 삭제에 실패하였습니다.';
  const INSERT_SUCCESS = '데이터를 성공적으로 추가하였습니다.';
  const INSERT_FAIL = '데이터 추가에 실패하였습니다.';
  const SELECT_SUCCESS = '데이터를 성공적으로 조회하였습니다.';
  const SELECT_FAIL = '데이터 조회에 실패하였습니다.';
  const UPDATE_SUCCESS = '데이터를 성공적으로 갱신하였습니다.';
  const UPDATE_FAIL = '데이터 갱신에 실패하였습니다.';
  const INVALID_USER = '수정하고자 하는 사용자 계정을 한번 더 확인해주세요 ';
  const DELETE_SUCCESS = '데이터를 성공적으로 삭제하였습니다.';
  const DELETE_FAIL = '데이터 삭제에 실패하였습니다.';
  const COMMIT_CODE = '코드를 모두 실행하였습니다.\n이전 페이지로 돌아갑니다.';

  // form validation 시 사용 메시지
  const FILL_USERNAME = '사용자 아이디를 적어주세요.';
  const FILL_PASSWD = '비밀번호를 적어주세요.';
  const FILL_CPASSWD = '비밀번호(확인)을 적어주세요.';
  const FILL_CELLPHONE = '전화번호를 적어주세요.';
  const FILL_EMAIL = '이메일주소를 적어주세요.';
  const DIFF_PASSWD = '비밀번호가 확인용 비밀번호와 다릅니다.';
  const EXIST_USERNAME = '존재하는 아이디입니다.';

  // 로그인 성공 삭제
  const LOGIN_SUCCESS = '로그인에 성공하였습니다.';
  const LOGIN_FAIL = '로그인에 실패하였습니다.';

  // 팝업창 형태의 알림 메시지 출력용 함수 정의
  function outmsg($msg){
    return "<script>alert('".$msg."')</script>";
  }
?>