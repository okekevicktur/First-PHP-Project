<?php
   
    if(isset($_POST['submit'])){
       // echo "Session has expired";
       require 'dbh.inc.php';

      //  $uid= mysqli_real_escape_string($conn, $_POST['uid']);
      //  $pwd= mysqli_real_escape_string($conn, $_POST['pwd']);
      $uid=  $_POST['uid'];
      $pwd=  $_POST['pass'];
      
       if (empty($uid) || empty($pwd)) {
          header("Location: ../login.php?error=emptyfields&uid=".$uid);
          exit();
       }
      else {
         $sql = "SELECT * FROM login WHERE uid= ?;"; //OR useremail=?
         //prepared statement
         $stmt = mysqli_stmt_init($conn); 
         if (!mysqli_stmt_prepare($stmt, $sql )) {
             header("Location: ../login.php?error=sqlerror");
             exit();
         }
         else {
             mysqli_stmt_bind_param($stmt, "s", $uid);
             mysqli_stmt_execute($stmt);
             $result = mysqli_stmt_get_result($stmt);
             if ($row = mysqli_fetch_assoc($result)) {
               $pwdCheck1 = password_verify($pwd, $row['pwd']);
               // echo "$pwd";
               // exit();           
               if ($pwdCheck1) {
                  session_start();
                  $_SESSION['userId'] = $row['id'];
                  $_SESSION['userUid'] = $row['uid'];
                  header("Location: ../login.php?Login=success");
               }       
               else {  // ($pwdCheck1 == false) 
                  header("Location: ../login.php?error=wrongpassword");
                  exit();
               }
               // else{
               //    header("Location: ../login.php?error=wrongdetails");
               //    exit();
               // }
             }else{
               header("Location: ../login.php?error=nouser&uid=".$uid);
               exit();
             }
            //  $resultCheck = mysqli_stmt_num_rows($stmt);
            //  if ($resultCheck > 0) {
            //      header("Location: ../signup.php?error=userTaken&mail=".$mail);
                
            //  }else {
            //      $sql= "INSERT INTO login (uid, useremail, pwd ) VALUES (?, ?, ?)";
            //      $stmt = mysqli_stmt_init($conn);
            //      if (!mysqli_stmt_prepare($stmt, $sql )) {
            //          header("Location: ../signup.php?error=sqlerror");
            //          exit();
            //      }
            //      else {
            //          $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            //          mysqli_stmt_bind_param($stmt, "sss", $uid, $mail, $hashedPwd);
            //          mysqli_stmt_execute($stmt);
            //          header("Location: ../signup.php?signup=success");
            //          exit();
                     
            //      }
            //  }
         }
    }

   //  mysqli_stmt_close($stmt);
   //  mysqli_close($conn);
 }
 else {
     header("Location: ../login.php");
       exit();
 }
   
    








     //    elseif (!filter_var($uid, FILTER_VALIDATE_EMAIL)) {
    //     header("Location: ./login.php?error=invalidmail&uid=".$uid);
    //       exit();
    //    }