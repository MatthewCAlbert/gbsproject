<?php
require "../include/structure.php";
require '../include/server.php';
require '../include/session.checker.php';
require '../include/getuserdata.php';
if( $user_row['level'] == 3 ){
    header("Location: $main_directory/gbs-admin/dashboard");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../include/structure/header.php'; 
    ?>
    <title>PHPMailer - GBS eMoney Admin</title>
    <?php require '../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            //$(".nav .nav-item:contains('Mail')").addClass('active');
        });
    </script>
</head>
    <?php
    if(isset($_POST['email'])){
    $recipient_email = $_POST['email'];
    $header = $_POST['title'];
    $content = $_POST['reply-text'];
    }else{
        $recipient_email = '';
        $header = '';
        $content = '';
    }
    //======================= Emailing =========================

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'vendor/autoload.php';
    require 'credential.php';
    ?>
    <body class="">
        <div class="wrapper">
            <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
                <!--
            Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

            Tip 2: you can also add an image using data-image tag
        -->
                <?php require "../include/structure/sidenav-bar.php"; ?>
            </div>
            <div class="main-panel">
                <?php require "../include/structure/navbar.php"; ?>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-chart card-header-primary">
                                    <h4 class="card-title">PHPMailer</h4>
                                    <p class="card-category">Modules</p>
                                </div>
                                <div class="card-body">
                                <div class="card-category">
                                    <div class="row container">
                                    <form id="process" method="post" action="index.php">
                                    <h5>Email</h5>
                                    <input class="form-control" name="email" type="email" value="<?php echo $recipient_email; ?>" readonly>
                                    <br>
                                    <h5>Title</h5><input class="form-control" name="title" type="text" value="<?php echo $header; ?>"><br>
                                    <br>
                                    <h5>Message</h5>
                                    <textarea class="form-control" name="reply-text" cols="40" rows="5" placeholder="Your reply here.." value="<?php echo $content; ?>"></textarea>
                                    <br><button type="submit" class="btn btn-primary">Send</button>
                                    </form>
                                    </div><br>
                                    <div class="row container">
                                        <h5>Logs</h5>
                                        <div class="container" style="background-color:rgba(0,0,0,0.05);padding:20px;">
                                        <?php
                                            if(isset($_POST['email']) && isset($_POST['title']) && isset($_POST['reply-text'])){
                                                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                                                if( filter_var($email, FILTER_VALIDATE_EMAIL) && filter_var($recipient_email, FILTER_VALIDATE_EMAIL) )
                                                    try {
                                                        //Server settings
                                                        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                                                        $mail->isSMTP();                                      // Set mailer to use SMTP
                                                        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                                                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                                        $mail->Username = $email;                 // SMTP username
                                                        $mail->Password = $password;                           // SMTP password
                                                        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                                                        $mail->Port = 587;                                    // TCP port to connect to

                                                        //Recipients
                                                        $mail->setFrom($email,$sender_name);
                                                        $mail->addAddress($recipient_email);     // Add a recipient
                                                        //$mail->addAddress('ellen@example.com');               // Name is optional
                                                        //$mail->addReplyTo('info@example.com', 'Information');
                                                        //$mail->addCC('cc@example.com');
                                                        //$mail->addBCC('bcc@example.com');

                                                        //Attachments
                                                        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                                                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                                                        //Content
                                                        $mail->isHTML(true);                                  // Set email format to HTML
                                                        $mail->Subject = $header;
                                                        $mail->Body    = $content;
                                                        $mail->AltBody = $content;

                                                        $mail->send();
                                                        echo '<p class="alert alert-success">'.'Message has been sent'.'</p>';
                                                    } catch (Exception $e) {
                                                        echo '<p class="alert alert-danger">';
                                                        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                                                        echo '</p>';
                                                    }
                                                else{
                                                    echo '<p class="alert alert-danger">';
                                                    echo 'Message could not be sent. Mailer Error: Invalid Email Address';
                                                    echo '</p>';
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div><br>
                                    <div class="row container">
                                        <?php
                                            if(isset($_POST['redirect'])){
                                                $redirect = "'".$_POST['redirect']."'";
                                                echo '<button class="btn btn-primary" onclick="window.location.href='.$redirect.'"><i class="material-icons">arrow_back_ios</i>Back</button>';
                                            }
                                        ?>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <?php require "../include/structure/footer.php"; ?>
            </div>
        </div>
    </body>
</html>