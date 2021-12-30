<?php
$secret="6LefzowUAAAAABvV3sYo6l-vKggvTwJAUrq-6L5X";
$response=$_POST["g-recaptcha-response"];
$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
$captcha_success=json_decode($verify);
$captcha_verify = $captcha_success->success;
?>