<?php
    require "../include/config.php";
    require "../include/server.php";
    if(isset($_POST["submit"])){
        $id = mysqli_real_escape_string($conn,$_POST["id"]);
        $pwd = mysqli_real_escape_string($conn,$_POST["password"]);
        
        //Error Handlers
        //Check for empty fields
        if( empty($id) || empty($pwd)){
            header("Location: ../login?login=empty");
            exit();
        }else{
            //Checked if input are valid
            $status = null; $resultCheck = null; $login_method = 'id';
            checkWho('student');
            checkWho('teacher');
            checkWho('vendor');
            if($status == null){
                header("Location: index.php?login=mismatch");
                exit();
            }else{
                $sql = "SELECT * FROM `$status` WHERE `$login_method`='$id'";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
                if( $resultCheck > 0){
                    $row = mysqli_fetch_assoc($result);
                    //De-hashing password
                    $hashedPwdCheck = password_verify($pwd, $row['password']);
                    if( $hashedPwdCheck == false ){
                        //$error = $row['id'].$row['name']."&".$status;
                        header("Location: ../login?login=mismatch");
                        exit();
                    }elseif( $hashedPwdCheck == true ){
                        //Log in the user
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['status'] = $status;
                        $_SESSION['api_key'] = "0000";
                        if( $row['pin'] != "" ){
                            $_SESSION['pin_verified'] = false;
                            $_SESSION['token'] = "";
                        }else{
                            $_SESSION['pin_verified'] = true;
                            $_SESSION['token'] = null;
                        }
                            //check for remember me
                            if(!empty($_POST["remember"])) {
                                setcookie ("member_login",$id,time()+ (7 * 24 * 60 * 60),"$cookie_dir","$main_domain",$secure_https,$http_only); //saved for 1 week
                                setcookie ("status",$status,time()+ (7 * 24 * 60 * 60),"$cookie_dir","$main_domain",$secure_https,$http_only);
                            }
                            header("Location: ../login?login=success");
                        exit();
                    }else{
                        header("Location: ../login?login=error");
                        exit();
                    }
                }else{
                    header("Location: ../login?login=mismatch");
                }
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

function checkWho($who){
    global $conn, $status, $resultCheck, $id;
    $sql = "SELECT * FROM `$who` WHERE `id`='$id'";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0){   
        $status = $who;
    }
}

function checkLoginMethod($who){
    global $conn, $id;

}