<?php

session_start();

if(isset($_POST['submit'])){

    include 'dbh-inc.php';
    $uid = mysqli_real_escape_string($conn ,$_POST['uid']);
    $pwd = mysqli_real_escape_string($conn ,$_POST['pwd']);

    if(empty($uid) || empty($pwd))
    {
      header("Location: ../index.php?login=error");
      exit();
    }
    else
    {
      $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
      $result = mysqli_query($conn, $sql);
      $result_check = mysqli_num_rows($result);
      if($result_check < 1){
        header("Location: ../index.php?login=error");
        exit();
      } else {
        if($row = mysqli_fetch_assoc($result)){
          $hashed = password_verify($pwd, $row['user_pwd']);
          if($hashed == false)
          {
            header("Location: ../index.php?login=error");
            exit();
          } elseif ($hashed == true)
          {
            $_SESSION['u_id'] = $row['user_id'];
            $_SESSION['u_first'] = $row['user_first'];
            $_SESSION['u_last'] = $row['user_last'];
            $_SESSION['u_email'] = $row['user_email'];
            $_SESSION['u_uid'] = $row['user_uid'];
            header("Location: ../index.php?login=success");
            exit();
          }
        }
      }
    }
  }
  else
  {
      header("Location: ../index.php?login=error");
      exit();

}
