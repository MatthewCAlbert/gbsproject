<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require '../include/head.php';
    ?>
    <title>GBS Project - School Cashless Solution</title>
</head>
<body>
    <div id="main-container">
        <?php 
            require '../include/header.php';
        ?>
        <div id="main-wrapper">
            <div class="container-fluid page-header">
                <div class="row">
                    <div class="col-12">
                        <h2>Get Registered</h2><br>
                        <h6>Follow guides below.</h6>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="section" id="section-1">
                    <div class="row">
                        <div class="col-12">
                            <h4>How to get registered?</h4>
                            <p>You can register your school by submiting an inquiry to our email or directly contacting us.</p>
                            <div class="d-flex flex-wrap">
                                <div class="p-2">
                                    <a href="<?php echo $main_directory; ?>contact" class="btn btn-primary waves-effect waves-light" style="border-radius:15px;padding:10px 20px;">Contact</a>
                                </div>
                                <div class="p-2">
                                    <a href="mailto:emoney.gbs@gmail.com" class="btn btn-primary waves-effect waves-light" style="border-radius:15px;padding:10px 20px;">emoney.gbs@gmail.com</a>
                                </div>
                            </div>
                            <div class="hr hr-100"></div>
                            <h4>Form Format</h4>
                            <div style="padding:20px;border:1px solid grey;border-radius:5px;width:75%;">
                                <b>School/Organization Name :</b>
                                <br>
                                <b>Contact Name :</b>
                                <br>
                                <b>Contact Email :</b>
                                <br>
                                <b>Contact Phone Number :</b>
                                <br>
                            </div><br>
                            <div class="hr hr-100"></div>
                            <h4>Technical Requirements</h4>
                            <ul>
                                <li>Stable Internet Connection (Minimum: 2-3Mbit/s. Recommendation : 10Mbit/s or faster*).</li>
                                <li>RFID Student Card.</li>
                                <li>WiFi Router (Minimum: b/g/n router with 2 antennas. Recommendation : b/g/n/a/ac router or better with 4 antennas or more**).</li>
                                <li>Power outlet on each counter.</li>
                            </ul>
                            <small>* Depending on how much EDC Machine placed.</small><br>
                            <small>** Vary on cover area size and condition.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            require '../include/footer.php';
        ?>
    </div>
</body>
</html>