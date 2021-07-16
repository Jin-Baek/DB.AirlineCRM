<!DOCTYPE html>

<?php

  $id = $_POST[ 'id' ];
  $pwd = $_POST[ 'pwd' ];

  if ( !is_null($id) ) {
    session_start();
    
    $conn = mysql_connect("localhost","root", "apmsetup");
    
    mysql_set_charset("utf-8",$conn);
    mysql_select_db("project",$conn);
    
    $sql = "SELECT pwd from account where id ='{$id}';";

    $result = mysql_query($sql,$conn);

    ## admin admin 이 관리자 계정 
    while($row=mysql_fetch_array($result)){
        $_SESSION['user'] = $id;
        if($pwd==$row['pwd']){
            echo"<script>alert('로그인에 성공하셨습니다.');</script>";
            if($id=='admin'){
              echo "<script>location.href='admin.php'</script>";
            }
            else{
              echo "<script>location.href='passenger.php'</script>";
            }
        }
        else{
            echo"<script>alert('로그인에 실패하셨습니다.');</script>";
            }
        }
    }

?>

  <head>
    <meta charset="utf-8">
    <title>로그인</title>
    <style>
      input[type='submit']{
        background:#9fcaf3;
        border-radius:5px;
        border-color:#9fcaf3;
        width:260px;
        height:27px;
        border:2px #9fcaf3;
        color:white;
      }
      input[type='text'],input[type='password']{
          width:250px;
          height: 27px;
          border-color:#e6e4e4;
      }

    </style>
  </head>
  <body>
    <h2>로그인</h1>
    <form action="login.php" method="POST">
    <b>아이디</b><br><br>
      <input type="text" name="id" placeholder="아이디" required><br><br>
    <b>비밀번호</b><br><br>
      <input type="password" name="pwd" placeholder="비밀번호" required>
      <p><input type="submit" value="로그인"></p>
    </form>
  </body>
</html>