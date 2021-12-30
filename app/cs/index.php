<?php
    require '../include/config.php'; 
    require '../include/server.php';
    if(isset($_SESSION['user_id'])){
    }else if(isset($_COOKIE['member_login'])){
        require '../include/backend/cookie_detector.php';
    }else{
       header("Location: ../login");
       exit();
    }
    require '../include/backend/getuserdata.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require '../include/structure/head.php';?>
    <title>Customer Service<?php echo $main_title; ?></title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <?php require '../include/structure/loader.php';?>
    <?php require '../include/structure/header.php';?>
    <div id="content">
        <?php
            if(isset($_GET['warning'])){
                $warning = mysqli_real_escape_string($conn,$_GET['warning']);
                echo '<div class="section" style="padding: 2% 5%;color:red;background-color:pink;">WARNING : '.ucfirst($warning).'</div>';   
            }
            if(isset($_GET['result'])){
                $result = mysqli_real_escape_string($conn,$_GET['result']);
                if( $result == "ok" ){
                    $msg = "We'll contact you as soon as possible through our email, please be patient. Thank you.";
                    $color="#82E0AA";
                }else{
                    $msg = "Please resubmit your form.";
                    $color="pink";
                }
                echo '<div class="section" style="padding: 2% 5%;color:green;background-color:'.$color.';">RESULT : '.ucfirst($result).' - '.$msg.'</div>';   
            }
        ?>
        <div class="section section-white">
            <div style="padding: 5% 5%;">
            <form action="submit.php" method="post">
                <h4>Customer Service Form</h4>
                <br>
                <label for="">Inquiry*</label>
                <select name="type" class="form-control" id="form" required>
                    <option value="">Select Type</option>
                    <option value="Help">Help</option>
                    <option value="Ask">Ask</option>
                    <option value="Request">Request</option>
                    <option value="Complaint">Complaint</option>
                    <option value="Report">Report</option>
                    <option value="Feedback">Feedback</option>
                </select>
                <br>
                <label for="">Title*</label>
                <input type="text" name="title" value="" class="form-control" placeholder="" minlength="6" maxlength="50" required />
                <br>
                <label for="">Email*</label>
                <input type="email" name="email" value="<?php echo $user_row['email']; ?>" class="form-control" placeholder="" required />
                <br>
                <label for="">Message*</label>
                <textarea name="message" id="" cols="50" rows="10" class="form-control" required></textarea>
                <br>
                <div class="g-recaptcha" data-sitekey="6LefzowUAAAAAFRqHI-jkZ1o0L-2OKQGpXcY2-QM"></div>
                <br>
                <button type="submit" class="btn btn-primary" style="float:right;" name="submit">Submit</button>
                <br><br>
            </form>
            </div>
        </div>
    </div>
    <?php require '../include/structure/nav.php';?>
</body>
<?php require '../include/structure/bottom-script.php';?>
<script>
grecaptcha.ready(function() {
grecaptcha.execute('6LfOyYwUAAAAAPqP6zUFNX48KWLoT_WdWyQB9I-I', {action: 'action_name'})
.then(function(token) {
// Verify the token on the server.
});
});
</script>
</html>