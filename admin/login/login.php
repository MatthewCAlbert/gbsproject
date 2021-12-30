<?php
    require "../include/structure.php";
    require "../include/server.php";
    if(isset($_POST["submit"])){
        $id = mysqli_real_escape_string($conn,$_POST["username"]);
        $pwd = mysqli_real_escape_string($conn,$_POST["password"]);
        
        //Error Handlers
        //Check for empty fields
        if( empty($id) || empty($pwd)){
            header("Location: index.php?login=empty");
            exit();
        }else{
            //Checked if input are valid
                $sql = "SELECT * FROM `admin` WHERE `username`='$id'";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
                if( $resultCheck > 0 ){
                    $row = mysqli_fetch_assoc($result);
                    //De-hashing password
                    $hashedPwdCheck = password_verify($pwd, $row['password']);
                    if( $hashedPwdCheck == false ){
                        $error = $row['username'].$row['name'];
                        header("Location: index.php?login=mismatch");
                        exit();
                    }elseif( $hashedPwdCheck == true ){
                        //Log in the user
                        if( $row['status'] == 'active' ){
                            $_SESSION['useradmin_id'] = $row['username'];
                            $_SESSION['name'] = $row['name'];
                                //check for remember me
                                if(!empty($_POST["remember"])) {
                                    setcookie ("admin_login",$id,time()+ (7 * 24 * 60 * 60),"$cookie_dir","$main_domain",$secure_https,$http_only); //saved for 1 week
                                }
                                header("Location: ../index.php?login=success");
                            exit();
                        }else{
                            header("Location: index.php?login=banned");
                            exit();
                        }
                    }else{
                        header("Location: index.php?login=error");
                        exit();
                    }
                }else{
                    header("Location: index.php?login=mismatch");
                }
            }
    }else{
        header("Location: ../login");
        exit();
    }

function checkWords($x){
    if(preg_match("/^[a-zA-Z]*$", $x)){
        return true;
    }else{
        return false;
    }
}