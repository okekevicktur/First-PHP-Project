<?php
   
    if(isset($_POST['submit'])){
       // echo "Session has expired";
       require 'dbh.inc.php';

       $uid= mysqli_real_escape_string($conn, $_POST['uid']);
       $pwd= mysqli_real_escape_string($conn, $_POST['pwd']);
       $mail= mysqli_real_escape_string($conn, $_POST['mail']);
       $pwdRepeat= mysqli_real_escape_string($conn, $_POST['pwdRepeat']);
       
       if (empty($uid) || empty($pwd) || empty($mail)|| empty($pwdRepeat)) {
          header("Location: ../signup.php?error=emptyfields&uid=".$uid."&mail=".$mail);
          exit();
       }
       elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidmail&uid=".$uid."&mail=".$mail);
          exit();
       }
       elseif (!preg_match("/^[a-zA-Z0-9]*$/",$uid)) {
        header("Location: ../signup.php?error=invalidusername&uid=".$uid."&mail=".$mail);
        exit();
       }
       elseif ($pwd !== $pwdRepeat) {
        header("Location: ../signup.php?error=passwordcheck&uid=".$uid."&mail=".$mail);
          exit();
       }
       else {
            $sql = "SELECT uid FROM login WHERE uid=?";
            //prepared dstatement
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql )) {
                header("Location: ../signup.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $uid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    header("Location: ../signup.php?error=userTaken&mail=".$mail);
                   
                }else {
                    $sql= "INSERT INTO login (uid, useremail, pwd ) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql )) {
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                    }
                    else {
                        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "sss", $uid, $mail, $hashedPwd);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../login.php?signup=success");
                        exit();
                        
                    }
                }
            }
       }
   
       mysqli_stmt_close($stmt);
       mysqli_close($conn);
    }
    else {
        header("Location: ../signup.php");
          exit();
    }

